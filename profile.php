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
       users.phone,
       users.city,
       profiles.*
FROM users
LEFT JOIN profiles
ON users.id = profiles.user_id
WHERE users.id='$user_id'";

$result = mysqli_query($conn, $sql);

$profile = mysqli_fetch_assoc($result);

$profile_completion = 0;

if (!empty($profile['profile_photo'])) {
    $profile_completion += 15;
}

if (!empty($profile['bio'])) {
    $profile_completion += 15;
}

if (!empty($profile['experience'])) {
    $profile_completion += 15;
}

if (!empty($profile['skills'])) {
    $profile_completion += 15;
}

if (!empty($profile['languages'])) {
    $profile_completion += 10;
}

if (!empty($profile['instagram']) && $profile['instagram'] != "#") {
    $profile_completion += 10;
}

if (!empty($profile['youtube']) && $profile['youtube'] != "#") {
    $profile_completion += 10;
}

if (!empty($profile['phone'])) {
    $profile_completion += 5;
}

if (!empty($profile['city'])) {
    $profile_completion += 5;
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

  <?php include("includes/navbar.php"); ?>


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
<?php
$isOwner = ($user_id == $_SESSION['user_id']);
?>

<h2><?php echo $profile['full_name']; ?></h2>

<p class="role"><?php echo $profile['role']; ?></p>

<?php if($isOwner && $profile_completion < 100){ ?>

<h3 style="margin-top:15px;">
    Profile Completion: <?php echo $profile_completion; ?>%
</h3>



<p class="progress-text">
    <?php echo $profile_completion; ?>% Completed
</p>
<?php



$missing = [];

if(empty($profile['profile_photo'])) $missing[] = "📷 Profile Photo";
if(empty($profile['bio'])) $missing[] = "📝 Bio";
if(empty($profile['experience'])) $missing[] = "🎬 Experience";
if(empty($profile['skills'])) $missing[] = "⭐ Skills";
if(empty($profile['languages'])) $missing[] = "🌍 Languages";
if(empty($profile['instagram']) || $profile['instagram'] == "#"){
    $missing[] = "📷 Instagram";
}

if(empty($profile['youtube']) || $profile['youtube'] == "#"){
    $missing[] = "▶ YouTube";
}
if(empty($profile['phone'])) $missing[] = "📞 Phone";
if(empty($profile['city'])) $missing[] = "📍 City";

if(count($missing) > 0){
?>

<div class="missing-fields">

    <h4>Complete these to reach 100%</h4>

    <ul>

    <?php
    foreach($missing as $item){
        echo "<li>$item</li>";
    }
    ?>

    </ul>

</div>

<?php
}
?>
<?php } ?>

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