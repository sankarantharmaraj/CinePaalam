<?php

session_start();
include("includes/db.php");

$error = false;

if ($_SERVER["REQUEST_METHOD"] == "POST") {

    $email = $_POST['email'];
    $password = $_POST['password'];

  $stmt = mysqli_prepare($conn, "SELECT * FROM users WHERE email=?");

mysqli_stmt_bind_param($stmt, "s", $email);

mysqli_stmt_execute($stmt);

$result = mysqli_stmt_get_result($stmt);
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

            $error = true;

        }

    } else {

        $error = true;

    }

}

?>

<!DOCTYPE html>
<html>

<head>
    <title>Login - CinePaalam</title>
    <link rel="stylesheet" href="css/style.css">
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
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
<?php if($error){ ?>

<script>

Swal.fire({
    icon: 'error',
    title: 'Login Failed',
    text: 'Invalid email or password.'
});

</script>

<?php } ?>


</body>
</html>