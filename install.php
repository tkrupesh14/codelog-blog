<?php
if(file_exists('db.php')){
	header('location:index.php');
	die();
}
$msg="";
$host="";
$dbuname="";
$dbpwd="";
$dbname="";
$adminname="";
$adminemail="";
$adminpass="";
if(isset($_POST['submit'])){
	$host=$_POST['host'];
	$dbuname=$_POST['dbuname'];
	$dbpwd=$_POST['dbpwd'];
	$dbname=$_POST['dbname'];
	$adminname=$_POST['adminname'];
	$adminemail=$_POST['adminemail'];
	$adminpass=$_POST['adminpass'];
	
	$conn=@mysqli_connect($host,$dbuname,$dbpwd,$dbname);
	if(mysqli_connect_error()){
		$msg=mysqli_connect_error();
	}else{
		copy("db.config-sample.php","db.php");
		$file="db.php";
		file_put_contents($file,str_replace("db_host",$host,file_get_contents($file)));
		file_put_contents($file,str_replace("db_username",$dbuname,file_get_contents($file)));
		file_put_contents($file,str_replace("db_password",$dbpwd,file_get_contents($file)));
		file_put_contents($file,str_replace("db_name",$dbname,file_get_contents($file)));
		
		$sql = "CREATE TABLE `admin` (
		  `id` int(11) NOT NULL,
		  `full name` varchar(200) NOT NULL,
		  `email` varchar(200) NOT NULL,
		  `password` varchar(200) NOT NULL
		) ENGINE=InnoDB DEFAULT CHARSET=latin1;";
		mysqli_query($conn, $sql);
		
		$sql = "CREATE TABLE `catagory` (
			`id` int(11) NOT NULL,
			`name` varchar(200) NOT NULL
		  ) ENGINE=InnoDB DEFAULT CHARSET=latin1;
		  ";
		mysqli_query($conn, $sql);
		
		$sql = "CREATE TABLE `comments` (
			`id` int(11) NOT NULL,
			`name` varchar(255) NOT NULL,
			`comment` text NOT NULL,
			`post_id` int(11) NOT NULL,
			`commented_at` timestamp NOT NULL DEFAULT current_timestamp()
		  ) ENGINE=InnoDB DEFAULT CHARSET=latin1;";
		mysqli_query($conn, $sql);
		
		$sql = "CREATE TABLE `images` (
			`id` int(11) NOT NULL,
			`post_id` int(11) NOT NULL,
			`image` text NOT NULL
		  ) ENGINE=InnoDB DEFAULT CHARSET=latin1;";
		mysqli_query($conn, $sql);
		
		$sql = "CREATE TABLE `menu` (
			`id` int(11) NOT NULL,
			`name` varchar(200) NOT NULL,
			`action` text NOT NULL
		  ) ENGINE=InnoDB DEFAULT CHARSET=latin1;";
		mysqli_query($conn, $sql);
		
		$sql = "CREATE TABLE `posts` (
			`id` int(11) NOT NULL,
			`title` text NOT NULL,
			`catagory_id` int(11) NOT NULL,
			`content` text NOT NULL,
			`created_at` timestamp NOT NULL DEFAULT current_timestamp()
		  ) ENGINE=InnoDB DEFAULT CHARSET=latin1;";
		mysqli_query($conn, $sql);
		
		$sql = "CREATE TABLE `submenu` (
			`id` int(11) NOT NULL,
			`menu_id` int(11) NOT NULL,
			`name` varchar(200) NOT NULL,
			`action` text NOT NULL
		  ) ENGINE=InnoDB DEFAULT CHARSET=latin1;";
		mysqli_query($conn, $sql);
		
		$sql = "INSERT INTO `admin` (`id`, `full name`, `email`, `password`) VALUES
		(1, '$adminname', '$adminemail', '$adminpass');";
		mysqli_query($conn, $sql);

		$sql = "INSERT INTO `menu` (`id`, `name`, `action`) VALUES
		(1, 'Home', 'index.php'),
		(2, 'About ', 'about.php'),
		(3, 'Categories', '#');";
		mysqli_query($conn, $sql);

		$sql = "INSERT INTO `submenu` (`id`, `menu_id`, `name`, `action`) VALUES
		(2, 3, 'Graphics Design 1', '#'),
		(3, 3, 'App Development', '#'),
		(4, 3, 'WordPress Development', '#'),
		(5, 3, 'Video Editing', '#');";
		mysqli_query($conn, $sql);
		
		$sql = "ALTER TABLE `admin`
		ADD PRIMARY KEY (`id`);";
		mysqli_query($conn, $sql);


		$sql = "ALTER TABLE `catagory`
		ADD PRIMARY KEY (`id`);";
		mysqli_query($conn, $sql);


		$sql = "ALTER TABLE `comments`
		ADD PRIMARY KEY (`id`);";
		mysqli_query($conn, $sql);


		$sql = "ALTER TABLE `images`
		ADD PRIMARY KEY (`id`);";
		mysqli_query($conn, $sql);


		$sql = "ALTER TABLE `menu`
		ADD PRIMARY KEY (`id`);";
		mysqli_query($conn, $sql);


		$sql = "ALTER TABLE `posts`
		ADD PRIMARY KEY (`id`);";
		mysqli_query($conn, $sql);


		$sql = "ALTER TABLE `submenu`
		ADD PRIMARY KEY (`id`);";
		mysqli_query($conn, $sql);

		$sql = "ALTER TABLE `admin`
		MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=0;";
		mysqli_query($conn, $sql);

		$sql = "ALTER TABLE `catagory`
		MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=0;";
		mysqli_query($conn, $sql);

		$sql = "ALTER TABLE `comments`
		MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=0;";
		mysqli_query($conn, $sql);

		$sql = "ALTER TABLE `images`
		MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=0;";
		mysqli_query($conn, $sql);

		$sql = "ALTER TABLE `menu`
		MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=0;";
		mysqli_query($conn, $sql);

		$sql = "ALTER TABLE `posts`
		MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=0;";
		mysqli_query($conn, $sql);

		$sql = "ALTER TABLE `submenu`
		MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=0;";
		mysqli_query($conn, $sql);




		header('location: ./admin/index.php');
	}
}
?>

