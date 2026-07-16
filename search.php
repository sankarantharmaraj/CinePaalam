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

$min_age = "";

if(isset($_GET['min_age'])){
    $min_age = $_GET['min_age'];
}

$max_age = "";

if(isset($_GET['max_age'])){
    $max_age = $_GET['max_age'];
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

    <div class="search-box">

        <h2>🔍 Find Cinema Talents</h2>

        <p>Search by Name, Role or City</p>

        <form method="GET">

           <input
    type="text"
    name="search"
    placeholder="Search actors, directors, singers..."
    value="<?php echo $search; ?>">

<div class="filter-grid">

    <input
        type="text"
        name="city"
        placeholder="City"
        value="<?php echo $city; ?>">

    <input
        type="number"
        name="min_age"
        placeholder="Min Age"
        value="<?php echo $min_age; ?>">

    <input
        type="number"
        name="max_age"
        placeholder="Max Age"
        value="<?php echo $max_age; ?>">

</div>

<button type="submit">
    Search
</button>

        </form>

    </div>

    <div class="card-container">

<?php


$where = [];

if($search != ""){
    $where[] = "(users.full_name LIKE '%$search%'
              OR users.role LIKE '%$search%'
              OR users.city LIKE '%$search%')";
}

if($city != ""){
    $where[] = "users.city LIKE '%$city%'";
}

if($min_age != ""){
    $where[] = "profiles.age >= '$min_age'";
}

if($max_age != ""){
    $where[] = "profiles.age <= '$max_age'";
}

$sql = "SELECT users.id,
               users.full_name,
               users.role,
               users.city,
               profiles.profile_photo,
               profiles.age
        FROM users
        LEFT JOIN profiles
        ON users.id = profiles.user_id";

if(count($where) > 0){
    $sql .= " WHERE " . implode(" AND ", $where);
}

$result = mysqli_query($conn, $sql);

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