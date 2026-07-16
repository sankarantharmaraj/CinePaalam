<?php

$nav_user = $_SESSION['user_id'];

$nav_sql = "SELECT users.full_name,
                   users.role,
                   profiles.profile_photo
            FROM users
            LEFT JOIN profiles
            ON users.id = profiles.user_id
            WHERE users.id='$nav_user'";

$nav_result = mysqli_query($conn, $nav_sql);

$nav = mysqli_fetch_assoc($nav_result);

?>

<div class="navbar">

    <div class="logo">
        🎬 CinePaalam
    </div>

    <div class="menu">

        <a href="index.php">Home</a>

        <a href="search.php">Search</a>

        <div class="profile-dropdown">

<?php
if(!empty($nav['profile_photo'])){
?>

<img src="uploads/<?php echo $nav['profile_photo']; ?>" class="nav-profile"  id="profileBtn">

<?php
}else{
?>

<img src="images/default.png" class="nav-profile" id="profileBtn">

<?php
}
?>


<div class="dropdown-content"  id="profileMenu">

<h4><?php echo $nav['full_name']; ?></h4>

<p><?php echo $nav['role']; ?></p>

<hr>

<a href="profile.php">👤 My Profile</a>

<a href="edit_profile.php">✏️ Edit Profile</a>
<a href="#" onclick="confirmLogout()">🚪 Logout</a>

</div>

</div>

</div>

</div>

<script>

const btn = document.getElementById("profileBtn");
const menu = document.getElementById("profileMenu");

btn.addEventListener("click", function(e){
    e.stopPropagation();

    if(menu.style.display === "block"){
        menu.style.display = "none";
    }else{
        menu.style.display = "block";
    }
});

document.addEventListener("click", function(){
    menu.style.display = "none";
});

menu.addEventListener("click", function(e){
    e.stopPropagation();
});

</script>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

<script>

function confirmLogout(){

    Swal.fire({
        title: 'Logout?',
        text: 'Are you sure you want to logout?',
        icon: 'question',
        showCancelButton: true,
        confirmButtonColor: '#2563eb',
        cancelButtonColor: '#6b7280',
        confirmButtonText: 'Yes, Logout',
        cancelButtonText: 'Cancel'
    }).then((result) => {

        if(result.isConfirmed){
            window.location.href = "logout.php";
        }

    });

}

</script>