<?php 
session_start();
$_SESSION['abc'] = 1;
$_SESSION['model']="";
?>
<html>
<head>
	<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap.min.css"/>
	
	</head>
<body class="background">
<?php 
include 'style.css' ; 

foreach($_REQUEST as $key => $value)
{
}

try {
    $pdo = new PDO("mysql:host=localhost;dbname=mobiledb", 'root', '');
    // execute the stored procedure
    
    $_SESSION['abc'] = $key;
    
    $sql = 'select m.e_commerce,m.model_id,m.brand_id,m.price,m.popularity,b.brand_name,m.model_name,s.p_camera,s.s_camera,s.ram,s.rom,s.screen_size,o.os_name,o.os_version,s.battery,p.processor_name,p.p_vendor,p.gpu,p.no_of_cores,m.img 
    from brand b,model m,specifications s,processor p,operating_system o 
    where b.brand_id=m.brand_id and b.brand_id=s.brand_id and s.model_id=m.model_id and s.os_id=o.os_id and s.processor_id=p.processor_id and s.model_id=' .$key .'';

    $stmt = $pdo->prepare($sql);
    
    $r =$stmt->execute();
    $models = $stmt->fetchAll(PDO::FETCH_ASSOC);
    //var_dump($models);
    $model = $models[0];
    $_SESSION['model']=$model;
    //var_dump($model);
    //$conn->close();
    
    //var_dump($models);
    //var_dump($models[9]['model_name']);
    // while ($row = $stmt->fetch(PDO::FETCH_NUM, PDO::FETCH_ORI_NEXT)) {
    //     $data = $row[0] . ":" . $row[1]  . "\n";
    //    print $data;
    //  var_dump($data);
    //}
    
    /* if($uid > 0) {
     $username = $_REQUEST['uname'];
     
     }*/
    //var_dump($uid);
    // execute the second query to get values from OUT parameter
    //var_dump($r);
} catch (PDOException $pe) {
    die("Error occurred:" . $pe->getMessage());
}
?>

   <div id="aa" style="white-space:nowrap">
   	  <div id="image" style="display:inline;">
        <img src="icon.png"/>
    </div>
      <div id="texts" style="display:inline; white-space:nowrap;">SMARTPHONE ALLEY</div>
      <div id="texts" style="display:inline;position:relative;top:-15;left:450; font-size:18px">User : <?php echo $_SESSION['user_name'];?></div>
      <a id="texts" style="display:inline;position:relative;top:-15;left:500;font-size:18px" href="first.php">LOGOUT</a>
    </div>
    <h4 align=center><a href="login.php" style="font-family : Nexa Bold;text-align:center;font-size:15px;color:#D8D8D8;position:relative;top:-10;left:10;">Not satified? Try changing your budget here</a></h4>
    
    
    <div style="position:relative;top:60;">
    <?php echo '<img src="' . $model['img'] . '" width="25%" height="70%"/>' ?> 
    <a href ="wishlist.php" ><button style="position:relative; top:-230;left:-240;font-family:Nexa;font-size:11px;width:12%;height:5%;" style="position:relative;top:-5;">
     ADD TO WISHLIST</button></a>
     </div>
     
    <section style="position: relative;top:-450;left:400;width:50%;font-color:white;">
    <h5 style="font-family: Nexa Bold;color:red;">Brand : <?php echo $model['brand_name'] ?></h5>
    <hr>
    <h5 style="font-family: Nexa Bold;color:red;">Model : <?php echo $model['model_name'] ?></h5>
    <hr>
    <h5 style="font-family: Nexa Bold;color:red;">Price : <?php echo $model['price'] ?></h5>
    <hr>    
    <h5 style="font-family: Nexa Bold;color:red;">Primary Camera (MPs) : <?php echo $model['p_camera'] ?></h5>
    <hr>
    <h5 style="font-family: Nexa Bold;color:red;">Secondary Camera (MPs) : <?php echo $model['s_camera'] ?></h5>
    <hr>
    <h5 style="font-family: Nexa Bold;color:red;">RAM : <?php echo $model['ram'] ?></h5>
    <hr>
    <h5 style="font-family: Nexa Bold;color:red;">Memory (internal) : <?php echo $model['rom'] ?></h5>
    <hr>
    <h5 style="font-family: Nexa Bold;color:red;">Screen Size (inches) : <?php echo $model['screen_size'] ?></h5>
    <hr>
    <h5 style="font-family: Nexa Bold;color:red;">OS : <?php echo $model['os_name'] ?></h5>
    <hr>
    <h5 style="font-family: Nexa Bold;color:red;">Battery (mAh) : <?php echo $model['battery'] ?></h5>
    <hr>
    <h5 style="font-family: Nexa Bold;color:red;">Processor : <?php echo $model['p_vendor']; echo $model['processor_name'] ?> </h5>
    <hr>
    <h5 style="font-family: Nexa Bold;color:red;">GPU : <?php echo $model['gpu'] ?></h5>
    <hr>
    <h5 style="font-family: Nexa Bold;color:red;">Processor cores : <?php echo $model['no_of_cores'] ?></h5>
    <hr>
    <h5 style="font-family: Nexa Bold;color:red;">Popularity : <?php echo $model['popularity'] ?></h5>
    <hr>
    
  
 
    
    </section>
       </body>
       </html>