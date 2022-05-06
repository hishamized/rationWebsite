<?php 
   require_once "config.php";

   $username = $password = $confirm_password = $adhaar =  "";
   $username_err = $password_err = $confirm_password_err = $adhaar_err = "";

   if($_SERVER["REQUEST_METHOD"] == "POST"){
       //Check for username
       if(empty(trim($_POST["username"]))){
           $username_err = "Username cannot be empty";
       }
       else {
           $sql = "SELECT id FROM users where username = ?";
           $stmt = mysqli_prepare($conn, $sql);

           if($stmt){
               mysqli_stmt_bind_param($stmt, "s", $param_username);
               $param_username = trim($_POST["username"]);

               if(mysqli_stmt_execute($stmt)){
                   mysqli_stmt_store_result($stmt);
                   if(mysqli_stmt_num_rows($stmt) == 1){
                       $username_err = "This username is taken. Try another one";
                   }
                   else {
                       $username = trim($_POST["username"]);
                   }
               }
               else {
                   echo "Something went wrong";
               }
           }
       }
       mysqli_stmt_close($stmt);    
        
       //check for password
       if(empty(trim($_POST["password"]))){
           $password_err = "Password cannot be empty";
       }
       elseif(strlen(trim($_POST["password"])) < 5){
           $password_err = "Password must be atleast 6 characters.";
       }
       else {
           $password = trim($_POST["password"]);
       }

       if(trim($_POST["password"]) != trim($_POST["confirm_password"])){
           $password_err = "Passwords do not match";
       }

       //check adhaar card number
       if(empty(trim($_POST["adhaar"]))){
           $adhaar_err = "Please enter your 12 digit adhaar number";
       } else {
           $adhaar = trim($_POST["adhaar"]);
       }

       //if there are no errors then go ahead and store user details in database
       if(empty($username_err)   && empty($password_err)  && empty($confirm_password_err) && empty($adhaar_err)){
           $sql = "INSERT INTO users (username, password, Adhaar) VALUES (?, ?, ?)";
           $stmt = mysqli_prepare($conn, $sql);
           if($stmt){
               mysqli_stmt_bind_param($stmt, "sss", $param_username, $param_password, $param_adhaar);

               $param_username = $_POST["username"];
               $param_password = password_hash($_POST["password"], PASSWORD_DEFAULT);
               $param_adhaar = $_POST["adhaar"];

               if(mysqli_stmt_execute($stmt)){
                   header("location: login.php");
               }
               else {
                   echo "Something went wrong";
               }
           }
           mysqli_stmt_close($stmt);
       }
      mysqli_close($conn);
   }
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Register Page</title>
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
                <li><a href="./login.php"> <i class="fa-solid fa-right-to-bracket"></i> Log in</a></li>
            </div>
        </ul>
    </nav>
    <!-- Navigation bar end  -->

    <!-- Sign up form start  -->
     <section class="form-container">
         <form class="form" action="" method="POST">
           <h3>Please fill in all the details to get registered</h3>
           <div class="username form-item">
                <label for="">Username</label>
                <input type="text" name="username" placeholder="eg: cool.mark7364">
           </div>
           <div class="password form-item">
               <label for="">Password</label>
               <input type="password" name="password" placeholder="******">
           </div>
           <div class="password form-item">
               <label for="">Confirm Password</label>
               <input type="password" name="confirm_password" placeholder="******">
           </div>
           <div class="form-item">
               <label for="">Adhaar No.</label>
               <input type="text" min="12" name="adhaar" placeholder="Eg: 4325 6452 1238">
           </div>
           <button class="signup-button form-item" type="submit">SignUp</button>
         </form>
     </section>
    <!-- Sign up form end  -->

</body>
</html>