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
<script type="text/javascript" src="<?=base_url() ?>assets/js/datatablesmonitoring.js"></script>








<!DOCTYPE html>
<html lang="en">
<body>
<br/>

<div id="myTable">

<div id="wrapper" >
    <div  class="imgheader" style="display: flex; flex-wrap: nowrap; gap: 20px;" >
        <div class="boxes"><img id="entrycar" src="<?=base_url()?>assets/img/car.png" style="height: 230px; width: 230px"></div>
        <div class="boxes"><img id="entryface" src="<?=base_url()?>assets/img/driver.png" style="height: 230px; width: 230px"></div>
        <div class="boxes"><img id="exitcar" src="<?=base_url()?>assets/img/car.png" style="height: 230px; width: 230px"></div>
        <div class="boxes"><img id="exitface" src="<?=base_url()?>assets/img/driver.png" style="height: 230px; width: 230px"></div>
    </div>
</div>
<br/>



    <div id="wrapper">
        <div class="container-fluid">
            <table id="monitoring_table" class="table table-striped">
                <thead class="text-center">
                <tr class="table-primary text-center">
                    <th>cardserial</th>
                    <th>entry_termid</th>
                    <th>Entry Date</th>
                    <th>payment</th>
                    <th>paymentdate</th>
                    <th>exit</th>
                    <th>exitdate</th>
                    <th>platenum</th>
                    <th>brandmodel</th>
                    <th>process</th>

                </tr>
                </thead>
                <!--<tbody>
                <tr>
                    <td>Row 1 Data 1</td>
                    <td>Row 1 Data 2</td>
                    <td>Row 1 Data 3</td>
                    <td>Row 1 Data 4</td>
                    <td>Row 1 Data 5</td>
                    <td>Row 1 Data 6</td>
                    <td>Row 1 Data 7</td>
                    <td>Row 1 Data 8</td>
                    <td>Row 1 Data 9</td>
                </tr>
                </tbody>-->
            </table>
        </div>
    </div>
</div>
<br/><br/>
</body>
</html>