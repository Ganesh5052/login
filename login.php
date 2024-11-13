<?php
session_start();
include "dbconnect.php";
$email = $pwd = "";
$email_err = $pwd_err = "";
$err_msg = "";
$error = false;

if(isset($_POST['submit'])){
  $email = trim($_POST['email']);
  $pwd = trim($_POST['pwd']);


  if(isset($_POST['remember']))
     $remember = $_POST['remember'];
  //Validate Inputs
  if($email == ""){
    $email_err = "Please enter Email";
    $error = true;
  }
  
  if($pwd == ""){
    $pwd_err = "Please enter Password";
    $error = true;
  }
  if(!$error){
//proceed with login
     $sql = "select * from users where email = ?";
     $stmt = $conn->prepare($sql);
     $stmt->bind_param("s", $email);
     $stmt->execute();
     $result = $stmt->get_result();
     if($result->num_rows == 1){
         $row = $result->fetch_assoc();
         $stored_pwd = $row['password'];
         if(password_verify($pwd, $stored_pwd)){
           //successful login
           if(isset($_POST['remember'])){
            //set cokie for email and checkbox
            setcookie("remember_email", $email, time()+365*24*60*60); //here we can metion the dates only
            setcookie("remember", $remember, time()+365*24*60*60); 
           }
           else{
             //delete cokie for email and checkbox
             setcookie("remember_email", $email, time() - 365*24*60*60); //here we can metion the dates only
             setcookie("remember", $remember, time() - 365*24*60*60); 
           }
           $_SESSION['name'] = $row['name'];
           header("location:index.php");
         }
         else{
          $err_msg = "Incorrect Password";
         }
     }
     else{
      $err_msg = "Email is not Registered";
     }
  }
}
include "topmenu.php";
?>
<div class="container">
   <h1>Login</h1>
   <div class="show_error">
      <?php
      if(!empty($err_msg)){?>
      <div class="alert alert-danger">
        <?= $err_msg; ?>
      </div>
      <?php } ?>
    </div>
   <form action="" method="post">
     <?php
     $display_email = isset($_COOKIE['remember_email']) ? $_COOKIE['remember_email'] : $email;
     $checked = isset($_COOKIE['remember']) ? "checked":(!empty($remember) ? "checked" : "");
     ?>
     <div class="mb-3">
      <label for="email" class="form-label">Email</label>
      <input 
        type="text"
        class="form-control"
        name="email"
        id="email"
        placeholder="Enter Email"
        value="<?= $display_email?>"
      />
      <div class="text-danger input-err"><?= $email_err?></div>
     </div>

     <div class="mb-3">
      <label for="pwd" class="form-label">Password</label>
      <input 
        type="password"
        class="form-control"
        name="pwd"
        id="pwd"
        placeholder="Enter Password"
        value="<?= $pwd?>"
      />
      <div class="text-danger input-err"><?= $pwd_err?></div>
     </div>

     <div class="form-check">
      <input class="form-check-input" name="remember" id="remember"   type="checkbox" value="checkedValue" 
      arial-label="Text for screen reader" <?= $checked?> /> Remember Me
     </div>
     <div class="text-center">
       <button type="submit" name="submit" class="btn btn-primary">Login</button>
     </div>
     <p>Not Registerd? Register <a href="register.php">here</a></p>
   </form>
</div>

</body>
</html>