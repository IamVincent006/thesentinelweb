<?php
//print_r($this->uri->uri_string());
?>

<!DOCTYPE html>
<html lang="en">

<script type="text/javascript">
    
//document.addEventListener('contextmenu', function(e) {
//  e.preventDefault();
//});


//$(document).keydown(function(e){
//    if(e.which === 123){
//       return false;
//    }
//});

</script>



<head>

 
	<meta http-equiv="Content-Security-Policy" content="upgrade-insecure-requests" />
    <title></title>
    <meta charset="utf-8">
	<!--<meta http-equiv="Content-Security-Policy" content="upgrade-insecure-requests">-->
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <!-- Bootstrap 5.1.3 CSS -->
    <link rel="stylesheet" href="<?=base_url()?>assets/css/index.css">



   <!-- <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/4.5.2/css/bootstrap.css">-->



    <!--<link href="https://maxcdn.bootstrapcdn.com/font-awesome/4.6.3/css/font-awesome.min.css" rel="stylesheet"/>-->
    <link  href="<?=base_url()?>assets/css/font-awesome.min.css" rel="stylesheet"/>



    <!-- 1. BOOTSTRAP v4.0.0         CSS !-->
    <link rel="stylesheet" href="<?=base_url()?>assets/css/bootstrap.min.css">


    <link rel="stylesheet" href="<?=base_url()?>assets/css/jquery-ui.css">


    <link rel="stylesheet" type="text/css" href="<?=base_url()?>assets/css/datatables1.css"/>




<script type="text/javascript">
    var api_url = "<?php echo rtrim(api_url(), "/");?>";
    var t0k3n1z3d = "&t0k3n1z3d=<?php echo api_token(); ?>";
    var loginlevel = "<?php echo $this->session->userdata('userlevel');?>";
    //alert(api_url);




   /* var unloadHandler = function(e){
         $.ajax({
                type: 'POST',
                url: "<?php echo base_url('/users/logoutuser/1'); ?>",
                //data: $(this).serialize(),
                 //data: { rowcount: $("#rowcount").val() },
                //dataType: 'JSON',
                success: function (data) {;
                        alert("QQQQ");
                    
                }
        });
      };
    window.unload = unloadHandler;*/

</script>



</head>
</html>