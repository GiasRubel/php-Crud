<?php
require_once("database.php");
require_once("config.php");
$db = new Database();
if(isset($_GET['id']))
{
	$id = $_GET['id'];
}
$query = "select * from tbl_user where id = '$id' ";
$result = $db->select($query)->fetch_assoc();

$sports = "";
$sport_val = array();

$sports_new = $result['sports'];
$spn = explode(', ', $sports_new);
// print_r($spn);

	$ename     = "";
	$eemail    = ""; 
	$epassword = "";
	$egender   = "";
	$ecountry  = "";
	$eimage    = "";
	$esports   = "";

	if(isset($_POST['update'])) 
	{
		$name   = mysqli_real_escape_string($db->link,$_POST['name']);
		$email  = mysqli_real_escape_string($db->link,$_POST['email']);

		if (isset($_POST['gender']))
			$gender = mysqli_real_escape_string($db->link,$_POST['gender']);

		$country = mysqli_real_escape_string($db->link,$_POST['country']);
		$adress  = mysqli_real_escape_string($db->link,$_POST['adress']);

		if(isset($_POST['sports']))
			$sport_val = $_POST['sports'];
		foreach($sport_val as $val)
		{
			$sports .= $val.', ';	
		}

		$er = 0;

		if($name == "")
		{
			$er++;
			$ename = "Name required*";
		}

		if($email == "")
		{
			$er++;
			$eemail = "Email required*";
		}

		 

		if($country == "")
		{
			$er++;
			$ecountry = "Country required*";
		}

		if($gender == "")
		{
			$er++;
			$egender = "Gender required*";
		}

		if($sports == "")
		{
			$er++;
			$esports = "Sports required*";
		}


		$permited  = array('jpg', 'jpeg', 'png', 'gif');
	    $file_name = $_FILES['image']['name'];
	    $file_size = $_FILES['image']['size'];
	    $file_temp = $_FILES['image']['tmp_name'];

	    $div = explode('.', $file_name);
	    $file_ext = strtolower(end($div));
	    $unique_image = substr(md5(time()), 0, 10).'.'.$file_ext;
	    $uploaded_image = "uploads/".$unique_image;

	    if(!empty($file_name))
	    {
		    if ($file_size >1048567) {
		    	$er++;
		    	$eimage = "Image Size should be less then 1MB!";
		    } elseif (in_array($file_ext, $permited) === false) {
		    	$er++;
		    	$eimage = "you can upload only:".implode(',',$permited)." Files";
		    }

			if($er == 0){
					move_uploaded_file($file_temp, $uploaded_image);
					$query = "update tbl_user set 
								name    = '$name',
								email   = '$email', 
								gender  = '$gender',
								country = '$country',
								image   = '$uploaded_image',
								adress  = '$adress',
								sports  = '$sports'
								where id = '$id' " ;
					$update = $db->update($query);
					if($update)
					{
						
						header("Location:index.php");
						exit();
					}
					else{
						echo "Data not updated";
					}
				}
		}
		elseif($er == 0){
			$query = "update tbl_user set 
						name    = '$name',
						email   = '$email', 
						gender  = '$gender',
						country = '$country',
						
						adress  = '$adress',
						sports  = '$sports'
						where id = '$id' " ;
			$update = $db->update($query);
			if($update)
			{
				
				header("Location:index.php");
				exit();
			}
			else{
				echo "Data not updated";
			}
		}
	}

?>

<!DOCTYPE html>
<html>
<head>
	<title>Update user</title>
	<link rel="stylesheet" type="text/css" href="css/bootstrap.min.css">
	<link rel="stylesheet" type="text/css" href="css/style.css">
	<script type="text/javascript" src="js/bootstrap.min.js"></script>
</head>
<body>
	<br>
	<div class="container">
		<div class="row">
		  <div class="col-lg-4 col-lg-offset-4">
		  	<form action="" method="post" enctype="multipart/form-data">

		  		<div class="form-group">
		  			<label>Name:</label><span class="error" style="color: red;"><?= $ename?></span>
					<input type="text" name="name" placeholder="Plese enter name" class="form-control" value="<?= $result['name']?>">
				</div>
				<div class="form-group">
					<label>Email:</label><span class="error" style="color: red;"><?= $eemail?></span>
					<input type="email" name="email" placeholder="Please enter your email" class="form-control" value="<?= $result['email']?>">
				</div>
				
				
				<div class="form-group">
					<label>Adress:</label>
					<textarea name="adress" class="form-control"> <?= $result['adress']?></textarea>
				</div>

				<div class="form-check form-check-inline">
					<label class="form-check-label">
					<label>Gender:</label>
						<input class="form-check-input" type="radio" name="gender"
						<?php if ($result['gender']=="female") echo "checked";?>
						value="female">Female
						<input class="form-check-input" type="radio" name="gender"
						<?php if ($result['gender']=="male") echo "checked";?>
						value="male">Male <span class="error" style="color: red;"><?= $egender?></span>
					</label>
				</div>

				<div class="form-group">
					<label>Country:</label><span class="error" style="color: red;"><?= $ecountry?></span>
					<select name="country" class="form-control">
					  
					  <option value="Bangladesh" <?php if ($result['country']=="Bangladesh") echo "selected";?>>Bangladesh</option>
					  <option value="nepal" <?php if ($result['country']=="nepal") echo "selected";?>>nepal</option>
					  <option value="Bhutan" <?php if ($result['country']=="Bhutan") echo "selected";?>>Bhutan</option>
					</select>
				</div>


				<div class="form-check form-check-inline">
					<label class="form-check-label">
					<label>Sports:</label>
						<input type="checkbox" name="sports[]" 
						<?php if (in_array('cricket', $spn)) echo "checked";?>
						value="cricket"> cricket
				 		 <input type="checkbox" name="sports[]" 
				 		 <?php if (in_array('football', $spn)) echo "checked";?>
				 		 value="football" > football
				 		 <input type="checkbox" name="sports[]"
				 		 <?php if (in_array('tenis', $spn)) echo "checked";?>
				 		  value="tenis" > tenis <span class="error" style="color: red;"><?= $esports?></span>
				 	</label>
		 		 </div>

		 		 <div class="form-group">
		 		 	<label>Image:</label><span class="error" style="color: red;"><?= $eimage?></span>
					<input class="form-control-file" type="file" name="image" /><br>
					<img src="<?= $result['image']?>" height="100" width="100">
				</div>

				<button type="submit" class="btn btn-primary" name="update">Update</button>
			
			</form> 
		  </div>  
		</div>
	</div>

</body>
</html>