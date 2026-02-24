<?php include "template/header.php"; ?>



    <div class="spacing"></div>
<section class="pdct-frame1">
	<div class="frm-cntnr">
		<div class="pdct-frame1__wrapper">
			<div class="pdct-frame1__title">
				<h1 class="clr--green desktop">Our Services</h1>
				<h1 class="clr--green mobile">Our Services</h1>
				<img id="btnfilter" src="_resources/themes/main/images/filter.png" alt="">
			</div>

			<form action="services-details.php" method="POST">
				<input type="hidden" name="id">
                <div class="pagination" style="display: flex; flex-direction: column;">
				</div>
			</form>
		</div>
	</div>
</section>





</div>

           <script type="text/javascript">
           	services("service_result.php");

            var pageID = 'ProductPage',
            baseHref = 'https://worldhomedepot.com/',
            themeDir = '/_resources/themes/main';
        </script>

<?php include "template/footer.php"; ?>