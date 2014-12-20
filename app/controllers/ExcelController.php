<?php

class ExcelController extends BaseController {

	/*
	|--------------------------------------------------------------------------
	| EXCEL CONTROLLER
	|--------------------------------------------------------------------------
	|
	| GENERATES ALL THE EXCEL BASED REPORTS
	|
	*/

	public function lossReport()
	{
		
		echo '<p style="font-family:Cambria">Opening excel ...</p>';
		//WILL READ EXCEL FILES
		$excel = new COM("Excel.application") or die ("ERROR: Unable to instantaniate   COM!\r\n");
		$excel->Visible = False;
		echo '<p style="font-family:Cambria">Reading file ...</p>';
		$wb = $excel->Workbooks->Open('E:\For Import\Inter City\Loss Report\SR-InvoiceWise.XLS');
		$wks = $wb->Worksheets(1);
		//voucher number
		$i = 2;
		$j = 3;

		//DB::statement("DELETE FROM `sr_invoicewise`");
		// echo $wks->Cells($i,$j);
		echo '<p style="font-family:Cambria">Will process data now ...</p>';
		echo str_repeat(' ',1024*64);
		flush();
		echo '<div id="information" style="font-family: Cambria"></div>';
		Do {
			$fy_code = ($wks->Cells($i,1));
			$trc_code = ($wks->Cells($i,2));
			$vr_no = ($wks->Cells($i,3));
			$dateget = (string) ($wks->Cells($i,4));
			$datestr = (string) substr($dateget,0,10);
			$timestr = substr($dateget,12);
			$date_array = explode('/',$datestr);
			//echo var_dump($date_array);
			//$time_array = explode(':',$timestr);
			$vr_date = $date_array[2] . '-' . $date_array[1] . "-" . $date_array[0] . " " . $timestr;
			$trc_name = ($wks->Cells($i,5));
			$code = (string) ($wks->Cells($i,6));
			$accname = (string) ($wks->Cells($i,7));
			$discount = ($wks->Cells($i,8));
			$saleamt = ($wks->Cells($i,9));
			$amt = ($wks->Cells($i,10));
			$qty = ($wks->Cells($i,11));
			$salesman = ($wks->Cells($i,12));
			$values_string = "'" . $trc_code . "'," . $vr_no . ",'" . $vr_date . "','" . $trc_name
							 . "','" . $code .  "','" . $accname . "'," . $discount . "," . $saleamt . ","
							 . $amt . "," . $qty . ",'" . $salesman . "'";
			
			$check_qry = "SELECT * FROM sr_invoicewise WHERE vr_no = " . $vr_no;
			if (!DB::Select($check_qry)) {
				$insert_qry = "INSERT INTO sr_invoicewise (`trc_code`, `vr_no`, `vr_date`, `trc_name`, `code`, 
						`accname`, `discount`, `saleamt`, `amt`, `qty`, `salesman`) VALUES (" . $values_string . ")";
				DB::statement($insert_qry);
			}
			
			echo '<script language="javascript">
    			 document.getElementById("information").innerHTML="'.$i.' row(s) processed.";
    			 </script>';
    		echo str_repeat(' ',1024*64);
			flush();
			$i = $i + 1;
		} While (!is_null($wks->Cells($i,$j)) && strlen($wks->Cells($i,$j) > 0)); 

		echo '<p style="font-family:Cambria">Closing Excel ...</p>';
		flush();
		//Exit Excel
		$wb->Close();
		$excel->Quit();

		//echo '<p style="font-family:Cambria">Redirecting ...</p>';
		
		echo '<p style="font-family:Cambria">';
		return Redirect::to('/salesreport');
		echo '</p>';
	}


	public function xllossReport() {
		//WILL READ EXCEL FILES
		$excel = new COM("Excel.application") or die ("ERROR: Unable to instantaniate   COM!\r\n");
		$excel->Visible = True;
		$wb = $excel->Workbooks->Add();
		$wks = $wb->Worksheets->Add();
		$wks->Name = "Loss Report";

		$i = 1;
		$j = 1;

		$wks->Cells(1,1)->Value = "INTER CITY PERFUMES LLC";
		$wks->Cells(2,1)->Value = "INVOICE WISE LOSS REPORT";
		$wks->Cells(3,1)->Value = "FOR THE SALES DATED " . Date('Y-m-d');

		//REDIRECT
		return Redirect::to('/lossreport');
	}
}


