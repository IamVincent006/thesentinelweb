<script type="text/javascript" src="<?=base_url() ?>assets/js/index.js"></script>



<script type="text/javascript" src="<?=base_url() ?>assets/js/bootstrap.bundle.js"></script>
<script type="text/javascript" src="<?=base_url() ?>assets/js/pdfmake.min.js"></script>
<script type="text/javascript" src="<?=base_url() ?>assets/js/vfs_fonts.js"></script>


<!-- 2. GOOGLE JQUERY JS v3.2.1  JS !-->
<script type="text/javascript" src="<?=base_url() ?>assets/js/jquery.min.js"></script>
<!-- 3. BOOTSTRAP v4.0.0         JS !-->
<script type="text/javascript" src="<?=base_url() ?>assets/js/bootstrap.min.js"></script>

<script type="text/javascript" src="<?=base_url() ?>assets/js/jquery-ui.js"></script>


<script type="text/javascript" src="<?=base_url()?>assets/js/datatables1.js"></script>

<script type="text/javascript" src="<?=base_url()?>assets/js/datatablesreport.js"></script>




<!DOCTYPE html>
<html lang="en">
<body>
<div id="wrapper">
<div class="container-fluid">
<br/>
<br/>
	<form action = "" method = "post" name = "reportfrm"> 
		<input type=hidden name="no_date" value="">   
		<div align="center">
			<br/><br/>
			<div class="form-control" style="width: 100%; height: 50px; margin-top: -2%;">
				<div class="row"><br>
					<label style="margin-left: 6%;"><strong>Date & Time :</strong></label>
					<label style="margin-left: 6%;">From:</label>
					<div class="col-sm-3">
					<input type="text" style="width:100%;" name="from_date" id="from_date" autocomplete="off" class="form-control" placeholder="Input date..">
					</div>
						<label style="margin-left: 6%;">To:</label>
						<div class="col-sm-3">
						<input type="text" style="width:100%;" name="to_date" id="to_date" autocomplete="off" class="form-control" placeholder="Input date..">
					</div>
				</div>
				<br/>
				<br/>
                <div class="row">
                    <div class="col-sm"></div>
                    <div class="col-sm">
                      <label><strong>Terminal:</strong></label>
                        <select id="ter" name="terminal" class="form-control">

                    
                     	<option value="0/all">ALL</option>
                     	<?php foreach ($terminals as $value): ?>

	                     	<option value = "<?= $value["termID"]."/".$value["termname"] ?>"><?= $value["termname"] ?></option>
	                   
                     	<?php endforeach; ?>

                        </select>
                    </div>
                    <div class="col-sm">
                       <label><strong>Parker Type:</strong></label>
                          <select name="parker" id="parker" class="form-control">
                            <option value="all">ALL</option>
                        	<?php foreach ($rates as $value):?>
		
		
	                     	<option value = "<?= $value["rate_code"] ?>"><?= $value["rate_code"] ?></option>

	                     	<?php endforeach; ?>
                          </select>
                    </div>
                   <div class="col-sm">
                       <label><strong>AREA:</strong></label>
                          <select name="area" id="area" class="form-control">
                            <option value="0">NONE</option>
                            <option value="1">SENTINEL</option>
               
                          </select>
                    </div>

                    <div class="col-sm"></div>
     
                     
              	</div>



			<div class="col-sm">
					<div style="margin-left:35%;padding: 10px;">
		                <span class="parkchange badge badge-pill badge-success" style="height: 30px; font-size: 20px; display: none;">Terminal and Parker Type</span>
					</div>

				       
	              <ul class="nav nav-tabs" role="tablist" style="margin-left: 20%; margin-right: 20%;">
				                

          		  <li class="nav-item">
				    <a class="thisNav nav-link" href="#bylocation" role="tab" data-toggle="tab">BY LOCATION</a>
				  </li>
				  <li class="nav-item">
				    <a class="thisNav nav-link" href="#byterm" role="tab" data-toggle="tab">BY TERMINAL</a>
				  </li>
				   <li class="nav-item">
				    <a class="thisNav nav-link" href="#byshift" role="tab" data-toggle="tab">BY SHIFT</a>
				  </li>

				</ul>

			<div class="tab-content">



				<div role="tabpanel" class="tab-pane fade" id="bylocation">
					    <br>
					    <table id="termtable" class="table table-striped" align="center">
					      <thead>
					        <th>Report Name</th>
					        <th>Description</th>
					        <th>Generate</th>
					      </thead>
					      <tbody>
					        <tr>
					          <td>DAILY REPORT</td>
					          <td>CASHIER REPORT DAILY</td>
					          <td><input type="button" value="EXCEL"  onclick="SubmitForm('dailypdf')" name="dailypdf" class="btn btn-success"> <input type="button" value="PDF"  onclick="SubmitForm('dailypdf')" name="dailypdf" class="btn btn-danger"></td>
					        </tr>
					        
					      </tbody>
					    </table>
					    <br/>
					    <br/>
					    <br/>
					    <br/>
					    <br/>
				</div>

			
				<div role="tabpanel" class="tab-pane fade" id="byterm">
					    <br>
					    <table id="termtable" class="table table-striped" align="center">
					      <thead>
					        <th>Report Name</th>
					        <th>Description</th>
					        <th>Generate</th>
					      </thead>
					      <tbody>
					        <tr>
					          <td>TRANSACTION REPORT</td>
					          <td></td>
					          <td>
					          	<!--<input type="button" value="EXCEL"  onclick="SubmitForm('accountabilityexcel')" name="accountabilityexcel" class="btn btn-success"> -->
					          	<input type="button" value="PDF"  onclick="SubmitForm('transactionpdf')" name="transactionpdf" class="btn btn-danger"></td>
					        </tr>

					         <!--<tr>
					          <td>ACCOUNTABILITY REPORT</td>
					          <td></td>
					          <td>

					          	<input type="button" value="PDF"  onclick="SubmitForm('accountabilitypdf')" name="accountabilitypdf" class="btn btn-danger"></td>
					        </tr>
					        <tr>
					          <td>X READING</td>
					          <td></td>
					          <td>
					          	<input type="button" value="PDF"  onclick="SubmitForm('xreadpdf')" name="xreadpdf" class="btn btn-danger"></td>
					        </tr>
					        <tr>
					          <td>Z READING</td>
					          <td></td>
					          <td>
					          	<input type="button" value="PDF"  onclick="SubmitForm('zreadpdf')" name="zreadpdf" class="btn btn-danger"></td>
					        </tr>-->


					       	<tr>
					          <td>SENIOR BOOK</td>
					          <td></td>
					          <td>
					          	<input type="button" value="PDF"  onclick="SubmitForm('seniorbookpdf')" name="seniorbookpdf" class="btn btn-danger"></td>
					        </tr>
					       	<tr>
					          <td>PWD BOOK</td>
					          <td></td>
					          <td>
					          	<input type="button" value="PDF"  onclick="SubmitForm('pwdbookpdf')" name="pwdbookpdf" class="btn btn-danger"></td>
					        </tr>
				          <td>VOUCHER BOOK</td>
					          <td></td>
					          <td>
					          	<input type="button" value="PDF"  onclick="SubmitForm('voucherbookpdf')" name="voucherbookpdf" class="btn btn-danger"></td>
					        </tr>
					        <tr>
					          <td>BIR REPORT</td>
					          <td></td>
					          <td>
					          	<input type="button" value="PDF"  onclick="SubmitForm('birpdf')" name="birpdf" class="btn btn-danger"></td>
					        </tr>
					        <tr>
					          <td>E-JOURNAL</td>
					          <td></td>
					          <td>
					          	<input type="button" value="PDF"  onclick="SubmitForm('ejournal')" name="ejournal" class="btn btn-danger">
					          	<input type="button" value="TXT"  onclick="SubmitForm('ejournaltxt')" name="ejournaltxt" class="btn btn-danger">

					          </td>
					        </tr>
					        <!--<tr>
					          <td>Activity Log</td>
					          <td></td>
					          <td>
					          	<input type="button" value="PDF"  onclick="SubmitForm('activitylog')" name="activitylog" class="btn btn-danger"></td>
					        </tr>-->
					        <!--<tr>
					          <td>AUTOPAY SUMMARY</td>
					          <td></td>
					          <td>
					          	<input type="button" value="PDF"  onclick="SubmitForm('autosum')" name="autosum" class="btn btn-danger"></td>
					        </tr>-->
					        <tr>
					          <td>AUTOPAY REPORT</td>
					          <td></td>
					          <td>
					          	<input type="button" value="PDF"  onclick="SubmitForm('autorep')" name="autorep" class="btn btn-danger"></td>
					        </tr>
					       
					       
				
					      </tbody>
					    </table>
					    <br/>
					    <br/>
					    <br/>
					    <br/>
					    <br/>
				</div>


				<div role="tabpanel" class="tab-pane fade" id="byshift">
				<br>
				  <center>


				                <label><strong>Teller Name:</strong></label>
				                 <select id="user_id" name = "user_id" size = "1" class="form-control" style="text-align: center; width: 20%;">
				                  	
			                     	<?php foreach ($users as $value): ?>

					
				                     	<option value = "<?= $value["userid"] ?>"><?= $value["firstname"].' '.$value["lastname"] ?></option>
				                   
			                     	   <?php endforeach; ?>


				                  </select>
				                  <br>
				              <input type="button" style="text-align: center; width: 10%;" value="GENERATE"  onclick="SubmitForm('cashierdailypdf')"  name="cashierdailypdf" class="form-control btn btn-primary">
				    </center>

				    <br/>
				    <br/>
				    <br/>
				    <br/>
				    <br/>
				    <br/>
				    <br/>
				    <br/>
				    <br/>
				    <br/>




				</div>






			</div>







			</div>
			





			</div>

		</div>
	</form>

	<br/>
	<br/>
	<br/>
	<br/>


