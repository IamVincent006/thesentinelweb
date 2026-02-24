<?php 
include "template/header.php"; 

require_once ("db.php");

$sql = "SELECT * from project_details where pid =" . $_POST['id'] . "  ";
$result = $conn->query($sql);

#$row = mysqli_fetch_array($result);
//$conn->close();



?>

            <div class="spacing"></div>
		<center><h1> <?= $_POST['name'] ?></h1></center>
		<br/><br/>
<?php while ($row = mysqli_fetch_array($result)) { ?>
	<div class="project-details">



		<section class="spdct-frame1">
			<div class="spdct-slider animate-up">
				<?php foreach(explode(",", $row['image']) as $img): ?>
					<div class="spdct-slider__item">
						<img src="<?= $img ?>" alt="DIGITAL SILVER">
					</div>
				<?php endforeach; ?>
				
			</div>
		</section>
    

		<section class="spdct-frame2">
			<div class="frm-cntnr width--80 w-wrapper ">
				
				<div class="spdct-frame2__name animate-up">
					<h2 class="clr--green"> <?= $row['name'] ?> </h2>
				</div>

				<div class="spdct-frame2__details animate-up">
					<h2><?= $row['details'] ?></h2>
				</div>

				
			</div>
		</section>
	</div>
<?php } ?>


            

            

        </div>

        
          <!-- !!! -->
        <script type="text/javascript">
            var pageID = 'Product',
            baseHref = 'https://worldhomedepot.com/',
            themeDir = '/_resources/themes/main';
        </script>


        
<?php include "template/footer.php"; ?>
