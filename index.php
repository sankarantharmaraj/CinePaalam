<?php

session_start();

if (!isset($_SESSION['user_name'])) {
    header("Location: login.php");
    exit();
}

include("includes/db.php");
$nav_user = $_SESSION['user_id'];

$nav_sql = "SELECT users.full_name,
                   users.role,
                   profiles.profile_photo
            FROM users
            LEFT JOIN profiles
            ON users.id = profiles.user_id
            WHERE users.id='$nav_user'";

$nav_result = mysqli_query($conn, $nav_sql);

$nav = mysqli_fetch_assoc($nav_result);

?>

<!DOCTYPE html>
<html>

<head>
    <title>CinePaalam - Home</title>
    <link rel="stylesheet" href="css/style.css">
</head>

<body>
    <?php include("includes/navbar.php"); ?>




<div class="container">

    <div class="welcome">
        <h1>Welcome, <?php echo $_SESSION['user_name']; ?> 👋</h1>
        <p><strong>Your Role:</strong> <?php echo $_SESSION['role']; ?></p>
    </div>

    <h2>⭐ Latest Talents</h2>

    <div class="card-container">

<?php

$sql = "SELECT users.id,
               users.full_name,
               users.role,
               profiles.profile_photo
        FROM users
        LEFT JOIN profiles
        ON users.id = profiles.user_id
        ORDER BY users.id DESC";

$result = mysqli_query($conn, $sql);

while($row = mysqli_fetch_assoc($result)){

?>

        <div class="card">

            <?php
            if($row['profile_photo'] != ""){
            ?>

            <img src="uploads/<?php echo $row['profile_photo']; ?>">

            <?php
            }else{
            ?>

            <img src="assets/images/default-profile.png">

            <?php
            }
            ?>

            <h3><?php echo $row['full_name']; ?></h3>

            <p><?php echo $row['role']; ?></p>

            <a href="profile.php?id=<?php echo $row['id']; ?>">
                <button>View Profile</button>
            </a>

        </div>

<?php

}

?>

    </div>

</div>

</body>
</html>