</div>
</div>

</body>
</html>


<script type="text/javascript">
$( function() {
    $('#from_date').datepicker({
        dateFormat: 'yy-mm-dd',
        onSelect: function(datetext){
            var d = new Date($('#from_date').val()); // for now
            var h = d.getHours();
            h = (h < 10) ? ("0" + h) : h ;

            var m = d.getMinutes();
            m = (m < 10) ? ("0" + m) : m ;

            var s = d.getSeconds();
            s = (s < 10) ? ("0" + s) : s ;

           // datetext = datetext + " " + h + ":" + m + ":" + s;
            datetext = datetext + " " + "00" + ":" + "00" + ":" + "00";
            $('#from_date').click();
            $('#from_date').val(datetext);

            //$('#frhr').val(h);
            //$('#frmn').val(m);
            //$('#frsc').val(s);
        },
    });
                                       
                                          
  $('#to_date').datepicker({
        dateFormat: 'yy-mm-dd',
        onSelect: function(datetext){
            var d = new Date($('#to_date').val()); // for now
            var h = d.getHours();
            h = (h < 10) ? ("0" + h) : h ;

            var m = d.getMinutes();
            m = (m < 10) ? ("0" + m) : m ;

            var s = d.getSeconds();
            s = (s < 10) ? ("0" + s) : s ;


                            

            //datetext = datetext + " " + h + ":" + m + ":" + s;
             datetext = datetext + " " + "21" + ":" + "59" + ":" + "59";
            $('#to_date').click();
            $('#to_date').val(datetext);
            $('#tohr').val(h);
            $('#tomn').val(m);
            $('#tosc').val(s);
        },
    });


} );
</script>

