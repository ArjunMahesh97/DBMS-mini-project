<?php 
session_start();

?>
<html>
<head>
	<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap.min.css"/>
	</head>
<div class="background">
<?php 
include 'style.css' ; 
if(!isset($_REQUEST['name'])) {
?>

   <div id="aa" style="white-space:nowrap">
   	  <div id="image" style="display:inline;">
        <img src="icon.png"/>
    </div>
      <div id="texts" style="display:inline; white-space:nowrap;">SMARTPHONE ALLEY</div>
      
      </div>
 	<form action="" method="post">
  <div class="container1">
    <label><b>Username</b></label>
    <input type="text" placeholder="Enter Username" name="name" required>
    
    <label><b>Email</b></label>
    <input type="text" placeholder="Enter Email" name="email" required>

    <label><b>Password</b></label>
    <input type="password" placeholder="Enter Password" name="psw" required>
    <div id="b"><input type="submit" value="Sign Up" /></div>

    
     
  </div>
</form>
 
 <?php
} else {
    try {
        $pdo = new PDO("mysql:host=localhost;dbname=mobiledb", 'root', '');
        
        // execute the stored procedure
        $sql = 'CALL insertUser(:name,:email,:psw,@msg,@user_id)';
        $stmt = $pdo->prepare($sql);
        
        $stmt->bindParam(':name', $_REQUEST['name'], PDO::PARAM_STR);
        $stmt->bindParam(':email', $_REQUEST['email'], PDO::PARAM_STR);
        $stmt->bindParam(':psw', $_REQUEST['psw'], PDO::PARAM_STR);
        $stmt->execute();
        $stmt->closeCursor();
        
        // execute the second query to get values from OUT parameter
        $msg="";
        $r = $pdo->query("SELECT @msg,@user_id")
        ->fetch(PDO::FETCH_ASSOC);
        if ($r) {
            printf('msg:%s',
                $r['@msg']);
            $msg= $r['@msg'];
            $user_id=$r['@user_id'];
        }
        if($msg == 'success') {
             // call next screen
             $_SESSION['user_id'] = $user_id;
             $_SESSION['user_name'] = $_REQUEST['name'];
             echo "<script>alert('Welcome " . $_SESSION['user_name'] . "');document.location='login.php'</script>";
        } else {
            printf("Failed creating user");
            $_SESSION['user_id'] = 0;
            $_SESSION['user_name'] = 'Unknown';
            unset($_REQUEST['name']);
            echo "<script>alert('Failed creating user, please try diferent user name');document.location='signup.php'</script>";
        }
        //var_dump($_SESSION);
    } catch (PDOException $pe) {
        die("Error occurred:" . $pe->getMessage());
    }
}
 ?>     
 </div>
 	
</html> 