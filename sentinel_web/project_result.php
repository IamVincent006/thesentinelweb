<?php
require_once ("db.php");
require_once ("pagination.class.php");
$ProjectPage = new ProjectPage();


$sql = "SELECT * from projects";

$paginationlink = "project_result.php?page=";


$page = 1;
if (! empty($_GET["page"])) {
    $page = $_GET["page"];
}
$start = ($page - 1) * $ProjectPage->perpage;
if ($start < 0) {
    $start = 0;
}

//$statement = $connection->prepare($sql);
//$statement->execute();
//$result = $statement->get_result();
$result = $conn->query($sql);

$perpageresult = $ProjectPage->perpage($result->num_rows, $paginationlink);
$query = $sql . " limit " . $start . "," . $ProjectPage->perpage;
//$statement = $connection->prepare($query);
//$statement->execute();
//$result = $statement->get_result();
$result = $conn->query($query);
$conn->close();
$output = '';
$output .= '<div class="project-container">';
while ($row = mysqli_fetch_array($result)) {

    $id = $row["id"];
    $name = $row["project_name"];

    $output .= '<div class="project-item animate-up">';
    $output .= '<a onclick="formSubmit(' . "['$id','$name']" .')">';
    $output .= '<img src="'.$row["project_image"].'" alt="" style="width: 100%; height: 100%; object-fit: cover;">';
    $output .= '<div class="gradient"></div>';
    $output .= '</a>'; // Close the anchor tag here
    $output .= '<div class="project-title">
                <h6>
                    ' . $row["project_name"] . '<br>
                    ' . $row["project_description"] .  ' <br> <br>
                    '. $row["project_narrative"] . '
                </h6>';
    $output .= '</div>';

    $output .= '</div>'; // Close the project-item div here

}
$output .= '</div>';
if (! empty($perpageresult)) {
    //$output .= '<div id="pagelink">' . $perpageresult . '</div>';

    $output .= '<div class="page-num desktop">' . $perpageresult . '</div>';


}
print $output;
?>

