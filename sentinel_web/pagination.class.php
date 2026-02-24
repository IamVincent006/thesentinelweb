<?php
////////////////////////////////////////////////PROJECT PAGE//////////////////////////////////////////////////////////
class ProjectPage
{

    public $perpage;

    function __construct()
    {
        $this->perpage = 3;
    }

    function perpage($count, $href)
    {

        $output = '';
        if (! isset($_GET["page"]))
            $_GET["page"] = 1;
        if ($this->perpage != 0)
            $pages = ceil($count / $this->perpage);
        if ($pages > 1) {
            if ($_GET["page"] == 1)
                //$output = $output . '<span class="disabled"><<</span><span class="disabled"><</span>';
				$output = $output . '<a class="prev"> <div class="left-arrow page-arrow"><img src="_resources/themes/main/images/r-arrow.png" alt=""> </div></a>';
            else
	            $output = $output . '<a class="prev" onclick="projects(\'' . $href . ($_GET["page"] - 1) . '\')" > <div class="left-arrow page-arrow"><img src="_resources/themes/main/images/r-arrow.png" alt=""> </div></a>';

            if (($_GET["page"] - 3) > 0) {
                if ($_GET["page"] == 1)


                    $output = $output . '<div class="numbers"><a>1</a></div>';
                else
                    $output = $output . '<div class="numbers"><a onclick="projects(\'' . $href . '1\')" >1</a></div>';
            }
            if (($_GET["page"] - 3) > 1) {
                //$output = $output . '...';
				$output = $output . '';
            }

            for ($i = ($_GET["page"] - 2); $i <= ($_GET["page"] + 2); $i ++) {
                if ($i < 1)
                    continue;
                if ($i > $pages)
                    break;
                if ($_GET["page"] == $i)
                    $output = $output . '<div class="numbers">' . $i . '</div>';
                else
                    $output = $output . '<div class=numbers> <a  onclick="projects(\'' . $href . $i . '\')" >' . $i . '</a></div>';
            }

            if (($pages - ($_GET["page"] + 2)) > 1) {
                //$output = $output . '...';
				$output = $output . '';
            }
            if (($pages - ($_GET["page"] + 2)) > 0) {
                if ($_GET["page"] == $pages)
                    $output = $output . '<div id=' . ($pages) . ' class="current numbers">' . ($pages) . '</div>';
                else
                    $output = $output . '<div class=numbers> <a  onclick="projects(\'' . $href . ($pages) . '\')" >' . ($pages) . '</a></div>';
            }

            if ($_GET["page"] < $pages)
                $output = $output . '<a  class="next" onclick="projects(\'' . $href . ($_GET["page"] + 1) . '\')" ><div class="right-arrow page-arrow"><img src="_resources/themes/main/images/r-arrow.png" alt=""></div></a>';



            else
                //$output = $output . '<span class="disabled">></span><span class="disabled">>></span>';
		          $output = $output . '<a class="next"> <div class="right-arrow page-arrow"><img src="_resources/themes/main/images/r-arrow.png" alt=""> </div></a>';
            //$output = $output . '<span id="loader-icon">
			
             //   <img src="LoaderIcon.gif" />
            //    </span>';
        }
        return $output;
    }
}






////////////////////////PRODUCTPAGE////////////////////////////////////////////////////
class ProductPage
{

    public $perpage;

    function __construct()
    {
        $this->perpage = 5;
    }

