<?php 

include "template/header.php"; 


$sql = "SELECT * from services where id =" . $_POST['id'] . "  ";

//$statement = $connection->prepare($sql);
//$statement->execute();
//$result = $statement->get_result();
$result = $conn->query($sql);
$row = mysqli_fetch_array($result);
//$conn->close();



?>

            

            <div class="spacing"></div>
<section class="spdct-frame1">
	<div class="spdct-slider animate-up">
		
		<div class="spdct-slider__item">
			<img src="assets/product/sentinel.png" alt="SENTINEL GUAM">
		</div>
		
	</div>
</section>
<section class="spdct-frame2">
	<div class="frm-cntnr width--80 w-wrapper services">
		<div class="spdct-frame2__name animate-up">
			<h2 class="clr--green"> <?= $row['service_name'] ?> </h2>
		</div>
		<div class="spdct-frame2__brand animate-up">
			<h6> <?= $row['service_brand'] ?> </h6>
		</div>
		<div class="spdct-frame2__details animate-up">
			<h2><?= $row['service_details'] ?><br><br/>
					<?= $row['service_description'] ?></h2>
		</div>
		
		
	</div>
</section>




            

            

        </div>

        
         <!-- !!! -->
        <script type="text/javascript">
            var pageID = 'Product',
            baseHref = 'https://worldhomedepot.com/',
            themeDir = '/_resources/themes/main';
        </script>


<?php include "template/footer.php"; ?>