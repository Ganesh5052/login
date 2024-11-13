<?php
include "dbconnect.php";
$name = $email = $pwd = $conf_pwd = "";
$name_err = $email_err = $pwd_err = $conf_pwd_err = "";
$succ_msg = $err_msg = "";
$error = false;

if(isset($_POST['submit'])){
  $name = trim($_POST['name']);
  $email = trim($_POST['email']);
  $pwd = trim($_POST['pwd']);
  $conf_pwd = trim($_POST['conf_pwd']);

  //Validate Inputs
  if($name == ""){
    $name_err = "Please enter Name";
    $error = true;
  }
  if($email == ""){
    $email_err = "Please enter Email";
    $error = true;
  }
  elseif(!filter_var($email, FILTER_VALIDATE_EMAIL)){
    $email_err = "Invalid Email Format";
    $error = true;
  }
  else{
    $sql = "select * from users where email = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("s", $email);
    $stmt->execute();
    $result = $stmt->get_result();
    if($result->num_rows>0){
      $email_err = "Email already Registered";
      $error = true;
    }
  }
  if($pwd == ""){
    $pwd_err = "Please enter Password";
    $error = true;
  }
  if($conf_pwd == ""){
    $conf_pwd_err = "Please enter Confirm Password";
    $error = true;
  }
  if($pwd != "" && $conf_pwd != ""){
    if($pwd != $conf_pwd){
      $conf_pwd_err = "Passwords do not match";
      $error = true;
    }
  }
  if(!$error){
//procedd for registration
     $pwd = password_hash($pwd, PASSWORD_DEFAULT);
     $sql = "insert into users(name,email,password) values (?,?,?)";

     try{
         $stmt = $conn->prepare($sql);
         $stmt->bind_param("sss", $name, $email, $pwd);
         $stmt->execute();
         $succ_msg ="Registration successful. Please login <a href='login.php'>here</a>";
     }
     catch(Exception $e){
      $err_msg = $e->getMessage();

     }
  }
}
include "topmenu.php";
?>
<div class="container">
   <h1>Registration</h1>
   <div class="show_error">
    <?php
      if(!empty($succ_msg)){?>
      <div class="alert alert-success">
        <?= $succ_msg; ?>
      </div>
      <?php } ?>

      <?php
      if(!empty($err_msg)){?>
      <div class="alert alert-danger">
        <?= $succ_msg; ?>
      </div>
      <?php } ?>
    </div>
   <form action="" method="post">
     <div class="mb-3">
      <label for="name" class="form-label">Name</label>
      <input 
        type="text"
        class="form-control"
        name="name"
        id="name"
        placeholder="Enter Name"
      />
      <div class="text-danger input-err"><?= $name_err?></div>
     </div>

     <div class="mb-3">
      <label for="email" class="form-label">Email</label>
      <input 
        type="text"
        class="form-control"
        name="email"
        id="email"
        placeholder="Enter Email"
        value="<?= $name?>"
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
        value="<?= $email?>"
      />
      <div class="text-danger input-err"><?= $pwd_err?></div>
     </div>

     <div class="mb-3">
      <label for="conf_pwd" class="form-label">Confirm Password</label>
      <input 
        type="password"
        class="form-control"
        name="conf_pwd"
        id="conf_pwd"
        placeholder="Confirm Password"
      />
      <div class="text-danger input-err"><?= $conf_pwd_err?></div>
     </div>

     <div class="form-check">
      <input class="form-check-input" name="" id=""   type="checkbox" value="checkedValue" arial-label="Text for screen reader" onclick = "showPwd()" >Show Password
     </div>
     <div class="text-center">
       <button type="submit" name="submit" class="btn btn-primary">Register</button>
     </div>
     <p>Already Registerd? Login <a href="login.php">here</a></p>
   </form>
</div>

<script>
  function showPwd(){
    var pwd = document.getElementById("pwd");
    var conf_pwd = document.getElementById("conf_pwd");

    if(pwd.type === "text")
       pwd.type = "password";
    else
       pwd.type = "text";

    if(conf_pwd.type === "text")
       conf_pwd.type = "password";
    else
       conf_pwd.type = "text";
  }
</script>
</body>
</html>