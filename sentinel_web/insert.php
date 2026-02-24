<?php
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "sentinelweb";

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);
// Check connection
if ($conn->connect_error) {
  die("Connection failed: " . $conn->connect_error);
}

//$data = array("one", "two", "tree");

// output one, two, three
//$insert_data = implode(",", $data);
//print_r($insert_data);
/*$sql = "INSERT INTO project_details (id, image)
VALUES ('', '$insert_data')";

if ($conn->query($sql) === TRUE) {
  echo "New record created successfully";
} else {
  echo "Error: " . $sql . "<br>" . $conn->error;
}

$conn->close();*/
$sql = "SELECT * from project_details where id =7  ";
$result = $conn->query($sql);
$row = mysqli_fetch_array($result);

$retrieve = json_encode($row['image']);
$cats = explode(",", $row['image']);
//$retrieve = $row['image'];
//print_r($retrieve);

foreach($cats as $cat) {
    $cat = trim($cat);
	print_r($cat);
    //$categories .= "<category>" . $cat . "</category>\n";
}

?>



