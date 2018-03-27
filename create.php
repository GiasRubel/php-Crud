<?php
require_once("database.php");
require_once("config.php");
$db = new Database();
// Declaration of variable
	$name     = "";
	$email    = ""; 
	$password = "";
	$repass   = "";
	$gender   = "";
	$country  = "";
	$image    = "";
	$adress   = "";
	$sports   = "";
	$sport_val = array();
// Declaration variable for error counting
	$ename     = "";
	$eemail    = ""; 
	$epassword = "";
	$egender   = "";
	$ecountry  = "";
	$eimage    = "";
	$esports   = "";
// get the post value and store into variable
	if(isset($_POST['submit'])) 
	{
		$name    = mysqli_real_escape_string($db->link,$_POST['name']);
		$email   = mysqli_real_escape_string($db->link,$_POST['email']);
		if (isset($_POST['gender']))
			$gender = mysqli_real_escape_string($db->link,$_POST['gender']);
		$country  = mysqli_real_escape_string($db->link,$_POST['country']);
		$password = mysqli_real_escape_string($db->link,$_POST['password']);
		$repass   = mysqli_real_escape_string($db->link,$_POST['repassword']);
		$adress   = mysqli_real_escape_string($db->link,$_POST['adress']);

		if(isset($_POST['sports']))
			$sport_val = $_POST['sports'];
		foreach($sport_val as $val) //because it is in a array.
		{
			$sports .= $val.', ';

			
		}
		//initialize an error with 0, if field empty increment its value
		$er = 0;

		if($name == "")
		{
			$er++;
			$ename = "Name required*"; //store error messege in error variable
		}

		if($email == "")
		{
			$er++;
			$eemail = "Email required*";
		}

		if($password == "")
		{
			$er++;
			$epassword = "Password required*";
		}

		if($repass == "")
		{
			$er++;
			$epassword = "Retype password";
		}

		if($password != $repass)
		{
			$er++;
			$epassword = "password Does not match";
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

		//Get the file name,size. also set permited format
		$permited  = array('jpg', 'jpeg', 'png', 'gif');
	    $file_name = $_FILES['image']['name'];
	    $file_size = $_FILES['image']['size'];
	    $file_temp = $_FILES['image']['tmp_name'];

	    //define path of the image,get extention name with explode and end,give an uniq name and move it to uploads folder
	    $div = explode('.', $file_name);
	    $file_ext = strtolower(end($div));
	    $unique_image = substr(md5(time()), 0, 10).'.'.$file_ext;
	    $uploaded_image = "uploads/".$unique_image;
	    //check for file validation
	    if (empty($file_name)) {
	    	$er++;
	    	$eimage = "Select an Image";
	    }elseif ($file_size >1048567) {
	    	$er++;
	    	$eimage = "Image Size should be less then 1MB!";
	    } elseif (in_array($file_ext, $permited) === false) {
	    	$er++;
	    	$eimage = "you can upload only:".implode(',',$permited)." Files";
	    }

	    //if there is no error move further to insert query
		if($er == 0){
				move_uploaded_file($file_temp, $uploaded_image);

				$query = " insert into tbl_user( name, email, gender,country, image, password, adress, sports ) values ( '$name', '$email' , '$gender','$country','$uploaded_image', '$password', '$adress', '$sports' ) " ;
				$create = $db->insert($query);
				if($create)
				{
					
					header("Location:index.php");
					exit();
				}
				else{
					echo "Data not inserted";
				}
		}
	}

?>

<!DOCTYPE html>
<html>
<head>
	<title>Create user</title>
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
		  	<!-- keep the value of variable and show error massage -->
		  		<div class="form-group">
		  			<label>Name:</label> <span class="error" style="color: red;"><?= $ename?></span>
					<input type="text" name="name" placeholder="Plese enter name" class="form-control" value="<?= $name?>">
				</div>
				<div class="form-group">
					<label>Email:</label> <span class="error" style="color: red;"><?= $eemail?></span>
					<input type="email" name="email" placeholder="Please enter your email" class="form-control" value="<?= $email?>">
				</div>
				
				<div class="form-group">
					<label>Password:</label><span class="error" style="color: red;"><?= $epassword?></span>
					<input type="password" name="password" placeholder="Please enter your Password"  class="form-control">
				</div>

				<div class="form-group">
					<label>Retype Password:</label>
					<input type="password" name="repassword" placeholder="ReType password" class="form-control" >
				</div>
				
				<div class="form-group">
					<label>Adress:</label>
					<textarea name="adress" class="form-control"> <?= $adress?></textarea>
				</div>
				<!-- check for gender is mark with an if statement -->
				<div class="form-check form-check-inline">
					<label class="form-check-label">
					<label>Gender:</label>
						<input class="form-check-input" type="radio" name="gender"
						<?php if (isset($gender) && $gender=="female") echo "checked";?>
						value="female">Female
						<input type="radio" name="gender"
						<?php if (isset($gender) && $gender=="male") echo "checked";?>
						value="male">Male <span class="error" style="color: red;"><?= $egender?></span>
					</label>
				</div>
				<!-- check for country is selected with an if statement -->
				<div class="form-group">
					<label>Country:</label><span class="error" style="color: red;"><?= $ecountry?></span>
					<select name="country" class="form-control">
					  <option value="">Select country</option>
					  <option value="Bangladesh" <?php if (isset($country) && $country=="Bangladesh") echo "selected";?>>Bangladesh</option>
					  <option value="nepal" <?php if (isset($country) && $country=="nepal") echo "selected";?>>nepal</option>
					  <option value="Bhutan" <?php if (isset($country) && $country=="Bhutan") echo "selected";?>>Bhutan</option>
					</select>
				</div>

				<!-- check for sports is mark with an if statement,store the name in an array for multiple checkbox, and check in_ array condition for each value of array -->
				<div class="form-check form-check-inline">
					<label class="form-check-label">
					<label>Sports:</label>
						<input type="checkbox" name="sports[]" 
						<?php if (in_array('cricket', $sport_val)) echo "checked";?>
						value="cricket"> cricket
				 		 <input type="checkbox" name="sports[]" 
				 		 <?php if (in_array('football', $sport_val)) echo "checked";?>
				 		 value="football" > football
				 		 <input type="checkbox" name="sports[]"
				 		 <?php if (in_array('tenis', $sport_val)) echo "checked";?>
				 		  value="tenis" > tenis<span class="error" style="color: red;"><?= $esports?></span>
				 	</label>
		 		 </div>

		 		 <div class="form-group">
		 		 	<label>Image:</label><span class="error" style="color: red;"><?= $eimage?></span>
					<input class="form-control-file" type="file" name="image"/>
				</div>

				<button type="submit" class="btn btn-primary" name="submit">Submit</button>
				<!-- <input type="submit" name="submit" value = "submit"> -->
				<button type="reset" class="btn btn-warning">Reset</button>
			</form> 
		  </div>  
		</div>
	</div>

 	

</body>
</html>