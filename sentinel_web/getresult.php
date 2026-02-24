<?php
require_once ("db.php");
require_once ("pagination.class.php");
$perPage = new PerPage();
$sql = "SELECT * from projects";
$paginationlink = "getresult.php?page=";
$page = 1;
if (! empty($_GET["page"])) {
    $page = $_GET["page"];
}
$start = ($page - 1) * $perPage->perpage;
if ($start < 0) {
    $start = 0;
}
$statement = $connection->prepare($sql);
$statement->execute();
$result = $statement->get_result();
$perpageresult = $perPage->perpage($result->num_rows, $paginationlink);
$query = $sql . " limit " . $start . "," . $perPage->perpage;
$statement = $connection->prepare($query);
$statement->execute();
$result = $statement->get_result();
$output = '';
$output .= '<div class="project-container">';
while ($row = mysqli_fetch_array($result)) {

   
    $output .= '<div class="project-item animate-up">';
	    $output .= '<img src=" ' . $row["project_image"] . ' " alt="">';
	    $output .= '<div class="gradient"></div>';
	    $output .= '<div class="project-title">
						<h6>
							' . $row["project_name"] . '<br>
							' . $row["project_description"] . '
						</h6>';


    $output .= '</div> </div>  '  ;

}
$output .= '</div>';
if (! empty($perpageresult)) {
    //$output .= '<div id="pagelink">' . $perpageresult . '</div>';

    $output .= '<div class="page-num desktop">' . $perpageresult . '</div>';


}
print $output;
?>

