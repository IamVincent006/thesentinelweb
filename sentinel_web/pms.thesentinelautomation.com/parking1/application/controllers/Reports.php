<?php
defined('BASEPATH') OR exit('No direct script access allowed');




class Reports extends CI_Controller {

	public function __construct()
	{
		parent::__construct();
		$this->load->model('functions');
		if(!Auth::is_loggedin())
			Auth::Bounce($this->uri->uri_string());
	}




	public function index()
	{
		$datasend = array();
/////////////////////////////////////////////////////////////////////////
		//get terminals
		/*$url = rtrim(api_url(), "/")."get_terminals";
		$json = file_get_contents($url);
		$json_data = json_decode($json, true);
		$data["terminals"] = $json_data["data"];*/
		$data["terminals"] = $this->functions->apiv1($datasend,"get_terminals");
////////////////////////////////////////////////////////////////////////////
		//get rates
		/*$url = rtrim(api_url(), "/")."Rates";
		
		$json = file_get_contents($url);
		$json_data = json_decode($json, true);

		$data["rates"] = $json_data["data"];*/
		$data["rates"] = $this->functions->apiv1($datasend,"Rates");
////////////////////////////////////////////////////////////////////////////////

		//get users
		/*$url = rtrim(api_url(), "/")."userinfo_details";
		$json = file_get_contents($url);
		$json_data = json_decode($json, true);
		$data["users"] = $json_data["data"];*/
		$data["users"] = $this->functions->apiv1($datasend,"userinfo_details");


		
		$data['title'] = 'Dashboard';
		$data['page'] = 'Reports';
		$data['fname'] = $this->session->userdata('firstname');
		$data['lname'] = $this->session->userdata('lastname');



		//$this->load->view('template', $data);
		//$this->load->view('template');

		$this->load->view('components/header');
		$this->load->view('components/sidenav',$data);
		//$this->load->view('components/cards');
		$this->load->view('pages/reports_view');
	}
	public function area_accountabilityexcel(){

		//load our new PHPExcel library
		$this->load->library('excel');
		//activate worksheet number 1
		$this->excel->setActiveSheetIndex(0);
		//name the worksheet
		$this->excel->getActiveSheet()->setTitle('test worksheet');
		//set cell A1 content with some text
		$this->excel->getActiveSheet()->setCellValue('A1', 'This is just some text value');
		//change the font size
		$this->excel->getActiveSheet()->getStyle('A1')->getFont()->setSize(20);
		//make the font become bold
		$this->excel->getActiveSheet()->getStyle('A1')->getFont()->setBold(true);
		//merge cell A1 until D1
		$this->excel->getActiveSheet()->mergeCells('A1:D1');
		//set aligment to center for that merged cell (A1 to D1)
		$this->excel->getActiveSheet()->getStyle('A1')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
		 
		$filename='just_some_random_name.xls'; //save our workbook as this file name
		header('Content-Type: application/vnd.ms-excel'); //mime type
		header('Content-Disposition: attachment;filename="'.$filename.'"'); //tell browser what's the file name
		header('Cache-Control: max-age=0'); //no cache
		            
		//save it to Excel5 format (excel 2003 .XLS file), change this to 'Excel2007' (and adjust the filename extension, also the header mime type)
		//if you want to save it as .XLSX Excel 2007 format
		$objWriter = PHPExcel_IOFactory::createWriter($this->excel, 'Excel5');  
		//force user to download the Excel file without writing it to server's HD
		$objWriter->save('php://output');


	}

	public function transactionpdf(){
		
		$terminal = explode("/", $this->input->post('terminal'));;
		$from_date = $this->input->post('from_date');
		$to_date = $this->input->post('to_date');
		$area = $this->input->post('area');

		$datasend =  array(
				          'terminal'     => $terminal[0],
				          'from_date'     => $from_date,
				          'to_date'     => $to_date,
				          'area'     => $area,                   
				    );

		/*TRANSACTION TOTAL*/
		$trxn_record = $this->functions->apiv1($datasend,"transaction_records");


		$pdf = $this->functions->pdfheader2();

	    $pdf->CustomHeaderText = "TRANSACTION REPORT";
	    $pdf->TerminalName = $terminal[1];
	    $pdf->DateFrom = $from_date;
	    $pdf->DateTo = $to_date;
	    $pdf->Name = strtoupper($this->session->userdata('firstname').' '. $this->session->userdata('lastname'));



		
		// ---------------------------------------------------------
		// add a page
		$pdf->AddPage('L', 'A4');
		$pdf->SetFont('times', 'B', 10);
 	
 		$pdf->Cell(20,0.15,'Cardserial','TB',0,'L',0);
 		$pdf->Cell(20,0.15,'Plate#','TB',0,'L',0);
		$pdf->Cell(35,0.15,'Entrydate','TB',0,'L',0);
		$pdf->Cell(35,0.15,'Exitdate','TB',0,'L',0);
		$pdf->Cell(35,0.15,'Paymentdate','TB',0,'L',0);
		$pdf->Cell(35,0.15,'Receipt#','TB',0,'L',0);
		$pdf->Cell(35,0.15,'Void#','TB',0,'L',0);
		$pdf->Cell(20,0.15,'Charge','TB',0,'L',0);
		$pdf->Cell(20,0.15,'Type','TB',0,'L',0);
		$pdf->Cell(30,0.15,'Voucher ID','TB',0,'L',0);
		//$pdf->Cell(10,0.15,'VAT','TB',0,'R',0);
		//$pdf->Cell(5,0.15,'','',0,'R',0);
		//$pdf->Cell(35,0.15,'AMOUNT RECEIVED','TB',0,'R',0);
		$pdf->Cell(5,0.15,'','',0,'R',0);
 		$pdf->ln();
		$pdf->SetFont('times', '', 10);
		$remark = "";
		$totalsales = 0;
		foreach ($trxn_record as  $value) {
			if($value["process"] == "1" || $value["process"] == "2" || $value["process"] == "0" || $value["process"] == "100" )
			{
				$totalsales += $value["charge"];
				$remark = "sales";
			}
			elseif($value["process"] == "98")
				$remark = "void";
			elseif($value["process"] == "99")
				$remark = "refund";
		
			$pdf->Cell(20,0.15,$value["cardserial"],'',0,'L',0);
			$pdf->Cell(20,0.15,$value["platenum"],'',0,'L',0);
			$pdf->Cell(35,0.15,$value["entrydate"],'',0,'L',0);
			$pdf->Cell(35,0.15,$value["exitdate"],'',0,'L',0);
			$pdf->Cell(35,0.15,$value["paymentdate"],'',0,'L',0);
			$pdf->Cell(35,0.15,$value["receiptnum"],'',0,'L',0);
			$pdf->Cell(35,0.15,$value["voidnum"],'',0,'L',0);
			$pdf->Cell(20,0.15,$value["charge"],'',0,'L',0);
			$pdf->Cell(20,0.15,$remark,'',0,'L',0);
			$pdf->Cell(30,0.15,$value["dccode"],'',0,'L',0);
			//$pdf->Cell(35,0.15,$value["count"],'',0,'R',0);
			$pdf->ln();

		}
		$pdf->Cell(20,0.15,'TOTAL','TB',0,'L',0);
 		$pdf->Cell(20,0.15,'','TB',0,'L',0);
		$pdf->Cell(35,0.15,'','TB',0,'L',0);
		$pdf->Cell(35,0.15,'','TB',0,'L',0);
		$pdf->Cell(35,0.15,'','TB',0,'L',0);
		$pdf->Cell(35,0.15,'','TB',0,'L',0);
		$pdf->Cell(35,0.15,'','TB',0,'L',0);
		$pdf->Cell(20,0.15,number_format($totalsales,2),'TB',0,'L',0);
		$pdf->Cell(20,0.15,'','TB',0,'L',0);
		$pdf->Cell(30,0.15,'','TB',0,'L',0);
		//$pdf->Cell(10,0.15,'VAT','TB',0,'R',0);
		




		date_default_timezone_set('Asia/Singapore');
		$datename = date('Y-m-d-H-i-s');

		//Close and output PDF document
		$pdf->Output('transaction-'.$datename.'.pdf', 'I');



		$audit_data = "";
		//$audit_term = gethostbyaddr($_SERVER['REMOTE_ADDR']);
		$audit_term = gethostname();
		$audit_ip = $_SERVER['REMOTE_ADDR'];

		$audit_data = "GENERATE REPORT";

		$auditsend = array(
		  'function'   => 'TRANSACTION REPORT',
		  'description'=> $audit_data,
		  'userid'     => $this->session->userdata('userid'),
		  'ip'   => getenv("REMOTE_ADDR"),
		  'pcname' => $audit_term,
		);

		$result = $this->functions->apiv1($auditsend,"insert_auditlog");


		//============================================================+
		// END OF FILE
		//============================================================+


	}


	public function xreadpdf(){
		
		$terminal = explode("/", $this->input->post('terminal'));;
		$from_date = $this->input->post('from_date');
		$to_date = $this->input->post('to_date');
		$area = $this->input->post('area');

		$datasend =  array(
				          'terminal'     => $terminal[0],
				          'from_date'     => $from_date,
				          'to_date'     => $to_date,
				          'area'     => $area,                   
				    );

		/*TRANSACTION TOTAL*/
		$trxn_total = $this->functions->apiv1($datasend,"transaction_total");
		//print_r($trxn_total);
		//return;

		$total_count = $trxn_total[0]["tcount"];
		$min_or = $trxn_total[0]["min_or"];
		$max_or = $trxn_total[0]["max_or"];
		$charge = $trxn_total[0]["tcharge"];
		$vatsales = $trxn_total[0]["vatsales"];
		$oldtotal = $trxn_total[0]["oldtotal"];
		$net_total = $charge + $oldtotal; 
		$VAT = number_format(($vatsales) * 0.12,2);

		/*GROUP BY RATE*/
		$trxn_data = $this->functions->apiv1($datasend,"transaction_groupbyrate");
		//print_r($trxn_data);
		//return;


		$pdf = $this->functions->pdfheader2();

	    $pdf->CustomHeaderText = "X READING REPORT";
	    $pdf->TerminalName = $terminal[1];
	    $pdf->DateFrom = $from_date;
	    $pdf->DateTo = $to_date;
	    $pdf->Name = strtoupper($this->session->userdata('firstname').' '. $this->session->userdata('lastname'));



		
		// ---------------------------------------------------------
		// add a page
		/*$tcharge = 0;
		$tcount = 0;
		$tinit = 0;
		$ton = 0;
		$lost = 0;
		$tdiscount = 0;
		$texvat = 0;
		$tsucceed = 0;
		$tvatable = 0;
		$tvat = 0;*/


		$validsales = 0;
		$voidsales = 0;
		$returnsales = 0;

		$validcnt = 0;

		$voidcnt = 0;
		$returncnt = 0;
		$discount = 0;

		$netamount = 0;
		$grossamount = 0;


		$initcharge = 0;
		$surcharge = 0;	
		$lostcharge = 0;
		$oncharge = 0;
		$lessvatadjustment = 0;	
		$totalsales = 0;
		foreach ($trxn_data as  $value) {

            $initcharge += $value["initcharge"];
            $surcharge += $value["surcharge"];
            $surcharge += $value["lostcharge"];
            $oncharge += $value["oncharge"];
            $lessvatadjustment += $value["vatexempt"] * 0.12;

         

			if($value["process"] == 1 || $value["process"] == 2)
			{
				$totalsales += $value["charge"];
				$discount += $value["discount"];

			}
			if($value["process"] == 98)
			{
				$voidsales += $value["charge"];
			}
			if($value["process"] == 99)
			{
				$returnsales += $value["charge"];
			}


            $grossamount = $initcharge + $surcharge + $lostcharge + $oncharge;
            $netamount = $grossamount - $discount - $returnsales - $voidsales - $lessvatadjustment;

		}

		$pdf->AddPage('L', 'A4');


		$pdf->ln();
        $pdf->SetFont('times', '', 10);
        //$pdf->Write(0, "Reset Series. :    1", '', 0, 'L', true, 0, false, false, 0);
        $pdf->Write(0, "Beg SI:    $min_or", '', 0, 'L', true, 0, false, false, 0);
		#$pdf->Write(0, "Transaction Count :    $total_count", '', 0, 'L', true, 0, false, false, 0);
        $pdf->Write(0, "End SI:    $max_or", '', 0, 'L', true, 0, false, false, 0);
        #$pdf->Write(0, "Old Grand Total Sales PHP : ".number_format($oldtotal,2), '', 0, 'L', true, 0, false, false, 0);
        #$pdf->Write(0, "New Grant Sales PHP : ".number_format($net_total,2), '', 0, 'L', true, 0, false, false, 0);
        #$pdf->Write(0, "Net Sales PHP : ".number_format($charge,2), '', 0, 'L', true, 0, false, false, 0);
        #$pdf->Write(0, "VAT PHP :    $VAT", '', 0, 'L', true, 0, false, false, 0);
        
        $pdf->ln();$pdf->ln();

        $pdf->SetFont('times', 'B', 12);
 		$pdf->Write(0, "SYSTEM GENERATED SALES BREAKDOWN:", '', 0, 'L', true, 0, false, false, 0);
 
 		$pdf->ln();
 		
 		$pdf->SetFont('times', 'B', 10);
		$pdf->Cell(1,0.15,'','',0,'R',0);
		$pdf->Cell(30,0.15,'VATABLE SALES','TB',0,'R',0);
		$pdf->Cell(28,0.15,'VAT AMOUNT','TB',0,'R',0);
		$pdf->Cell(28,0.15,'VAT EXEMPT','TB',0,'R',0);
		$pdf->Cell(28,0.15,'ZERO RATED','TB',0,'R',0);
		$pdf->Cell(25,0.15,'Gross Amount','TB',0,'R',0);
		$pdf->Cell(25,0.15,'Less Discount','TB',0,'R',0);
		$pdf->Cell(25,0.15,'Less Return','TB',0,'R',0);
		$pdf->Cell(25,0.15,'Less Void','TB',0,'R',0);
		$pdf->Cell(35,0.15,'Less vat adjustment','TB',0,'R',0);
		$pdf->Cell(20,0.15,'Net Amount','TB',0,'R',0);
 		$pdf->ln();
		$pdf->SetFont('times', '', 10);

		$pdf->Cell(30,0.15,number_format($netamount / 1.12,2),'',0,'R',0);
		$pdf->Cell(28,0.15,number_format($netamount / 1.12 * 0.12,2),'',0,'R',0);
		$pdf->Cell(28,0.15,number_format(0,2),'',0,'R',0);
		$pdf->Cell(28,0.15,number_format(0,2),'',0,'R',0);
		$pdf->Cell(25,0.15,number_format($grossamount,2),'',0,'R',0);
		$pdf->Cell(25,0.15,number_format($discount,2),'',0,'R',0);
		$pdf->Cell(25,0.15,number_format($returnsales,2),'',0,'R',0);
		$pdf->Cell(25,0.15,number_format($voidsales,2),'',0,'R',0);
		$pdf->Cell(35,0.15,number_format($lessvatadjustment,2),'',0,'R',0);
		$pdf->Cell(20,0.15,number_format($netamount,2),'',0,'R',0);
		$pdf->ln();
		$pdf->Cell(30,0.15,"TOTAL",'TB',0,'R',0);
		$pdf->Cell(28,0.15,"",'TB',0,'R',0);
		$pdf->Cell(28,0.15,"",'TB',0,'R',0);
		$pdf->Cell(28,0.15,"",'TB',0,'R',0);
		$pdf->Cell(25,0.15,"",'TB',0,'R',0);
		$pdf->Cell(25,0.15,"",'TB',0,'R',0);
		$pdf->Cell(25,0.15,"",'TB',0,'R',0);
		$pdf->Cell(25,0.15,"",'TB',0,'R',0);
		$pdf->Cell(35,0.15,"",'TB',0,'R',0);
		$pdf->Cell(20,0.15,number_format($netamount,2),'TB',0,'R',0);







		date_default_timezone_set('Asia/Singapore');
		$datename = date('Y-m-d-H-i-s');

		//Close and output PDF document
		$pdf->Output('xreading-'.$datename.'.pdf', 'I');


		//============================================================+
		// END OF FILE
		//============================================================+


	}



