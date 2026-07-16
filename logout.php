<?php
session_start();

// Remove session
session_unset();
session_destroy();
?>

<!DOCTYPE html>
<html>

<head>

<title>Logging Out...</title>

<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

</head>

<body>

<script>

Swal.fire({
    icon: 'success',
    title: 'Logged Out!',
    text: 'Thanks for using CinePaalam 🎬',
    timer: 2000,
    showConfirmButton: false
}).then(() => {

    window.location.href = "login.php";

});

</script>

</body>

</html>