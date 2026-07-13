<?php

session_start();
include("includes/db.php");

if ($_SERVER["REQUEST_METHOD"] == "POST") {

    $email = $_POST['email'];
    $password = $_POST['password'];

    $sql = "SELECT * FROM users WHERE email='$email'";
    $result = mysqli_query($conn, $sql);

    if (mysqli_num_rows($result) > 0) {

        $user = mysqli_fetch_assoc($result);

        if (password_verify($password, $user['password'])) {

            // Store user details in session
            $_SESSION['user_id'] = $user['id'];
            $_SESSION['user_name'] = $user['full_name'];
            $_SESSION['email'] = $user['email'];
            $_SESSION['role'] = $user['role'];

            header("Location: dashboard.php");
            exit();

        } else {

            echo "<h2 style='color:red;'>Incorrect Password ❌</h2>";

        }

    } else {

        echo "<h2 style='color:red;'>Email Not Found ❌</h2>";

    }

}

?>

<!DOCTYPE html>
<html>

<head>
    <title>Login - CinePaalam</title>
    <link rel="stylesheet" href="css/style.css">
</head>

<body>



<div class="login-page">

    <div class="login-card">

        <h1>🎬 CinePaalam</h1>

        <p class="subtitle">Welcome Back 👋</p>

        <form action="" method="POST">

            <label>Email Address</label>
            <input type="email" name="email" placeholder="Enter your email" required>

            <label>Password</label>
            <input type="password" name="password" placeholder="Enter your password" required>

            <button type="submit">Login</button>

        </form>

        <p class="bottom-text">
            Don't have an account?
            <a href="register.php">Register</a>
        </p>

    </div>

</div>



</body>
</html>