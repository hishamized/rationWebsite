<?php
    session_start();

    if(!isset($_SESSION['loggedin']) || isset($_SESSION['loggedin']) !== true) {
        header("location: login.php");
    }
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Welcome</title>
    <script src="https://kit.fontawesome.com/1bc2765d38.js" crossorigin="anonymous"></script>
    <link rel="stylesheet" href="../css/register.css">
    <link rel="stylesheet" href="../css/welcome.css">
</head>
<body>
     <!-- Navigation bar start  -->
     <nav>
        <ul class="navbar">
            <div class="left-nav">
                <li><a href="./register.php">Home</a></li>
                <li><a href="#">Contact Us</a></li>
                <li><a href="#">Donate</a></li>
            </div>
            <div class="right-nav">
                <li><a href="./register.php"><i class="fa-solid fa-user-plus"></i> Sign Up</a></li>
                <li><a href="./logout.php"><i class="fa-solid fa-right-to-bracket"></i> Log-out</a></li>
            </div>
        </ul>
    </nav>
    <!-- Navigation bar end  -->
   <div class="welcome">
       <h3> <?php echo "Welcome  ". $_SESSION['username'] ?>! You can now use the website. </h3>
   </div>
</body>
</html>