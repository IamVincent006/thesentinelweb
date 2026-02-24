<!--<script type="text/javascript" src="<?=base_url() ?>assets/js/index.js"></script>
<script type="text/javascript" src="https://cdn.datatables.net/1.13.6/js/dataTables.bootstrap4.min.js"></script>
<script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.2.7/pdfmake.min.js"></script>
<script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.2.7/vfs_fonts.js"></script>

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
                        <label for="exampleInputEmail1">Parktype Name:</label>
                        <span style="color: red;">*</span>
                        <input type="text" class="form-control input-sm" name="rate_code" value="<?=$query["rate_code"]?>">
                        <small id="emailHelp" class="form-text text-muted"></small>
                    </div>
                    <div class="form-group">
                  
                        <label for="oncharge">AREA</label>
                        <select name="termarea" class="form-control">

                        <option value = "" style="background-color:#007bff; color: white;" disabled><strong>USER TYPE</strong></option>
                        <?php foreach ($termarea as $value): ?>        
                            <option value = "<?= $value["area_id"] ?>"  <?= $value["area_id"]==$termarea ? 'selected="selected"' : '' ?>><?= $value["area_name"] ?></option>
                       
                        <?php endforeach; ?>

                        </select>


                        <small id="emailHelp" class="form-text text-muted"></small>

                    </div>
                    <div class="form-group">
                        <label for="initcharge">Initial Hour:</label>

                          <i class="fa fa-question-circle"></i>
                            <span class="tip-txt">
                              initial hour to be charge
                            </span>
  
                        <input type="text" class="form-control" name="inithour" value="<?=$query["initcharge_hour"]?>">
                        <small id="emailHelp" class="form-text text-muted"></small>
                    </div>
                    <div class="form-group">
                        <label for="initcharge">Init Charge:</label>
                        <input type="text" class="form-control" name="initcharge" value="<?=$query["initcharge"]?>">
                        <small id="emailHelp" class="form-text text-muted"></small>
                    </div>
                    <div class="form-group">
                        <label for="surcharge_hour">Succeding Hour</label>
                        <input type="text" class="form-control" name="suchour" value="<?=$query["succharge_hour"]?>">
                        <small id="emailHelp" class="form-text text-muted"></small>


                    </div>
                    <div class="form-group">
                        <label for="succharge">Succeding Charge</label>
                        <input type="text" class="form-control" name="succharge" value="<?=$query["succharge"]?>">
                        <small id="emailHelp" class="form-text text-muted"></small>
                    </div>
                    <div class="form-group">
                        <label for="oncharge">Overnight Charge</label>
                        <input type="text" class="form-control" name="oncharge" value="<?=$query["oncharge"]?>">
                        <small id="emailHelp" class="form-text text-muted"></small>

                        
                    </div>
                    <div class="form-group">
                        <label for="lostcharge">Lost Charge</label>
                        <input type="text" class="form-control" name="lostcharge" value="<?=$query["lostcharge"]?>">
                        <small id="emailHelp" class="form-text text-muted"></small>
                    </div>
                    <div class="form-group">
                        <label for="member_type">Type</label>
                        <input type="text" class="form-control" name="type" value="<?=$query["member_type"]?>">
                        <small id="emailHelp" class="form-text text-muted"></small>
                    </div>
                    <div class="form-group">
                        <label for="member_type">Discount</label>
                        <input type="text" class="form-control" name="discount" value="<?=$query["discount"]?>">
                        <small id="emailHelp" class="form-text text-muted"></small>
                    </div>
                    <div class="form-group">
                        <label for="member_type">Status</label>
                        <input type="text" class="form-control" name="rate_status" value="<?=$query["rate_status"]?>">
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