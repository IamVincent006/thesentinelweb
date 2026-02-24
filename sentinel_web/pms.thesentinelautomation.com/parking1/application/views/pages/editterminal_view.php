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
                        <?php $this->load->view('components/alert') ?> 
                    </div>
                    


                    <div class="form-group">
                        <label for="initcharge">Terminal Name:</label>

                        <input type="text" class="form-control" name="termname" value="<?= $query['termname'] ?>">
                        <small id="emailHelp" class="form-text text-muted"></small>
                    </div>

                    <div class="form-group">
                        <label for="initcharge">Terminal IP:</label>

                        <input type="text" class="form-control" name="termIP" value="<?= $query['termIP'] ?>">
                        <small id="emailHelp" class="form-text text-muted"></small>
                    </div>

                    <div class="form-group">
                        <label for="initcharge">CODE:</label>
                        <i class="fa fa-question-circle"></i>
                            <span class="tip-txt">
                              DOCUMENT CODE FOR RECEIPT IE.(SNT-)
                        </span>  

                        <input type="text" class="form-control" name="area_code" value="<?= $query['area_code'] ?>">
                        <small id="emailHelp" class="form-text text-muted"></small>
                    </div>
                    <div class="form-group">
                        <label for="initcharge">DOCUMENT:</label>
                        <i class="fa fa-question-circle"></i>
                            <span class="tip-txt">
                              DOCUMENT COUNT FOR RECEIPT IE.(01-)
                        </span>  
                        <input type="text" class="form-control" name="docnum" value="<?= $query['docnum'] ?>">
                        <small id="emailHelp" class="form-text text-muted"></small>
                    </div>
                    <div class="form-group">
                  
                        <label for="oncharge">TYPE</label>
    
                        <select name="termtype" class="form-control">

                        <option value = "" style="background-color:#007bff; color: white;" disabled><strong>USER TYPE</strong></option>
                        <option value = "ENTRY"  <?= "ENTRY"==$query['termtype'] ? 'selected="selected"' : '' ?>>ENTRY</option>
                        <option value = "EXIT"  <?= "EXIT"==$query['termtype'] ? 'selected="selected"' : '' ?>>EXIT</option>
                        <option value = "PAYMENT"  <?= "PAYMENT"==$query['termtype'] ? 'selected="selected"' : '' ?>>PAYMENT</option>
                        <option value = "AUTOPAY"  <?= "AUTOPAY"==$query['termtype'] ? 'selected="selected"' : '' ?>>AUTOPAY</option>
             
                        </select>


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
                        <label for="exampleInputEmail1">ID COUNT:</label>
                        <i class="fa fa-question-circle"></i>
                            <span class="tip-txt">
                              COUNT ID  IE. START AT(10,0000000) MAX OF (10,9999999)
                            </span>
                        <input type="text" class="form-control input-sm" name="termcnt" value="<?= $query['termcnt'] ?>">
                        <small id="emailHelp" class="form-text text-muted"></small>
                    </div>
                    <div class="form-group">
                        <label for="surcharge_hour">RECEIPT</label>
                        <input type="text" class="form-control" name="termreceipt" value="<?= $query['termreceipt'] ?>">
                        <small id="emailHelp" class="form-text text-muted"></small>
                    </div>
                    <div class="form-group">
                        <label for="surcharge_hour">TELLER</label>
                        <input type="text" class="form-control" name="termtellerlogID" value="<?= $query['termtellerlogID'] ?>">
                        <small id="emailHelp" class="form-text text-muted"></small>
                    </div>
                    <div class="form-group">
                        <label for="surcharge_hour">PARKER</label>
                        <input type="text" class="form-control" name="termparkid" value="<?= $query['termparkid'] ?>">
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