	public function zreadpdf(){

		date_default_timezone_set('Asia/Singapore');
		$datename = date('Y-m-d-H-i-s');
		//print_r($datename);
		//return;

		$terminal = explode("/", $this->input->post('terminal'));;
		$from_date = $this->input->post('from_date');
		$to_date = $this->input->post('to_date');
		$area = $this->input->post('area');

		$datasend =  array(
				          'terminal'     => $terminal[0],
				          'from_date'     => $from_date,
				          'to_date'     => $to_date, 
				          'area'     => $area,    
				    );
		$trxn_total = $this->functions->apiv1($datasend,"transaction_total");

		//print_r($trxn_total);
		//return;

		$total_count = $trxn_total[0]["tcount"] + $trxn_total[0]["oldcount"];
		$oldmin_or = $trxn_total[0]["oldmin_or"];
		$min_or = $trxn_total[0]["min_or"];
		$max_or = $trxn_total[0]["max_or"];
		$charge = $trxn_total[0]["tcharge"];
		$vatsales = $trxn_total[0]["vatsales"];
		$oldtotal = $trxn_total[0]["oldtotal"];
		$net_total = $charge + $oldtotal; 
		$VAT = number_format(($vatsales) * 0.12,2);
////////////////////////////////////////////////////////////////////////////////////////////


		/*TRANSACTION BY RATE*/
		$trxn_data = $this->functions->apiv1($datasend,"transaction_groupbyrate");


		//return;


		$pdf = $this->functions->pdfheader2();
	    $pdf->CustomHeaderText = "Z READING REPORT";
	    $pdf->TerminalName = $terminal[1];
	    $pdf->DateFrom = $from_date;
	    $pdf->DateTo = $to_date;
	    $pdf->Name = strtoupper($this->session->userdata('firstname').' '. $this->session->userdata('lastname'));


		// ---------------------------------------------------------
		// add a page
		
 		
 		/*$pdf->SetFont('times', 'B', 10);
 		$pdf->Cell(5,0.15,'','',0,'R',0);
 		$pdf->Cell(25,0.15,'TXN TYPE','TB',0,'C',0);
		$pdf->Cell(5,0.15,'','',0,'R',0);
		$pdf->Cell(15,0.15,'COUNT','TB',0,'R',0);
		$pdf->Cell(20,0.15,'INITIAL','TB',0,'R',0);
		$pdf->Cell(30,0.15,'SUCCEEDING','TB',0,'R',0);
		$pdf->Cell(25,0.15,'OVERNIGHT','TB',0,'R',0);

		$pdf->Cell(15,0.15,'LOST','TB',0,'R',0);
		$pdf->Cell(5,0.15,'','',0,'R',0);
		$pdf->Cell(18,0.15,'VATABLE','TB',0,'R',0);
		$pdf->Cell(25,0.15,'DISCOUNT','TB',0,'R',0);
		$pdf->Cell(10,0.15,'VAT','TB',0,'R',0);
		$pdf->Cell(5,0.15,'','',0,'R',0);
		$pdf->Cell(35,0.15,'AMOUNT RECEIVED','TB',0,'R',0);
		$pdf->Cell(5,0.15,'','',0,'R',0);
 		$pdf->ln();
		$pdf->SetFont('times', '', 10);
		$tcharge = 0;
		$tcount = 0;
		$tinit = 0;
		$ton = 0;
		$lost = 0;
		$tdiscount = 0;
		$texvat = 0;
		$tsucceed = 0;
		$tvatable = 0;
		$tvat = 0;*/

		$validsales = 0;
		$voidsales = 0;
		$returnsales = 0;

		$validcnt = 0;

		$voidcnt = 0;
		$returncnt = 0;
		$discount = 0;

		$netamount = 0;
		$grossamount = 0;


		$initcharge = 0;
		$surcharge = 0;	
		$lostcharge = 0;
		$oncharge = 0;
		$lessvatadjustment = 0;	
		$totalsales = 0;
		foreach ($trxn_data as  $value) {

		    $initcharge += $value["initcharge"];
            $surcharge += $value["surcharge"];
            $surcharge += $value["lostcharge"];
            $oncharge += $value["oncharge"];
            $lessvatadjustment += $value["vatexempt"] * 0.12;

         

			if($value["process"] == 1 || $value["process"] == 2)
			{
				$totalsales += $value["charge"];
				$discount += $value["discount"];

			}
			if($value["process"] == 98)
			{
				$voidsales += $value["charge"];
			}
			if($value["process"] == 99)
			{
				$returnsales += $value["charge"];
			}


            $grossamount = $initcharge + $surcharge + $lostcharge + $oncharge;
            $netamount = $grossamount - $discount - $returnsales - $voidsales - $lessvatadjustment;
			/*$tcharge += $value["charge"];
			$tcount += $value["count"];
			$tinit += $value["initcharge"];
			$ton += $value["oncharge"];
			$lost += $value["lostcharge"];
			$tdiscount += $value["discount"];
			$tsucceed += $value["surcharge"];
			$total = ($value["oncharge"] +$value["lostcharge"] +$value["surcharge"] + $value["initcharge"]);
			$tvatable += $total / 1.12;
			$tvat += $value["vatsales"] * 0.12;
		
			$pdf->Cell(5,0.15,'','',0,'R',0);
			$pdf->Cell(25,0.15,$value["ratetype"],'',0,'L',0);
			$pdf->Cell(5,0.15,'','',0,'R',0);
			$pdf->Cell(15,0.15,number_format($value["count"]),'',0,'R',0);
			$pdf->Cell(20,0.15,number_format($value["initcharge"],2),'',0,'R',0);
			$pdf->Cell(30,0.15,number_format($value["surcharge"],2),'',0,'R',0);
			$pdf->Cell(25,0.15,number_format($value["oncharge"],2),'',0,'R',0);
			$pdf->Cell(15,0.15,number_format($value["lostcharge"],2),'',0,'R',0);
			$pdf->Cell(5,0.15,'','',0,'R',0);
			$pdf->Cell(18,0.15,number_format($total / 1.12,2),'',0,'R',0);
			$pdf->Cell(25,0.15,number_format($value["discount"],2),'',0,'R',0);
			$pdf->Cell(10,0.15,number_format($value["vatsales"] * 0.12,2),'',0,'R',0);
			$pdf->Cell(5,0.15,'','',0,'R',0);
			$pdf->Cell(35,0.15,number_format($value["charge"],2),'',0,'R',0);
			$pdf->ln();*/

		}


		$pdf->AddPage('L', 'A4');
        $pdf->SetFont('times', '', 10);
        $pdf->Write(0, "Beg. SI No. :    $oldmin_or", '', 0, 'L', true, 0, false, false, 0);
		//$pdf->Write(0, "Transaction Count :    $total_count", '', 0, 'L', true, 0, false, false, 0);
        $pdf->Write(0, "End SI No. :    $max_or", '', 0, 'L', true, 0, false, false, 0);
        $pdf->Write(0, "Beg. Void. :    ". $trxn_total[0]["min_void"], '', 0, 'L', true, 0, false, false, 0);
        $pdf->Write(0, "End Void. :    ". $trxn_total[0]["max_void"], '', 0, 'L', true, 0, false, false, 0);
        $pdf->Write(0, "Beg. Refund. :    ".$trxn_total[0]["min_refund"], '', 0, 'L', true, 0, false, false, 0);
        $pdf->Write(0, "End Refund. :    ".$trxn_total[0]["max_refund"], '', 0, 'L', true, 0, false, false, 0);




        $pdf->Write(0, "Previous Accumulated Sales : ".number_format($oldtotal,2), '', 0, 'L', true, 0, false, false, 0);
        $pdf->Write(0, "Present Accumulated Sales: ".number_format($net_total,2), '', 0, 'L', true, 0, false, false, 0);
        $pdf->Write(0, "New Sales : ".number_format($charge,2), '', 0, 'L', true, 0, false, false, 0);
        $pdf->Write(0, "RESET COUNTER. :    0", '', 0, 'L', true, 0, false, false, 0);


      
 		$pdf->ln();
        
        $pdf->ln();$pdf->ln();

        $pdf->SetFont('times', 'B', 12);
 		$pdf->Write(0, "SYSTEM GENERATED SALES BREAKDOWN:", '', 0, 'L', true, 0, false, false, 0);
 
 		$pdf->ln();
 		
 		$pdf->SetFont('times', 'B', 10);
		$pdf->Cell(1,0.15,'','',0,'R',0);
		$pdf->Cell(30,0.15,'VATABLE SALES','TB',0,'R',0);
		$pdf->Cell(28,0.15,'VAT AMOUNT','TB',0,'R',0);
		$pdf->Cell(28,0.15,'VAT EXEMPT','TB',0,'R',0);
		$pdf->Cell(28,0.15,'ZERO RATED','TB',0,'R',0);
		$pdf->Cell(25,0.15,'Gross Amount','TB',0,'R',0);
		$pdf->Cell(25,0.15,'Less Discount','TB',0,'R',0);
		$pdf->Cell(25,0.15,'Less Return','TB',0,'R',0);
		$pdf->Cell(25,0.15,'Less Void','TB',0,'R',0);
		$pdf->Cell(35,0.15,'Less vat adjustment','TB',0,'R',0);
		$pdf->Cell(20,0.15,'Net Amount','TB',0,'R',0);
 		$pdf->ln();
		$pdf->SetFont('times', '', 10);

		$pdf->Cell(30,0.15,number_format($netamount / 1.12,2),'',0,'R',0);
		$pdf->Cell(28,0.15,number_format($netamount / 1.12 * 0.12,2),'',0,'R',0);
		$pdf->Cell(28,0.15,number_format(0,2),'',0,'R',0);
		$pdf->Cell(28,0.15,number_format(0,2),'',0,'R',0);
		$pdf->Cell(25,0.15,number_format($grossamount,2),'',0,'R',0);
		$pdf->Cell(25,0.15,number_format($discount,2),'',0,'R',0);
		$pdf->Cell(25,0.15,number_format($returnsales,2),'',0,'R',0);
		$pdf->Cell(25,0.15,number_format($voidsales,2),'',0,'R',0);
		$pdf->Cell(35,0.15,number_format($lessvatadjustment,2),'',0,'R',0);
		$pdf->Cell(20,0.15,number_format($netamount,2),'',0,'R',0);
		$pdf->ln();
		$pdf->Cell(30,0.15,"TOTAL",'TB',0,'R',0);
		$pdf->Cell(28,0.15,"",'TB',0,'R',0);
		$pdf->Cell(28,0.15,"",'TB',0,'R',0);
		$pdf->Cell(28,0.15,"",'TB',0,'R',0);
		$pdf->Cell(25,0.15,"",'TB',0,'R',0);
		$pdf->Cell(25,0.15,"",'TB',0,'R',0);
		$pdf->Cell(25,0.15,"",'TB',0,'R',0);
		$pdf->Cell(25,0.15,"",'TB',0,'R',0);
		$pdf->Cell(35,0.15,"",'TB',0,'R',0);
		$pdf->Cell(20,0.15,number_format($netamount,2),'TB',0,'R',0);




		/*$pdf->Cell(5,0.15,'','',0,'R',0);
		$pdf->Cell(25,0.15,'TOTAL','TB',0,'L',0);
		$pdf->Cell(5,0.15,'','',0,'R',0);
		$pdf->Cell(15,0.15,number_format($tcount),'TB',0,'R',0);
		$pdf->Cell(20,0.15,number_format($tinit,2),'TB',0,'R',0);
		$pdf->Cell(30,0.15,number_format($tsucceed,2),'TB',0,'R',0);
		$pdf->Cell(25,0.15,number_format($ton,2),'TB',0,'R',0);
		$pdf->Cell(15,0.15,number_format($lost,2),'TB',0,'R',0);
		$pdf->Cell(5,0.15,'','',0,'R',0);
		$pdf->Cell(18,0.15,number_format($tvatable,2),'TB',0,'R',0);
		$pdf->Cell(25,0.15,number_format($tdiscount,2),'TB',0,'R',0);
		$pdf->Cell(10,0.15,number_format($tvat,2),'TB',0,'R',0);
		$pdf->Cell(5,0.15,'','',0,'R',0);
		$pdf->Cell(35,0.15,number_format($tcharge,2),'TB',0,'R',0);
		$pdf->ln();$pdf->ln();$pdf->ln();$pdf->ln();$pdf->ln();$pdf->ln();
        $pdf->SetFont('times', 'B', 12);*/


		date_default_timezone_set('Asia/Singapore');
		$datename = date('Y-m-d-H-i-s');

		//Close and output PDF document
		$pdf->Output('zreading-'.$datename.'.pdf', 'I');

		//============================================================+
		// END OF FILE
		//============================================================+

	}


