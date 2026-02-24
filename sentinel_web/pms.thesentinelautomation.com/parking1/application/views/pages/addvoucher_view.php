
<link href="https://maxcdn.bootstrapcdn.com/font-awesome/4.6.3/css/font-awesome.min.css" rel="stylesheet"/>-->
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


<!DOCTYPE html>
<html lang="en">
<body>
    <div id="wrapper">

        <div class="row">
            <div class="col-md-6">





                <form action = "" method = "post" class="d-flex flex-column p-4" style="width: 750px; height: 750px;">

                    <div class="mb-3">
                        <span style="color: red;"> <?php echo validation_errors(); ?></span>

                        

                    </div>
                    
                    <div class="form-group">
                        <label for="exampleInputEmail1">Name:</label>
                        <span style="color: red;">*</span>
                        <input type="text" class="form-control input-sm" name="dc_name" value="<?= $dc_name ?>">
                        <small id="emailHelp" class="form-text text-muted"></small>
                    </div>
                     <div class="form-group">
                  
                        <label for="oncharge">User Type</label>
                        <select name="ratetype" class="form-control">

                        <option value = "" style="background-color:#007bff; color: white;" disabled><strong>RATE TYPE</strong></option>

                        <?php foreach ($rates as $value):?>
                      
        
                            <option value = "<?= $value["rate_id"] ?>" 
                             <?= $value["rate_id"]==$ratetype ? 'selected="selected"' : '' ?>><?= $value["rate_code"] ?></option>
                      
                       
                        <?php endforeach ?>
                        </select>

                    </div>
                    <!--<div class="form-group">
                        <label for="exampleInputEmail1">Amount:</label>
                        <span style="color: red;">*</span>
                        <input type="text" class="form-control input-sm" name="dc_amount" value="<?= $dc_amount ?>">
                        <small id="emailHelp" class="form-text text-muted"></small>
                    </div>-->

                    <div class="form-group">
                        <label for="exampleInputEmail1">Description:</label>
                        <span style="color: red;">*</span>
                        <input type="text" class="form-control input-sm" name="dc_desc" value="<?= $dc_desc ?>">
                        <small id="emailHelp" class="form-text text-muted"></small>
                    </div>
                    <!--<div class="form-group">
                        <label for="exampleInputEmail1">Code:</label>
                        <span style="color: red;">*</span>
                        <input type="text" class="form-control input-sm" name="dccode" value="<?= $dccode ?>">
                        <small id="emailHelp" class="form-text text-muted"></small>
                    </div>-->
                   
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