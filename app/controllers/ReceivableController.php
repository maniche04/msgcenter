<?php

class ReceivableController extends BaseController {

	/*
	|--------------------------------------------------------------------------
	| Default Home Controller
	|--------------------------------------------------------------------------
	|
	| You may wish to use controllers instead of, or in addition to, Closure
	| based routes. That's great! Here is an example controller method to
	| get you started. To route to this controller, just add the route:
	|
	|	Route::get('/', 'HomeController@showWelcome');
	|
	*/

	public function get_jizcustdata()
	{
		echo '<p style="font-family:Cambria">Opening excel ...</p>';
		//WILL READ EXCEL FILES
		$excel = new COM("Excel.application") or die ("ERROR: Unable to instantaniate   COM!\r\n");
		$excel->Visible = False;
		echo '<p style="font-family:Cambria">Reading file ...</p>';
		$wb = $excel->Workbooks->Open('E:\For Import\Jizan\CInfo.xlsx');
		$wks = $wb->Worksheets(1);
		//voucher number
		$i = 2;
		$j = 3;

		DB::statement("DELETE FROM `jiz_customers`");
		// echo $wks->Cells($i,$j);
		echo '<p style="font-family:Cambria">Will process data now ...</p>';
		echo str_repeat(' ',1024*64);
		flush();
		echo '<div id="information" style="font-family: Cambria"></div>';
		Do {
			$acc_code = (string) ($wks->Cells($i,1));
			$acc_name = (string) ($wks->Cells($i,2));
			$grp = (string) ($wks->Cells($i,3));
			$trd_license = (string) ($wks->Cells($i,4));
			
			//CHECK CREDIT PERIOD
			$temp_crperiod = trim((string) ($wks->Cells($i,5)));
			if (is_null($temp_crperiod) || strlen($temp_crperiod) < 1) {
				$cr_period = -1;
			} elseif (strcasecmp($temp_crperiod,"Open") == 0) {
				$cr_period = -2;
			} else {
				$cr_period = $temp_crperiod;
			}
			
			//CHECK COLLECTION PERIOD
			$temp_colperiod = trim((string) ($wks->Cells($i,6)));
			if (is_null($temp_colperiod) || strlen($temp_colperiod) < 1) {
				$col_period = -1;
			} elseif (strcasecmp($temp_colperiod,"Open") == 0) {
				$col_period = -2;
			} elseif (strcasecmp($temp_colperiod,"Upon Delivery") == 0) {
				$col_period = 0;
			}else {
				$col_period = $temp_colperiod;
			}

			//CHECK CREDIT LIMIT
			$temp_crlimit = trim((string) ($wks->Cells($i,7)));
			if (is_null($temp_crlimit) || strlen($temp_crlimit) < 1) {
				$cr_limit = -1;
			} elseif (strcasecmp($temp_crlimit,"Open") == 0) {
				$cr_limit = -2;
			} elseif (strcasecmp($temp_crlimit,"Upon Delivery") == 0) {
				$cr_limit = 0;
			}else {
				$cr_limit = $temp_crlimit;
			}

			$location = (string) ($wks->Cells($i,8));
			$apr_date = (string) ($wks->Cells($i,9));
			$remarks = (string) ($wks->Cells($i,10));
			$status = (string) ($wks->Cells($i,11));
			
			$values_string = '"' . $acc_code . '","' . $acc_name . '","' . $grp . '","' . $trd_license . '",' . 
							 $cr_period . ',' . $col_period . ',' . $cr_limit . ',"' . $location . '","' . 
							 $apr_date . '","' . $remarks .  '","' . $status . '"';
			
			
			$insert_qry = "INSERT INTO `jiz_customers`(`acc_code`, `accname`, `grp`, `trd_license`, `cr_period`, `col_period`, `cr_limit`, `location`, `apr_date`, `remarks`, `status`) VALUES (" . $values_string . ")";
			DB::statement($insert_qry);
			
			//echo $values_string;
			echo '<script language="javascript">
    			 document.getElementById("information").innerHTML="'.$i.' row(s) processed.";
    			 </script>';
    		echo str_repeat(' ',1024*64);
			flush();
			$i = $i + 1;
		} While (strlen((string) $wks->Cells($i,$j)) > 0); 

		echo '<p style="font-family:Cambria">Closing Excel ...</p>';
		flush();
		//Exit Excel
		$wb->Close();
		$excel->Quit();

		
		
		echo '<p style="font-family:Cambria">';
		return Redirect::to('/jiz/rec');
		echo '</p>';
	}

	public function get_jizcustbal()
	{ 
		echo '<p style="font-family:Cambria">Opening excel ...</p>';
		//WILL READ EXCEL FILES
		$excel = new COM("Excel.application") or die ("ERROR: Unable to instantaniate   COM!\r\n");
		$excel->Visible = False;
		echo '<p style="font-family:Cambria">Reading file ...</p>';
		$wb = $excel->Workbooks->Open('E:\For Import\Jizan\CBalance.XLS');
		$wks = $wb->Worksheets(1);
		//voucher number
		$i = 2;
		$j = 3;

		DB::statement("DELETE FROM `jiz_customers_os`");
		// echo $wks->Cells($i,$j);
		echo '<p style="font-family:Cambria">Will process data now ...</p>';
		echo str_repeat(' ',1024*64);
		flush();
		echo '<div id="information" style="font-family: Cambria"></div>';
		Do {
			$acc_code = (string) ($wks->Cells($i,1));
			$bill_no = (string) ($wks->Cells($i,2));
			
			$dateget = (string) ($wks->Cells($i,3));
			$datestr = (string) substr($dateget,0,10);
			$timestr = substr($dateget,12);
			$date_array = explode('/',$datestr);
			if (isset($date_array[2])) {
				$bill_date = $date_array[2] . '-' . $date_array[1] . "-" . $date_array[0] . " " . $timestr;
			} else {
				$bill_date = time();
			}
			
			
			$acc_name = (string) ($wks->Cells($i,7));
			$cur_amt = ($wks->Cells($i,8));
			
			$values_string = '"' . $acc_code . '","' . $bill_no . '","' . $bill_date . '","' . $acc_name . '",' . 
							 $cur_amt;
			
			$insert_qry = "INSERT INTO `jiz_customers_os`(`acc_code`, `bill_no`, `bill_date`, `acc_name`, `curamt`) VALUES (" . $values_string . ")";
			DB::statement($insert_qry);
			
			//echo $values_string;
			echo '<script language="javascript">
    			 document.getElementById("information").innerHTML="'.$i.' row(s) processed.";
    			 </script>';
    		echo str_repeat(' ',1024*64);
			flush();
			$i = $i + 1;
		} While (strlen((string) $wks->Cells($i,1)) > 0); 

		echo '<p style="font-family:Cambria">Closing Excel ...</p>';
		flush();
		//Exit Excel
		$wb->Close();
		$excel->Quit();

		
		
		echo '<p style="font-family:Cambria">';
		return Redirect::to('/jiz/rec');
		echo '</p>';
	}

	public function get_jizrecanalysis()
	{ 
	}
}
