<?php

session_start();

if (!isset($_SESSION['user_name'])) {
    header("Location: login.php");
    exit();
}

include("includes/db.php");


$search = "";

if(isset($_GET['search'])){
    $search = $_GET['search'];
}
$city = "";

if(isset($_GET['city'])){
    $city = $_GET['city'];
}
$role = "";

if(isset($_GET['role'])){
    $role = $_GET['role'];
}

$age = "";

if(isset($_GET['age'])){
    $age = $_GET['age'];
}


?>
<?php

$where = [];

if($search != ""){
    $where[] = "(users.full_name LIKE '%$search%'
          OR users.role LIKE '%$search%'
          OR profiles.city LIKE '%$search%')";
}

if($city != ""){
    $where[] = "profiles.city LIKE '%$city%'";
}
if($role != ""){
    $where[] = "users.role = '$role'";
}

if($age != ""){

    $range = explode("-", $age);

    $min = $range[0];
    $max = $range[1];

    $where[] = "profiles.age BETWEEN $min AND $max";
}

$sql = "SELECT users.id,
               users.full_name,
               users.role,
               profiles.city,
               profiles.profile_photo,
               profiles.age
        FROM users
        LEFT JOIN profiles
        ON users.id = profiles.user_id";

if(count($where) > 0){
    $sql .= " WHERE " . implode(" AND ", $where);
}

$result = mysqli_query($conn, $sql);
if(!$result){
    die(mysqli_error($conn));
}

?>


<!DOCTYPE html>
<html>

<head>

    <title>Search Users - CinePaalam</title>

    <link rel="stylesheet" href="css/style.css">

</head>

<body>

<!-- NAVBAR -->

  <?php include("includes/navbar.php"); ?>

<!-- CONTAINER -->

<div class="container">

  <h1 class="search-title">🎬 Discover Cinema Talent</h1>

    <p class="search-subtitle">
        Find actors, directors, singers and other cinema professionals.
    </p>

</div>

<h3 class="result-count">

<?php echo mysqli_num_rows($result); ?>

Talents Found

</h3>

<div class="card-container">

    

<?php



if(mysqli_num_rows($result) > 0){

while($row = mysqli_fetch_assoc($result)){

?>

<div class="card">

<?php
if(!empty($row['profile_photo'])){
?>

<img src="uploads/<?php echo $row['profile_photo']; ?>">

<?php
}else{
?>

<img src="images/default.png">

<?php
}
?>

<h3><?php echo $row['full_name']; ?></h3>

<p class="role-badge">
<?php echo $row['role']; ?>
</p>

<p>📍 <?php echo $row['city']; ?></p>

<p>🎂 <?php echo $row['age']; ?> Years</p>

<a href="profile.php?id=<?php echo $row['id']; ?>">
<button>View Profile</button>
</a>

</div>

<?php

}

}else{

?>

<h3 style="margin:auto;">😔 No users found.</h3>

<?php

}

?>


    </div>

</div>

</body>

</html>