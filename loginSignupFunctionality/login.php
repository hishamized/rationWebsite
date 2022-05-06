<?php
    session_start();

    if(isset($_SESSION['username'])) {
        header("location: welcome.php");
        exit;
    } 
    
    require_once "config.php";

    $username = $password = "";
    $err = "";

    if($_SERVER["REQUEST_METHOD"] == "POST") {
        if(empty(trim($_POST['username'])) || empty(trim($_POST['password']))){
            $err = "Please enter a valid username and password. These fields cannot be empty";
        } else {
            $username = trim($_POST['username']);
            $password = trim($_POST['password']);
        }
        if(empty($err)){
            $sql = "SELECT id, username, password FROM users WHERE username = ?";
            $stmt = mysqli_prepare($conn, $sql);
            mysqli_stmt_bind_param($stmt, "s", $param_username);
            $param_username = $username;

            if(mysqli_stmt_execute($stmt)){
                mysqli_stmt_store_result($stmt);
                if(mysqli_stmt_num_rows($stmt) == 1){
                    mysqli_stmt_bind_result($stmt, $id, $username, $hashed_password);
                    if(mysqli_stmt_fetch($stmt)){
                        if(password_verify($password, $hashed_password)){
                            session_start();
                            $_SESSION["username"] = $username;
                            $_SESSION["id"] = $id;
                            $_SESSION["loggedin"] = true;

                            header("location: welcome.php");
                        }
                    }
                }
            }
        }
    }

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login Page</title>
    <script src="https://kit.fontawesome.com/1bc2765d38.js" crossorigin="anonymous"></script>
    <link rel="stylesheet" href="../css/register.css">
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
                <li><a href="#"> <i class="fa-solid fa-right-to-bracket"></i> Log in</a></li>
            </div>
        </ul>
    </nav>
    <!-- Navigation bar end  -->

    <!-- Login form start  -->
     <section class="form-container">
         <form action="" method="POST">
           <h3>Please login here</h3>
           <div class="username">
                <label for="">Username</label>
                <input type="text" name="username" placeholder="eg: cool.mark7364">
           </div>
           <div class="password">
               <label for="">Password</label>
               <input type="password" name="password" placeholder="******">
           </div>
           <button class="signup-button" type="submit">Login</button>
         </form>
     </section>
    <!-- Login form end  -->

</body>
</html>