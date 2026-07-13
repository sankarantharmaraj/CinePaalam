
<?php

include("includes/db.php");

if ($_SERVER["REQUEST_METHOD"] == "POST") {

    $full_name = $_POST['full_name'];
    $email = $_POST['email'];
    $password = $_POST['password'];
    $confirm_password = $_POST['confirm_password'];
    $role = $_POST['role'];
    $phone = $_POST['phone'];
    $city = $_POST['city'];

    // Check password
    if($password != $confirm_password){
        die("Passwords do not match!");
    }

    // Hash password
    $password = password_hash($password, PASSWORD_DEFAULT);

    // Insert query
    $sql = "INSERT INTO users(full_name,email,password,role,phone,city)
            VALUES('$full_name','$email','$password','$role','$phone','$city')";

    if(mysqli_query($conn,$sql)){
        echo "<h2 style='color:green;'>Registration Successful 🎉</h2>";
    }else{
        echo "Error : ".mysqli_error($conn);
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

    <div>
        <label>Phone Number</label>
        <input type="text"
               name="phone"
               placeholder="Enter phone number"
               required>
    </div>

    <div>
        <label>City</label>
        <input type="text"
               name="city"
               placeholder="Enter your city"
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

</body>

</html>