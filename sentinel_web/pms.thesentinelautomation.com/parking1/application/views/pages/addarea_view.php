<!--<script type="text/javascript" src="<?=base_url() ?>assets/js/index.js"></script>
<script type="text/javascript" src="https://cdn.datatables.net/1.13.6/js/dataTables.bootstrap4.min.js"></script>
<script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.2.7/pdfmake.min.js"></script>
<script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.2.7/vfs_fonts.js"></script>

<link href="https://maxcdn.bootstrapcdn.com/font-awesome/4.6.3/css/font-awesome.min.css" rel="stylesheet"/>-->
<script type="text/javascript" src="<?=base_url() ?>assets/js/index.js"></script>


<script type="text/javascript" src="<?=base_url() ?>assets/js/bootstrap.bundle.js"></script>

<script type="text/javascript" src="<?=base_url() ?>assets/js/pdfmake.min.js"></script>
<script type="text/javascript" src="<?=base_url() ?>assets/js/vfs_fonts.js"></script>
<!--
<script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.2.7/pdfmake.min.js"></script>
<script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.2.7/vfs_fonts.js"></script>
-->

<!-- 2. GOOGLE JQUERY JS v3.2.1  JS !-->
<script type="text/javascript" src="<?=base_url() ?>assets/js/jquery.min.js"></script>
<!--<script src="https://ajax.googleapis.com/ajax/libs/jquery/2.1.1/jquery.min.js"></script>-->
<!-- 3. BOOTSTRAP v4.0.0         JS !-->

<script type="text/javascript" src="<?=base_url() ?>assets/js/bootstrap.min.js"></script>
<!--
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js" integrity="sha384-JZR6Spejh4U02d8jOt6vLEHfe/JQGiRRSQQxSfFWpi1MquVdAyjUar5+76PVCmYl" crossorigin="anonymous"></script>
-->
<script type="text/javascript" src="<?=base_url() ?>assets/js/jquery-ui.js"></script>
<!--<script src="https://code.jquery.com/ui/1.13.2/jquery-ui.js"></script>-->

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
                        <label for="exampleInputEmail1">Area Code:</label>
                        <span style="color: red;">*</span>
                        <input type="text" class="form-control input-sm" name="area_code" value="<?= $area_code ?>">
                        <small id="emailHelp" class="form-text text-muted"></small>
                    </div>
                    <div class="form-group">
                        <label for="initcharge">Area Location:</label>

                          <i class="fa fa-question-circle"></i>
                            <span class="tip-txt">
                              initial hour to be charge
                            </span>
  
                        <input type="text" class="form-control" name="area_name" value="<?= $area_name ?>">
                        <small id="emailHelp" class="form-text text-muted"></small>
                    </div>
                    <div class="form-group">
                        <label for="payment_gracehour">Payment GraceHour:</label>
                        <input type="text" class="form-control" name="payment_gracehour" value="<?= $payment_gracehour ?>">
                        <small id="emailHelp" class="form-text text-muted"></small>
                    </div>
                    <div class="form-group">
                        <label for="payment_graceminute">Payment GraceMinutes</label>
                        <input type="text" class="form-control" name="payment_graceminute" value="<?= $payment_graceminute ?>">
                        <small id="emailHelp" class="form-text text-muted"></small>


                    </div>
                    <div class="form-group">
                        <label for="entry_gracehour">Entry GraceHour</label>
                        <input type="text" class="form-control" name="entry_gracehour" value="<?= $entry_gracehour ?>">
                        <small id="emailHelp" class="form-text text-muted"></small>
                    </div>
                    <div class="form-group">
                        <label for="entry_graceminute">Entry GraceMinutes</label>
                        <input type="text" class="form-control" name="entry_graceminute" value="<?= $entry_graceminute ?>">
                        <small id="emailHelp" class="form-text text-muted"></small>

                        
                    </div>
                    <div class="form-group">
                        <label for="cutoffhour">Cutoff Hour</label>
                        <input type="text" class="form-control" name="cutoffhour" value="<?= $cutoffhour ?>">
                        <small id="emailHelp" class="form-text text-muted"></small>
                    </div>
                    <div class="form-group">
                        <label for="cutoffminute">Cutoff Minutes</label>
                        <input type="text" class="form-control" name="cutoffminute" value="<?= $cutoffminute ?>">
                        <small id="emailHelp" class="form-text text-muted"></small>


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