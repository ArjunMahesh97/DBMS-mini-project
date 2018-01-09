<?php 
session_start();
?>
<html>
	<head>
		<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap.min.css"/>
	
	</head>
	<body class="background">
<?php 
include 'style.css' ; 
$model= $_SESSION['model'];

foreach($_REQUEST as $key => $value)
{
    if(substr($key, 0,6)=="remove"){
        $rem_mod = substr($key, 7);
        //var_dump($rem_mod);
    }
}

try {
      $pdo = new PDO("mysql:host=localhost;dbname=mobiledb", 'root', '');
if(!isset($_REQUEST['option'])){      
      if(!isset($rem_mod)){
      
      $sql = 'insert into wishlist(model_id,brand_id,brand_name,model_name,price,user_id,e_commerce) values(:model_id,:brand_id,:brand_name,:model_name,:price,:user,:e_commerce)';
      //var_dump($sql);
      $stmt = $pdo->prepare($sql);
      $stmt->bindParam(':model_id', $model['model_id'], PDO::PARAM_INT);
      $stmt->bindParam(':brand_id', $model['brand_id'], PDO::PARAM_INT);
      $stmt->bindParam(':brand_name', $model['brand_name'], PDO::PARAM_STR);
      $stmt->bindParam(':model_name', $model['model_name'], PDO::PARAM_STR);
      $stmt->bindParam(':price', $model['price'], PDO::PARAM_INT); 
      $stmt->bindParam(':user', $_SESSION['user_id'], PDO::PARAM_INT); 
      $stmt->bindParam(':e_commerce', $model['e_commerce'], PDO::PARAM_STR);
      $r =$stmt->execute();
      
      $r = $stmt->fetch(PDO::FETCH_NUM);
      $stmt->closeCursor();
      
      }
      else{
      $sql = 'delete from wishlist where model_id=:model_id and user_id=:user_id';
      //var_dump($sql);
      //var_dump($rem_mod);
      //var_dump($_SESSION['user_id']);
      $rem=(int)$rem_mod;
      var_dump($rem);
      $stmt = $pdo->prepare($sql);
      $stmt->bindParam(':model_id', $rem, PDO::PARAM_INT);
      $stmt->bindParam(':user_id', $_SESSION['user_id'], PDO::PARAM_INT);
      $r =$stmt->execute();
      
      $r = $stmt->fetchAll(PDO::FETCH_NUM);
      $stmt->closeCursor();
      }
}      
      
      
      $sql = 'select model_id,brand_id,brand_name,model_name,price,e_commerce
    from wishlist
    where user_id =' . $_SESSION['user_id'] . '';
      
      $stmt = $pdo->prepare($sql);
      
      $r =$stmt->execute();
      $models = $stmt->fetchAll(PDO::FETCH_ASSOC);
      
      
      
      
      
      
}
catch (PDOException $pe) {
    die("Error occurred:" . $pe->getMessage());
}
      
            

?>

   		<div id="aa" style="white-space:nowrap">
   	  		<div id="image" style="display:inline;">
       			 <img src="icon.png"/>
    		</div>
    		<div id="texts" style="display:inline; white-space:nowrap;">SMARTPHONE ALLEY</div>
   			<div id="texts" style="display:inline;position:relative;top:-20;left:450; font-size:18px">User: <?php $_SESSION['user_name']?></div>
    		<a id="texts" style="display:inline;position:relative;top:-20;left:500;font-size:18px" href="first.php">Logout</a>
    		 <h4 align=center><a href="login.php" style="font-family : Nexa Bold;text-align:center;font-size:15px;color:#D8D8D8;position:relative;top:-10;left:10;">Not satified? Try changing your budget here</a></h4>
    
      
      
   			</div>
   			<form action="" method="post"> 
  		<div>    		
      		<table id="customers">
  				<tr>
    				<th>BRAND</th>
   					<th>MODEL</th>
    				<th>PRICE</th>
    				<th>e-commerce</th>
    				<th>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</th>
  				</tr>
  				<?php 
  				foreach($models as $mod)
  				{?>
  				 <tr>
  					<td><?php echo $mod['brand_name'] ?></td>
  					<td><?php echo $mod['model_name'] ?></td>
  					<td><?php echo $mod['price'] ?></td>
  					<td><a href="<?php echo $mod['e_commerce'] ?>" target="_blank" style="color:black;">CLICK HERE</a></td>
  					<td><input type="submit" name="remove_<?php echo $mod['model_id']?>" value="Remove" id="remove_<?php echo $mod['model_id']?>" ></td>
  				</tr>
  				<?php }?>
  
    
			</table>
			
		</div>
		</form>
  	</body>
</html>