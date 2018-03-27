<?PHP
require_once("database.php");
require_once("config.php");

$db = new Database();
$query = "select * from tbl_user";
$read = $db->select($query); //fetch data from tbl_user
?>

<!DOCTYPE html>
<html>
<head>
	<title>read data</title>
	<link rel="stylesheet" type="text/css" href="css/bootstrap.min.css">
	<link rel="stylesheet" type="text/css" href="css/style.css">
	<script type="text/javascript" src="js/bootstrap.min.js"></script>
</head>
<body>
<?php 
if(isset($_GET['msg']))
{
	echo $_GET['msg'];
}
?>
<br>
<table class="table table-striped">
	<tr>
		<th >serial</th>
		<th>name</th>
		<th>email</th>
		<th>Adress</th>
		<th>Gender</th>
		<th>Country</th>
		<th>Sports</th>
		<th>Image</th>

		<th>Action</th>
	</tr>
	<!-- fetch data and store every row data in $row -->
	<?php if($read) { ?>
	<?php
		$id = 1;
	 	while($row = $read->fetch_assoc()) {
	?>
	<tr>
		<td><?php echo $id++; ?></td>
		<td><?php echo $row['name'];?></td> <!-- show fetched data -->
		<td><?php echo $row['email'];?></td>
		<td><?php echo $row['adress'];?></td>
		<td><?php echo $row['gender'];?></td>
		<td><?php echo $row['country'];?></td>
		<td><?php echo substr($row['sports'],0,-2)?></td>
		<td><img src="<?= $row['image']?>" height="60" width="70"></td>
		<td>
			<a href="update.php?id=<?php echo $row['id']; ?>"><button type="button" class="btn btn-primary">Update</button></a><!-- get the id of indiviual -->
			<a href="delete.php?id=<?php echo $row['id']; ?>"><button type="button" class="btn btn-danger">Delete</button></a><!-- get the id of indiviual -->
		</td>
	</tr>
	<?php }?>
	<?php } else { ?>
	<p>Data not found</p>
	<?php } ?>
</table>
<div class="row">
  <div class="col-lg-4 col-lg-offset-1">
  	<div class="create" >
  	<iframe src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d236203.14472662838!2d91.68255720601731!3d22.328160515796785!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x30acd8a64095dfd3%3A0x5015cc5bcb6905d9!2sChittagong!5e0!3m2!1sen!2sbd!4v1491062004645" width="600" height="450" frameborder="0" style="border:0" allowfullscreen></iframe>
	<h3>create user</h3>
	<a href="create.php"><button type="button" class="btn btn-success">Create</button></a>
	</div>
  </div>
  
</div>

</body>
</html>