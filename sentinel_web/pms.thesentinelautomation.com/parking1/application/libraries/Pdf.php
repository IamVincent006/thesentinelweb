<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
require_once dirname(__FILE__) . '/tcpdf/tcpdf.php';
class Pdf extends TCPDF
{
    function __construct()
    {
        parent::__construct();
    }



        //Page header
    public function Header() {
        global $headername;

        //$img_file = K_PATH_IMAGES.'image_demo.jpg';
        //$this->Image($img_file, 0, 0, 210, 297, '', '', '', false, 300, '', false, false, 0);

        // Logo
        //$image_file = K_PATH_IMAGES.'logo_example.jpg';
        //$this->Image($image_file, 10, 18, 15, '', '', '', 'J', false, 300, '', false, false, 0, false, false, false);
        //$this->Image($image_file, 0, 10, 10, 15, '', '', '', false, 300, '', false, false, 0);
        // Set font
       
        // Title
        $this->Cell(0, 5,  '', 0, false, 'C', 0, '', 0, false, 'M', 'M');
        $this->ln();



        $this->SetFont('helvetica', 'B', 12);
        $this->Cell(0, 10,  'THE SENTINEL PARKING SYSTEM', 0, false, 'C', 0, '', 0, false, 'M', 'M');
        $this->SetFont('times', 'B', 18);
        $this->ln();
        $this->Write(0, $this->CustomHeaderText, '', 0, 'C', true, 0, false, false, 0);
        $this->ln();
        $this->SetFont('times', 'B', 12);
        $this->Write(0, "SYSTEM GENERATED PARAMETERS:", '', 0, 'L', true, 0, false, false, 0);
        $this->SetFont('helvetica', '', 10);
        $this->ln();
        date_default_timezone_set('Asia/Singapore');
        $datenow = date('Y-m-d H:i:s');
        $this->Write(0, "Generate date :  ".$datenow, '', 0, 'L', true, 0, false, false, 0);
        $this->Write(0, "Generate By :  ".$this->Name, '', 0, 'L', true, 0, false, false, 0);
        $this->Write(0, "Date From :     ".$this->DateFrom, '', 0, 'L', true, 0, false, false, 0);
        $this->Write(0, "Date To :         ".$this->DateTo, '', 0, 'L', true, 0, false, false, 0);
        if(isset($this->TerminalName))
            $this->Write(0, "TERMINAL :    ".$this->TerminalName, '', 0, 'L', true, 0, false, false, 0);
        if(isset($this->TellerName))
            $this->Write(0, "Teller :             ".$this->TellerName, '', 0, 'L', true, 0, false, false, 0);
        $this->ln();
        $this->SetFont('times', 'B', 10);
        $this->Write(0, "SYSTEM GENERATED RESULTS:", '', 0, 'L', true, 0, false, false, 0);
        $this->ln();

        if(isset($this->TableHeader))
        {

            $tableheaders = explode(",", $this->TableHeader);
            $w_align = explode(",", $this->TableAlign);
            $w = explode(",", $this->TableWidth);         

            for($i=0;$i<count($tableheaders);$i++)
                $this->Cell($w[$i],7,$tableheaders[$i],'TBLR',0,$w_align[$i]);
            $this->Ln();

        }
        if(isset($this->TableHeader1))
        {

            $tableheaders = explode(",", $this->TableHeader1);
            $w_align = explode(",", $this->TableAlign1);
            $w = explode(",", $this->TableWidth1);  
            $border = explode(",", $this->tableborder1);         

            for($i=0;$i<count($tableheaders);$i++)
                $this->Cell($w[$i],7,$tableheaders[$i],$border[$i],0,$w_align[$i]);
            $this->Ln();

        }
        if(isset($this->TableHeader2))
        {

            $tableheaders = explode(",", $this->TableHeader2);
            $w_align = explode(",", $this->TableAlign2);
            $w = explode(",", $this->TableWidth2);
            $border = explode(",", $this->tableborder2); 
         

            for($i=0;$i<count($tableheaders);$i++)
                $this->Cell($w[$i],7,$tableheaders[$i],$border[$i],0,$w_align[$i]);
            $this->Ln();

        }
        if(isset($this->TableHeader3))
        {

            $tableheaders = explode(",", $this->TableHeader3);
            $w_align = explode(",", $this->TableAlign);
            $w = explode(",", $this->TableWidth);  
            $border = explode(",", $this->tableborder3);        

            for($i=0;$i<count($tableheaders);$i++)
                $this->Cell($w[$i],7,$tableheaders[$i],$border[$i],0,$w_align[$i]);
            $this->Ln();

        }

       

        
        
    }

    // Page footer
    public function Footer() {
        // Position at 15 mm from bottom
        $this->SetY(-15);
        // Set font
        $this->SetFont('helvetica', 'I', 8);
        // Page number
        $this->Cell(0, 10, 'Page '.$this->getAliasNumPage().' out of '.$this->getAliasNbPages(), 0, false, 'R', 0, '', 0, false, 'T', 'M');
    }




}
/*Author:Tutsway.com */  
/* End of file Pdf.php */
/* Location: ./application/libraries/Pdf.php */