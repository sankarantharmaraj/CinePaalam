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

?>

<!DOCTYPE html>
<html>

<head>

    <title>Search Users - CinePaalam</title>

    <link rel="stylesheet" href="css/style.css">

</head>

<body>

<!-- NAVBAR -->

<div class="navbar">

    <div class="logo">
        🎬 CinePaalam
    </div>

    <div class="menu">
        <a href="index.php">Home</a>
        <a href="profile.php">My Profile</a>
        <a href="edit_profile.php">Edit Profile</a>
        <a href="logout.php">Logout</a>
    </div>

</div>

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

            <button type="submit">
                Search
            </button>

        </form>

    </div>

    <div class="card-container">

<?php

if($search != ""){

$sql = "SELECT users.id,
               users.full_name,
               users.role,
               users.city,
               profiles.profile_photo
        FROM users
        LEFT JOIN profiles
        ON users.id = profiles.user_id
        WHERE users.full_name LIKE '%$search%'
        OR users.role LIKE '%$search%'
        OR users.city LIKE '%$search%'";

$result = mysqli_query($conn,$sql);

if(mysqli_num_rows($result)>0){

while($row=mysqli_fetch_assoc($result)){

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

<a href="profile.php?id=<?php echo $row['id']; ?>">

<button>

View Profile

</button>

</a>

</div>

<?php

}

}else{

?>

<h3 style="margin:auto;">😔 No users found.</h3>

<?php

}

}

?>

    </div>

</div>

</body>

</html>