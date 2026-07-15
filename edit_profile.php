<?php
session_start();

if (!isset($_SESSION['user_name'])) {
    header("Location: login.php");
    exit();
}

include("includes/db.php");
$success = false;
$error = false;
$user_id = $_SESSION['user_id'];
$sql = "SELECT users.full_name,
               users.email,
               users.role,
               profiles.*
        FROM users
        LEFT JOIN profiles
        ON users.id = profiles.user_id
        WHERE users.id='$user_id'";
$result = mysqli_query($conn, $sql);

$profile = mysqli_fetch_assoc($result);
if($profile == null){

 $profile = [

    "full_name" => "",
    "email" => "",
    "role" => "",

    "bio" => "",
    "age" => "",
    "gender" => "",
    "experience" => "",
    "skills" => "",
    "languages" => "",
    "instagram" => "",
    "youtube" => "",
    "profile_photo" => "",
    "phone" => "",
    "city" => ""

];

}

if ($_SERVER["REQUEST_METHOD"] == "POST") {

  $user_id = $_SESSION['user_id'];

$bio = $_POST['bio'];
$age = $_POST['age'];
$gender = $_POST['gender'];
$experience = $_POST['experience'];
$skills = $_POST['skills'];
$languages = $_POST['languages'];
$instagram = $_POST['instagram'];
$youtube = $_POST['youtube'];
$phone = $_POST['phone'];
$city = $_POST['city'];
if(!preg_match('/^[6-9][0-9]{9}$/', $phone)){

    echo "
    <script>
    Swal.fire({
        icon:'error',
        title:'Invalid Phone Number',
        text:'Phone number must contain exactly 10 digits and start with 6, 7, 8, or 9.'
    });
    </script>";

    exit();
}


$photo_name = $_FILES['profile_photo']['name'];
$photo_tmp = $_FILES['profile_photo']['tmp_name'];

if($photo_name != ""){

    move_uploaded_file($photo_tmp, "uploads/" . $photo_name);

}else{

    // Keep old photo
    $photo_name = $profile['profile_photo'];

}

// echo "Photo Uploaded Successfully! ✅<br><br>";
// echo "Photo Name: " . $photo_name . "<br><br>";

// Check if profile already exists
$check = "SELECT * FROM profiles WHERE user_id='$user_id'";
$check_result = mysqli_query($conn, $check);

if(mysqli_num_rows($check_result) > 0){

    // UPDATE Existing Profile
    $sql = "UPDATE profiles SET
            bio='$bio',
            age='$age',
            gender='$gender',
            experience='$experience',
            skills='$skills',
            languages='$languages',
            instagram='$instagram',
            youtube='$youtube',
            profile_photo='$photo_name',
            phone='$phone',
            city='$city'
            WHERE user_id='$user_id'";

}else{

    // INSERT New Profile
    $sql = "INSERT INTO profiles
(user_id, bio, age, gender, experience, skills, languages, instagram, youtube, profile_photo, phone, city)
VALUES
('$user_id',
'$bio',
'$age',
'$gender',
'$experience',
'$skills',
'$languages',
'$instagram',
'$youtube',
'$photo_name',
'$phone',
'$city')";
}

// Execute Query
if(mysqli_query($conn, $sql)){
    $success = true;
}else{
    $error = true;
}


    // echo "<h2 style='color:green;'>Profile Form Submitted Successfully! 🎉</h2>";

    // echo "User ID : $user_id <br><br>";

    // echo "Bio: $bio <br>";
    // echo "Age: $age <br>";
    // echo "Gender: $gender <br>";
    // echo "Experience: $experience <br>";
    // echo "Skills: $skills <br>";
    // echo "Languages: $languages <br>";
    // echo "Instagram: $instagram <br>";
    // echo "YouTube: $youtube <br>";

}
?>
<!DOCTYPE html>
<html>

<head>
    <title>Edit Profile - CinePaalam</title>
    <link rel="stylesheet" href="css/style.css">
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
</head>

<body>

<div class="navbar">

    <div class="logo">
        🎬 CinePaalam
    </div>

    <div class="menu">
        <a href="index.php">Home</a>
        <a href="profile.php">My Profile</a>
        <a href="search.php">Search</a>
        <a href="logout.php">Logout</a>
    </div>

</div>

<div class="container">

<div class="register-box">

<h1>🎬 Edit Profile</h1>
<p>Complete your cinema profile</p>

<form action="" method="POST" enctype="multipart/form-data">

<div class="form-grid">

<div>

<label>Bio</label>
s
<textarea
name="bio"
rows="6"
placeholder="Tell people about yourself..."
required><?php echo $profile['bio']; ?></textarea>

</div>

<div>

<label>Profile Photo</label>

<?php
if(!empty($profile['profile_photo'])){
?>

<img src="uploads/<?php echo $profile['profile_photo']; ?>"
class="edit-profile-photo">

<?php
}
?>

<input
type="file"
name="profile_photo"
accept="image/*">

</div>

<div>

<label>Age</label>

<input
type="number"
name="age"
value="<?php echo $profile['age']; ?>"
required>

</div>

<div>

<label>Gender</label>

<select name="gender" required>

<option value="">-- Select Gender --</option>

<option value="Male" <?php if($profile['gender']=="Male") echo "selected"; ?>>
Male
</option>

<option value="Female" <?php if($profile['gender']=="Female") echo "selected"; ?>>
Female
</option>

<option value="Other" <?php if($profile['gender']=="Other") echo "selected"; ?>>
Other
</option>

</select>

</div>

<div>

<label>Phone Number</label>

<input
type="text"
name="phone"
value="<?php echo $profile['phone']; ?>"
maxlength="10"
pattern="[6-9][0-9]{9}"
title="Enter a valid 10-digit Indian phone number"
required>

</div>

<div>

<label>City</label>

<input
type="text"
name="city"
value="<?php echo $profile['city']; ?>">

</div>

<div>

<label>Experience</label>

<input
type="text"
name="experience"
value="<?php echo $profile['experience']; ?>"
placeholder="Example: 3 Short Films">

</div>

<div>

<label>Languages</label>

<input
type="text"
name="languages"
value="<?php echo $profile['languages']; ?>"
placeholder="Tamil, English">

</div>

</div>

<label>Skills</label>

<textarea
name="skills"
rows="4"
placeholder="Acting, Singing, Editing..."
required><?php echo $profile['skills']; ?></textarea>

<label>Instagram Profile</label>

<input
type="url"
name="instagram"
value="<?php echo $profile['instagram']; ?>"
placeholder="https://www.instagram.com/username">

<label>YouTube Channel</label>

<input
type="url"
name="youtube"
value="<?php echo $profile['youtube']; ?>"
placeholder="https://www.youtube.com/@channel">

<br>

<button type="submit">
💾 Save Profile
</button>

</form>

</div>

</div>
<?php if($success){ ?>

<script>
Swal.fire({
    icon: 'success',
    title: 'Profile Saved!',
    text: 'Your profile has been updated successfully.',
    timer: 2000,
    showConfirmButton: false
});
</script>

<?php } ?>

<?php if($error){ ?>

<script>
Swal.fire({
    icon: 'error',
    title: 'Oops!',
    text: 'Something went wrong!',
});
</script>

<?php } ?>

</body>

</html>