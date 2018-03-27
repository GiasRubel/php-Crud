<?php
require_once("database.php");
require_once("config.php");
$db = new Database();

if(isset($_GET['id']))
{
	$id = $_GET['id'];
}

$query = "select image from tbl_user where id = '$id' ";
$result = $db->select($query);
while($row = $result->fetch_assoc())
{
	$delmg = $row['image']; //this part for delete image from uploads folder
	unlink($delmg);
}


$query = "delete from tbl_user where id = '$id'";
$del = $db->delete($query);
if($del)
{
	header("Location:index.php");
	exit();
}
?>