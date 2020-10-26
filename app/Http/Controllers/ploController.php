<?php namespace App\Http\Controllers;

use App\Http\Requests;
use App\Http\Controllers\Controller;

use Illuminate\Http\Request;

use App\User;
use Bican\Roles\Models\Role;
use Bican\Roles\Models\Permission;
use Illuminate\Support\Facades\Redirect;
use Auth;

use App\pro;
use App\plo;

use DB;
use Log;
use Session;

class ploController extends Controller {

	public function index()
	{
		//
		// dd("polako, nije PLO tabela jos gotova");

		$data = DB::connection('sqlsrv')->select(DB::raw("SELECT * FROM [posummary].[dbo].[plo] "));
		return view('PLO.index', compact('data'));
	}

	public function update_plo()
	{
		//
		$data_fr = DB::connection('sqlsrv1')->select(DB::raw("SELECT  --o.*
				--o.ORDER_ID
				o.ORDER_NAME as plo_fr
				--,o.ORIGINAL_NAME
				--,o.PRODUCT_ID
				,o.CREATED_DATE as created_fr
				--,o.CUSTOMER_ID
				--,o.TIMETABLE_ID
				,o.STATUS as status_fr
				--,o.FLOW_ID
				--,o.LAST_IN_CUST
				--,o.CHANGE_DATE
				--,o.RECEIVED_DATE
				--,o.*
				,c.CUSTOMER_NAME as segment
				,p.PRODUCT_NAME as material
		        ,p.DESCRIPTION as color_desc
		        --,p.PROD_TYPE_ID
		        ,pt.PROD_TYPE_NAME as prod_type
		        --,pt.DESCRIPTION
		        --pt.*
		        ,od.ORIG_DEL_DATE as delivery_date_orig
		        ,od.DEL_DATE as delivery_date
		        ,od.DEL_QTY as qty
		        --,l.*
		        --,l.LC_NAME
		        --,l.LC_ID
		        --,ol.QTY_PROGRESS
		        --,udf.*
		        --,udf.UD_FIELD_VALUE
		        --,pu.*
		        --,pu.
		        
		        --,pu.UPDATE_QTY
		        --,pu.PLAN_QTY
		        --,s.*
		        --,s.QUANTITY
		        --,s.QTY_MADE
		        --,s.STRIP_START
		        --,s.STRIP_END
		        --,pr.[ROW_NAME]
		        --,pg.[GROUP_NAME]
		        
		        ,t.TIMETABLE_NAME as timetable_name
		        ,(SELECT [UD_FIELD_VALUE] FROM [FR_Gordon].[dbo].[_ORDER_USER_DEFINED_VALUES] WHERE [ORDER_ID] = o.ORDER_ID AND [UD_FIELD_ID] = '52') as pdm_bom
		        ,(SELECT [UD_FIELD_VALUE] FROM [FR_Gordon].[dbo].[_ORDER_USER_DEFINED_VALUES] WHERE [ORDER_ID] = o.ORDER_ID AND [UD_FIELD_ID] = '80') as pdm_bom_alt
		        ,(SELECT [UD_FIELD_VALUE] FROM [FR_Gordon].[dbo].[_ORDER_USER_DEFINED_VALUES] WHERE [ORDER_ID] = o.ORDER_ID AND [UD_FIELD_ID] = '85') as flash
		        ,(SELECT [UD_FIELD_VALUE] FROM [FR_Gordon].[dbo].[_ORDER_USER_DEFINED_VALUES] WHERE [ORDER_ID] = o.ORDER_ID AND [UD_FIELD_ID] = '17') as season
		        ,(SELECT [ORDER_NAME] FROM [FR_Gordon].[dbo].[_ORDERS] WHERE [HOST_ORDER_ID] = o.[ORDER_ID] ) as pro_fr

		  FROM [FR_Gordon].[dbo].[_ORDERS] as o
		  JOIN [FR_Gordon].[dbo].[_CUSTOMERS] as c ON c.CUSTOMER_ID = o.CUSTOMER_ID
		  JOIN [FR_Gordon].[dbo].[_PRODUCTS] as p ON  p.PRODUCT_ID = o.PRODUCT_ID
		  JOIN [FR_Gordon].[dbo].[_PROD_TYPES] as pt ON pt.PROD_TYPE_ID = p.PROD_TYPE_ID
		  JOIN [FR_Gordon].[dbo].[_ORDER_DELIVERIES] as od ON od.ORDER_ID = o.ORDER_ID
		  --JOIN [FR_Gordon].[dbo].[_ORDER_LOADCENTRES] ol ON o.ORDER_ID = ol.ORDER_ID
		  --JOIN [FR_Gordon].[dbo].[_LOADCENTRES] as l ON l.[LC_ID] = ol.[LC_ID]					 --more lines
		  --JOIN [FR_Gordon].[dbo].[_ORDER_USER_DEFINED_VALUES] as udf ON o.ORDER_ID = udf.ORDER_ID  --more lines
		  
		  --JOIN [FR_Gordon].[dbo].[_STRIP_DATA] as s ON s.ORDER_ID = o.ORDER_ID
		  --JOIN [FR_Gordon].[dbo].[_PLAN_ROWS] as pr ON pr.ROW_ID = s.ROW_ID
		  --JOIN [FR_Gordon].[dbo].[_PLAN_UPDATES] as pu ON pu.ORDER_ID = o.ORDER_ID --AND pu.ROW_ID = s.ROW_ID
		  --JOIN [FR_Gordon].[dbo].[_PLAN_GROUPS] as pg ON pg.[GROUP_ID] = pr.[GROUP_ID]
		  
		  JOIN [FR_Gordon].[dbo].[_TIMETABLES] as t ON t.TIMETABLE_ID = o.TIMETABLE_ID
		  
		  WHERE o.ORDER_NAME like 'PLO%' AND p.PRODUCT_NAME != 'TEST1B   001 4B'
		  --WHERE o.ORDER_NAME like 'PRO580640888::1::S/M'
		  --WHERE o.ORDER_ID = '6818862' --OR o.ORDER_ID = '6768258'
		  --WHERE o.CREATED_DATE >= Convert(datetime, '2020-05-01' ) AND ORDER_NAME like 'PRO%'
		  
		  Order by o.CREATED_DATE desc
		  "));
		
		// dd($data_fr);

		for ($i=0; $i < count($data_fr); $i++) { 
			
			$data_local = DB::connection('sqlsrv')->select(DB::raw("SELECT * FROM plo WHERE plo_fr = '".$data_fr[$i]->plo_fr."' "));
			// var_dump($data_local);

			if (isset($data_local[0]->id)) {
				// var_dump("exist");
				// dd("SET");

				// UPDATE
				$sql = DB::connection('sqlsrv')->select(DB::raw("SET NOCOUNT ON;
						UPDATE plo
						SET 
						pro_fr = '".$data_fr[$i]->pro_fr."',
						created_fr = '".$data_fr[$i]->created_fr."', 
						delivery_date = '".$data_fr[$i]->delivery_date."',
						delivery_date_orig = '".$data_fr[$i]->delivery_date_orig."',
						qty = '".$data_fr[$i]->qty."'
						
						WHERE plo_fr = '".$data_fr[$i]->plo_fr."';
						SELECT TOP 1 id FROM plo;"));
	
			} else  {
				// var_dump("not exist");	
				// dd($data_local[0]);

				$plo_fr = $data_fr[$i]->plo_fr;
				// var_dump($plo_fr);

				$po_array = explode('::', $plo_fr);

				// $brcrtica = substr_count($po_array[0],"-");
				// if ($brcrtica == 1)
				// {
				// 	list($one, $two) = explode('-', $po_array[0]);
				// 	$po = substr($one,-6,6);
					
				// } else {
				// 	$po = substr($po_array[0],-6,6);
				// }
				// var_dump($po);
				// dd($po);
				$plo = substr($po_array[0],3);
				// var_dump($plo_fr);
				// dd($plo);
				$material = $data_fr[$i]->material;
				// dd($material);

				$style = substr($material, 0, 8);
				$style = trim($style);
				// dd($style);

				$color = substr($material, 9, 4);
				$color = trim($color);
				// dd($color);

				$size = substr($material, 13);
				$size = trim($size);
				// dd($size);

				$pro= NULL;
								
				// $get_brand =DB::connection('sqlsrv2')->select(DB::raw("SELECT brand FROM [settings].[dbo].[styles] WHERE style = '".$style."' "));
				// dd($get_brand);

				// if (isset($get_brand[0]->brand)) {
				// 	$brand = $get_brand[0]->brand;
				// } else {
				// 	$brand = 'no info';
				// }

				$now = date("Y-m-d H:i:s");

				//UPDATE FROM INTEOS

				// UPDATE FROM COOIS

				// var_dump($q_coois);

				$sql = DB::connection('sqlsrv')->select(DB::raw("SET NOCOUNT ON;
						INSERT INTO plo
					           ([plo]
					           ,[plo_fr]
					           ,[pro_fr]

					           ,[material]
					           ,[style]
					           ,[color]
					           ,[size]
					           ,[color_desc]

					           ,[prod_type]
					           ,[season]
					           ,[flash]
					           ,[status_fr]
					           ,[segment]
					           ,[timetable_name]
					           ,[pdm_bom]
					           ,[pdm_bom_alt]

					           ,[created_fr]
							   ,[delivery_date]
							   ,[delivery_date_orig]

							   ,[qty]
							   
							   ,[created_at]
							   ,[updated_at])
					           
					 	VALUES
					          ('".$plo."'
					           ,'".$data_fr[$i]->plo_fr."'
					           ,'".$data_fr[$i]->pro_fr."'

					           ,'".$data_fr[$i]->material."'
					           ,'".$style."'
					           ,'".$color."'
					           ,'".$size."'
					           ,'".$data_fr[$i]->color_desc."'

					           ,'".$data_fr[$i]->prod_type."'
					           ,'".$data_fr[$i]->season."'
					           ,'".$data_fr[$i]->flash."'
					           ,'".$data_fr[$i]->status_fr."'
					           ,'".$data_fr[$i]->segment."'
					           ,'".$data_fr[$i]->timetable_name."'
					           ,'".$data_fr[$i]->pdm_bom."'
					           ,'".$data_fr[$i]->pdm_bom_alt."'

					           ,'".$data_fr[$i]->created_fr."'
					           ,'".$data_fr[$i]->delivery_date."'
					           ,'".$data_fr[$i]->delivery_date_orig."'

					           ,'".$data_fr[$i]->qty."'
					           ,'".$now."'
					           ,'".$now."'
							   );
					
						 SELECT TOP 1 [id] FROM plo;
						
						"));
			}

		}
		// dd('q');

		return Redirect::to('/plo');
	}

	public function edit(Request $request, $id)
	{
		//
		$input = $request->all(); // change use (delete or comment user Requestl; )
		$plo = PLO::findOrFail($id);
		return view('PLO.edit', compact('plo'));
	}

	public function edit_save(Request $request, $id)
	{
		//
		$input = $request->all(); // change use (delete or comment user Requestl; )
		// dd($input);
		// dd($input['pdm']);

		$table = plo::findOrFail($id);
		$table->bom = $input['bom'];
		$table->routing = $input['routing'];
		$table->prod_version = $input['prod_version'];
		
		$table->save();
		
		return Redirect::to('/plo');
	}
	
}
