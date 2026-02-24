<?php





$logo = [
    "src" => base_url()."assets/img/E-PARADA.png",
];




?>


<div id="wrapper">

    <!-- Sidebar -->
    <div id="sidebar-wrapper" class="navbar-collapse" >

        <ul class="sidebar-nav mr-auto">

            
            <li>
                <img src="<?php echo $logo['src']; ?>" alt="logo" style="width: 100px; height: 100px; margin-left: 50px;margin-right: 50px;" class="sidebar-logo"/>
            </li>

            <li class="sidebar-brand">
                <a href="<?php echo "#"; ?>" >
                    <?php echo $fname; ?>, <?php echo $lname; ?>
                </a>
            </li>




        <?php foreach ($this->session->userdata('menu') as $value) : ?>
                <?php if ($value['parent_id'] == 0 && in_array($this->session->userdata('userlevel'), explode(',',$value['level']) )):?>
                <?php if ($value['menu_type'] == 1): ?>

                    <li >
                        <a href="<?=site_url($value['link'])?> ">
                            <img src="<?= base_url().$value['icon'] ?>" alt="<?php echo $value['label']; ?>" style="width: 20px; height: 20px; vertical-align: middle;"> &nbsp;<?= $value['label']; ?>
                        </a>
                    </li>
                <?php endif ?>    
                <?php if ($value['menu_type'] == 2): ?>
                     
                    <li class="nav-item nav" role="tablist">
                        <a  href="<?=$value['link']?>" id="view" role="tab" data-toggle="tab" onclick="getPaging(this.id)">  
                          <img src="<?= base_url().$value['icon']; ?>">&nbsp;&nbsp;<?= $value['label']; ?><span class="fa fa-caret-down"></span>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                        </a>
                       <a href="#hideall" role="tab" id="hide" data-toggle="tab" onclick="getPaging(this.id)" style="display:none;">  
                          <img src="<?= base_url() ?>assets/img/gear.svg">&nbsp;&nbsp;<?= $value['label']; ?><span class="fa fa-caret-down"></span>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                        </a>
                    </li>

                    <div class="tab-content">

                    <div role="tabpanel" class="tab-pane fade" id="viewall">
                        <?php foreach ($this->session->userdata('menu') as $submenu): ?>
                            <?php if ($submenu['parent_id'] == $value['id'] && in_array($this->session->userdata('userlevel'), explode(',',$submenu['level']) )): ?>
                            <li>
                                <a class="sidebar-subnav" href="<?=site_url($submenu['link']) ?>">
                                    <img src="<?= base_url().$submenu['icon']; ?>" style="width: 25px; height: 25px; vertical-align: middle;">
                                    &nbsp;<?= $submenu['label']; ?>
                                </a>
                            </li>
                            <?php endif ?> 
                        <?php endforeach; ?>
                         
                    </div>
                    <div role="tabpanel" class="tab-pane fade" id="hideall">
             
                    </div>
                </div>



                <?php endif ?> 
            <?php endif ?> 
        <?php endforeach; ?>


     
        
        
                


        <!--   <li class="dropdown-btn">
                <a href="<?=site_url('authentication/logout') ?>"> <img src="<?= base_url() ?>assets/img/box-arrow-left.svg" style="width: 25px; height: 25px; vertical-align: middle;">&nbsp;&nbsp;Logout
                </a>
            </li>-->

        </ul>
    </div>

    <!-- Page Content -->
    <div id="page-content-wrapper">
        <div class="container-fluid page-content-wrapper-inside">
            <div class="row row-1">
                <div class="col">
                    <div class="page-content-header"></div>
                </div>
                <div class="col-md-auto">
                    <div id="displayDate" class="page-content-header">00/00/0000</div>
                </div>
                <div class="col-md-auto">
                    <div id="displayTime" class="page-content-header">00:00:00 AM</div>
                </div>
            </div>
        </div>
    </div>
    <!-- /#page-content-wrapper -->

    <!-- Page Title -->
    <div class="page-title-wrapper">
        <h1 id="page-title-1" class="page-title-1"><?php echo $title; ?></h1>
        <h5 id="page-title-2" class="page-title-2"><?php echo $page; ?></h5>
    </div>
    <!-- /Page Title -->


</div>
<!-- /#wrapper -->




<script type="text/javascript">



    function getPaging(str) {
        //alert(str);
          if(str=="view")
          {
    
           document.getElementById("view").style.display = 'none';
           document.getElementById("hide").style.display = 'block';
            
          }
          else
          {
            document.getElementById("view").style.display = 'block';
            document.getElementById("hide").style.display = 'none';                   
          }

    }


</script>