	public function voucherbookpdf(){

			if($this->input->post('terminal') == NULL)
		{	
			return;
		}
		$terminal = explode("/", $this->input->post('terminal'));
		$from_date = $this->input->post('from_date');
		$to_date = $this->input->post('to_date');

		$datasend =  array(
				          'terminal'     => $terminal[0],
				          'from_date'     => $from_date,
				          'to_date'     => $to_date,                   
				    );
		$opts = $this->functions->postheader($datasend);

		$trxn_data = $this->functions->apiv1($datasend,"transaction_records");
		//$trxn_data = $this->functions->apiv1($datasend,"transaction_groupbydate");
		//print_r($trxn_data);
		//return;
		/*HEADER SETUP*/

		$pdf = $this->functions->pdfheader3();
		$pdf->CustomHeaderText = "VOUCHER BOOK";
		$pdf->TerminalName = $terminal[1];
	    $pdf->DateFrom = $from_date;
	    $pdf->DateTo = $to_date;
	    $pdf->Name = strtoupper($this->session->userdata('firstname').' '. $this->session->userdata('lastname'));



	    $header = "DATE,INVOICE#,Voucher Code,Sales Inclusive Vat,VAT Amount,VAT Exempt,Discount(20%),NET SALES";
        $align = "C,C,C,C,C,C,C,C,C,C,C,C";
	    $width = "35,35,40,40,35,30,25,25,23,27,25";

	    $pdf->TableHeader = $header;
	    $pdf->TableAlign = $align;
	    $pdf->TableWidth = $width;

	    $tableheader = explode(",", $header);
	    $w_align=explode(",", $align);
	    $w = explode(",", $width);
	    /////////////////////////////////////////////////////////////////////////////////////////////////////


		// ---------------------------------------------------------
		// add a page
		$pdf->AddPage('L', 'A4');

	    $pdf->SetFont('times', 'B', 10);
	    
		$lostcharge = 0;
		$tnetamount = 0;
		$tdiscount = 0;		
		$tvat = 0;
		$tgross = 0;
		$totalnet = 0;
		$totalgross = 0;
		$totaldiscount =0;
		$totalvatexempt = 0;
		//print_r($trxn_data);
		//return;
		$seniorname = "";
		$seniortin = "";
		$seniorid = "";
		//print_r($trxn_data);
		//return;

	    foreach ($trxn_data as  $value) {


	    	//if(strpos($value["ratename"], "PWD")  !== false)
	    	if(isset($value["dccode"]))
	    	{


	    			if(isset($value["setl_ref"]))
	    			{	    				
						$seniordata = explode(',', $value["setl_ref"]);
						$seniorname = $seniordata[1];
						$seniorid = $seniordata[0];
						$seniortin = $seniordata[2];
	    			}
			

					$initcharge = $value["initcharge"];
		            $surcharge = $value["surcharge"];
		            $surcharge = $value["lostcharge"];
		            $oncharge = $value["oncharge"];
		            $lessvatadjustment = $value["vatexempt"];
		            $discount = $value["discount"];

					$grossamount = $initcharge + $surcharge + $lostcharge + $oncharge;
					$netamount = $grossamount - $discount - ($lessvatadjustment * 0.12);
					$totalnet += $netamount;
					$totalgross += $grossamount;
					$totaldiscount += $discount;
					$totalvatexempt += $value["vatexempt"];
					$row = array(
						$value["paymentdate"],
						$value["receiptnum"],
						$value["dccode"],
					 	number_format($grossamount,2),
						number_format($grossamount - ($grossamount / 1.12 * 0.12),2),
						number_format($value["vatexempt"],2),
						number_format($discount,2),
						number_format($netamount,2)

					);

				$pdf->Cell(1,0.15,'','',0,'R',0);
				$pdf->Ln();
				for($i=0;$i<count($tableheader);$i++) {
					$pdf->Cell($w[$i],6,$row[$i],0,0,$w_align[$i]);
				}

			 	$pdf->Ln();
		    }

		
		}

	
		$footer    = array(
		"TOTAL",
		"",
		"",
		number_format($totalgross,2),
		number_format($totalgross / 1.12 * 0.12,2),
		number_format($totalvatexempt,2),
		number_format($totaldiscount,2),
		number_format($totalnet,2)

		);

		
		$pdf->SetFont('times','B',12);
		for($i=0;$i<count($footer);$i++) {
		    $pdf->Cell($w[$i],8,$footer[$i],'TB',0,$w_align[$i]);
		}

		$pdf->Ln();




		$audit_data = "";
		//$audit_term = gethostbyaddr($_SERVER['REMOTE_ADDR']);
		$audit_term = gethostname();
		
		$audit_ip = $_SERVER['REMOTE_ADDR'];

		$audit_data = "GENERATE PWD BOOK REPORT";		

		$auditsend = array(
		  'function'   => 'RATES ADDED',
		  'description'=> $audit_data,
		  'userid'     => $this->session->userdata('userid'),
		  'ip'   => getenv("REMOTE_ADDR"),
		  'pcname' => $audit_term,
		);



		date_default_timezone_set('Asia/Singapore');
		$datename = date('Y-m-d-H-i-s');

		//Close and output PDF document
		$pdf->Output('senior/pwd-'.$datename.'.pdf', 'I');


		//============================================================+
		// END OF FILE
		//============================================================+



	}


	public function pwdbookpdf(){

			if($this->input->post('terminal') == NULL)
		{	
			return;
		}
		$terminal = explode("/", $this->input->post('terminal'));
		$from_date = $this->input->post('from_date');
		$to_date = $this->input->post('to_date');

		$datasend =  array(
				          'terminal'     => $terminal[0],
				          'from_date'     => $from_date,
				          'to_date'     => $to_date,                   
				    );
		$opts = $this->functions->postheader($datasend);

		$trxn_data = $this->functions->apiv1($datasend,"transaction_records");
		//$trxn_data = $this->functions->apiv1($datasend,"transaction_groupbydate");
		//print_r($trxn_data);
		//return;
		/*HEADER SETUP*/

		$pdf = $this->functions->pdfheader3();
		$pdf->CustomHeaderText = "PWD BOOK";
		$pdf->TerminalName = $terminal[1];
	    $pdf->DateFrom = $from_date;
	    $pdf->DateTo = $to_date;
	    $pdf->Name = strtoupper($this->session->userdata('firstname').' '. $this->session->userdata('lastname'));



	    $header = "DATE,FULL NAME,ID#,TIN#,INVOICE#,Sales Inclusive Vat,VAT Amount,VAT Exempt,Discount(20%),NET SALES";
        $align = "C,C,C,C,C,C,C,C,C,C,C,C";
	    $width = "35,35,25,25,35,30,25,25,23,27,25";

	    $pdf->TableHeader = $header;
	    $pdf->TableAlign = $align;
	    $pdf->TableWidth = $width;

	    $tableheader = explode(",", $header);
	    $w_align=explode(",", $align);
	    $w = explode(",", $width);
	    /////////////////////////////////////////////////////////////////////////////////////////////////////


		// ---------------------------------------------------------
		// add a page
		$pdf->AddPage('L', 'A4');

	    $pdf->SetFont('times', 'B', 10);
	    
		$lostcharge = 0;
		$tnetamount = 0;
		$tdiscount = 0;		
		$tvat = 0;
		$tgross = 0;
		$totalnet = 0;
		$totalgross = 0;
		$totaldiscount =0;
		$totalvatexempt = 0;
		//print_r($trxn_data);
		//return;
		$seniorname = "";
		$seniortin = "";
		$seniorid = "";
		
	    foreach ($trxn_data as  $value) {


	    	if(strpos($value["ratename"], "PWD")  !== false)
	    	{


	    			if(isset($value["setl_ref"]))
	    			{	    				
						$seniordata = explode(',', $value["setl_ref"]);
						$seniorname = $seniordata[1];
						$seniorid = $seniordata[0];
						$seniortin = $seniordata[2];
	    			}
			

					$initcharge = $value["initcharge"];
		            $surcharge = $value["surcharge"];
		            $surcharge = $value["lostcharge"];
		            $oncharge = $value["oncharge"];
		            $lessvatadjustment = $value["vatexempt"];
		            $discount = $value["discount"];

					$grossamount = $initcharge + $surcharge + $lostcharge + $oncharge;
					$netamount = $grossamount - $discount - ($lessvatadjustment * 0.12);
					$totalnet += $netamount;
					$totalgross += $grossamount;
					$totaldiscount += $discount;
					$totalvatexempt += $value["vatexempt"];
					
					$row = array(
						$value["paymentdate"],
						$seniorname,
						$seniorid,
						$seniortin,
						$value["receiptnum"],
					 	number_format($grossamount,2),
						number_format(0,2),
						number_format($value["vatexempt"],2),
						number_format($discount,2),
						number_format($netamount,2)

					);

				$pdf->Cell(1,0.15,'','',0,'R',0);
				$pdf->Ln();
				for($i=0;$i<count($tableheader);$i++) {
					$pdf->Cell($w[$i],6,$row[$i],0,0,$w_align[$i]);
				}

			 	$pdf->Ln();
		    }

		
		}

	
		$footer    = array(
		"TOTAL",
		"",
		"",
		"",
		"",
		number_format($totalgross,2),
		number_format(0,2),
		number_format($totalvatexempt,2),
		number_format($totaldiscount,2),
		number_format($totalnet,2)

		);

		
		$pdf->SetFont('times','B',12);
		for($i=0;$i<count($footer);$i++) {
		    $pdf->Cell($w[$i],8,$footer[$i],'TB',0,$w_align[$i]);
		}

		$pdf->Ln();




		$audit_data = "";
		//$audit_term = gethostbyaddr($_SERVER['REMOTE_ADDR']);
		$audit_term = gethostname();
		
		$audit_ip = $_SERVER['REMOTE_ADDR'];

		$audit_data = "GENERATE PWD BOOK REPORT";		

		$auditsend = array(
		  'function'   => 'RATES ADDED',
		  'description'=> $audit_data,
		  'userid'     => $this->session->userdata('userid'),
		  'ip'   => getenv("REMOTE_ADDR"),
		  'pcname' => $audit_term,
		);



		date_default_timezone_set('Asia/Singapore');
		$datename = date('Y-m-d-H-i-s');

		//Close and output PDF document
		$pdf->Output('senior/pwd-'.$datename.'.pdf', 'I');


		//============================================================+
		// END OF FILE
		//============================================================+



	}


