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

use App\mb51_all;

use DB;
use Log;
use Session;
use DateTime;

class import_sapController extends Controller {

	public function index() {
		//
		return view('import.index_sap');
	}

	public function postImport_mb51(Request $request) {
		$getSheetName = Excel::load(Request::file('file1'))->getSheetNames();
	    // dd($getSheetName);

	    foreach($getSheetName as $sheetName)
	    {
	        //if ($sheetName === 'Product-General-Table')  {
	    	//selectSheetsByIndex(0)
	           	// DB::statement('SET FOREIGN_KEY_CHECKS=0;');
	            // DB::table('users')->truncate();
	
	            // Excel::selectSheets($sheetName)->load($request->file('file'), function ($reader)
	            // Excel::selectSheets($sheetName)->load(Input::file('file'), function ($reader)
	            // Excel::filter('chunk')->selectSheetsByIndex(0)->load(Request::file('file'))->chunk(50, function ($reader)
	            Excel::filter('chunk')->selectSheets($sheetName)->load(Request::file('file1'))->chunk(10000, function ($reader)
	            
	            {
	                $readerarray = $reader->toArray();
	                // var_dump($readerarray);

	                foreach($readerarray as $row) {
	                	// dd($row);

						if ($row['material'] == '') {
							dd($row);
							continue;
						}

						
						if (isset($row['posting_date'])) {
	                		if ($row['posting_date'] != NULL) {
	                			// dd($row['del_date']);

	                			if ($row['posting_date'] < '1900-01-01') {
	                				
	                				$posting_date = NULL;

	                			} else {
	                				$excelDate =$row['posting_date'];
			                		$baseDate = new DateTime('1899-12-30'); // Adjusted base date for Excel
									$excelDateTime = $baseDate->modify("+{$excelDate} days");
									$phpDate = $excelDateTime->format('Y-m-d');
			                		$posting_date = $phpDate;	
	                			}
	                		}

	                	} else {
	                		$posting_date = NULL;
	                	}
	                	

	                	// dd($posting_date);

	                	$material_document = $row['material_document'];
	                	$material = $row['material'];
	                	$storage_location = $row['storage_location'];
	                	$movement_type = $row['movement_type'];
	                	$pro = $row['order'];
	                	$batch = $row['batch'];
	                	$qty = round((float)$row['qty_in_unit_of_entry'],2);

	                	// dd($qty);

						$table = new mb51_all;
						$table->posting_date = $posting_date;
						$table->material_document = $material_document;
						$table->material = $material;
						$table->storage_location = $storage_location;
						$table->movement_type = $movement_type;
						$table->pro = $pro;
						$table->batch = $batch;
						$table->qty = $qty;
						$table->save();

	                }
	            });
	    }
		// return redirect('/');
		dd('Import MB51_all Done');

	}
}
