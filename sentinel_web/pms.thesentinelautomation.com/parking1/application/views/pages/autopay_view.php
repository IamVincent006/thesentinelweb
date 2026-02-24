<?php
$cards = [
    [
        "card-value" => "00",
        "card-title" => "Available Parking Slot",
        "href" => "#",
        "card-additionaltext" => "More Info",
    ],
    [
        "card-value" => "00",
        "card-title" => "Total Users",
        "href" => "#",
        "card-additionaltext" => "More Info",
    ],

];

?>
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

    <!-- statistics-cards -->
    <br/>


<div class="container">


    <div id="app"></div>



</div>

    <!-- /statistics-cards -->



</div>
</body>
</html>
<script type="text/javascript">
function loadlink(){

    const app = document.querySelector('#app');

    fetch("<?php echo base_url('/autopay/getautopaydata'); ?>")
      .then(response => response.json())
      .then(data => {

        const chunk = data.map(data => 
    `<table class="table table-bordered">
            <thead>
            <tr class="text-center">
                <th scope="col" class="table-primary">${data.termname}</th>
                <th scope="col" class="table-primary">PHP1000</th>
                <th scope="col" class="table-primary">PHP500</th>
                <th scope="col" class="table-primary">PHP200</th>
                <th scope="col" class="table-primary">PHP100</th>
                <th scope="col" class="table-primary">PHP50</th>
                <th scope="col" class="table-primary">PHP20</th>
                <th scope="col" class="table-primary">PHP10</th>
                <th scope="col" class="table-primary">PHP5</th>
                <th scope="col" class="table-primary">PHP1</th>
            </tr>
            </thead>
            <tbody>
            <tr class="text-center">
                <th scope="row">LOAD</th>
                <td>${data.lphp1000}</td>
                <td>${data.lphp500}</td>
                <td>${data.lphp200}</td>
                <td>${data.lphp100}</td>
                <td>${data.lphp50}</td>
                <td>${data.lphp20}</td>
                <td>${data.lphp10}</td>
                <td>${data.lphp5}</td>
                <td>${data.lphp1}</td>
            </tr>
            <tr class="text-center">
                <th scope="row">RECIEVE</th>
                <td>${data.rphp1000}</td>
                <td>${data.rphp500}</td>
                <td>${data.rphp200}</td>
                <td>${data.rphp100}</td>
                <td>${data.rphp50}</td>
                <td>${data.rphp20}</td>
                <td>0</td>
                <td>0</td>
                <td>0</td>
            </tr>
            <tr class="text-center">
                <th scope="row">CHANGE</th>
                <td>${data.cphp1000}</td>
                <td>${data.cphp500}</td>
                <td>${data.cphp200}</td>
                <td>${data.cphp100}</td>
                <td>${data.cphp50}</td>
                <td>${data.cphp20}</td>
                <td>${data.cphp10}</td>
                <td>${data.cphp5}</td>
                <td>${data.cphp1}</td>
            </tr>
             <tr class="text-center">
                <th scope="row">TOTAL</th>
                <td>${parseInt(data.lphp1000) + parseInt(data.rphp1000) - parseInt(data.cphp1000)}</td>
                <td>${parseInt(data.lphp500) + parseInt(data.rphp500) - parseInt(data.cphp500)}</td>
                <td>${parseInt(data.lphp200) + parseInt(data.rphp200) - parseInt(data.cphp200)}</td>
                <td>${parseInt(data.lphp100) + parseInt(data.rphp100) - parseInt(data.cphp100)}</td>
                <td>${parseInt(data.lphp50) + parseInt(data.rphp50) - parseInt(data.cphp50)}</td>
                <td>${parseInt(data.lphp20) + parseInt(data.rphp20) - parseInt(data.cphp20)}</td>
                <td>${parseInt(data.lphp10) - parseInt(data.cphp10)}</td>
                <td>${parseInt(data.lphp5) - parseInt(data.cphp5)}</td>
                <td>${parseInt(data.lphp1) - parseInt(data.cphp1)}</td>
            </tr>

            </tbody>
        </table>
        <br/>
        <br/>`

        ).join('');

        // create a virtual container
        const range = document.createRange();
        // give it a context
        range.selectNode(app);
        // add the html, this converts the html into a collection of elements
        const fragment = range.createContextualFragment(chunk);
        // append the elements to the document
        //console.log(fragment) 
        app.innerHTML = '';
        app.appendChild(fragment);
        //alert("QQQ");
        //
     
       
      });
  };


loadlink(); // This will run on page load
setInterval(function(){

    //
    //alert("QQQ");
    loadlink() // this will run after every 5 seconds
}, 5000);


</script>