	public function seniorbookpdf(){

	
		if($this->input->post('terminal') == NULL)
		{	
			return;
		}
		$terminal = explode("/", $this->input->post('terminal'));
		$from_date = $this->input->post('from_date');
		$to_date = $this->input->post('to_date');

		$datasend =  array(
				          'terminal'     => $terminal[0],
				          'from_date'     => $from_date,
				          'to_date'     => $to_date,                   
				    );
		$opts = $this->functions->postheader($datasend);

		$trxn_data = $this->functions->apiv1($datasend,"transaction_records");
		//$trxn_data = $this->functions->apiv1($datasend,"transaction_groupbydate");
		//print_r($trxn_data);
		//return;
		/*HEADER SETUP*/

		$pdf = $this->functions->pdfheader3();
		$pdf->CustomHeaderText = "SENIOR BOOK";
		$pdf->TerminalName = $terminal[1];
	    $pdf->DateFrom = $from_date;
	    $pdf->DateTo = $to_date;
	    $pdf->Name = strtoupper($this->session->userdata('firstname').' '. $this->session->userdata('lastname'));



	    $header = "DATE,FULL NAME,ID#,TIN#,INVOICE#,Sales Inclusive Vat,VAT Amount,VAT Exempt,Discount(20%),NET SALES";
        $align = "C,C,C,C,C,C,C,C,C,C,C,C";
	    $width = "35,35,25,25,35,30,25,25,23,27,25";

	    $pdf->TableHeader = $header;
	    $pdf->TableAlign = $align;
	    $pdf->TableWidth = $width;

	    $tableheader = explode(",", $header);
	    $w_align=explode(",", $align);
	    $w = explode(",", $width);
	    /////////////////////////////////////////////////////////////////////////////////////////////////////


		// ---------------------------------------------------------
		// add a page
		$pdf->AddPage('L', 'A4');

	    $pdf->SetFont('times', 'B', 10);
	    
		$lostcharge = 0;
		$tnetamount = 0;
		$tdiscount = 0;		
		$tvat = 0;
		$tgross = 0;
		$totalnet = 0;
		$totalgross = 0;
		$totaldiscount =0;
		$totalvatexempt = 0;

		//print_r($trxn_data);
		//return;
		$seniorname = "";
		$seniortin = "";
		$seniorid = "";
		
	    foreach ($trxn_data as  $value) {


	    	if(strpos($value["ratename"], "SENIOR")  !== false)
	    	{


	    			if(isset($value["setl_ref"]))
	    			{	    				
						$seniordata = explode(',', $value["setl_ref"]);
						$seniorname = $seniordata[1];
						$seniorid = $seniordata[0];
						$seniortin = $seniordata[2];
						
	    			}
			

					$initcharge = $value["initcharge"];
		            $surcharge = $value["surcharge"];
		            $surcharge = $value["lostcharge"];
		            $oncharge = $value["oncharge"];
		            $lessvatadjustment = $value["vatexempt"];
		            $discount = $value["discount"];


					
					$grossamount = $initcharge + $surcharge + $lostcharge + $oncharge;
					$netamount = $grossamount - $discount - ($lessvatadjustment * 0.12);
					$totalnet += $netamount;
					$totalgross += $grossamount;
					$totaldiscount += $discount;
					$totalvatexempt += $value["vatexempt"];
					
					$row = array(
						$value["paymentdate"],
						$seniorname,
						$seniorid,
						$seniortin,
						$value["receiptnum"],
					 	number_format($grossamount,2),
						number_format(0,2),
						number_format($value["vatexempt"],2),
						number_format($discount,2),
						number_format($netamount,2)

					);

				$pdf->Cell(1,0.15,'','',0,'R',0);
				$pdf->Ln();
				for($i=0;$i<count($tableheader);$i++) {
					$pdf->Cell($w[$i],6,$row[$i],0,0,$w_align[$i]);
				}

			 	$pdf->Ln();
		    }

		
		}

	
		$footer    = array(
		"TOTAL",
		"",
		"",
		"",
		"",
		number_format($totalgross,2),
		number_format(0,2),
		number_format($totalvatexempt,2),
		number_format($totaldiscount,2),
		number_format($totalnet,2)

		);

		
		$pdf->SetFont('times','B',12);
		for($i=0;$i<count($footer);$i++) {
		    $pdf->Cell($w[$i],8,$footer[$i],'TB',0,$w_align[$i]);
		}

		$pdf->Ln();





		$audit_data = "";
		//$audit_term = gethostbyaddr($_SERVER['REMOTE_ADDR']);
		$audit_term = gethostname();
		
		$audit_ip = $_SERVER['REMOTE_ADDR'];

		$audit_data = "GENERATE SENIOR BOOK REPORT";	

		$auditsend = array(
		  'function'   => 'RATES ADDED',
		  'description'=> $audit_data,
		  'userid'     => $this->session->userdata('userid'),
		  'ip'   => getenv("REMOTE_ADDR"),
		  'pcname' => $audit_term,
		);

		$result = $this->functions->apiv1($auditsend,"insert_auditlog");



		date_default_timezone_set('Asia/Singapore');
		$datename = date('Y-m-d-H-i-s');

		//Close and output PDF document
		$pdf->Output('senior/pwd-'.$datename.'.pdf', 'I');


		//============================================================+
		// END OF FILE
		//============================================================+

	}

	public function birpdf(){

	
		if($this->input->post('terminal') == NULL)
		{	
			return;
		}
		$terminal = explode("/", $this->input->post('terminal'));
		$from_date = $this->input->post('from_date');
		$to_date = $this->input->post('to_date');

		$datasend =  array(
				          'terminal'     => $terminal[0],
				          'from_date'     => $from_date,
				          'to_date'     => $to_date,                   
				    );
		$opts = $this->functions->postheader($datasend);


		
		$getdaterange = $this->functions->apiv1($datasend,"birdaterange");

		//print_r($getdaterange);



		$begin = new DateTime($getdaterange[0]['minpaydate']);
		$end = new DateTime($getdaterange[0]['maxpaydate']);
		$end->modify('+1 day');
 		$interval = DateInterval::createFromDateString('1 day');
		$period = new DatePeriod($begin, $interval, $end);



		$trxn_data = $this->functions->apiv1($datasend,"transaction_groupbydate");
		//print_r($trxn_data);
		//return;
		/*HEADER SETUP*/

		$pdf = $this->functions->pdfheader();
		$pdf->CustomHeaderText = "BIR REPORT";
		$pdf->TerminalName = $terminal[1];
	    $pdf->DateFrom = $from_date;
	    $pdf->DateTo = $to_date;
	    $pdf->Name = strtoupper($this->session->userdata('firstname').' '. $this->session->userdata('lastname'));

	    $header1 = ",Deductions,Adjustment on VAT,";

        $align1 = "C,C,C,C";
	    $width1 = "265,170,140,111";
	    $border1 = "TLR,BTLR,BTLR,TLR";


	    $header2 = ",Discount,,Discount,,";

        $align2 = "C,C,C,C,C,C";
	    $width2 = "265,100,70,60,80,111";
	    $border2 = "LR,LR,LR,LR,LR,LR";



	    $header3 = "DATE,Beg SI,End SI,Sales end,Sales Beg,Gross,VATable,VAT Amount,VAT Exempt,Zero Rated,SC ,PWD ,NAAC ,SP , Others, Returns, Voids ,Total Deductions , SC, PWD, Others, Vat on Returns, Others,Total VAT Adj.,VAT Payable,Net Sales,Total Income,Reset,Z-Counter";
	    $border3 = "TBLR,TBLR,TBLR,TBLR,TBLR,TBLR,TBLR,TBLR, TBLR,TBLR,TBLR,TBLR,TBLR,TBLR,TBLR,TBLR,TBLR,TBLR,TBLR,TBLR,TBLR,TBLR,TBLR,TBLR,TBLR,TBLR,TBLR,TBLR,TBLR";
	    $align3 = "C,C,C,C,C,C,C,C,C,C,C,C,C,C,C,C,C,C,C,C,C,C,C,C,C,C,C,C,C,C";
	    $width3 = "30,30,30,25,25,25,25,25,25,25,20,20,20,20,20,20,20,30,20,20,20,30,20,30,25,23,23,20,20";
	    //$width3 = "30,30,30,25,25,25,20,25,25,25,20,25,25,25,25,25,23,23,20,20";

	    $pdf->TableHeader1 = $header1;
	    $pdf->tableborder1 = $border1;
	    $pdf->TableAlign1 = $align1;
	    $pdf->TableWidth1 = $width1;

	    $pdf->TableHeader2 = $header2;
	    $pdf->TableAlign2 = $align2;
	    $pdf->TableWidth2 = $width2;
	    $pdf->tableborder2 = $border2;


	    $pdf->TableHeader3 = $header3;
	    $pdf->TableAlign = $align3;
	    $pdf->TableWidth = $width3;
	    $pdf->tableborder3 = $border3;

	    $tableheader = explode(",", $header3);
	    $w_align=explode(",", $align3);
	    $w = explode(",", $width3);
	    /////////////////////////////////////////////////////////////////////////////////////////////////////


		// ---------------------------------------------------------
		// add a page
		$pdf->AddPage('L', array(700, 300));
		//$pdf->AddPage('L', 'A3');

	    $pdf->SetFont('times', 'B', 10);
	    /*table body*/



	    $grossamount = 0;
	    $salesbeg = 0;
	    $salesend = 0;
	    $netamount = 0;
	    $lessvatadjustment = 0;
	    //print_r($trxn_data);
	    $minpaydate = $trxn_data[0]["minpaydate"];


	   	$totalnetamount = 0;
	   	$totaldiscount = 0;
	   	$totalsccharge = 0;
	   	$totalpwdcharge = 0;

	   	$totalvoid = 0;
	   	$totalvatexempt = 0;
	   	$vatsales = 0;
	   	$vatamount = 0;
	   	$totalvatamount = 0;


	   	$oldmax_or = "";
	   	//$sccharge = 0;
	   	//$pwdcharge = 0;	   
		foreach ($period as $dt) {
			$datasend =  array(
		          'terminal'     => $terminal[0],
		          'from_date'     => $dt->format("Y-m-d 00:00:00"),
		          'to_date'     => $dt->format("Y-m-d 23:59:59"),                   
		    );


			$value = $this->functions->apiv1($datasend,"transaction_groupbydatez");
			$value = $value[0];


			

			if(!isset($value["pdate"]))
				$value["pdate"] = $dt->format("Y-m-d");	
			if(!isset($value["SC"]))
				$value["SC"] = 0;		    
			if(!isset($value["PWD"]))
				$value["PWD"] = 0;
			if(!isset($value["initcharge"]))
				$value["initcharge"] = 0;
			if(!isset($value["surcharge"]))
				$value["surcharge"] = 0;
			if(!isset($value["lostcharge"]))
				$value["lostcharge"] = 0;
			if(!isset($value["oncharge"]))
				$value["oncharge"] = 0;
			if(!isset($value["netamount"]))
				$value["netamount"] = 0;
			if(!isset($value["void"]))
				$value["void"] = 0;
			if(!isset($value["discount"]))
				$value["discount"] = 0;
			if(!isset($value["vatexempt"]))
				$value["vatexempt"] = 0;


			if(isset($value["max_or"]))
				$oldmax_or = $value["max_or"];


			if(!isset($value["min_or"]))
				$value["min_or"] = $oldmax_or;
			if(!isset($value["max_or"]))
				$value["max_or"] = $oldmax_or;			





			$datediff =strtotime($value["pdate"]) - strtotime($minpaydate);
			//$datediff =strtotime($dt->format("Y-m-d")) - strtotime($minpaydate);
			
			$zcounter =  round($datediff / (60 * 60 * 24)) + 1;




		    $lessvatadjustment = (($value["SC"] + $value["PWD"]) * 0.12);

			//$sccharge = $value["SC"];
			//$pwdcharge = $value["PWD"];		   
			
    		$grossamount =  $value["initcharge"] +  $value["surcharge"] + $value["oncharge"];
    		$netamount = $grossamount - (($value["SC"] + $value["PWD"]) * 0.20) - $value["void"] - $lessvatadjustment;
			//$netamount = ($value["SC"] + $value["PWD"]) * 0.20;
    		$vatamount = $value["netamount"];
			
			
			//print_r("\n");
			//print_r($value["lostcharge"]);
			//print_r("\n");

			$salesend+=$grossamount;
	

			$totalvatamount += $value["netamount"];
			$totalnetamount += $netamount;
			$totaldiscount += $value["discount"];
			$totalvoid += $value["void"];
			$totalvatexempt += $value["vatexempt"];
			$totalsccharge += $value["SC"];
			$totalpwdcharge += $value["PWD"];
			$row = array(
				$value["pdate"],
				$value["min_or"],
				$value["max_or"],
				number_format($salesend,2),
				number_format($salesbeg,2),
				number_format($grossamount,2),
				number_format($vatamount / 1.12,2),
				number_format($vatamount / 1.12 * 0.12,2),
				number_format($value["vatexempt"],2),
				number_format(0,2),
				number_format(($value["SC"]) * 0.20,2),
				number_format(($value["PWD"]) * 0.20,2),
				number_format(0,2),
				number_format(0,2),
				number_format(0,2),
				number_format(0,2),		
				number_format($value["void"],2),
				number_format($value["discount"] + $value["void"],2),
				number_format($value["SC"] * 0.12,2),	
				number_format($value["PWD"] * 0.12,2),
				number_format(0,2),	
				number_format(0,2),
				number_format(0,2),
				number_format(($value["SC"] * 0.12) + ($value["PWD"] * 0.12),2),
				number_format($vatamount / 1.12 * 0.12,2),
				number_format($netamount,2),
				number_format($grossamount,2),
				0,				
				$zcounter

			);

			$pdf->Cell(1,0.15,'','',0,'R',0);
			$pdf->Ln();
			for($i=0;$i<count($tableheader);$i++) {
				$pdf->Cell($w[$i],6,$row[$i],0,0,$w_align[$i]);
			}

			$pdf->Ln();

			$salesbeg+=$grossamount;


		}

		
	
		$footer    = array(
			"TOTAL",
			"",
			"",
			"",
			"",
			number_format($salesend,2),
			number_format($totalvatamount / 1.12,2),
			number_format($totalvatamount / 1.12 * 0.12,2),
			number_format($totalvatexempt,2),
			number_format(0,2),
			number_format(($totalsccharge) * 0.20,2),
			number_format(($totalpwdcharge) * 0.20,2),
			number_format(0,2),
			number_format(0,2),
			number_format(0,2),
			number_format(0,2),
			number_format($totalvoid,2),
			number_format($totaldiscount + $totalvoid,2),
			number_format(($totalsccharge) *  0.12,2),
			number_format(($totalpwdcharge) *  0.12,2),
			number_format(0,2),
			number_format(0,2),
			number_format(0,2),	
			number_format(($totalsccharge * 0.12) + ($totalpwdcharge * 0.12),2),
			number_format($totalvatamount / 1.12 * 0.12,2),
			number_format($totalnetamount,2),
			number_format($salesend,2),
			"",
			""

				
		);

		//number_format(($totalsccharge) *  0.12 + ($totalpwdcharge) *  0.12 + $totalvoid / 1.12 * 0.12,2),
		$pdf->SetFont('times','B',12);
		for($i=0;$i<count($footer);$i++) {
		    $pdf->Cell($w[$i],8,$footer[$i],'TB',0,$w_align[$i]);
		}
	
		$pdf->Ln();

	    /*foreach ($trxn_data as  $value) {
		

			$datediff =strtotime($value["pdate"]) - strtotime($minpaydate);
			$zcounter =  round($datediff / (60 * 60 * 24)) + 1;


	
			$lessvatadjustment = (($value["SC"] + $value["PWD"]) * 0.12);

			//$sccharge = $value["SC"];
			//$pwdcharge = $value["PWD"];		   


    		$grossamount =  $value["initcharge"] +  $value["surcharge"] + $value["lostcharge"] + $value["oncharge"];
    		$netamount = $grossamount - (($value["SC"] + $value["PWD"]) * 0.20) - $value["void"] - $lessvatadjustment;
			//$netamount = ($value["SC"] + $value["PWD"]) * 0.20;
    		$vatamount = $value["netamount"];

			$salesend+=$grossamount;
	

			$totalvatamount = $value["netamount"];
			$totalnetamount += $netamount;
			$totaldiscount += $value["discount"];
			$totalvoid += $value["void"];
			$totalvatexempt += $value["vatexempt"];
			$totalsccharge += $value["SC"];
			$totalpwdcharge += $value["PWD"];
			$row = array(
				$value["pdate"],
				$value["min_or"],
				$value["max_or"],
				number_format($salesend,2),
				number_format($salesbeg,2),
				number_format($grossamount,2),
				number_format($vatamount / 1.12,2),
				number_format($vatamount / 1.12 * 0.12,2),
				number_format($value["vatexempt"],2),
				number_format(0,2),
				number_format(($value["SC"]) * 0.20,2),
				number_format(($value["PWD"]) * 0.20,2),
				number_format(0,2),
				number_format(0,2),
				number_format(0,2),
				number_format(0,2),		
				number_format($value["void"],2),
				number_format($value["discount"] + $value["void"],2),
				number_format($value["SC"] * 0.12,2),	
				number_format($value["PWD"] * 0.12,2),
				number_format(0,2),	
				number_format(0,2),
				number_format(0,2),
				number_format(($value["SC"] * 0.12) + ($value["PWD"] * 0.12),2),
				number_format($vatamount / 1.12 * 0.12,2),
				number_format($netamount,2),
				number_format($grossamount,2),
				0,				
				$zcounter

			);

			$pdf->Cell(1,0.15,'','',0,'R',0);
			$pdf->Ln();
			for($i=0;$i<count($tableheader);$i++) {
				$pdf->Cell($w[$i],6,$row[$i],0,0,$w_align[$i]);
			}

			$pdf->Ln();

			$salesbeg+=$grossamount;
		
		}

	
		$footer    = array(
			"TOTAL",
			"",
			"",
			"",
			"",
			number_format($salesend,2),
			number_format($totalvatamount / 1.12,2),
			number_format($totalvatamount / 1.12 * 0.12,2),
			number_format($totalvatexempt,2),
			number_format(0,2),
			number_format(($totalsccharge) * 0.20,2),
			number_format(($totalpwdcharge) * 0.20,2),
			number_format(0,2),
			number_format(0,2),
			number_format(0,2),
			number_format(0,2),
			number_format($totalvoid,2),
			number_format($totaldiscount + $totalvoid,2),
			number_format(($totalsccharge) *  0.12,2),
			number_format(($totalpwdcharge) *  0.12,2),
			number_format(0,2),
			number_format(0,2),
			number_format(0,2),	
			number_format(($totalsccharge) *  0.12 + ($totalpwdcharge) *  0.12 + $totalvoid / 1.12 * 0.12,2),
			number_format($totalvatamount / 1.12 * 0.12,2),
			number_format($totalnetamount,2),
			number_format($salesend,2),
			"",
			""

				
		);

		
		$pdf->SetFont('times','B',12);
		for($i=0;$i<count($footer);$i++) {
		    $pdf->Cell($w[$i],8,$footer[$i],'TB',0,$w_align[$i]);
		}
	
		$pdf->Ln();


		*/



		date_default_timezone_set('Asia/Singapore');
		$datename = date('Y-m-d-H-i-s');

		//Close and output PDF document
		$pdf->Output('bir-'.$datename.'.pdf', 'I');


		$audit_data = "";
		//$audit_term = gethostbyaddr($_SERVER['REMOTE_ADDR']);
		$audit_term = gethostname();
		$audit_ip = $_SERVER['REMOTE_ADDR'];

		$audit_data = "BIR REPORT REPORT";	

		$auditsend = array(
		  'function'   => 'GENERATE REPORT',
		  'description'=> $audit_data,
		  'userid'     => $this->session->userdata('userid'),
		  'ip'   => getenv("REMOTE_ADDR"),
		  'pcname' => $audit_term,
		);

		$result = $this->functions->apiv1($auditsend,"insert_auditlog");

		//============================================================+
		// END OF FILE
		//============================================================+

	}

