<?php

session_start();

if (!isset($_SESSION['user_name'])) {
    header("Location: login.php");
    exit();
}

include("includes/db.php");

$sender_id = $_SESSION['user_id'];
$receiver_id = $_GET['id'];
$sql = "SELECT users.full_name,
               profiles.profile_photo
        FROM users
        LEFT JOIN profiles
        ON users.id = profiles.user_id
        WHERE users.id='$receiver_id'";

$result = mysqli_query($conn, $sql);
if (!$result) {
    die("SQL Error: " . mysqli_error($conn));
}

$user = mysqli_fetch_assoc($result);

?>

<!DOCTYPE html>
<html>

<head>

    <title>Chat</title>

    <link rel="stylesheet" href="css/style.css">

</head>

<body>

<?php include("includes/navbar.php"); ?>

<div class="chat-container">

    <div class="chat-header">

        <img src="uploads/<?php echo $user['profile_photo']; ?>" class="chat-profile">

        <div>

            <h2><?php echo $user['full_name']; ?></h2>

            <p>Online</p>

        </div>

    </div>

    <div class="chat-messages">

    </div>

    <form class="chat-input">

        <input
            type="text"
            placeholder="Type a message..."
            name="message">

        <button type="submit">

            Send

        </button>

    </form>

</div>

</div>

</body>

</html>