
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

<div class="login-page">

    <div class="login-card">

        <h1>🎬 CinePaalam</h1>

        <p class="subtitle">Join The Bridge Between Talent and Cinema 🎥</p>

        <form action="" method="POST">

            <label>Full Name</label>
            <input type="text"
                   name="full_name"
                   placeholder="Enter your full name"
                   required>

            <label>Email Address</label>
            <input type="email"
                   name="email"
                   placeholder="Enter your email"
                   required>

            <label>Password</label>
            <input type="password"
                   name="password"
                   placeholder="Create a password"
                   required>

            <label>Confirm Password</label>
            <input type="password"
                   name="confirm_password"
                   placeholder="Confirm your password"
                   required>

            <label>Select Role</label>

            <select name="role" required>

                <option value="">Choose your role</option>

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

            <label>Phone Number</label>
            <input type="text"
                   name="phone"
                   placeholder="Enter your phone number"
                   required>

            <label>City</label>
            <input type="text"
                   name="city"
                   placeholder="Enter your city"
                   required>

            <button type="submit">
                Create Account
            </button>

        </form>

        <p class="bottom-text">
            Already have an account?
            <a href="login.php">Login</a>
        </p>

    </div>

</div>

</body>

</html>