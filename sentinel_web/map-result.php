<?php
require_once ("db.php");


if(!isset($_POST['id']))
$id = 1;
else
$id = $_POST['id'];



$sql = "SELECT * from contact_details where id = " . $id . "   ";

//$statement = $connection->prepare($sql);
//$statement->execute();
//$result = $statement->get_result();
$result = $conn->query($sql);
$conn->close();
$row = mysqli_fetch_array($result);


$output = array(
'details'	=>	$row['details'],
'name'	=>	$row['name'],
'latitude'	=>	$row['latitude'],
'longitude'	=>	$row['longitude'],


);

echo json_encode($output);
?>

