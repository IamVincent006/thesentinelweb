<?php

class Functions extends CI_Model {

// 	private $tableName;
//	private $model;

	public function __construct() {
//	    $this->model     = new Model();	
//	    $this->tableName = PREFIX.'payment';	
	}
    public function acsinit(){
        global $context,$readers;
        
        $context = scard_establish_context();
        $readers = scard_list_readers($context);

        if($readers){
            $connection = scard_connect($context, $readers[1], 2);
        }
        return $connection;

    }

    public function pdfheader2(){

        //ob_end_clean();

        $this->load->library('Pdf');
        $pdf = new Pdf(PDF_PAGE_ORIENTATION, PDF_UNIT, PDF_PAGE_FORMAT, true, 'UTF-8', false);


        //$pdf->SetPrintHeader(false);

        // set document information
        //$pdf->SetCreator(PDF_CREATOR);
        //$pdf->SetAuthor('JOFEL EDROSOLANO');
        //$pdf->SetTitle('Z READING REPORT');
        //$pdf->SetSubject('SENTINEL GENERATED');
        //$pdf->SetKeywords('AUTO GENERATED REPORT');

        // set default header data
        $pdf->SetHeaderData(PDF_HEADER_LOGO, PDF_HEADER_LOGO_WIDTH, PDF_HEADER_TITLE, PDF_HEADER_STRING);

        // set header and footer fonts
        $pdf->setHeaderFont(Array(PDF_FONT_NAME_MAIN, '', PDF_FONT_SIZE_MAIN));
        $pdf->setFooterFont(Array(PDF_FONT_NAME_DATA, '', PDF_FONT_SIZE_DATA));

        // set default monospaced font
        $pdf->SetDefaultMonospacedFont(PDF_FONT_MONOSPACED);


        // set margins
        $pdf->SetMargins(PDF_MARGIN_LEFT, PDF_MARGIN_TOP, PDF_MARGIN_RIGHT);

        $pdf->SetHeaderMargin(PDF_MARGIN_HEADER);
        $pdf->SetFooterMargin(PDF_MARGIN_FOOTER);

        // set auto page breaks
        $pdf->SetAutoPageBreak(TRUE, PDF_MARGIN_BOTTOM);

        // set image scale factor
        $pdf->setImageScale(PDF_IMAGE_SCALE_RATIO);

        return $pdf;


    }

    public function pdfheader(){

        //ob_end_clean();

        $this->load->library('Pdf');
        $pdf = new Pdf(PDF_PAGE_ORIENTATION, PDF_UNIT, PDF_PAGE_FORMAT, true, 'UTF-8', false);


        //$pdf->SetPrintHeader(false);

        // set document information
        //$pdf->SetCreator(PDF_CREATOR);
        //$pdf->SetAuthor('JOFEL EDROSOLANO');
        //$pdf->SetTitle('Z READING REPORT');
        //$pdf->SetSubject('SENTINEL GENERATED');
        //$pdf->SetKeywords('AUTO GENERATED REPORT');

        // set default header data
        $pdf->SetHeaderData(PDF_HEADER_LOGO, PDF_HEADER_LOGO_WIDTH, PDF_HEADER_TITLE, PDF_HEADER_STRING);

        // set header and footer fonts
        $pdf->setHeaderFont(Array(PDF_FONT_NAME_MAIN, '', PDF_FONT_SIZE_MAIN));
        $pdf->setFooterFont(Array(PDF_FONT_NAME_DATA, '', PDF_FONT_SIZE_DATA));

        // set default monospaced font
        $pdf->SetDefaultMonospacedFont(PDF_FONT_MONOSPACED);


        // set margins
        $pdf->SetMargins(PDF_MARGIN_LEFT, 100, PDF_MARGIN_RIGHT);

        $pdf->SetHeaderMargin(PDF_MARGIN_HEADER);
        $pdf->SetFooterMargin(PDF_MARGIN_FOOTER);

        // set auto page breaks
        $pdf->SetAutoPageBreak(TRUE, PDF_MARGIN_BOTTOM);

        // set image scale factor
        $pdf->setImageScale(PDF_IMAGE_SCALE_RATIO);

        return $pdf;


    }

    public function pdfheader3(){

        //ob_end_clean();

        $this->load->library('Pdf');
        $pdf = new Pdf(PDF_PAGE_ORIENTATION, PDF_UNIT, PDF_PAGE_FORMAT, true, 'UTF-8', false);


        //$pdf->SetPrintHeader(false);

        // set document information
        //$pdf->SetCreator(PDF_CREATOR);
        //$pdf->SetAuthor('JOFEL EDROSOLANO');
        //$pdf->SetTitle('Z READING REPORT');
        //$pdf->SetSubject('SENTINEL GENERATED');
        //$pdf->SetKeywords('AUTO GENERATED REPORT');

        // set default header data
        $pdf->SetHeaderData(PDF_HEADER_LOGO, PDF_HEADER_LOGO_WIDTH, PDF_HEADER_TITLE, PDF_HEADER_STRING);

        // set header and footer fonts
        $pdf->setHeaderFont(Array(PDF_FONT_NAME_MAIN, '', PDF_FONT_SIZE_MAIN));
        $pdf->setFooterFont(Array(PDF_FONT_NAME_DATA, '', PDF_FONT_SIZE_DATA));

        // set default monospaced font
        $pdf->SetDefaultMonospacedFont(PDF_FONT_MONOSPACED);


        // set margins
        $pdf->SetMargins(PDF_MARGIN_LEFT, 90, PDF_MARGIN_RIGHT);

        $pdf->SetHeaderMargin(PDF_MARGIN_HEADER);
        $pdf->SetFooterMargin(PDF_MARGIN_FOOTER);

        // set auto page breaks
        $pdf->SetAutoPageBreak(TRUE, PDF_MARGIN_BOTTOM);

        // set image scale factor
        $pdf->setImageScale(PDF_IMAGE_SCALE_RATIO);

        return $pdf;


    }
    public function postheader($list=array()){
  

        $list["t0k3n1z3d"] = api_token();
        $postdata = http_build_query($list);
        $opts = array('http' =>
        array(
        'method'  => 'POST',
        'header'  => 'Content-Type: application/x-www-form-urlencoded',
        'content' => $postdata
            )
        );
  
        return $opts;
    }

    public function apiv1($list=array(),$link){
		try
		{
			//if(trim(md5(hash('sha512',$_SERVER['REMOTE_ADDR']))) == "a6b6f3309d3ffb25fc43d5c64fb8ce7e")
			//{
				$opts = $this->postheader($list);
				//print_r($opts);
				$context  = stream_context_create($opts);
				$url = rtrim(api_url(), "/").$link;
				//print_r($url);
				$json = file_get_contents($url, false, $context);
				$json_data = json_decode($json, true);
				//print_r($json_data);
				$result = $json_data["data"];
				return $result;
			//}
		}
		catch (Exception $hi)
		{
			return "";
		}


    }



    


}
?>
