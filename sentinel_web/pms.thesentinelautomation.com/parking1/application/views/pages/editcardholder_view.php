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

        <div class="row">
            <div class="col-md-6">





                <form action = "" method = "post" class="d-flex flex-column p-4" style="width: 500px; height: 750px;">

                    <div class="mb-3">
                        <?php $this->load->view('components/alert') ?> 
                    </div>
                    
                    <div class="form-group">
                        <label for="initcharge">CardSerial:</label>

                        <input type="text" class="form-control" name="cardserial" id="cardserial"  value="<?= $query['cardserial'] ?>">
                    </div>
                     <div class="form-group">
                  
                        <label for="oncharge">AREA</label>
                        <select name="area_id" class="form-control">

                        <option value = "" style="background-color:#007bff; color: white;" disabled><strong>AREA TYPE</strong></option>
                           
                        <?php foreach($termarea as $value): ?>   
                            <option value = "<?= $value["area_id"] ?>"  <?= $value["area_id"]==$termarea ? 'selected="selected"' : '' ?>><?= $value["area_name"] ?></option>
                       
                         <?php endforeach; ?>

                        </select>


                        <small id="emailHelp" class="form-text text-muted"></small>

                    </div>
                   <div class="form-group">
                  
                        <label for="oncharge">User Type</label>
                        <select name="ratetype" class="form-control">

                        <option value = "" style="background-color:#007bff; color: white;" disabled><strong>USER TYPE</strong></option>

                        <?php foreach ($rates as $value):?>
                      
        
                            <option value = "<?= $value["rate_id"] ?>" 
                             <?= $value["rate_id"]==$query['ratetype'] ? 'selected="selected"' : '' ?>><?= $value["rate_code"] ?></option>
                      
                       
                        <?php endforeach ?>
                        </select>

                    </div>
                    <div class="form-group">
                        <label for="exampleInputEmail1">License Number:</label>
                        <input type="text" class="form-control input-sm" name="platenum" value="<?= $query['platenum'] ?>">
                        
                    </div>
                    <div class="form-group">
                        <label for="exampleInputEmail1">First Name:</label>
                        <input type="text" class="form-control input-sm" name="firstname" value="<?= $query['firstname'] ?>">
                    </div>
                    <div class="form-group">
                        <label for="exampleInputEmail1">Last Name:</label>
                        <input type="text" class="form-control input-sm" name="lastname" value="<?= $query['lastname'] ?>">
                    </div>
                    <div class="form-group">
                        <label for="exampleInputEmail1">Valid Until:</label>
                        <input type="text" class="form-control input-sm" name="cardvalidity" id="cardvalidity"  autocomplete="off" class="form-control" placeholder="Input date.." value="<?= $query['cardvalidity'] ?>">

                        
                    </div>
         


                    <input type="submit" class="btn btn-primary" value="Submit" name="submit" style="width: 100px; height: 50px;">

                    <br/>
                    <br/>
                    <br/>
                </form>
            </div>
        </div>
    </div>
</body>
</html>

<script type="text/javascript">
$( function() {
    $('#cardvalidity').datepicker({
        dateFormat: 'yy-mm-dd',
        onSelect: function(datetext){
            var d = new Date($('#cardvalidity').val()); // for now
           /* var h = d.getHours();
            h = (h < 10) ? ("0" + h) : h ;

            var m = d.getMinutes();
            m = (m < 10) ? ("0" + m) : m ;

            var s = d.getSeconds();
            s = (s < 10) ? ("0" + s) : s ;

            datetext = datetext + " " + h + ":" + m + ":" + s;
            datetext = datetext;*/
            $('#cardvalidity').click();
            $('#cardvalidity').val(datetext);

        },
    });
                                       
    
} );







  /*var interval = 1200;  // 1000 = 1 second, 3000 = 3 seconds
    function doAjax() {
         $.ajax({
                type: 'POST',
                url: "<?php echo base_url('/cardholders/pcscreadergetserial'); ?>",
                data: $(this).serialize(),
                dataType: 'JSON',
                success: function (data) {
                        if(data.error == 0){
                            if(document.getElementById('cardserial').value != data.cardserial && data.cardserial!= ""){
                                $('#cardserial').val(data.cardserial);
                            }   
                            if(document.getElementById('cardserial').value != "" && data.cardserial== ""){
                                $('#cardserial').val("");
                            }
                        }
                },
                complete: function (data) {
                        // Schedule the next
                        setTimeout(doAjax, interval);
                }
        });

    }
    setTimeout(doAjax, interval);
*/




</script>

