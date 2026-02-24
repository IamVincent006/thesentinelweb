<?php
require_once ("db.php");
require_once ("pagination.class.php");

$output = '';




$paginationfilter = "product_result.php?filter=";

$filter = 1;
if (! empty($_GET["filter"])) {
    $filter = $_GET["filter"];
   
}



$link = "SELECT * from product_category";
$result1 = $conn->query($link);
//$statement1 = $connection->prepare($sql1);
//$statement1->execute();
//$result1 = $statement1->get_result();



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







$ProductPage = new ProductPage();

if($filter == 1){
	 $sql = "SELECT * from products";
}
else {
	 $sql = "SELECT * from products where product_category = $filter";
}

//$sql = "SELECT * from products where product_category = $filter";
$paginationlink = "product_result.php?page=";
$page = 1;
if (! empty($_GET["page"])) {
    $page = $_GET["page"];
}
$start = ($page - 1) * $ProductPage->perpage;
if ($start < 0) {
    $start = 0;
}

//$statement = $connection->prepare($sql);
//$statement->execute();
//$result = $statement->get_result();
$result = $conn->query($sql);

$perpageresult = $ProductPage->perpage($result->num_rows, $paginationlink);
$query = $sql . " limit " . $start . "," . $ProductPage->perpage;
$result = $conn->query($query);
$conn->close();
//$statement = $connection->prepare($query);
//$statement->execute();
//$result = $statement->get_result();








$output .= '<div>';
$output .= '<div id="title-az" class="pdct-frame1__product-wrapper inlineBlock-parent">';
while ($row = mysqli_fetch_array($result)) {

	$id = $row['id'];
	$name = "aa";
	$output .= "<div class='product-card align-t'>";   
		//$output .= '<a href="products-details.php?id=' . $row['id'] . '">';
		//$output .= '<a href=\"javascript:formSubmit($id);\">';
		//$output .= '<a onclick="formSubmit(' . $row['id'] . ')">';
	$output .= '<a onclick="formSubmit(' . "['$id','$name']" .')">';
		//$output .='<a href="#" onclick="products(\'' . $paginationfilter . $row1['id'] . '\')"><p>' . $row1["category"]  . '</p></a>';
			$output .= "<div class='product-image'>";
				$num = 1;
				foreach(explode(",", $row['product_image']) as $img) {

				$output .= '<div class="product-img img' . $num . '" style="background-image: url(' . $img . ');"></div>';
				$num++;
				//$output .= '<div class="product-img img2" style="background-image: url(' .  $row['product_image2'] . ');"></div>';

				}
			$output .= '</div>';
			$output .= '<div class="product-details">';
				$output .= '<div class="product-name">';
					$output .= '<h6>' . $row['product_name'] . '</h6>';
				$output .= '</div>';
				$output .= '<div class="product-brand">';
					$output .= '<h6>' . $row['product_brand'] . '</h6>';
				$output .= '</div>';
	$output .= '<div class="product-category">';
	$output .= '<small>' . $row['product_details'] . '</small>';
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

