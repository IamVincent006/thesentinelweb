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


<script type="text/javascript" src="<?=base_url() ?>assets/js/datatablesusers.js"></script>

<!DOCTYPE html>
<html lang="en">
<body>
<br/><br/>







<div id="myTable">

    <div id="wrapper">
        <div class="container-fluid">

    <div id="viewPage">
          <a href = "<?=base_url()?>users/adduser" class="btn" style="background: #715cfa; color: #fff;" >Add Users</a>
          <!--<button type="button" id="arcbtn" class="btn" style="border-color:#715cfa; color: #715cfa;">Show Inactive Rates</button>-->
          </div>
          <div id="arcPage" style="display: none;">
          <p>Archive &nbsp;&nbsp;<button type="button" id="viewbtn" class="btn btn-2">Show Active Rates</button></p>
          </div>
<br/><br/>




            <table id="users_table" class="table table-striped">
                <thead class="text-center">
                <tr class="table-primary text-center">
                    <th>Username</th>
                    <th>First Name</th>
                    <th>Last Name</th>
                    <th>User Type</th>
                    <th>Last Date Login</th>
                    <th>Last PC Login</th>
                    <th>Login Status</th>
                    <th>Users Status</th>
                  


   



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
</body>
</html>