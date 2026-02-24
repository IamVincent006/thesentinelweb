<?php 
include "template/header.php"; 


$sql = "SELECT * from products where id =" . $_POST['id'] . "  ";
$result = $conn->query($sql);

$row = mysqli_fetch_array($result);




?>

            <div class="spacing"></div>

<section class="spdct-frame1">
	<div class="spdct-slider animate-up">
		<?php foreach(explode(",", $row['product_image']) as $img): ?>
			<div class="spdct-slider__item">
				<img src="<?= $img ?>" alt="DIGITAL SILVER">
			</div>
		<?php endforeach; ?>		

		
	</div>
</section>


<section class="spdct-frame2">
	<div class="frm-cntnr width--80 w-wrapper ">


		<div class="spdct-frame2__name animate-up">
			<h2 class="clr--green"> <?= $row['product_name'] ?> </h2>
		</div>
		<div class="spdct-frame2__brand animate-up">
			<h6><?= $row['product_brand'] ?></h6>
		</div>
		<div class="spdct-frame2__details animate-up">
			<h2><?= $row['product_details'] ?><br>
					<?= $row['product_description'] ?></h2>
		</div>
		
		<div class="brochure-btn btn animate-up">
			<a class="clr--green" href="<?= $row['product_brochure'] ?>" target="_blank">DOWNLOAD BROCHURE</a>
		</div>
		
	</div>
</section>

<section class="spdct-frame3">
	<div class="frm-cntnr width--80 w-wrapper">
		<div class="spdct-frame3__header animate-up">
			<h2 class="clr--green">Get Quotation</h2>
		</div>
		<form id="quotationForm" method="post">
			<div class="form-wrapper">
				<div class="input-hldr animate-up">
					<label class="input-label" for="product">Product Name</label>
					<input type="text" name="product" placeholder="product Name"  value=" <?= $row['product_name'] ?>" required="" readonly>
				</div>
				<div class="input-hldr animate-up">
					<label class="input-label" for="fullname">Full Name</label>
					<input type="text" name="fullname" placeholder="Full Name" required="">
				</div>
				<div class="input-hldr animate-up">
					<label class="input-label" for="mobile">Mobile Number</label>
					<input type="text" name="mobile" placeholder="Mobile Number" required="">
				</div>
				<div class="input-hldr animate-up">
					<label class="input-label" for="email">Email</label>
					<input type="text" name="email" placeholder="Email" required="">
				</div>
				<input type="hidden" name="postFlag" value="1">
			</div>
			<div class="recaptcha-hldr m-margin-b animate-up">
				<div class="g-recaptcha" data-sitekey="6LdzqH0iAAAAAH4aACDM-FCozJysYsP5mzuAxxNQ"></div>
			</div>
			<div class="form-btn btn animate-up" id="quotationBtn">
				<a href="index.htm#">GET A QUOTE</a>
			</div>
		</form>
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
