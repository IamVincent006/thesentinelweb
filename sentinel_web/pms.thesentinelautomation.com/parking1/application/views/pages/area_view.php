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


<script type="text/javascript" src="<?=base_url() ?>assets/js/datatablesarea.js"></script>

<!DOCTYPE html>
<html lang="en">
<body>
<br/><br/>







<div id="myTable">

    <div id="wrapper">
        <div class="container-fluid">

    <div id="viewPage">
          <a href = "<?=base_url()?>area/addarea" class="btn" style="background: #715cfa; color: #fff;" >Add Area</a>
          </div>
          <div id="arcPage" style="display: none;">
          <p>Archive &nbsp;&nbsp;<button type="button" id="viewbtn" class="btn btn-2">Show Active Rates</button></p>
          </div>
<br/><br/>




            <table id="rates_table" class="table table-striped">
                <thead class="text-center">
                <tr class="table-primary text-center">
                    <th>Code</th>
                    <th>Location</th>
                    <th>Payment Gracehour</th>
                    <th>Payment Graceminutes</th>
                    <th>Entry Gracehour</th>
                    <th>Entry Graceminutes</th>
                    <th>Cut offhour</th>
                    <th>Cut offminutes</th>
                  


   



                </tr>
                </thead>
            </table>
        </div>
    </div>
</div>
</body>
</html>