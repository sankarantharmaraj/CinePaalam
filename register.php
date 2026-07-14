
<?php

include("includes/db.php");
$success = false;
$error = false;

if ($_SERVER["REQUEST_METHOD"] == "POST") {

    $full_name = $_POST['full_name'];
    $email = $_POST['email'];
    $password = $_POST['password'];
    $confirm_password = $_POST['confirm_password'];
    $role = $_POST['role'];


    // Check password
    if($password != $confirm_password){
        die("Passwords do not match!");
    }

    // Hash password
    $password = password_hash($password, PASSWORD_DEFAULT);

   $sql = "INSERT INTO users(full_name,email,password,role)
VALUES('$full_name','$email','$password','$role')";

if(mysqli_query($conn,$sql)){

    // Get newly created user ID
    $user_id = mysqli_insert_id($conn);

    // Create empty profile automatically
    $profile_sql = "INSERT INTO profiles
    (user_id, bio, age, gender, experience, skills, languages, instagram, youtube, profile_photo)
    VALUES
    ('$user_id', '', 0, '', '', '', '', '', '', '')";

    mysqli_query($conn, $profile_sql);

    $success = true;

}else{

    $error = true;

}
}

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Register - CinePaalam</title>

    <link rel="stylesheet" href="css/style.css">
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
</head>

<body>

    <div class="register-container">

        <div class="login-card">

            <h1>🎬 CinePaalam</h1>
          <p class="tagline">
    The Bridge Between Talent and Cinema 
</p>
<form action="" method="POST">

<div class="register-grid">

    <div>
        <label>Full Name</label>
        <input type="text"
               name="full_name"
               placeholder="Enter your full name"
               required>
    </div>

    <div>
        <label>Email Address</label>
        <input type="email"
               name="email"
               placeholder="Enter your email"
               required>
    </div>

    <div>
        <label>Password</label>
        <input type="password"
               name="password"
               placeholder="Enter password"
               required>
    </div>

    <div>
        <label>Confirm Password</label>
        <input type="password"
               name="confirm_password"
               placeholder="Confirm password"
               required>
    </div>

  

    <div class="full">
        <label>Select Role</label>

        <select name="role" required>

            <option value="">-- Select Role --</option>

            <option>Actor</option>
            <option>Director</option>
            <option>Producer</option>
            <option>Assistant Director</option>
            <option>Writer</option>
            <option>Editor</option>
            <option>Cinematographer</option>
            <option>Music Composer</option>
            <option>Singer</option>
            <option>Dancer</option>
            <option>Art Director</option>

        </select>
    </div>

    <div class="full">
        <button type="submit">Create Account</button>
    </div>

</div>

</form>

            <p class="login-link">
                Already have an account?
                <a href="login.php">Login</a>
            </p>

        </div>

    </div>
    <?php if($success){ ?>

<script>
Swal.fire({
    icon: 'success',
    title: 'Registration Successful!',
    text: 'Welcome to CinePaalam!',
    timer: 2000,
    showConfirmButton: false
}).then(() => {
    setTimeout(function () {
    window.location.href = "login.php";
}, 2000);
});
</script>

<?php } ?>

<?php if($error){ ?>

<script>
Swal.fire({
    icon: 'error',
    title: 'Registration Failed!',
    text: 'Please try again.'
});
</script>

<?php } ?>

</body>

</html>