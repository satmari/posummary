<?php namespace App\Http\Controllers;

use App\Http\Requests;
use App\Http\Controllers\Controller;

// use Illuminate\Http\Request;
use Request;

use App\User;
use Bican\Roles\Models\Role;
use Bican\Roles\Models\Permission;
use Illuminate\Support\Facades\Redirect;
use Auth;

use Maatwebsite\Excel\Facades\Excel;

use App\pro;

use DB;
use Log;
use Session;
use DateTime;

class importController extends Controller {

	public function index() {
		//
		return view('import.index');
	
	}

	public function postImportPro(Request $request) {
		$getSheetName = Excel::load(Request::file('file1'))->getSheetNames();
	    
	    foreach($getSheetName as $sheetName)
	    {
	        //if ($sheetName === 'Product-General-Table')  {
	    	//selectSheetsByIndex(0)
	           	// DB::statement('SET FOREIGN_KEY_CHECKS=0;');
	            //DB::table('users')->truncate();
	
	            //Excel::selectSheets($sheetName)->load($request->file('file'), function ($reader)
	            //Excel::selectSheets($sheetName)->load(Input::file('file'), function ($reader)
	            //Excel::filter('chunk')->selectSheetsByIndex(0)->load(Request::file('file'))->chunk(50, function ($reader)
	            Excel::filter('chunk')->selectSheets($sheetName)->load(Request::file('file1'))->chunk(5000, function ($reader)
	            
	            {
	                $readerarray = $reader->toArray();
	                // var_dump($readerarray);

	                foreach($readerarray as $row)
	                {
	                	// dd($row);
						// if ($row['pro'] == '580644937') {
						// 	dd($row);
						// }
						// dd($row);

	                	$pro = $row['pro'];
	                	// dd($pro);

	                	$existing = DB::connection('sqlsrv')->select(DB::raw("SELECT * FROM pro WHERE pro = '".$row['pro']."' "));
	                	
	                	if (isset($existing[0]->pro)) {
	                		
	                	} else {
	                		continue;
	                		// exit foreach if not exist
	                	}

	                	if (isset($row['pdm_file'])) {
	                		$pdm = $row['pdm_file'];
	                	} else {
	                		$pdm = $existing[0]->pdm;
	                	}

	                	if (isset($row['type'])) {
	                		$type = $row['type'];
	                	} else {
	                		$type = $existing[0]->flash_type;
	                	}

	                	if (isset($row['ex_cost'])) {
	                		$ex_cost = $row['ex_cost'];
	                	} else {
	                		$ex_cost = $existing[0]->ec_cost;
	                	}

	                	if (isset($row['pref_origin'])) {
	                		$pref_origin = $row['pref_origin'];
	                	} else {
	                		$pref_origin = $existing[0]->pref_origin;
	                	}

	                	if ($pref_origin == '0') {
	                		$pref_origin = '000';
	                	}

	                	if (isset($row['released'])) {
	                		$release = $row['released'];
	                	} else {
	                		$release = $existing[0]->release;
	                	}

	                	if (isset($row['sent_to_int'])) {
	                		$sent_to_int = $row['sent_to_int'];
	                	} else {
	                		$sent_to_int = $existing[0]->sent_to_inteos;
	                	}

	                	if (isset($row['tpp_ship'])) {
	                		$tpp_shipments = $row['tpp_ship'];
	                	} else {
	                		$tpp_shipments = $existing[0]->tpp_shipments;
	                	}

	                	if (isset($row['tpp_wastage'])) {
	                		$tpp_wastage = $row['tpp_wastage'];
	                	} else {
	                		$tpp_wastage = $existing[0]->tpp_wastage;
	                	}

	                	if (isset($row['skeda'])) {
	                		$skeda = $row['skeda'];
	                	} else {
	                		$skeda = $existing[0]->skeda;
	                	}

	                	if (isset($row['del_date'])) {
	                		if ($row['del_date'] != NULL) {
	                			
	                			$excelDate =$row['del_date'];
		                		$baseDate = new DateTime('1899-12-30'); // Adjusted base date for Excel
								$excelDateTime = $baseDate->modify("+{$excelDate} days");
								$phpDate = $excelDateTime->format('Y-m-d');
		                		$del_date = $phpDate;
	                		}

	                	} else {
	                		$del_date = $existing[0]->delivery_date;
	                	}
	                	// dd($del_date);

	                	if (isset($row['deleted'])) {
	                		$deleted = $row['deleted'];
	                	} else {
	                		$deleted = $existing[0]->deleted;
	                	}

	                	// else {
	                	// 	if (is_null($row['deleted'])) {
	                	// 		$deleted = '';
	                	// 	} else if ($row['deleted'] == '') {
	                	// 		$deleted = '';
	                	// 	} else {
	                	// 		$deleted = $existing[0]->deleted;
	                	// 	}
	                	// }
	                	
						$sql = DB::connection('sqlsrv')->update(DB::raw("SET NOCOUNT ON;
						UPDATE [posummary].[dbo].[pro]
					          SET
					          pdm = '".$pdm."',
					          flash_type = '".$type."',
					          ec_cost = '".$ex_cost."',
					          pref_origin = '".$pref_origin."',
					          release = '".$release."',
					          sent_to_inteos = '".$sent_to_int."',
					          tpp_shipments = '".$tpp_shipments."',
					          tpp_wastage = '".$tpp_wastage."',
					          skeda = '".$skeda."',
					          delivery_date = '".$del_date."',
					          deleted = '".$deleted."'
					    WHERE pro = '".$pro."' 						
						"));
						

	                }
	            });
	    }
		return redirect('/');

	}

	public function postImportPlo(Request $request) {

		$getSheetName = Excel::load(Request::file('file2'))->getSheetNames();
	    
	    foreach($getSheetName as $sheetName)
	    {
	        //if ($sheetName === 'Product-General-Table')  {
	    	//selectSheetsByIndex(0)
	           	// DB::statement('SET FOREIGN_KEY_CHECKS=0;');
	            //DB::table('users')->truncate();
	
	            //Excel::selectSheets($sheetName)->load($request->file('file'), function ($reader)
	            //Excel::selectSheets($sheetName)->load(Input::file('file'), function ($reader)
	            //Excel::filter('chunk')->selectSheetsByIndex(0)->load(Request::file('file'))->chunk(50, function ($reader)
	            Excel::filter('chunk')->selectSheets($sheetName)->load(Request::file('file2'))->chunk(1000, function ($reader)
	            
	            {
	                $readerarray = $reader->toArray();
	                // var_dump($readerarray);

	                foreach($readerarray as $row)
	                {
	                	// dd($row);
						// if ($row['pro'] == '161699-000') {
						// 	// dd($row['pro']);
						// }

						// }
						$plo = $row['plo'];
						$bom = $row['bom'];
						$routing = $row['routing'];
						$prod_version = $row['prod_ver'];
						
						$sql = DB::connection('sqlsrv')->select(DB::raw("SET NOCOUNT ON;
						UPDATE [posummary].[dbo].[plo]
					          SET
					          bom = '".$bom."',
					          routing = '".$routing."',
					          prod_version = '".$prod_version."'
					        
					    WHERE plo = '".$plo."';
						SELECT TOP 1 [id] FROM [posummary].[dbo].[plo];
						"));

	                }
	            });
	    }
		return redirect('/');

	}

	public function portImportSkedaStatus(Request $request) {
		$getSheetName = Excel::load(Request::file('file3'))->getSheetNames();
	    
	    foreach($getSheetName as $sheetName)
	    {
	        //if ($sheetName === 'Product-General-Table')  {
	    	//selectSheetsByIndex(0)
	           	// DB::statement('SET FOREIGN_KEY_CHECKS=0;');
	            //DB::table('users')->truncate();
	
	            //Excel::selectSheets($sheetName)->load($request->file('file'), function ($reader)
	            //Excel::selectSheets($sheetName)->load(Input::file('file'), function ($reader)
	            //Excel::filter('chunk')->selectSheetsByIndex(0)->load(Request::file('file'))->chunk(50, function ($reader)
	            Excel::filter('chunk')->selectSheets($sheetName)->load(Request::file('file3'))->chunk(1000, function ($reader)
	            
	            {
	                $readerarray = $reader->toArray();
	                // var_dump($readerarray);

	                foreach($readerarray as $row)
	                {
	                	// dd($row);
						// if ($row['pro'] == '161699-000') {
						// 	// dd($row['pro']);
						// }

						// }
						$skeda = $row['skeda'];

						if (!isset($row['skedastatus'])) {
							$skeda_status = '';	
						} else {
							$skeda_status = $row['skedastatus'];	
						}

	
						$existing_skeda = DB::connection('sqlsrv')->select(DB::raw("SELECT id, pro, skeda, skeda_status FROM pro WHERE skeda = '".$skeda."' "));
						// dd($existing_skeda);

						$date = date('Y-m-d');
						// dd($date);

						foreach($existing_skeda as $line) {
							// dd($line);

						 	$id = $line->id;
						 	// dd($id);
						 	$existing_skeda_status = $line->skeda_status;

						 	if ($existing_skeda_status == $skeda_status) {
						 		//continue

						 	} else {
						 		// update

						 		$sql = DB::connection('sqlsrv')->update(DB::raw("
								 	UPDATE [posummary].[dbo].[pro]
					 	  				SET skeda_status = '".$skeda_status."', skeda_status_updated_at = '".$date."'
					 	  			WHERE id = '".$id."' "));

						 	}

						}

						

	                }
	            });
	    }
		return redirect('/');

	}
	
	public function portImportNumberOfLines (Request $request) {
		$getSheetName = Excel::load(Request::file('file4'))->getSheetNames();
	    
	    foreach($getSheetName as $sheetName)
	    {
	        //if ($sheetName === 'Product-General-Table')  {
	    	//selectSheetsByIndex(0)
	           	// DB::statement('SET FOREIGN_KEY_CHECKS=0;');
	            //DB::table('users')->truncate();
	
	            //Excel::selectSheets($sheetName)->load($request->file('file'), function ($reader)
	            //Excel::selectSheets($sheetName)->load(Input::file('file'), function ($reader)
	            //Excel::filter('chunk')->selectSheetsByIndex(0)->load(Request::file('file'))->chunk(50, function ($reader)
	            Excel::filter('chunk')->selectSheets($sheetName)->load(Request::file('file4'))->chunk(1000, function ($reader)
	            
	            {
	                $readerarray = $reader->toArray();
	                // var_dump($readerarray);

	                foreach($readerarray as $row)
	                {
	                	// dd($row);
						// if ($row['pro'] == '161699-000') {
						// 	// dd($row['pro']);
						// }

						// }
						$pro = $row['pro'];
						// $no_lines_by_pro = $row['no_lines_by_pro'];
						$no_lines_by_skeda = $row['linesskeda'];

						$sql = DB::connection('sqlsrv')->select(DB::raw("SET NOCOUNT ON;
						UPDATE [posummary].[dbo].[pro]
					          SET
					          no_lines_by_skeda = 	'".$no_lines_by_skeda."'

					    WHERE pro = '".$pro."';
						SELECT TOP 1 [id] FROM [posummary].[dbo].[pro];
						"));

						// $sql = DB::connection('sqlsrv')->select(DB::raw("SELECT * FROM [posummary].[dbo].[pro]
						// 	WHERE pro = '".$pro."'	"));
						// dd($sql);

	                }
	            });
	    }
		return redirect('/');

	}
}
