<?php include "template/header.php"; ?>

            

            <div class="spacing"></div>
<section class="rapp-frame1">
	<div class="frm-cntnr width--80 w-wrapper">
		<div class="rapp-frame1__title">
			<h2 class="clr--green animate-up">Request Appointment</h2>
		</div>
		<div class="rapp-frame1__sub">
			<p class="clr--gray--600 animate-up">Please fill out the form below and we will contact you shortly.</p>
		</div>

		<div class="rapp-frame1__form">
			<form id="appointmentForm" method="post">
				<div class="form-wrapper">
					<div class="input-hldr animate-up">
						<label class="input-label" for="fullname">Name</label>
						<input type="text" name="fullname" placeholder="Name" required="">
					</div>
					<div class="input-hldr animate-up">
						<label class="input-label" for="mobile">Mobile Number</label>
						<input type="text" name="mobile" placeholder="Mobile Number" required="">
					</div>
					<div class="input-hldr animate-up">
						<label class="input-label" for="email">Email</label>
						<input type="text" name="email" placeholder="Email" required="">
					</div>
					<div class="input-hldr animate-up">
						<label class="input-label" for="date">Appointment Date</label>
						<input type="date" name="date" placeholder="Appointment Date" value="2022-09-23" required="">
					</div>
					<div class="input-hldr animate-up">
						<label class="input-label" for="time">Appointment Time</label>
						<input type="time" name="time" placeholder="Appointment Time" value="09:00" required="">
					</div>
					<div class="input-hldr animate-up">
						<label class="input-label" for="product">Drop your plan here</label>
						<input type="text" name="product" placeholder="Drop your plan here" required="">
					</div>
					<div class="input-hldr animate-up">
						<label class="input-label" for="messagedetails">Tell us about the project</label>
						<input type="text" name="messagedetails" placeholder="Tell us about the project" required="">
					</div>
					<div class="input-hldr animate-up">
						<label class="input-label" for="plan">Drop technical plans here</label>
						
						<div class="frm-input form-upload" data-id="1">
							<div class="frm-form__input">
								<label id="file-selected1" for="fileupload1" class="custom-file-upload">Drop technical plans here</label>
							</div>
							<input type="file" id="fileupload1" class="fileuploadBtn" name="file" required="" hidden="">
							<input type="hidden" id="file-image1" name="plan" value="" required="">
						</div>
					</div>
					
					<input type="hidden" name="postFlag" value="1">
				</div>
				<div class="recaptcha-hldr m-margin-b animate-up">
					<div class="g-recaptcha" data-sitekey="6Le5EY0dAAAAAHy6rXBE23xEligdd-2WOwN8mHIb"></div>
				</div>
				<div class="form-btn btn animate-up" id="appointmentBtn">
					<a href="request-appointment.html#">SUBMIT</a>
				</div>
			</form>
		</div>
	</div>
</section>

            

            

        </div>

        

        <script type="text/javascript">
            var pageID = 'RequestAppointment',
            baseHref = 'localhost',
            themeDir = '/_resources/themes/main';
        </script>


<?php include "template/footer.php"; ?>