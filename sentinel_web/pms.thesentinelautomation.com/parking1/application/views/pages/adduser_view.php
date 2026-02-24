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
                        <label for="initcharge">First Name:</label>

                          <i class="fa fa-question-circle"></i>
                            <span class="tip-txt">
                              initial hour to be charge
                            </span>  
                        <input type="text" class="form-control" name="firstname" value="<?= $firstname ?>">
                        <small id="emailHelp" class="form-text text-muted"></small>
                    </div>
                    <div class="form-group">
                        <label for="initcharge">Last Name:</label>
                        <input type="text" class="form-control" name="lastname" value="<?= $lastname ?>">
                        <small id="emailHelp" class="form-text text-muted"></small>
                    </div>
                    <div class="form-group">
                  
                        <label for="oncharge">User Type</label>
                        <select name="usertype" class="form-control">

                        <option value = "" style="background-color:#007bff; color: white;" disabled><strong>USER TYPE</strong></option>

                        <?php foreach ($userlevel as $value):?>
                            <?php if ($this->session->userdata('userlevel') <= $value["userlevel_id"]): ?>
        
                            <option value = "<?= $value["userlevel_id"] ?>"  <?= $value["userlevel_id"]==$usertype ? 'selected="selected"' : '' ?>><?= $value["userlevel_name"] ?></option>
                      
                            <?php endif ?>
                        <?php endforeach ?>
                        </select>


                        <small id="emailHelp" class="form-text text-muted"></small>

                    </div>
                    <div class="form-group">
                        <label for="exampleInputEmail1">User Name:</label>
                        <input type="text" class="form-control input-sm" name="username" value="<?= $username ?>">
                        <small id="emailHelp" class="form-text text-muted"></small>
                    </div>
                    <div class="form-group">
                        <label for="surcharge_hour">Password</label>
                        <input type="password" class="form-control" name="password" value="<?= $password ?>">
                        <small id="emailHelp" class="form-text text-muted"></small>


                    </div>
                    <div class="form-group">
                        <label for="succharge">Confirm Password</label>
                        <input type="password" class="form-control" name="confirmpword"  value="<?= $confirmpword ?>">
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