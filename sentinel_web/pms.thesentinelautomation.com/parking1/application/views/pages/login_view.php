<?php
//require('../components/header.php');
?>


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
<section class="vh-100 gradient-custom">
    <div class="container py-5 h-100">
        <div class="row d-flex justify-content-center align-items-center h-100">
            <div class="col-12 col-md-8 col-lg-6 col-xl-5">
                <div class="card text-white" style="border-radius: 1rem; background-color: #5139f7;">
                    <div class="card-body p-5 text-center">

                        <div class="mb-md-5 mt-md-4 pb-5">
                            <form action="" method="post">



                                <div class="mb-3">
                                    <label for="username" class="form-label">Username</label>
                                    <input type="text" class="form-control" id="username" name="username" value="<?= $username?>">
                                </div>
                                <div class="mb-3">
                                    <label for="password" class="form-label">Password</label>
                                    <input type="password" class="form-control" id="password" name="password">
                                </div>
                                <button type="submit" name="submit" value="submit" class="btn btn-light">Login</button>
                                <br>
                                <br>
                                <div class="mb-3">
                                     <?php $this->load->view('components/alert') ?> 
                                </div>
                            </form>
                        </div>

                        <div>
                            <p class="mb-0"></p>
                        </div>

                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
</html>