<!doctype html>
<html lang="en">
   <head>
      <meta charset="utf-8">
      <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
      <title>Codelog Installer</title>
      <link href="https://getbootstrap.com/docs/4.0/dist/css/bootstrap.min.css" rel="stylesheet">
      <style>
		table{width:30% !important; text-align:center; margin:auto; margin-top:100px;}
		.success{color:green;}
		.error{color:red;}
		.frm{width:70% !important; margin:auto; margin-top:100px;}
	  </style>
   </head>
   <body>
      
  <center> <h1 class="text-success"> Codelog Script Installer</h1></center>
      <main role="main" class="container">
		
		<?php
		if((isset($_GET['step'])) && $_GET['step']==2){
			?>
			
			<form class="frm" method="post">
			  <div class="form-group">
				<input type="text" class="form-control" placeholder="Host" required name="host" value="<?php echo $host?>">
			  </div>
			  <div class="form-group">
				<input type="text" class="form-control" placeholder="Database User Name" required name="dbuname" value="<?php echo $dbuname?>">
			  </div>
			  <div class="form-group">
				<input type="text" class="form-control" placeholder="Database Password" name="dbpwd" value="<?php echo $dbpwd?>">
			  </div>
			  <div class="form-group">
				<input type="text" class="form-control" placeholder="Database Name" required name="dbname" value="<?php echo $dbname?>">
			  </div>
			  <div class="form-group">
				<input type="text" class="form-control" placeholder="Admin Name" required name="adminname" value="<?php echo $dbname?>">
			  </div>
			  <div class="form-group">
				<input type="text" class="form-control" placeholder="Admin Email" required name="adminemail" value="<?php echo $dbname?>">
			  </div>
			  <div class="form-group">
				<input type="text" class="form-control" placeholder="Admin Password" required name="adminpass" value="<?php echo $dbname?>">
			  </div>
			  <button type="submit" name="submit" class="btn btn-primary">Install</button>
			  <span class="error"><?php echo $msg?></span>
			</form>
			
			<?php
		}else{
		?>
	  
         <table class="table">
		  <thead>
			<tr>
			  <th scope="col">Configuration</th>
			  <th scope="col">Status</th>
			</tr>
		  </thead>
		  <tbody>
			<tr>
			  <th scope="row">PHP Version</th>
			  <td>
				<?php
					$is_error="";
					$php_version=phpversion();
					if($php_version>5){
						echo "<span class='success'>".$php_version."</span>";
					}else{
						echo "<span class='error'>".$php_version."</span>";
						$is_error='yes';
					}
				?>
			  </td>
			</tr>
			<tr>
			  <th scope="row">Curl Install</th>
			  <td>
				<?php
				$curl_version=function_exists('curl_version');
				if($curl_version){
					echo "<span class='success'>Yes</span>";
				}else{
					echo "<span class='error'>No</span>";
					$is_error='yes';
				}
				?>
			  </td>
			</tr>
			<tr>
			  <th scope="row">Mail Function</th>
			  <td>
				<?php
				$mail=function_exists('mail');
				if($mail){
					echo "<span class='success'>Yes</span>";
				}else{
					echo "<span class='error'>No</span>";
					$is_error='yes';
				}
				?>
			  </td>
			</tr>
			<tr>
			  <th scope="row">Session Working</th>
			  <td>
				<?php
				$_SESSION['IS_WORKING']=1;
				if(!empty($_SESSION['IS_WORKING'])){
					echo "<span class='success'>Yes</span>";
				}else{
					echo "<span class='error'>No</span>";
					$is_error='yes';
				}
				?>
			  </td>
			</tr>
			
			<tr>
			  <td colspan="2">
				<?php 
				if($is_error==''){
					?>
					<a href="?step=2"><button type="button" class="btn btn-success">Next</button></a>
					<?php
				}else{
					?><button type="button" class="btn btn-danger" disabled>Error</button><?php
				}
				?>
			  </td>
			</tr>
		  </tbody>
		  
		</table>
		<?php } ?>
		
      </main>
      
      <script src="https://getbootstrap.com/docs/4.0/assets/js/vendor/popper.min.js"></script>
      <script src="https://getbootstrap.com/docs/4.0/dist/js/bootstrap.min.js"></script>
   </body>
</html>