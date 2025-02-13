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
use App\daily_plan;
use App\margin_analysis;
use App\plm_costings;
use App\future_orders;
use App\bom_cons;
use App\bom_cons_ratio;

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
	                			// dd($row['del_date']);

	                			if ($row['del_date'] < '1900-01-01') {
	                				
	                				$del_date = NULL;

	                			} else {
	                				$excelDate =$row['del_date'];
			                		$baseDate = new DateTime('1899-12-30'); // Adjusted base date for Excel
									$excelDateTime = $baseDate->modify("+{$excelDate} days");
									$phpDate = $excelDateTime->format('Y-m-d');
			                		$del_date = $phpDate;	
	                			}
	                		}

	                	} else {
	                		$del_date = $existing[0]->delivery_date;
	                	}
	                	

	                	if ($del_date < '2000-01-01') {
	                		$del_date = 'NULL';
	                	} else {
	                		$del_date = "'".$del_date."'";
	                	}
	                	// dd($del_date);


	                	if (isset($row['target_date'])) {
	                		if ($row['target_date'] != NULL) {
	                			
	                			if ($row['target_date'] < '1900-01-01') {
	                				
	                				$target_date = NULL;
	                			} else {

	                				$excelDate2 =$row['target_date'];
			                		$baseDate2 = new DateTime('1899-12-30'); // Adjusted base date for Excel
									$excelDateTime2 = $baseDate2->modify("+{$excelDate2} days");
									$phpDate2 = $excelDateTime2->format('Y-m-d');
			                		$target_date = $phpDate2;
	                			}

	                		} else {

	                			$target_date = $existing[0]->target_date;
	                		}

	                	} else {

	                		$target_date = $existing[0]->target_date;
	                	}

	                	if ($target_date < '2000-01-01') {
	                		$target_date = 'NULL';
	                	} else {
	                		$target_date = "'".$target_date."'";
	                	}

	                	// dd($target_date);

	                	if (isset($row['deleted'])) {
	                		$deleted = $row['deleted'];
	                	} else {
	                		$deleted = $existing[0]->deleted;
	                	}

	                	
	                	
						$sql = DB::connection('sqlsrv')->update(DB::raw("
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
					          delivery_date = ".$del_date.",
					          target_date = ".$target_date.",
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

						if (!isset($row['skeda'])) {
							dd('Sekda is empty, please check file that you are importing');
						} 

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

	public function portImportdaily_plan (Request $request) {
		$getSheetName = Excel::load(Request::file('file5'))->getSheetNames();

		// dd($request->request->get('import_date'));
		$import_date = Request::get('import_date');
		// dd($import_date);
		// dd(Request::all());

		// $import_date = $request->input('import_date');
		// dd($import_date);

		// CHECK IF EXIST

		$sql = DB::connection('sqlsrv')->update(DB::raw("
				DELETE FROM [posummary].[dbo].[daily_plans]
				WHERE date = '".$import_date."'"));
	    
	    foreach($getSheetName as $sheetName)
	    {
	        //if ($sheetName === 'Product-General-Table')  {
	    	//selectSheetsByIndex(0)
	           	// DB::statement('SET FOREIGN_KEY_CHECKS=0;');
	            //DB::table('users')->truncate();
	
	            //Excel::selectSheets($sheetName)->load($request->file('file'), function ($reader)
	            //Excel::selectSheets($sheetName)->load(Input::file('file'), function ($reader)
	            //Excel::filter('chunk')->selectSheetsByIndex(0)->load(Request::file('file'))->chunk(50, function ($reader)
	            Excel::filter('chunk')->selectSheets($sheetName)->load(Request::file('file5'))->chunk(1000, function ($reader)
	            
	            {
	                $readerarray = $reader->toArray();
	                // var_dump($readerarray);
	                // $head = $reader->getHeading();
	                // $head = $reader->first()->keys()->toArray();
	                // dd($head);

	                foreach($readerarray as $row)
	                {
	                	// dd($row);
						// if ($row['pro'] == '161699-000') {
						// 	// dd($row['pro']);
						// }

						// }
						$module = trim(strtoupper($row['module']));
						$pro = trim(strtoupper($row['base_code']));
						$style = trim(strtoupper($row['style']));
						$qty = (int)$row['0'];
						$import_date = Request::get('import_date');
						// dd($qty);


						$table = new daily_plan;
						$table->date = $import_date;
						$table->module = $module;
						$table->pro = $pro;
						$table->style = $style;
						$table->qty = $qty;
						$table->save();

						// $sql = DB::connection('sqlsrv')->select(DB::raw("SET NOCOUNT ON;
						// UPDATE [posummary].[dbo].[pro]
					 //          SET
					 //          no_lines_by_skeda = 	'".$no_lines_by_skeda."'

					 //    WHERE pro = '".$pro."';
						// SELECT TOP 1 [id] FROM [posummary].[dbo].[pro];
						// "));

						// $sql = DB::connection('sqlsrv')->select(DB::raw("SELECT * FROM [posummary].[dbo].[pro]
						// 	WHERE pro = '".$pro."'	"));
						// dd($sql);

	                }
	            });
	    }
		return redirect('/');
	}

	public function post_margin_analysis (Request $request) {
		$getSheetName = Excel::load(Request::file('file6'))->getSheetNames();

		// dd($request->request->get('import_date'));
		$import_date = Request::get('date');
		// dd($import_date);
		// dd(Request::all());

		// $import_date = $request->input('import_date');
		// dd($import_date);

		// CHECK IF EXIST

		// $sql = DB::connection('sqlsrv')->update(DB::raw("
		// 		DELETE FROM [posummary].[dbo].[daily_plans]
		// 		WHERE date = '".%date."'"));
	    
	    foreach($getSheetName as $sheetName)
	    {
	        //if ($sheetName === 'Product-General-Table')  {
	    	//selectSheetsByIndex(0)
	           	// DB::statement('SET FOREIGN_KEY_CHECKS=0;');
	            //DB::table('users')->truncate();
	
	            //Excel::selectSheets($sheetName)->load($request->file('file'), function ($reader)
	            //Excel::selectSheets($sheetName)->load(Input::file('file'), function ($reader)
	            //Excel::filter('chunk')->selectSheetsByIndex(0)->load(Request::file('file'))->chunk(50, function ($reader)
	            Excel::filter('chunk')->selectSheets($sheetName)->load(Request::file('file6'))->chunk(10000, function ($reader)
	            
	            {
	                $readerarray = $reader->toArray();
	                // var_dump($readerarray);
	                // $head = $reader->getHeading();
	                // $head = $reader->first()->keys()->toArray();
	                // dd($readerarray);

	                foreach($readerarray as $row)
	                {
	                	
						// if ($row['pro'] == '161699-000') {
						// 	// dd($row['pro']);
						// }

						// dd($row);

						$date = Request::get('date');

						$material = trim($row['material']);

						if ($material == 'Grand Total') {
							exit;
							// dd($row);
						}

						$plant_det = trim($row['plant_det']);
						$profit_center_summary = trim($row['profit_center_summary']);

						$sales_value = (float)$row['sales_value'];
						$sales_qty = (float)$row['sales_qty'];
						$sales_unit_price = (float)$row['sales_unit_price'];
						$std_cogs_mbew = (float)$row['std_cogs_mbew'];
						$std_pro_mat = (float)$row['std_pro_mat'];
						$std_pro_prd = (float)$row['std_pro_prd'];
						$std_cogs_pro = (float)$row['std_cogs_pro'];
						$std_cogs = (float)$row['std_cogs'];
						$gross_std_margin = (float)$row['gross_std_margin'];
						$stdmarg = (float)$row['stdmarg']; //?
						// dd($percentage);
						$var_recipe_mat = (float)$row['var_recipe_mat'];
						$var_recipe_prd = (float)$row['var_recipe_prd'];
						$var_efficiency_mat = (float)$row['var_efficiency_mat'];
						$var_efficiency_prd = (float)$row['var_efficiency_prd'];
						$var_price_mat = (float)$row['var_price_mat'];
						$var_price_prd = (float)$row['var_price_prd'];
						$var_exc_rate = (float)$row['var_exc_rate'];
						$var_tot = (float)$row['var_tot'];
						$gross_act_margin = (float)$row['gross_act_margin'];
						$actmarg = (float)$row['actmarg']; //?

						$unit_std = (float)$row['unit_std'];
						$unit_var = (float)$row['unit_var'];

						$mtype = trim($row['mtype']);
						$ck = trim($row['ck']);
						$mat_category = trim($row['mat_category']);
						$mat_brand = trim($row['mat_brand']);
						$material_article = trim($row['material_article']);

						$sales_min_tot = (float)$row['sales_min_tot'];
						$sales_min_special_ord = (float)$row['sales_min_special_ord'];
						$special_ord = (float)$row['special_ord'];
						
						// dd('stop');


						$table = new margin_analysis;
						$table->date = $date;
						$table->material = $material;
						$table->plant_det = $plant_det;
						$table->profit_center_summary = $profit_center_summary;

						$table->sales_value = $sales_value;
						$table->sales_qty = $sales_qty;
						$table->sales_unit_price = $sales_unit_price;
						$table->std_cogs_mbew = $std_cogs_mbew;
						$table->std_pro_mat = $std_pro_mat;
						$table->std_pro_prd = $std_pro_prd;
						$table->std_cogs_pro = $std_cogs_pro;
						$table->std_cogs = $std_cogs;
						$table->gross_std_margin = $gross_std_margin;
						$table->stdmarg = $stdmarg;

						$table->var_recipe_mat = $var_recipe_mat;
						$table->var_recipe_prd = $var_recipe_prd;
						$table->var_efficiency_mat = $var_efficiency_mat;
						$table->var_efficiency_prd = $var_efficiency_prd;
						$table->var_price_mat = $var_price_mat;
						$table->var_price_prd = $var_price_prd;
						$table->var_exc_rate = $var_exc_rate;
						$table->var_tot = $var_tot;
						$table->gross_act_margin = $gross_act_margin;
						$table->actmarg = $actmarg;

						$table->unit_std = $unit_std;
						$table->unit_var = $unit_var;

						$table->mtype = $mtype;
						$table->ck = $ck;
						$table->mat_category = $mat_category;
						$table->mat_brand = $mat_brand;
						$table->material_article = $material_article;

						$table->sales_min_tot = $sales_min_tot;
						$table->sales_min_special_ord = $sales_min_special_ord;
						$table->special_ord = $special_ord;

						$table->save();
	                }
	            });
	    }

	    dd('Succesfuly imported,  (please close this page/tab because if you refresh it will import again) ');
		// return redirect('/');
	}

	public function post_plm_costing (Request $request) {
		$getSheetName = Excel::load(Request::file('file7'))->getSheetNames();

		// dd($request->request->get('import_date'));
		// $import_date = Request::get('date');
		// dd($import_date);
		// dd(Request::all());

		// $import_date = $request->input('import_date');
		// dd($import_date);

		// CHECK IF EXIST

		// $sql = DB::connection('sqlsrv')->update(DB::raw("
		// 		DELETE FROM [posummary].[dbo].[daily_plans]
		// 		WHERE date = '".%date."'"));
	    
	    foreach($getSheetName as $sheetName)
	    {
	        //if ($sheetName === 'Product-General-Table')  {
	    	//selectSheetsByIndex(0)
	           	// DB::statement('SET FOREIGN_KEY_CHECKS=0;');
	            DB::table('plm_costings')->truncate();
	
	            //Excel::selectSheets($sheetName)->load($request->file('file'), function ($reader)
	            //Excel::selectSheets($sheetName)->load(Input::file('file'), function ($reader)
	            //Excel::filter('chunk')->selectSheetsByIndex(0)->load(Request::file('file'))->chunk(50, function ($reader)
	            Excel::filter('chunk')->selectSheets($sheetName)->load(Request::file('file7'))->chunk(10000, function ($reader)
	            
	            {
	                $readerarray = $reader->toArray();
	                // var_dump($readerarray);
	                // $head = $reader->getHeading();
	                // $head = $reader->first()->keys()->toArray();
	                // dd($readerarray);

	                foreach($readerarray as $row)
	                {
	                	
						// if ($row['pro'] == '161699-000') {
						// 	// dd($row['pro']);
						// }

						// dd($row);
						
						$fg_item = trim($row['fg_item']);
						$key_fg_pv_size_color_flash = trim($row['key_fg_pv_size_color_flash']);
						$color_code = trim($row['color_code']);
						$color = trim($row['color']);
						$stylecolor = trim($row['stylecolor']);
						$latest_version_status = trim($row['latest_version_status']);
						$ordertype = trim($row['order_type']);

						$operations_cost_eur = (float)$row['operations_cost_eur'];
						$operations_cost = (float)$row['operations_cost'];
						$material_cost_eur = (float)$row['material_cost_eur'];
						$material_cost = (float)$row['material_cost'];
						$total_cost = (float)$row['total_cost'];

						// dd('stop');

						$table = new plm_costings;

						$table->fg_item = $fg_item;
						$table->key_fg_pv_size_color_flash = $key_fg_pv_size_color_flash;
						$table->color_code = $color_code;
						$table->color = $color;
						$table->stylecolor = $stylecolor;
						$table->latest_version_status = $latest_version_status;
						$table->ordertype = $ordertype;
						
						$table->operations_cost_eur = $operations_cost_eur;
						$table->operations_cost = $operations_cost;
						$table->material_cost_eur = $material_cost_eur;
						$table->material_cost = $material_cost;
						$table->total_cost = $total_cost;
					
						$table->save();
	                }
	            });
	    }

	    dd('Succesfuly imported,  (please close this page/tab because if you refresh it will import again) ');
		// return redirect('/');
	}

	public function portImportfuture_orders(Request $request) {
		$getSheetName = Excel::load(Request::file('file8'))->getSheetNames();

		// dd($request->request->get('import_date'));
		// $order_group_macro = Request::get('order_group_macro');
		// $order_group = Request::get('order_group');

		// dd($order_group);

		// dd($import_date);
		// dd(Request::all());

		// $import_date = $request->input('import_date');
		// dd($import_date);

		// CHECK IF EXIST

		// $sql = DB::connection('sqlsrv')->update(DB::raw("
		// 		DELETE FROM [posummary].[dbo].[daily_plans]
		// 		WHERE date = '".$import_date."'"));
	    
	    foreach($getSheetName as $sheetName)
	    {
	        //if ($sheetName === 'Product-General-Table')  {
	    	//selectSheetsByIndex(0)
	           	// DB::statement('SET FOREIGN_KEY_CHECKS=0;');
	            //DB::table('users')->truncate();
	
	            //Excel::selectSheets($sheetName)->load($request->file('file'), function ($reader)
	            //Excel::selectSheets($sheetName)->load(Input::file('file'), function ($reader)
	            //Excel::filter('chunk')->selectSheetsByIndex(0)->load(Request::file('file'))->chunk(50, function ($reader)
	            Excel::filter('chunk')->selectSheets($sheetName)->load(Request::file('file8'))->chunk(1000, function ($reader)
	            
	            {
	                $readerarray = $reader->toArray();
	                // var_dump($readerarray);
	                // $head = $reader->getHeading();
	                // $head = $reader->first()->keys()->toArray();
	                // dd($head);

	                foreach($readerarray as $row)
	                {
	                	// dd($row);

	                	// $order_group_macro;
	                	// $order_group;


						$tda = $row['tda'];
						$season = trim($row['season']);
						$sku = trim($row['sku']);
						if ($sku == '') {
	                		continue;
	                	}
						$description = trim($row['description']);
						$qty = (int)$row['qty'];
						$smv = (float)$row['smv'];
						$total_minutes = (float)$row['total_minutes'];

						// $delivery = $row['delivery'];
						if ($row['delivery'] < '1900-01-01') {
	                				
            				$delivery = NULL;
            			} else {

            				$excelDate2 =$row['delivery'];
	                		$baseDate2 = new DateTime('1899-12-30'); // Adjusted base date for Excel
							$excelDateTime2 = $baseDate2->modify("+{$excelDate2} days");
							$phpDate2 = $excelDateTime2->format('Y-m-d');
	                		$delivery = $phpDate2;
            			}
            			// dd($delivery);

						// $rma_standard = $row['rma_standard'];
						if ($row['rma_standard'] < '1900-01-01') {
	                				
            				$rma_standard = NULL;
            			} else {

            				$excelDate2 =$row['rma_standard'];
	                		$baseDate2 = new DateTime('1899-12-30'); // Adjusted base date for Excel
							$excelDateTime2 = $baseDate2->modify("+{$excelDate2} days");
							$phpDate2 = $excelDateTime2->format('Y-m-d');
	                		$rma_standard = $phpDate2;
            			}
						// dd($rma_standard);

						$flash_price = $row['flash_price'];
						
						// dd($qty);
						$order_group_macro = Request::get('order_group_macro');
						$order_group = Request::get('order_group');

						$table = new future_orders;
						$table->tda = $tda;
						$table->season = $season;
						$table->sku = $sku;
						$table->description = $description;
						$table->qty = $qty;
						$table->smv = $smv;
						$table->total_minutes = $total_minutes;
						$table->delivery = $delivery;
						$table->rma_standard = $rma_standard;
						$table->flash_price = $flash_price;
						$table->order_group_macro = $order_group_macro;
						$table->order_group = $order_group;
						$table->status = 'NEW';

						$table->save();
						
	                }
	            });
	    }
	    dd('Succesfuly imported,  (please close this page/tab because if you refresh it will import again) ');
		// return redirect('/');
	}

	public function portUpdatefuture_orders(Request $request) {
		$getSheetName = Excel::load(Request::file('file11'))->getSheetNames();

		// dd($request->request->get('import_date'));
		// $order_group_macro = Request::get('order_group_macro');
		// $order_group = Request::get('order_group');

		// dd($order_group);

		// dd($import_date);
		// dd(Request::all());

		// $import_date = $request->input('import_date');
		// dd($import_date);

	    foreach($getSheetName as $sheetName)
	    {
	        //if ($sheetName === 'Product-General-Table')  {
	    	//selectSheetsByIndex(0)
	           	// DB::statement('SET FOREIGN_KEY_CHECKS=0;');
	            //DB::table('users')->truncate();
	
	            //Excel::selectSheets($sheetName)->load($request->file('file'), function ($reader)
	            //Excel::selectSheets($sheetName)->load(Input::file('file'), function ($reader)
	            //Excel::filter('chunk')->selectSheetsByIndex(0)->load(Request::file('file'))->chunk(50, function ($reader)
	            Excel::filter('chunk')->selectSheets($sheetName)->load(Request::file('file11'))->chunk(10000, function ($reader)
	            
	            {
	                $readerarray = $reader->toArray();
	                // var_dump($readerarray);
	                // $head = $reader->getHeading();
	                // $head = $reader->first()->keys()->toArray();
	                // dd($head);

	                foreach($readerarray as $row)
	                {
	                	// dd($row);
	                	$id = $row['id'];

	                	if (isset($row['main_mat'])) {
	                		$main_mat = trim($row['main_mat']);	

	                		$table = future_orders::findOrFail($id);
							$table->main_mat = $main_mat;
							$table->save();
	                	}

						if (isset($row['smv_fr'])) {
							$smv_fr = round($row['smv_fr'],3);

	                		$table = future_orders::findOrFail($id);
							$table->smv_fr = $smv_fr;
							$table->save();
						}

						if (isset($row['qty'])) {
							$qty = round($row['qty'],0);

	                		$table = future_orders::findOrFail($id);
							$table->qty = $qty;
							$table->save();
						}
	                }
	            });
	    }
	    dd('Succesfuly imported,  (please close this page/tab because if you refresh it will import again) ');
		// return redirect('/');
	}

	public function bom_cons_post(Request $request) {
		$getSheetName = Excel::load(Request::file('file9'))->getSheetNames();

		// dd($request->request->get('import_date'));
		// $order_group_macro = Request::get('order_group_macro');
		// $order_group = Request::get('order_group');

		// dd($order_group);

		// dd($import_date);
		// dd(Request::all());

		// $import_date = $request->input('import_date');
		// dd($import_date);

		// CHECK IF EXIST

		// $sql = DB::connection('sqlsrv')->update(DB::raw("
		// 		DELETE FROM [posummary].[dbo].[daily_plans]
		// 		WHERE date = '".$import_date."'"));
	    
	    foreach($getSheetName as $sheetName)
	    {
	        //if ($sheetName === 'Product-General-Table')  {
	    	//selectSheetsByIndex(0)
	           	// DB::statement('SET FOREIGN_KEY_CHECKS=0;');
	            //DB::table('users')->truncate();
	
	            //Excel::selectSheets($sheetName)->load($request->file('file'), function ($reader)
	            //Excel::selectSheets($sheetName)->load(Input::file('file'), function ($reader)
	            //Excel::filter('chunk')->selectSheetsByIndex(0)->load(Request::file('file'))->chunk(50, function ($reader)
	            Excel::filter('chunk')->selectSheets($sheetName)->load(Request::file('file9'))->chunk(10000, function ($reader)
	            
	            {
	                $readerarray = $reader->toArray();
	                // var_dump($readerarray);
	                // $head = $reader->getHeading();
	                // $head = $reader->first()->keys()->toArray();
	                // dd($head);

	                foreach($readerarray as $row)
	                {
	                	// dd($row);

						$order = $row['order'];
						$style = trim($row['style']);
						$material = trim($row['material']);
						$father = trim($row['father']);

						$main = round((float)$row['main'],3);
						$pas_ag = round((float)$row['pas_ag'],3);
						$ploce = round((float)$row['ploce'],3);
						$total_cons = round((float)$row['total_cons'],3);

						$table = new bom_cons;
						$table->order = $order;
						$table->style = $style;
						$table->material = $material;
						$table->father = $father;
						
						$table->main = $main;
						$table->pas_ag = $pas_ag;
						$table->ploce = $ploce;
						$table->total_cons = $total_cons;
						
						$table->save();
						
	                }
	            });
	    }
	    dd('Succesfuly imported,  (please close this page/tab because if you refresh it will import again) ');
		// return redirect('/');
	}

	public function bom_cons_ratio_post(Request $request) {
		$getSheetName = Excel::load(Request::file('file10'))->getSheetNames();

		// dd($request->request->get('import_date'));
		// $order_group_macro = Request::get('order_group_macro');
		// $order_group = Request::get('order_group');

		// dd($order_group);

		// dd($import_date);
		// dd(Request::all());

		// $import_date = $request->input('import_date');
		// dd($import_date);

		// CHECK IF EXIST

		// $sql = DB::connection('sqlsrv')->update(DB::raw("
		// 		DELETE FROM [posummary].[dbo].[daily_plans]
		// 		WHERE date = '".$import_date."'"));
	    
	    foreach($getSheetName as $sheetName)
	    {
	        //if ($sheetName === 'Product-General-Table')  {
	    	//selectSheetsByIndex(0)
	           	// DB::statement('SET FOREIGN_KEY_CHECKS=0;');
	            //DB::table('users')->truncate();
	
	            //Excel::selectSheets($sheetName)->load($request->file('file'), function ($reader)
	            //Excel::selectSheets($sheetName)->load(Input::file('file'), function ($reader)
	            //Excel::filter('chunk')->selectSheetsByIndex(0)->load(Request::file('file'))->chunk(50, function ($reader)
	            Excel::filter('chunk')->selectSheets($sheetName)->load(Request::file('file10'))->chunk(10000, function ($reader)
	            
	            {
	                $readerarray = $reader->toArray();
	                // var_dump($readerarray);
	                // $head = $reader->getHeading();
	                // $head = $reader->first()->keys()->toArray();
	                // dd($head);

	                foreach($readerarray as $row)
	                {
	                	// dd($row);

						$skeda = $row['skeda'];

						$total = round((float)$row['total'],1);
						$size_xs = round((float)$row['size_xs'],1);
						$size_s = round((float)$row['size_s'],1);
						$size_m = round((float)$row['size_m'],1);
						$size_l = round((float)$row['size_l'],1);
						$size_xl = round((float)$row['size_xl'],1);
						$size_xxl = round((float)$row['size_xxl'],1);
						$size_sm = round((float)$row['size_sm'],1);
						$size_ml = round((float)$row['size_ml'],1);
						$size_xssho = round((float)$row['size_xssho'],1);
						$size_ssho = round((float)$row['size_ssho'],1);
						$size_msho = round((float)$row['size_msho'],1);
						$size_lsho = round((float)$row['size_lsho'],1);
						$size_tu = round((float)$row['size_tu'],1);
						$size_2y = round((float)$row['size_2y'],1);
						$size_3_4y = round((float)$row['size_3_4y'],1);
						$size_5_6y = round((float)$row['size_5_6y'],1);
						$size_7_8y = round((float)$row['size_7_8y'],1);
						$size_9_10y = round((float)$row['size_9_10y'],1);
						$size_11_12y = round((float)$row['size_11_12y'],1);
						$size_2 = round((float)$row['size_2'],1);
						$size_3 = round((float)$row['size_3'],1);
						$size_4 = round((float)$row['size_4'],1);
						$size_5 = round((float)$row['size_5'],1);
						$size_6 = round((float)$row['size_6'],1);
						$size_12 = round((float)$row['size_12'],1);
						$size_34 = round((float)$row['size_34'],1);

						
						$table = new bom_cons_ratio;
						
						$table->skeda = $skeda;
						$table->total = $total;
						$table->size_xs = $size_xs;
						$table->size_s = $size_s;
						$table->size_m = $size_m;
						$table->size_l = $size_l;
						$table->size_xl = $size_xl;
						$table->size_xxl = $size_xxl;
						$table->size_sm = $size_sm;
						$table->size_ml = $size_ml;
						$table->size_xssho = $size_xssho;
						$table->size_ssho = $size_ssho;
						$table->size_msho = $size_msho;
						$table->size_lsho = $size_lsho;
						$table->size_tu = $size_tu;
						$table->size_2y = $size_2y;
						$table->size_3_4y = $size_3_4y;
						$table->size_5_6y = $size_5_6y;
						$table->size_7_8y = $size_7_8y;
						$table->size_9_10y = $size_9_10y;
						$table->size_11_12y = $size_11_12y;
						$table->size_2 = $size_2;
						$table->size_3 = $size_3;
						$table->size_4 = $size_4;
						$table->size_5 = $size_5;
						$table->size_6 = $size_6;
						$table->size_12 = $size_12;
						$table->size_34 = $size_34;
												
						$table->save();
						
	                }
	            });
	    }
	    dd('Succesfuly imported,  (please close this page/tab because if you refresh it will import again) ');
		// return redirect('/');
	}
}