	public function ejournal(){

	
		if($this->input->post('terminal') == NULL)
		{	
			return;
		}
		$terminal = explode("/", $this->input->post('terminal'));
		$from_date = $this->input->post('from_date');
		$to_date = $this->input->post('to_date');

		$datasend =  array(
				          'terminal'     => $terminal[0],
				          'from_date'     => $from_date,
				          'to_date'     => $to_date,                   
				    );
		$opts = $this->functions->postheader($datasend);

		$trxn_data = $this->functions->apiv1($datasend,"transaction_records");
		//$trxn_data = $this->functions->apiv1($datasend,"transaction_groupbydate");
		//print_r($trxn_data);
		//return;
		/*HEADER SETUP*/

		$pdf = $this->functions->pdfheader3();
		$pdf->CustomHeaderText = "E JOURNAL";
		$pdf->TerminalName = $terminal[1];
	    $pdf->DateFrom = $from_date;
	    $pdf->DateTo = $to_date;
	    $pdf->Name = strtoupper($this->session->userdata('firstname').' '. $this->session->userdata('lastname'));



	
	    /////////////////////////////////////////////////////////////////////////////////////////////////////


		// ---------------------------------------------------------
		// add a page
		//page settings



	    	
	    //print_r($data);
	 
	    
	    $load = 0;
	    foreach ($trxn_data as  $value) {


	    	//$data = file('http://' . $value["termIP"] . '/Records/' . $value["payid"] . '.txt');
	    	//$data = file('http://' . '127.0.0.1' . '/Records/' . '1000000001' . '.txt');


		    if(file('http://' . $value["termIP"] . '/Records/' . $value["payid"] . '.txt')) {
			  $data = file('http://' . $value["termIP"] . '/Records/' . $value["payid"] . '.txt');

		    	if($load == 0)
		    	{

		    		$load = 1;
					$pdf->AddPage('P', array(100, count($data) * count($trxn_data) * 5));
		   			$pdf->SetFont('times', '', 10);

		   			
		    	}


				foreach($data as $linetext)
				{	
					$pdf->Cell(0,0,$linetext,'',0,'L',0);
					$pdf->ln();
				}
				//$pdf->AddPage('P', 'A3');
				//return;


			} 

	  

		
		}

	




		date_default_timezone_set('Asia/Singapore');
		$datename = date('Y-m-d-H-i-s');

		//Close and output PDF document
		$pdf->Output('ejournal-'.$datename.'.pdf', 'I');




		$audit_data = "";
		//$audit_term = gethostbyaddr($_SERVER['REMOTE_ADDR']);
		$audit_term = gethostname();
		$audit_ip = $_SERVER['REMOTE_ADDR'];

		$audit_data = "EJOURNAL PDF REPORT";	

		$auditsend = array(
		  'function'   => 'GENERATE REPORT',
		  'description'=> $audit_data,
		  'userid'     => $this->session->userdata('userid'),
		  'ip'   => getenv("REMOTE_ADDR"),
		  'pcname' => $audit_term,
		);

		$result = $this->functions->apiv1($auditsend,"insert_auditlog");

		//============================================================+
		// END OF FILE
		//============================================================+

	}

	public function ejournaltxt(){

	
		if($this->input->post('terminal') == NULL)
		{	
			return;
		}
		$terminal = explode("/", $this->input->post('terminal'));
		$from_date = $this->input->post('from_date');
		$to_date = $this->input->post('to_date');

		$datasend =  array(
				          'terminal'     => $terminal[0],
				          'from_date'     => $from_date,
				          'to_date'     => $to_date,                   
				    );
		$opts = $this->functions->postheader($datasend);

		$trxn_data = $this->functions->apiv1($datasend,"transaction_records");
		//$trxn_data = $this->functions->apiv1($datasend,"transaction_groupbydate");
		//print_r($trxn_data);
		//return;
		/*HEADER SETUP*/

		//$pdf = $this->functions->pdfheader3();
		//$pdf->CustomHeaderText = "E JOURNAL";
		//$pdf->TerminalName = $terminal[1];
	    //$pdf->DateFrom = $from_date;
	    //$pdf->DateTo = $to_date;
	    //$pdf->Name = strtoupper($this->session->userdata('firstname').' '. $this->session->userdata('lastname'));



	
	    /////////////////////////////////////////////////////////////////////////////////////////////////////


		// ---------------------------------------------------------
		// add a page
		//page settings


	$content  = "";
    $url = "http://" . $trxn_data[0]["termIP"] . "/records/";
	$contents = file_get_contents($url);
 	$count = preg_match_all('/<a href="([^"]+)(txt|\/)">[^<]*<\/a>/', $contents, $files);
    for ($i = 0; $i < $count; ++$i) {
    	$fileURL = $url . $files[1][$i] . $files[2][$i];

    	 $headers = get_headers($fileURL, 1);
    	 $timestamp = strtotime($headers['Last-Modified']);
    	 //echo "- " . $files[1][$i] . $files[2][$i] . ": " . date("Y-m-d", $timestamp) .  "<br />\n";


    	  if(date("Y-m-d", $timestamp) >= $from_date && date("Y-m-d", $timestamp) <= $to_date) {
			  
			  	$data = file('http://' . $trxn_data[0]["termIP"] . '/Records/' . $files[1][$i] . $files[2][$i]);

				foreach($data as $linetext)
				{	
					$content .= $linetext;
					//$pdf->Cell(0,0,$linetext,'',0,'L',0);
					//$pdf->ln();
				}


		}



    }


    //$html = file($url);
    //foreach($html as $data )
    //{
    //	if(strpos($data, "txt") !== false)
    //	{
    //		print_r($data);	
    //	}
    	
    //}
    //print_r($html);
    //$count = preg_match_all('/<a href="([^"]+)(txt|\/)">[^<]*<\/a>/i', $html, $files);
    //$count = preg_match_all('/<a href="([^"]+)(txt|\/)">[^<]*<\/a>/', $html, $files);
    //print_r($html);
    /*for ($i = 0; $i < $count; ++$i) {

       echo "File: " . $files[1][$i] . $files[2][$i] . "<br />\n";
       //print_r($files);
    }
    //var_dump($files);*/






		
		
	    
	    /*$load = 0;
	    foreach ($trxn_data as  $value) {

		    if(file('http://' . $value["termIP"] . '/Records/' . $value["payid"] . '.txt')) {
			  	
			  	$data = file('http://' . $value["termIP"] . '/Records/' . $value["payid"] . '.txt');

		    	//if($load == 0)
		    	//{

		    	//	$load = 1;


					//$pdf->AddPage('P', array(100, count($data) * count($trxn_data) * 5));
		   			//$pdf->SetFont('times', '', 10);

		   			
		    	//}


				foreach($data as $linetext)
				{	
					$content .= $linetext;
					//$pdf->Cell(0,0,$linetext,'',0,'L',0);
					//$pdf->ln();
				}



			} 

	  

		
		}*/
	


		



		date_default_timezone_set('Asia/Singapore');
		$datename = date('Y-m-d-H-i-s');

		$filename = 'ejournal-'.$datename.'.txt';

		header('Content-Description: File Transfer');
		header('Content-Type: application/octet-stream');
		//header('Content-disposition: attachment; filename=S3S.txt');
		header("Content-disposition: attachment; filename=" . $filename);
		header('Content-Length: '.strlen($content));
		header('Cache-Control: must-revalidate, post-check=0, pre-check=0');
		header('Expires: 0');
		header('Pragma: public');
		echo $content;


		//Close and output PDF document
		//$pdf->Output('ejournal-'.$datename.'.pdf', 'I');


		$audit_data = "";
		//$audit_term = gethostbyaddr($_SERVER['REMOTE_ADDR']);
		$audit_term = gethostname();
		$audit_ip = $_SERVER['REMOTE_ADDR'];

		$audit_data = "EJOURNAL TXT REPORT";	

		$auditsend = array(
		  'function'   => 'GENERATE REPORT',
		  'description'=> $audit_data,
		  'userid'     => $this->session->userdata('userid'),
		  'ip'   => getenv("REMOTE_ADDR"),
		  'pcname' => $audit_term,
		);

		$result = $this->functions->apiv1($auditsend,"insert_auditlog");




		//============================================================+
		// END OF FILE
		//============================================================+

	}



