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
<script type="text/javascript" src="<?=base_url() ?>assets/js/datatablescardholder.js"></script>

<!DOCTYPE html>
<html lang="en">
<body>
<br/><br/>







<div id="myTable">

    <div id="wrapper">
        <div class="container-fluid">

    <div id="viewPage">
          <div id="viewPage">
               <a href = "<?=base_url()?>cardholders/addcardholder" class="btn" style="background: #715cfa; color: #fff;" >Add CardHolder</a>
          </div>
 



<br/><br/>




            <table id="cardholder_table" class="table table-striped">
                <thead class="text-align">
                <tr class="table-primary text-align">
                    <th>Date Created</th>
                    <th>Card Serial</th>
                    <th>Parker Type</th>
                    <th>area</th>
                    <th>License Number</th>
                    <th>First Name</th>
                    <th>Last Name</th>
                    <th>Valid Date</th>
                    <th>Status</th>
                


                </tr>
                </thead>

            </table>
        </div>
    </div>
</div>
</body>
</html>