    function perpage($count, $href)
    {
  
        $output = '';
        if (! isset($_GET["page"]))
            $_GET["page"] = 1;
        if ($this->perpage != 0)
            $pages = ceil($count / $this->perpage);
        if ($pages > 1) {
            if ($_GET["page"] == 1)
                //$output = $output . '<span class="disabled"><<</span><span class="disabled"><</span>';
                $output = $output . '<a class="prev"> <div class="left-arrow page-arrow"><img src="_resources/themes/main/images/r-arrow.png" alt=""> </div></a>';
            else
                $output = $output . '<a href="#" class="prev" onclick="products(\'' . $href . ($_GET["page"] - 1) . '\')" return false> <div class="left-arrow page-arrow"><img src="_resources/themes/main/images/r-arrow.png" alt=""> </div></a>';

            if (($_GET["page"] - 3) > 0) {
                if ($_GET["page"] == 1)


                    $output = $output . '<div class="numbers"><a>1</a></div>';
                else
                    $output = $output . '<div  class="numbers"><a href="#" onclick="products(\'' . $href . '1\')" return false>1</a></div>';
            }
            if (($_GET["page"] - 3) > 1) {
                $output = $output . '...';
                $output = $output . '';
            }

            for ($i = ($_GET["page"] - 2); $i <= ($_GET["page"] + 2); $i ++) {
                if ($i < 1)
                    continue;
                if ($i > $pages)
                    break;
                if ($_GET["page"] == $i)
                    $output = $output . '<div class="numbers">' . $i . '</div>';
                else
                    $output = $output . '<div class=numbers> <a href="#"  onclick="products(\'' . $href . $i . '\')" return false>' . $i . '</a></div>';
            }

            if (($pages - ($_GET["page"] + 2)) > 1) {
                $output = $output . '...';
                $output = $output . '';
            }
            if (($pages - ($_GET["page"] + 2)) > 0) {
                if ($_GET["page"] == $pages)
                    $output = $output . '<div id=' . ($pages) . ' class="current numbers">' . ($pages) . '</div>';
                else
                    $output = $output . '<div class=numbers> <a href="#"  onclick="products(\'' . $href . ($pages) . '\')" return false>' . ($pages) . '</a></div>';
            }

            if ($_GET["page"] < $pages)
                $output = $output . '<a  href="#" class="next" onclick="products(\'' . $href . ($_GET["page"] + 1) . '\')" return false><div class="right-arrow page-arrow"><img src="_resources/themes/main/images/r-arrow.png" alt=""></div></a>';



            else
                //$output = $output . '<span class="disabled">></span><span class="disabled">>></span>';
                  $output = $output . '<a class="next"> <div class="right-arrow page-arrow"><img src="_resources/themes/main/images/r-arrow.png" alt=""> </div></a>';
            //$output = $output . '<span id="loader-icon">
            
             //   <img src="LoaderIcon.gif" />
            //    </span>';
        }
        return $output;
    }
}

////////////////////////SERVICE PAGE////////////////////////////////////////////////////
class ServicePage
{

    public $perpage;

    function __construct()
    {
        $this->perpage = 5;
    }

    function perpage($count, $href)
    {
  
        $output = '';
        if (! isset($_GET["page"]))
            $_GET["page"] = 1;
        if ($this->perpage != 0)
            $pages = ceil($count / $this->perpage);
        if ($pages > 1) {
            if ($_GET["page"] == 1)
                //$output = $output . '<span class="disabled"><<</span><span class="disabled"><</span>';
                $output = $output . '<a class="prev"> <div class="left-arrow page-arrow"><img src="_resources/themes/main/images/r-arrow.png" alt=""> </div></a>';
            else
                $output = $output . '<a href="#" class="prev" onclick="services(\'' . $href . ($_GET["page"] - 1) . '\')" return false> <div class="left-arrow page-arrow"><img src="_resources/themes/main/images/r-arrow.png" alt=""> </div></a>';

            if (($_GET["page"] - 3) > 0) {
                if ($_GET["page"] == 1)


                    $output = $output . '<div class="numbers"><a>1</a></div>';
                else
                    $output = $output . '<div  class="numbers"><a href="#" onclick="services(\'' . $href . '1\')" return false>1</a></div>';
            }
            if (($_GET["page"] - 3) > 1) {
                $output = $output . '...';
                $output = $output . '';
            }

            for ($i = ($_GET["page"] - 2); $i <= ($_GET["page"] + 2); $i ++) {
                if ($i < 1)
                    continue;
                if ($i > $pages)
                    break;
                if ($_GET["page"] == $i)
                    $output = $output . '<div class="numbers">' . $i . '</div>';
                else
                    $output = $output . '<div class=numbers> <a href="#"  onclick="services(\'' . $href . $i . '\')" return false>' . $i . '</a></div>';
            }

            if (($pages - ($_GET["page"] + 2)) > 1) {
                $output = $output . '...';
                $output = $output . '';
            }
            if (($pages - ($_GET["page"] + 2)) > 0) {
                if ($_GET["page"] == $pages)
                    $output = $output . '<div id=' . ($pages) . ' class="current numbers">' . ($pages) . '</div>';
                else
                    $output = $output . '<div class=numbers> <a href="#"  onclick="services(\'' . $href . ($pages) . '\')" return false>' . ($pages) . '</a></div>';
            }

            if ($_GET["page"] < $pages)
                $output = $output . '<a  href="#" class="next" onclick="services(\'' . $href . ($_GET["page"] + 1) . '\')" return false><div class="right-arrow page-arrow"><img src="_resources/themes/main/images/r-arrow.png" alt=""></div></a>';



            else
                //$output = $output . '<span class="disabled">></span><span class="disabled">>></span>';
                  $output = $output . '<a class="next"> <div class="right-arrow page-arrow"><img src="_resources/themes/main/images/r-arrow.png" alt=""> </div></a>';
            //$output = $output . '<span id="loader-icon">
            
             //   <img src="LoaderIcon.gif" />
            //    </span>';
        }
        return $output;
    }
}






?>