	public function activitylog(){

	
		if($this->input->post('terminal') == NULL)
		{	
			return;
		}
		$terminal = explode("/", $this->input->post('terminal'));
		$from_date = $this->input->post('from_date');
		$to_date = $this->input->post('to_date');

		$datasend =  array(
				          'terminal'     => $terminal[0],
				          'from_date'     => $from_date,
				          'to_date'     => $to_date,                   
				    );
		$opts = $this->functions->postheader($datasend);

		//$trxn_data = $this->functions->apiv1($datasend,"transaction_records");
		//$trxn_data = $this->functions->apiv1($datasend,"transaction_groupbydate");
		//print_r($trxn_data);
		//return;
		/*HEADER SETUP*/

		$pdf = $this->functions->pdfheader3();
		$pdf->CustomHeaderText = "Activity Log";
		$pdf->TerminalName = $terminal[1];
	    $pdf->DateFrom = $from_date;
	    $pdf->DateTo = $to_date;
	    $pdf->Name = strtoupper($this->session->userdata('firstname').' '. $this->session->userdata('lastname'));



	
	    /////////////////////////////////////////////////////////////////////////////////////////////////////


		// ---------------------------------------------------------
		// add a page
		//page settings


    	$data = file('http://' . $_SERVER['HTTP_HOST'] . '/logs/' . 'general-query' . '.txt');

  


		$pdf->AddPage('P', array(300, count($data) * 3));
		$pdf->SetFont('times', '', 10);

   			
   
		foreach($data as $linetext)
		{	
			if (strpos($linetext, 'st_tbl') !== false) { 
				$pdf->writeHTML($linetext, true, 0, true, true);
				//$pdf->Cell(0,0,$linetext,'',0,'L',0);
				$pdf->ln();
			}


		}



		$audit_data = "";
		//$audit_term = gethostbyaddr($_SERVER['REMOTE_ADDR']);
		$audit_term = gethostname();
		
		$audit_ip = $_SERVER['REMOTE_ADDR'];

		$audit_data = "GENERATE ACTIVITY LOG REPORT";	

		$auditsend = array(
		  'function'   => 'RATES ADDED',
		  'description'=> $audit_data,
		  'userid'     => $this->session->userdata('userid'),
		  'ip'   => getenv("REMOTE_ADDR"),
		  'pcname' => $audit_term,
		);

		$result = $this->functions->apiv1($auditsend,"insert_auditlog");
	


		date_default_timezone_set('Asia/Singapore');
		$datename = date('Y-m-d-H-i-s');

		//Close and output PDF document
		$pdf->Output('activitylog-'.$datename.'.pdf', 'I');


		//============================================================+
		// END OF FILE
		//============================================================+

	}

