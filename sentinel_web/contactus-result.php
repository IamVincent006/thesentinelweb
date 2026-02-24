<?php
require_once ("db.php");
require_once ("pagination.class.php");

$output = '';




$paginationfilter = "service_result.php?filter=";

$filter = 1;
if (! empty($_GET["filter"])) {
    $filter = $_GET["filter"];
}


$sql1 = "SELECT * from service_category";

$statement1 = $connection->prepare($sql1);
$statement1->execute();
$result1 = $statement1->get_result();
$output .= '<div class="pdct-frame1__header">';
$output .= '<div class="pdct-frame1__tab-container">';
//$stat = $row['id'] == 1  ? 'current' : 'link';
while ($row1 = mysqli_fetch_array($result1)) {

	$stat = $row1['id'] ==  $filter ? 'current' : 'link';
	$output .= '<div class="pdct-frame1__tab '  .  $stat . '">';
	$output .= '<a href="#" onclick="products(\'' . $paginationfilter . $row1['id'] . '\')"><p>' . $row1["category"]  . '</p></a>';
	//$output .= '<div  class="numbers"><a href="#" onclick="products(\'' . $paginationfilter . $row1['id'] .  '\')" return false>' . $row1["category"] . '</a></div>';
	$output .= '</div>';
	

}


$output .= '</div>';
$output .= '</div>';







$ServicePage = new ServicePage();


$sql = "SELECT * from services where service_category = $filter";
$paginationlink = "service_result.php?page=";
$page = 1;
if (! empty($_GET["page"])) {
    $page = $_GET["page"];
}
$start = ($page - 1) * $ServicePage->perpage;
if ($start < 0) {
    $start = 0;
}
$statement = $connection->prepare($sql);
$statement->execute();
$result = $statement->get_result();
$perpageresult = $ServicePage->perpage($result->num_rows, $paginationlink);
$query = $sql . " limit " . $start . "," . $ServicePage->perpage;
$statement = $connection->prepare($query);
$statement->execute();
$result = $statement->get_result();























$output .= '<div>';
$output .= '<div id="title-az" class="pdct-frame1__product-wrapper inlineBlock-parent">';
while ($row = mysqli_fetch_array($result)) {

	$output .= '<div class="product-card align-t">';   
		//$output .= '<a href="services-details.php">';
		$output .= '<a onclick="formSubmit(' . $row['id'] . ')">';
			$output .= "<div class='product-image'>";
				$output .= '<div class="product-img img1" style="background-image: url(' .  $row['service_image'] . ');"></div>';
				$output .= '<div class="product-img img2" style="background-image: url(' .  $row['service_image2'] . ');"></div>';
			$output .= '</div>';
			$output .= '<div class="product-details">';
				$output .= '<div class="product-name">';
					$output .= '<h6>' .  $row['service_name'] . '</h6>';
				$output .= '</div>';
				$output .= '<div class="product-brand">';
					$output .= '<h6></h6>';
				$output .= '</div>';
	$output .= '<div class="product-category">';
	$output .= '<small>' . $row['service_details'] . '</small>';
	$output .= '</div>';
			$output .= '</div>';
		$output .= '</a>';		
	$output .= '</div>';
}
$output .= '</div>';
$output .= '</div>';
if (! empty($perpageresult)) {
    //$output .= '<div id="pagelink">' . $perpageresult . '</div>';

    $output .= '<div class="page-num desktop">' . $perpageresult . '</div>';


}
print $output;
?>

