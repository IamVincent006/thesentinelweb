<?php
/*$cards = [
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
    [
        "card-value" => "00",
        "card-title" => "Total Parking",
        "href" => "#",
        "card-additionaltext" => "More Info",
    ],
    [
        "card-value" => "00",
        "card-title" => "Occupied Slot",
        "href" => "#",
        "card-additionaltext" => "More Info",
    ],
];*/

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



<<!DOCTYPE html>
<html>




<body>

<div id="wrapper">



                <form action = "" method = "post" class="d-flex flex-column p-4" style="width: 300px; ">
                    <div class="mb-3">
                        <span style="color: red;"> <?php echo validation_errors(); ?></span>
                    </div>


                    <div class="form-group">
                  
                        <label for="oncharge">AREA</label>
                        <select id="sel" name="termarea" class="form-control">

                        <option value = "" style="background-color:#007bff; color: white;" disabled><strong>AREA TYPE</strong></option>
                        <?php foreach ($termarea as $value): ?>        
                            <option value = "<?= $value["area_id"] ?>"  <?= $value["area_id"]==$termarea ? 'selected="selected"' : '' ?>><?= $value["area_name"] ?></option>
                       
                        <?php endforeach; ?>

                        </select>


                        <small id="emailHelp" class="form-text text-muted"></small>

                    </div>
                    
                </form>



    <div class="row statistics-cards">

    </div>



    <!-- statistics-cards -->
<!--
    <div class="row statistics-cards">
        <?php foreach ($cards as $card) : ?>
                    <div class="col-sm-3">
                        <div class="card">
                            <div class="card-body">
                                <h1 class="card-title"><?php echo $card['card-value']; ?></h1>
                                <p class="card-text"><?php echo $card['card-title']; ?></p>
                            </div>
                            <a class="card-links" href="<?php echo $card['href']; ?>">
                                <div class="card-footer"><?php echo $card['card-additionaltext']; ?></div>
                            </a>
                        </div>
                    </div>
        <?php endforeach; ?>
    </div>-->

    <!-- /statistics-cards -->



</div>
</body>


</html>



<script type="text/javascript">

/*$('#sel').change(function(){
    var areaid = $(this).find('option:selected').val();
})*/



  var interval = 1200;  // 1000 = 1 second, 3000 = 3 seconds
    function doAjax() {
         $.ajax({
                type: 'POST',
                url: "<?php echo base_url('/home/slotsdetails/'); ?>" + $( "#sel option:selected" ).val(),
                //data: $(this).serialize(),
                 //data: { rowcount: $("#rowcount").val() },
                //dataType: 'JSON',
                success: function (data) {;
                        //alert("QQQQ");
                         $(".statistics-cards").html(data);
                    
                },
                complete: function (data) {
                        // Schedule the next
                        //alert("QQQQQQQQQQ");

                        setTimeout(doAjax, interval);
                }
        });

    }
    setTimeout(doAjax, interval);





</script>