	public function accountabilitypdf(){

		$terminal = explode("/", $this->input->post('terminal'));;
		$from_date = $this->input->post('from_date');
		$to_date = $this->input->post('to_date');
		$area = $this->input->post('area');

		$datasend =  array(
				          'terminal'     => $terminal[0],
				          'from_date'     => $from_date,
				          'to_date'     => $to_date, 
				          'area'     => $area,                   
				    );
		$opts = $this->functions->postheader($datasend);


		$context  = stream_context_create($opts);
//////////////////////////////////////////////////////////////////
		/*get transaction by rate*/
		$trxn_data = $this->functions->apiv1($datasend,"transaction_groupbyrate");
////////////////////////////////////////////////////////////////////////////////////
		$login_data = $this->functions->apiv1($datasend,"tellerlog_byterminal");
		//return;
		
		/*PDF INITIALIZE*/

		$pdf = $this->functions->pdfheader2();
	    $pdf->CustomHeaderText = "ACCOUNTABILITY REPORT";
	    $pdf->TerminalName = $terminal[1];
	    $pdf->DateFrom = $from_date;
	    $pdf->DateTo = $to_date;
	    $pdf->Name = strtoupper($this->session->userdata('firstname').' '. $this->session->userdata('lastname'));
	    ////////////////////////////////////////////////////////////////////////

		// ---------------------------------------------------------
		// add a page
		$pdf->AddPage('L', 'A4');
 		$pdf->ln(); 		
 		$pdf->SetFont('times', 'B', 10);
 		$pdf->Cell(5,0.15,'','',0,'R',0);
 		$pdf->Cell(25,0.15,'TXN TYPE','TB',0,'C',0);
		$pdf->Cell(5,0.15,'','',0,'R',0);
		$pdf->Cell(20,0.15,'DISCOUNT','TB',0,'L',0);
		$pdf->Cell(5,0.15,'','',0,'R',0);
		$pdf->Cell(37,0.15,'PAYMENTS RECEIVED','TB',0,'L',0);
		$pdf->Cell(5,0.15,'','',0,'R',0);
		$pdf->ln();
		$pdf->SetFont('times', '', 10);
		$tcharge = 0; $tcount = 0; $tvat = 0; $tvatsales = 0; $discount = 0;
		$validsales = 0;
		$voidsales = 0;
		$returnsales = 0;

		$validcnt = 0;

		$voidcnt = 0;
		$returncnt = 0;
		$discount = 0;

		$netamount = 0;
		$grossamount = 0;
		$lessvatadjustment = 0;

		foreach ($trxn_data as  $value) {			
			if($value["process"] == 1 || $value["process"] == 2)
			{
				$validsales += $value["charge"];
				$discount += $value["discount"];



				$pdf->Cell(5,0.15,'','',0,'R',0);
				$pdf->Cell(25,0.15,$value["ratetype"],'',0,'L',0);
				$pdf->Cell(5,0.15,'','',0,'R',0);
				$pdf->Cell(30,0.15,number_format($value["discount"],2),'',0,'L',0);
				$pdf->Cell(37,0.15,number_format($value["charge"],2),'',0,'L',0);
				$pdf->ln();

			}
			if($value["process"] == 98)
			{


				$pdf->Cell(5,0.15,'','',0,'R',0);
				$pdf->Cell(25,0.15,'VOID','TB',0,'L',0);
				$pdf->Cell(5,0.15,'','',0,'R',0);
				$pdf->Cell(5,0.15,'','',0,'R',0);
				$pdf->Cell(37,0.15,"Amount" ,'TB',0,'R',0);
				$pdf->ln();

				$pdf->Cell(5,0.15,'','',0,'R',0);
				$pdf->Cell(25,0.15,$value["ratetype"],'',0,'L',0);
				$pdf->Cell(5,0.15,'','',0,'R',0);
				$pdf->Cell(37,0.15,number_format($value["charge"],2),'',0,'R',0);
				$pdf->ln();$pdf->ln();
				//$voidsales += $value["charge"];
			}
			if($value["process"] == 99)
			{
				$pdf->Cell(5,0.15,'','',0,'R',0);
				$pdf->Cell(25,0.15,'REFUND','TB',0,'L',0);
				$pdf->Cell(5,0.15,'','',0,'R',0);
				$pdf->Cell(5,0.15,'','',0,'R',0);
				$pdf->Cell(37,0.15,"Amount",'TB',0,'R',0);
				$pdf->ln();
				$pdf->Cell(5,0.15,'','',0,'R',0);
				$pdf->Cell(25,0.15,$value["ratetype"],'',0,'L',0);
				$pdf->Cell(5,0.15,'','',0,'R',0);
				$pdf->Cell(37,0.15,number_format($value["charge"],2),'',0,'R',0);
				$pdf->ln();$pdf->ln();
				//$returnsales += $value["charge"];
			}



		//$lessvatadjustment += $value["vatexempt"] * 0.12;
		//$grossamount +=  $value["initcharge"] +  $value["surcharge"] + $value["lostcharge"] + $value["oncharge"];
		//$netamount += $grossamount - $discount - $voidsales - $returnsales - $lessvatadjustment;

		/*$tcharge += $value["charge"];
		$tcount += $value["count"];
		$vat = $value["vatsales"] * 0.12;
		$tvat += $vat;

		$discount += $value["discount"];

		$vatsales = ($value['initcharge'] + $value['surcharge'] + $value['oncharge'] + $value['lostcharge']) / 1.12;
		$tvatsales += $vatsales;*/
		
			

		}




				$pdf->Cell(5,0.15,'','',0,'R',0);
				$pdf->Cell(25,0.15,'TOTAL','TB',0,'L',0);
				$pdf->Cell(5,0.15,'','',0,'R',0);
				$pdf->Cell(20,0.15,number_format($discount,2),'TB',0,'L',0);
				$pdf->Cell(5,0.15,'','',0,'R',0);
				$pdf->Cell(37,0.15,"      " . number_format($validsales,2),'TB',0,'L',0);
				$pdf->ln();$pdf->ln();













        $pdf->SetFont('times', 'B', 12);
        $pdf->Write(0, "ACOUNTABILITY RESULTS:", '', 0, 'L', true, 0, false, false, 0);

 		$pdf->SetFont('times', 'B', 10);
        $pdf->ln();

		$w_align=array("L","L","C","C","C","C","C","C","C","C");
		$w=array(23,25,33,33,20,25,20,45);

		$tableheader=array('TERMINAL','NAME','START DATE','END DATE','VATABLE','DISCOUNT','VAT','AMOUNT RECEIVED');

	    for($i=0;$i<count($tableheader);$i++)
			$pdf->Cell($w[$i],5,$tableheader[$i],'TBLR',0,$w_align[$i]);
	    $pdf->Ln();



	    $pdf->SetFont('times', '', 9);
	    $tcharge = 0; $tcount = 0; $tinit = 0; $ton = 0; $tlost=0; $tsuceed = 0; $tdiscount = 0; $tgross = 0; 
	    $ttotal = 0; $tvat = 0; $texvat = 0;
	    $tvatsales = 0;
	    $ldt = 0;

	    if(count($login_data)!=0)
	    {
	    	//print_r($login_data);
	    	foreach ($login_data as  $value) {
	    	if(!isset($value["logoutdate"]))
	    	{

				if(isset($login_data[$ldt+1]['logindate']))
					$value["logoutdate"] = $login_data[$ldt+1]['logindate'];
				else
					$value["logoutdate"] = $to_date;

	    	}

			$tellerdata =  array(
				  'terminal'	=> $terminal[0],
				  'from_date'	=> $value["logindate"],
				  'to_date'     => $value["logoutdate"],    
				  'tellerid'	=> $value["tellerid"],

			);


	    	///////////////////////////////////////////////////////////////////////////////////
			$ttd = $this->functions->apiv1($tellerdata,"transaction_byteller");


			//return;
			foreach ($ttd as  $ttdvalue)
			{
				if($ttdvalue["process"] == 1 || $ttdvalue["process"] == 2)
					$ttd = $ttdvalue;
			}

			$tcharge += $ttd["charge"];;
			$tinit += $ttd["initcharge"];
			$tsuceed += $ttd["surcharge"];
			$tlost += $ttd["lostcharge"];
			$ton += $ttd["overnight"];
			
			$total = ($ttd["overnight"] +$ttd["lostcharge"] +$ttd["surcharge"] + $ttd["initcharge"]);
			
			$ttotal += $total;

			$vatsales = ($ttd["overnight"] +$ttd["lostcharge"] +$ttd["surcharge"] + $ttd["initcharge"]) / 1.12;
			$tvatsales += $vatsales;
			$tdiscount += $ttd["discount"];
			$exvat = $ttd["vatexempt"] * 0.12;
			$vat = 	$ttd["vatsales"] * 0.12;
	

			if($ttd["count"]>=0)
			{
				$row = array($value["terminalname"],
				$value["firstname"].' '.$value["lastname"],
				$value["logindate"],
				$value["logoutdate"],
				number_format($vatsales,2),
				number_format($ttd["discount"],2),
				number_format($vat,2),
				number_format($ttd["charge"],2),
				"");
			
			for($i=0;$i<count($tableheader);$i++) {
				$pdf->Cell($w[$i],5,$row[$i],0,0,$w_align[$i]);
			}
			$pdf->Ln();

			}

		$ldt++;
	    }
	    }
	    

	  


		$pdf->SetFont('times', 'B', 10);
		$footer=array('','','','TOTAL',
			number_format($tvatsales,2),
			$tdiscount,
			number_format($tvat,2),
			$tcharge);


	    for($i=0;$i<count($tableheader);$i++)
			$pdf->Cell($w[$i],5,$footer[$i],'TB',0,$w_align[$i]);
	    $pdf->Ln();



		date_default_timezone_set('Asia/Singapore');
		$datename = date('Y-m-d-H-i-s');

		//Close and output PDF document
		$pdf->Output('accountability-'.$datename.'.pdf', 'I');


		//============================================================+
		// END OF FILE
		//============================================================+

	}	
	public function autosumpdf(){

		$terminal = explode("/", $this->input->post('terminal'));;
		$from_date = $this->input->post('from_date');
		$to_date = $this->input->post('to_date');
		$area = $this->input->post('area');

		$datasend =  array(
				          'terminal'     => $terminal[0],
				          'from_date'     => $from_date,
				          'to_date'     => $to_date, 
				          'area'     => $area,                   
				    );
		$opts = $this->functions->postheader($datasend);


		$context  = stream_context_create($opts);

////////////////////////////////////////////////////////////////////////////////////
		$login_data = $this->functions->apiv1($datasend,"tellerlog_byterminal");
		//return;
		

		/*SET HEADER HERE*/
		$pdf = $this->functions->pdfheader();
	    $pdf->CustomHeaderText = "AUTOPAY SUMMARY";
	    $pdf->TerminalName = $terminal[1];
	    $pdf->DateFrom = $from_date;
	    $pdf->DateTo = $to_date;
	    $pdf->Name = strtoupper($this->session->userdata('firstname').' '. $this->session->userdata('lastname'));

	    $header = "START DATE,END DATE,START,END,1000,500,200,100,50,20,CASH IN,1000,500,200,100,50,20,10,5,1,CASH OUT,CHARGE";
        $align = "C,C,C,C,C,C,C,C,C,C,C,C,C,C,C,C,C,C,C,C,C,C,C";
	    $width = "33,33,37,37,12,10,10,9,8,8,20,12,10,10,9,8,8,8,8,8,24,20";

	    $pdf->TableHeader = $header;
	    $pdf->TableAlign = $align;
	    $pdf->TableWidth = $width;

	    $tableheader = explode(",", $header);
	    $w_align=explode(",", $align);
	    $w = explode(",", $width);
/*//////////////////////////////////////////////////////////////////////////////////////*/

		// ---------------------------------------------------------
		// add a page
		$pdf->AddPage('L', 'LEGAL');
 		$pdf->ln(); 		
 		
 		$pdf->SetFont('times', 'B', 12);

	    if(count($login_data)!=0)
	    {



   			 $pdf->SetFont('times', '', 10);
	    	foreach ($login_data as  $value) {
	    	if(!isset($value["logoutdate"]))
				$value["logoutdate"] = $to_date;

			$tellerdata =  array(
				  'terminal'	=> $terminal[0],
				  'from_date'	=> $value["logindate"],
				  'to_date'     => $value["logoutdate"],    
				  //'tellerid'	=> $value["tellerid"],

			);

			//			$opts = $this->functions->postheader($datasend);
			//$context  = stream_context_create($opts);

	    	///////////////////////////////////////////////////////////////////////////////////
			$ttd = $this->functions->apiv1($tellerdata,"records_byteller");
			//$ttd = $ttd[0];

			//$tcount += $ttd["count"];
			//$tcharge += $ttd["charge"];



			
			$bills = [1000,500,200,100,50,20];
			$coins = [10,5,1];
			$count=1;
			$recievetotal = [0,0,0,0,0,0];
			$changebilltotal = [0,0,0,0,0,0];
			$changecointotal = [0,0,0];
		
			if(count($ttd) != 0)
			{
				foreach($ttd as $datas)
				{
					if ($count==1) $minor = $datas['receiptnum'];
					$maxor = $datas['receiptnum'];		
					$charge = $datas['charge'];
					if(isset($datas["recieved"]))
					{
						$receivearr = explode(",", $datas['recieved']);

						foreach($receivearr as $x => $val) {
						  	$recievetotal[$x] += $val * $bills[$x];
						}

					}

					if(isset($datas["changebill"]))
					{
						$changearr = explode(",", $datas['changebill']);

						foreach($changearr as $x => $val) {
						  	$changebilltotal[$x] += $val * $bills[$x];
						}

					}

					if(isset($datas["changecoin"]))
					{
						$changecoinarr = explode(",", $datas['changecoin']);

						foreach($changecoinarr as $x => $val) {
						  	$changecointotal[$x] += $val * $coins[$x];
						}

					}


					$count++;
				}
				

				$row = array(
				$value["logindate"],
				$value["logoutdate"],
				$minor,
				$maxor,
				$recievetotal[0],
				$recievetotal[1],
				$recievetotal[2],
				$recievetotal[3],
				$recievetotal[4],
				$recievetotal[5],
				array_sum($recievetotal),
				$changebilltotal[0],
				$changebilltotal[1],
				$changebilltotal[2],
				$changebilltotal[3],
				$changebilltotal[4],
				$changebilltotal[5],
				$changecointotal[0],
				$changecointotal[1],
				$changecointotal[2],
				array_sum($changebilltotal) + array_sum($changecointotal),
				$charge

			);
			
			for($i=0;$i<count($tableheader);$i++) {
				$pdf->Cell($w[$i],6,$row[$i],0,0,$w_align[$i]);
			}
			$pdf->Ln();

			}

	
	    }
	    }
	    

	  


		$pdf->SetFont('times', 'B', 10);
		$footer=array('','TOTAL',"",
			"",
			"",
			"",
			"",
			"",
			"","","","","","","","","","","","","","",
			""

		);


	    for($i=0;$i<count($tableheader);$i++)
			$pdf->Cell($w[$i],5,$footer[$i],'TB',0,$w_align[$i]);
	    $pdf->Ln();



		date_default_timezone_set('Asia/Singapore');
		$datename = date('Y-m-d-H-i-s');

		//Close and output PDF document
		$pdf->Output('accountability-'.$datename.'.pdf', 'I');


		//============================================================+
		// END OF FILE
		//============================================================+

	}	
	public function autoreppdf(){

		$terminal = explode("/", $this->input->post('terminal'));;
		$from_date = $this->input->post('from_date');
		$to_date = $this->input->post('to_date');
		$area = $this->input->post('area');

		$datasend =  array(
				          'terminal'     => $terminal[0],
				          'from_date'     => $from_date,
				          'to_date'     => $to_date, 
				          'area'     => $area,                   
				    );
		$opts = $this->functions->postheader($datasend);


		$context  = stream_context_create($opts);

////////////////////////////////////////////////////////////////////////////////////
		//$login_data = $this->functions->apiv1($datasend,"tellerlog_byterminal");
		//return;
		


		$pdf = $this->functions->pdfheader();
	    $pdf->CustomHeaderText = "AUTOPAY REPORT";
	    $pdf->TerminalName = $terminal[1];
	    $pdf->DateFrom = $from_date;
	    $pdf->DateTo = $to_date;
	    $pdf->Name = strtoupper($this->session->userdata('firstname').' '. $this->session->userdata('lastname'));

	    $header = "PAYMENT DATE,RECEIPT,CARDSERIAL,1000,500,200,100,50,20,CASH IN,1000,500,200,100,50,20,10,5,1,CASH OUT,SHORT,CHARGE";
	    $align = "C,C,C,C,C,C,C,C,C,C,C,C,C,C,C,C,C,C,C,C,C,C,C";
	    $width = "36,40,30,12,10,10,9,8,8,20,12,10,10,9,8,8,8,8,8,24,20,22";

	    $pdf->TableHeader = $header;
	    $pdf->TableAlign = $align;
	    $pdf->TableWidth = $width;

	    $headerarr = explode(",", $header);
	    $w_align=explode(",", $align);
	    $widtharr = explode(",", $width);
		// ---------------------------------------------------------
		// add a page
		$pdf->AddPage('L', 'LEGAL');
 		$pdf->ln(); 		

 		
 		$pdf->SetFont('times', 'B', 12);
		
		//$w=array(36,40,30,12,10,10,9,8,8,20,12,10,10,9,8,8,8,8,8,24,20,22);




	




			$pdf->SetFont('times', '', 10);


		$tellerdata =  array(
			  'terminal'	=> $terminal[0],
	          'from_date'     => $from_date,
	          'to_date'     => $to_date,   
			  //'tellerid'	=> 16,

		);

		//			$opts = $this->functions->postheader($datasend);
		//$context  = stream_context_create($opts);

    	///////////////////////////////////////////////////////////////////////////////////
		$ttd = $this->functions->apiv1($tellerdata,"records_byteller");
		//$ttd = $ttd[0];

		//$tcount += $ttd["count"];
		//$tcharge += $ttd["charge"];



		
		$bills = [1000,500,200,100,50,20];
		$coins = [10,5,1];
		$count=1;
		$recievetotal = [0,0,0,0,0,0];
		$changebilltotal = [0,0,0,0,0,0];
		$changecointotal = [0,0,0];
	
		if(count($ttd) != 0)
		{
			foreach($ttd as $datas)
			{
				$receivearr = explode(",", $datas['recieved']);
				foreach($receivearr as $x => $val) {
					  	$recievetotal[$x] = $val * $bills[$x];
				}

				$changearr = explode(",", $datas['changebill']);
				foreach($changearr as $x => $val) {
					  	$changetotal[$x] = $val * $bills[$x];
				}

				$changecoinarr = explode(",", $datas['changecoin']);
				foreach($changecoinarr as $x => $val) {
					  	$changecointotal[$x] = $val * $coins[$x];
				}


				$row = array(
				$datas["paymentdate"],
				$datas["receiptnum"],
				$datas["cardserial"],
				$recievetotal[0],
				$recievetotal[1],
				$recievetotal[2],
				$recievetotal[3],
				$recievetotal[4],
				$recievetotal[5],
				array_sum($recievetotal),
				$changetotal[0],
				$changetotal[1],
				$changetotal[2],
				$changetotal[3],
				$changetotal[4],
				$changetotal[5],
				$changecointotal[0],
				$changecointotal[1],
				$changecointotal[2],
				array_sum($changetotal) + array_sum($changecointotal),
				$datas["shortchange"],
				$datas["charge"],

				);
		
				for($i=0;$i<count($headerarr);$i++) {
					$pdf->Cell($widtharr[$i],6,$row[$i],0,0,$w_align[$i]);
				}
				$pdf->Ln();

			//	$count++;
			}
			

	
		
	

		}


	  


		$pdf->SetFont('times', 'B', 10);
		$footer=array('','TOTAL',"",
			"",
			"",
			"",
			"",
			"",
			"","","","","","","","","","","","","","",
			""

		);


	    for($i=0;$i<count($headerarr);$i++)
			$pdf->Cell($widtharr[$i],5,$footer[$i],'TB',0,$w_align[$i]);
	    $pdf->Ln();



		date_default_timezone_set('Asia/Singapore');
		$datename = date('Y-m-d-H-i-s');

		//Close and output PDF document
		$pdf->Output('accountability-'.$datename.'.pdf', 'I');


		//============================================================+
		// END OF FILE
		//============================================================+

	}	
	public function dailypdf(){
		return;
		$terminal = explode("/", $this->input->post('terminal'));;


		$from_date = $this->input->post('from_date');
		$to_date = $this->input->post('to_date');
		$area = $this->input->post('area');

		$datasend =  array(
				          'terminal'     => $terminal[0],
				          'from_date'     => $from_date,
				          'to_date'     => $to_date,
				          'area'     => $area,                   
				    );
		//$opts = $this->functions->postheader($datasend);

		//print_r($datasend);
		//$context  = stream_context_create($opts);
//////////////////////////////////////////////////////////////////
		$trxn_data = $this->functions->apiv1($datasend,"transaction_groupbyrate");
		//$url = rtrim(api_url(), "/")."transaction_groupbyrate";
		//$trxn = file_get_contents($url, false, $context);
		//$trxn_data = json_decode($trxn, true);
		//print_r($trxn_data);
		//return;
////////////////////////////////////////////////////////////////////////////////////
		$login_data = $this->functions->apiv1($datasend,"tellerlog_byterminal");
		//$url = rtrim(api_url(), "/")."tellerlog_details";
		//$login = file_get_contents($url, false, $context);
		//$login_data = json_decode($login, true);
		//print_r($login_data);
		//return;
		


		$pdf = $this->functions->pdfheader();
	    $pdf->CustomHeaderText = "DAILY REPORT";
	    $pdf->TerminalName = $terminal[1];
	    $pdf->DateFrom = $from_date;
	    $pdf->DateTo = $to_date;
	    $pdf->Name = strtoupper($this->session->userdata('firstname').' '. $this->session->userdata('lastname'));


		// ---------------------------------------------------------
		// add a page
		$pdf->AddPage('L', 'A4');
 		$pdf->ln(); 		
 		$pdf->SetFont('times', 'B', 10);
 		$pdf->Cell(5,0.15,'','',0,'R',0);
 		$pdf->Cell(25,0.15,'TXN TYPE','TB',0,'C',0);
		$pdf->Cell(5,0.15,'','',0,'R',0);
		$pdf->Cell(20,0.15,'COUNT','TB',0,'L',0);
		$pdf->Cell(30,0.15,'VATATABLE','TB',0,'L',0);
		$pdf->Cell(25,0.15,'VAT','TB',0,'L',0);

		$pdf->Cell(20,0.15,'DISCOUNT','TB',0,'L',0);
		$pdf->Cell(5,0.15,'','',0,'R',0);
		$pdf->Cell(37,0.15,'AMOUNT RECEIVED','TB',0,'L',0);
		$pdf->Cell(5,0.15,'','',0,'R',0);
		$pdf->ln();
		$pdf->SetFont('times', '', 10);
		$tcharge = 0; $tcount = 0; $tvat = 0; $tvatsales = 0; $discount = 0;
		foreach ($trxn_data as  $value) {
			   

			$tcharge += $value["charge"];
			$tcount += $value["count"];
			$vat = $value["vatsales"] * 0.12;
			$tvat += $vat;
			
			$discount += $value["discount"];

           $vatsales = ($value['initcharge'] + $value['surcharge'] + $value['oncharge'] + $value['lostcharge']) / 1.12;
		   $tvatsales += $vatsales;

			$pdf->Cell(5,0.15,'','',0,'R',0);
			$pdf->Cell(25,0.15,$value["ratetype"],'',0,'L',0);
			$pdf->Cell(5,0.15,'','',0,'R',0);
			$pdf->Cell(20,0.15,number_format($value["count"]),'',0,'L',0);
			$pdf->Cell(30,0.15,number_format($vatsales,2),'',0,'L',0);
			$pdf->Cell(25,0.15,number_format($vat,2),'',0,'L',0);
			$pdf->Cell(20,0.15,number_format($value["discount"],2),'',0,'L',0);
			$pdf->Cell(5,0.15,'','',0,'R',0);
			$pdf->Cell(37,0.15,number_format($value["charge"],2),'',0,'L',0);
			$pdf->ln();



		}
		$pdf->Cell(5,0.15,'','',0,'R',0);
		$pdf->Cell(25,0.15,'TOTAL','TB',0,'L',0);
		$pdf->Cell(5,0.15,'','',0,'R',0);
		$pdf->Cell(20,0.15,number_format($tcount),'TB',0,'L',0);
		$pdf->Cell(30,0.15,number_format($tvatsales,2),'TB',0,'L',0);
		$pdf->Cell(25,0.15,number_format($tvat,2),'TB',0,'L',0);
		$pdf->Cell(20,0.15,number_format($discount,2),'TB',0,'L',0);
		$pdf->Cell(5,0.15,'','',0,'R',0);
		$pdf->Cell(37,0.15,number_format($tcharge,2),'TB',0,'L',0);
		$pdf->ln();$pdf->ln();
 		$pdf->ln();
		$pdf->SetFont('times', 'B', 12);
		$pdf->Cell(25,0.15,'CASHIER ACCOUNTABILITY','',0,'L',0);
		$pdf->ln();
		$pdf->ln();

		$pdf->SetFont('times', 'B', 10);

		$tableheader=array('TERMINAL','NAME','COUNT','INITIAL','SUCCEEDING','LOST','OVERNIGHT','TOTAL','VATABLE', 'VAT', 'DISCOUNT', 'AMOUNT RECEIVED');
		$w_align=array("L","L","R","R","R","R","R","R","R","R","R","R");
		$w=array(25,30,17,18,30,15,25,18,22,15,25,38);



	    for($i=0;$i<count($tableheader);$i++)
			$pdf->Cell($w[$i],5,$tableheader[$i],'TBLR',0,$w_align[$i]);
	    $pdf->Ln();
	    $pdf->SetFont('times', '', 10);

	    $tcharge=0;$tcount=0;$tinit=0;$ton=0;$tlost=0;$tsuceed=0;$tdiscount=0;$tgross=0;$tvat=0;$tvatsales=0;
	    $discount=0;
   	    if(count($login_data)!=0)
	    {


	    	foreach ($login_data as  $value) {
	    	if(!isset($value["logoutdate"]))
				$value["logoutdate"] = $to_date;
			$tellerdata =  array(
				  'terminal'	=> $value["terminalid"],
				  'from_date'	=> $value["logindate"],
				  'to_date'     => $value["logoutdate"],    
				  'tellerid'	=> $value["tellerid"],

			);


			//$opts = $this->functions->postheader($datasend);
			//$context  = stream_context_create($opts);

	    	///////////////////////////////////////////////////////////////////////////////////
	    	$ttd = $this->functions->apiv1($tellerdata,"transaction_byteller");
			$ttd = $ttd[0];


			$tcount += $ttd["count"];
			$tcharge += $ttd["charge"];;
			$tinit += $ttd["initcharge"];
			$tsuceed += $ttd["surcharge"];
			$tlost += $ttd["lostcharge"];
			$ton += $ttd["overnight"];
			$vat = $ttd["vatsales"] * 0.12;
			$tvat += $vat;
			$vatsales = ($ttd["overnight"] +$ttd["lostcharge"] +$ttd["surcharge"] + $ttd["initcharge"]) / 1.12;
			$tvatsales += $vatsales;
			$tdiscount += $ttd["discount"];
			//print_r($ttd);
			//return;
 
			$gross = $ttd["initcharge"] + $ttd["surcharge"] + $ttd["lostcharge"] + $ttd["overnight"];
		
			if($ttd["count"]!=0)
			{

				$row = array($value["terminalname"],
					$value["firstname"].' '.$value["lastname"],
					$ttd["count"],$ttd["initcharge"],
					$ttd["surcharge"],$ttd["lostcharge"],
					$ttd["overnight"],number_format($gross,2),
					number_format($vatsales,2),
					number_format($vat,2),
					$ttd["discount"],
					number_format($ttd["charge"],2)
				);
				
				for($i=0;$i<count($row);$i++) {
					$pdf->Cell($w[$i],5,$row[$i],'',0,$w_align[$i]);
				//	$pdf->Cell($w[$i],5,$tableheader[$i],'TBLR',0,$w_align[$i]);
				
				}	
					$pdf->Ln();
			

			}

	
	   	  }
	   	  	$tgross = $tinit + $tsuceed + $tlost + $ton;
	 
	   	  		$pdf->SetFont('times', 'B', 10);
				$tableheader=array('','GRAND TOTAL',
					$tcount,
					$tinit,
					$tsuceed,
					$tlost,
					$ton,
					$tgross,
					number_format($tvatsales,2),
					number_format($tvat,2),
					$tdiscount,
					$tcharge);

			    for($i=0;$i<count($tableheader);$i++)
					$pdf->Cell($w[$i],5,$tableheader[$i],'TB',0,$w_align[$i]);
			    $pdf->Ln();

	    }
	

		date_default_timezone_set('Asia/Singapore');
		$datename = date('Y-m-d-H-i-s');

		//Close and output PDF document
		$pdf->Output('dailyaccountability-'.$datename.'.pdf', 'I');



		//============================================================+
		// END OF FILE
		//============================================================+

	}	
	public function cashierdailypdf(){

		return;
		$userid = $this->input->post('user_id');
		$from_date = $this->input->post('from_date');
		$to_date = $this->input->post('to_date');

		$datasend =  array(
				          'userid'     => $userid,
				          'from_date'     => $from_date,
				          'to_date'     => $to_date,                  
				    );

////////////////////////////////////////////////////////////////////////////////////
		$login_data = $this->functions->apiv1($datasend,"tellerlog_byteller");

		//print_r($login_data);
		//return;

		$pdf = $this->functions->pdfheader();
	    $pdf->CustomHeaderText = "CASHIER DAILY REPORT";
	    //$pdf->TerminalName = $terminal[1];

	    if(count($login_data)>0)
	    	$pdf->TellerName = strtoupper($login_data[0]['firstname'].' '.$login_data[0]['lastname']); 
	    $pdf->DateFrom = $from_date;
	    $pdf->DateTo = $to_date;
	    $pdf->Name = strtoupper($this->session->userdata('firstname').' '. $this->session->userdata('lastname'));


		// ---------------------------------------------------------
		// add a page
		$pdf->AddPage('L', 'A4');
 		$pdf->ln(); 		


		

   

		$tableheader=array('','TXN TYPE','','COUNT','VATATABLE','VAT','DISCOUNT','','AMOUNT RECEIVED');
		$w_align=array("L","L","R","R","R","R","R","R","R","R");
		$border=array("","TB","","TB","TB","TB","TB","","TB","TB");
		$w=array(5,25,5,20,30,15,30,5,45,5);




		//print_r($login_data);
		//return;
		if(count($login_data)>0){
	 		foreach ($login_data as  $value){

 					if(!isset($value["logoutdate"]))
 						$value["logoutdate"] = $to_date;


					$tellerdata =  array(
						'terminal'	=> $value["terminalid"],
						'from_date'	=> $value["logindate"],
						'to_date'     => $value["logoutdate"],    
						'tellerid'	=> $value["tellerid"],
						'area'	=> 0,
					);

			    	$trxndata = $this->functions->apiv1($tellerdata,"transaction_groupbyrate");

			    	if(count($trxndata)>0)
			    	{	
							
		 				$pdf->SetFont('times', 'R', 10);
					    $pdf->Write(0, "TERMINAL:  ".$value['terminalname'], 'TB', 0, 'L', true, 0, false, false, 0);
				 		$pdf->ln(); 

				 		$pdf->Cell(130,0.15,'DATE~~~ Login: '.$value['logindate'].'     Logout: '.$value['logoutdate'],'TB',0,'L');
				 	
				 		$pdf->ln(); 
		 				$pdf->SetFont('times', 'B', 11);
					    for($i=0;$i<count($tableheader);$i++)
							$pdf->Cell($w[$i],0.15,$tableheader[$i],$border[$i],0,$w_align[$i]);
					 	$pdf->ln();


				    	$pdf->SetFont('times', 'R', 10);
				    	$tcount=0; $tvatsales=0; $tdiscount=0; $tvat=0;$tcharge=0;
						foreach ($trxndata as  $data){	
							$tcount+=$data['count'];
							$tvatsales+=$data["vatsales"];
							$tvat+=$data["vatsales"] * 0.12;
							$tdiscount+=$data["discount"];
							$tcharge+=$data["charge"];



							$row = array(
								'',
								$data['ratetype'],
								'',
								$data['count'],
								number_format($data["vatsales"],2),
								number_format($data["vatsales"] * 0.12,2),
								number_format($data["discount"],2),
								'',
								number_format($data["charge"],2),
								'',
							);	

							for($i=0;$i<count($row);$i++) {
								$pdf->Cell($w[$i],5,$row[$i],'',0,$w_align[$i]);	
							}
							$pdf->Ln();
						}

							$footer = array(
								'',
								'TOTAL',
								'',
								$tcount,
								number_format($tvatsales,2),
								number_format($tvat,2),
								number_format($tdiscount,2),
								'',
								number_format($tcharge,2),
								'',
							);	

							for($i=0;$i<count($footer);$i++) {
								$pdf->Cell($w[$i],5,$footer[$i],$border[$i],0,$w_align[$i]);	
							}


					

				

					}

			


					$pdf->ln();
					$pdf->ln();
					
				
					
	 		}

		}
 	



		date_default_timezone_set('Asia/Singapore');
		$datename = date('Y-m-d-H-i-s');

		//Close and output PDF document
		$pdf->Output('shiftaccountability-'.$datename.'.pdf', 'I');

		//============================================================+
		// END OF FILE
		//============================================================+

	}	
}