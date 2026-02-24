<?php
require_once ("db.php");

$sql = "SELECT * from product_category";

$statement = $connection->prepare($sql);
$statement->execute();
$result = $statement->get_result();


$output ='';

while ($row = mysqli_fetch_array($result)) {

	$stat = $row['id'] == 1  ? 'current' : 'link';
	$output .= '<div class="pdct-frame1__tab '  .  $stat . '">';
	$output .= '<a href="#" onclick="updateParent(' . $row['id'] . ')"><p>' . $row["category"]  . '</p></a>';
	$output .= '</div>';
	

}

print $output;
?>
