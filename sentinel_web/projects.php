<?php include "template/header.php";


//////////////////BRAND/////////////////////////////////
$sql = "SELECT * FROM brand";
$result = $conn->query($sql);

?>




        
<!--        <div id="scrollbar">
        <div class="main">
  -->

          

            <div class="spacing"></div>


    <div class="prjct-frame1">
        <div class="frm-cntnr">
            <div class="frm-wrapper" >
                <div class="prjct-frame1__title animate-up">
                    <h2 class="clr--green">Completed Projects</h2>
                </div>









                <form action="projects-details.php" method="POST">
                    <input type="hidden" name="id">
                    <input type="hidden" name="name">
                    <div class="pagination" style="display: flex; flex-direction: column;"></div>
                </form>
            </div>
        </div>
    </div>



        <!-- !!! -->
        <script type="text/javascript">
    		projects("project_result.php");

            var pageID = 'ProductPage',
            baseHref = 'localhost',
            themeDir = '/_resources/themes/main';
        </script>


<?php include "template/footer.php"; ?>