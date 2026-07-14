<?php

session_start();

if (!isset($_SESSION['user_name'])) {
    header("Location: login.php");
    exit();
}

include("includes/db.php");

if(isset($_GET['id'])){

    $user_id = $_GET['id'];

}else{

    $user_id = $_SESSION['user_id'];

}
$sql = "SELECT users.full_name,
               users.role,
               profiles.*
        FROM users
        LEFT JOIN profiles
        ON users.id = profiles.user_id
        WHERE users.id='$user_id'";

$result = mysqli_query($conn, $sql);

$profile = mysqli_fetch_assoc($result);
if(!$profile){

    die("User not found.");

}

// Default values if profile is empty

$profile['profile_photo'] = $profile['profile_photo'] ?? "";
$profile['bio'] = $profile['bio'] ?: "No bio added yet.";
$profile['experience'] = $profile['experience'] ?: "No experience added.";
$profile['skills'] = $profile['skills'] ?: "No skills added.";
$profile['languages'] = $profile['languages'] ?: "Not specified.";
$profile['instagram'] = $profile['instagram'] ?: "#";
$profile['youtube'] = $profile['youtube'] ?: "#";

?>

<!DOCTYPE html>
<html>

<head>

    <title>Profile - CinePaalam</title>

    <link rel="stylesheet" href="css/style.css">
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

</head>

<body>

<div class="navbar">

    <div class="logo">
        🎬 CinePaalam
    </div>

    <div class="menu">

        <a href="dashboard.php">Home</a>
        <a href="profile.php">My Profile</a>
        <a href="search.php">Search</a>
        <a href="edit_profile.php">Edit Profile</a>
        <a href="logout.php">Logout</a>

    </div>

</div>


<div class="container">

    <div class="profile-card">

     <?php
if(!empty($profile['profile_photo'])){
?>

<img src="uploads/<?php echo $profile['profile_photo']; ?>" class="profile-img">

<?php
}else{
?>

<img src="images/default.png" class="profile-img">

<?php
}
?>

        <h2><?php echo $profile['full_name']; ?></h2>

        <p class="role"><?php echo $profile['role']; ?></p>

        <hr>

        <div class="profile-section">

            <h3>📝 About</h3>

            <p><?php echo $profile['bio']; ?></p>

        </div>

        <div class="profile-section">

            <h3>🎬 Experience</h3>

            <p><?php echo $profile['experience']; ?></p>

        </div>

        <div class="profile-section">

            <h3>⭐ Skills</h3>

            <p><?php echo $profile['skills']; ?></p>

        </div>

        <div class="profile-section">

            <h3>🌍 Languages</h3>

            <p><?php echo $profile['languages']; ?></p>

        </div>

        <div class="social-buttons">

            <a href="<?php echo $profile['instagram']; ?>" target="_blank">

                <button>📷 Instagram</button>

            </a>

            <a href="<?php echo $profile['youtube']; ?>" target="_blank">

                <button>▶ YouTube</button>

            </a>

        </div>

    </div>

</div>

</body>

</html>