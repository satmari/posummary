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

class proController extends Controller {

	public function index()
	{
		// dd("test");
		$data = DB::connection('sqlsrv')->select(DB::raw("SELECT * FROM [posummary].[dbo].[pro] "));
		return view('PRO.index', compact('data'));
	}

	public function table()
	{
		// dd("test");
		$data = DB::connection('sqlsrv')->select(DB::raw("SELECT 
		      plo.[plo]
		      --,plo.[plo_fr]
		            
		      ,plo.[material]
		      ,plo.[color_desc]
		      ,plo.[segment]
		      ,plo.[qty]
		      
		      ,plo.[bom]
		      ,plo.[routing]
		      ,plo.[prod_version]
		      
		      ,pro.pro
		      ,pro.ec_cost
		      ,pro.pref_origin
		      ,pro.release
		      ,pro.sent_to_inteos
		      
		      ,pro.[delivery_date_orig]
		      
		  FROM [posummary].[dbo].[plo] as plo
		  LEFT JOIN [posummary].[dbo].[pro] as pro ON pro.pro_fr = plo.pro_fr
		  ORDER by plo.plo asc"));

		return view('PRO.table', compact('data'));
	}

	public function update_pro()
	{
		//
		$data_fr = DB::connection('sqlsrv1')->select(DB::raw("SELECT  --o.*
				--o.ORDER_ID
				o.ORDER_NAME as pro_fr
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
		        ,(SELECT [ORDER_NAME] FROM [FR_Gordon].[dbo].[_ORDERS] WHERE [ORDER_ID] = o.[HOST_ORDER_ID] ) as plo_fr

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
		  
		  WHERE o.ORDER_NAME like 'PRO%' AND p.PRODUCT_NAME != 'TEST1B   001 4B'
		  --WHERE o.ORDER_NAME like 'PRO580640888::1::S/M'
		  --WHERE o.ORDER_ID = '6818862' --OR o.ORDER_ID = '6768258'
		  --WHERE o.CREATED_DATE >= Convert(datetime, '2020-05-01' ) AND ORDER_NAME like 'PRO%'
		  
		  Order by o.CREATED_DATE desc
		  "));
		
		// dd($data_fr);

		for ($i=0; $i < count($data_fr); $i++) { 
			
			$pro_fr = $data_fr[$i]->pro_fr;
			// var_dump($pro_fr);

			$po_array = explode('::', $pro_fr);

			$brcrtica = substr_count($po_array[0],"-");
			if ($brcrtica == 1)
			{
				list($one, $two) = explode('-', $po_array[0]);
				$po = substr($one,-6,6);
				
			} else {
				$po = substr($po_array[0],-6,6);
			}
			// var_dump($po);
			// dd($po);
			$pro_s = substr($po_array[0],3);
			// dd($pro_s);

			$data_local = DB::connection('sqlsrv')->select(DB::raw("SELECT * FROM pro WHERE pro like '%".$pro_s."%' "));
			// $data_local = DB::connection('sqlsrv')->select(DB::raw("SELECT * FROM pro WHERE pro_fr like '".$data_fr[$i]->pro_fr"' "));
			// dd($data_local);

			if (isset($data_local[0]->id)) {
				// var_dump("exist");
				// dd("SET");

				//-----UPDATE FROM INTEOS
				$inteos = DB::connection('sqlsrv4')->select(DB::raw("
					SELECT POnum
					      ,[Brand] as brand
					      ,[TPP] as tpp
					      ,[Approval] as approval
					      ,[EUR1] as eur1
					      ,[POClosed] as status_int
					FROM [BdkCLZG].[dbo].[CNF_PO]
					WHERE POnum like '%".$data_local[0]->pro."'
       			    UNION
					SELECT POnum
					      ,[Brand] as brand
					      ,[TPP] as tpp
					      ,[Approval] as approval
					      ,[EUR1] as eur1
					      ,[POClosed] as status_int
					FROM [SBT-SQLDB01P\INTEOSKKA].[BdkCLZKKA].[dbo].[CNF_PO]
					WHERE POnum like '%".$data_local[0]->pro."' "));

				// dd($inteos);

				if (isset($inteos[0]->brand)) {
					// dd('set');

					$brands = trim($inteos[0]->brand);
					if ($brands == 'TZN') {
						$brand = "Tezenis";
					} else if ($brands == 'CLZ') {
						$brand = "Calzedonia";
					} else if ($brands == 'INT') {
						$brand = "Intimissimi";
					} else {
						$brand = "Outlet";
					}
					$tpp = trim($inteos[0]->tpp);
					$approval = trim($inteos[0]->approval);
					$eur1 = trim($inteos[0]->eur1);
					$status_int = $inteos[0]->status_int;

					if (is_null($status_int) OR ($status_int == 0)) {
						$status_int = "Open";
					} else if ($status_int == 1) {
						$status_int = "Closed";
					} else {
						$status_int = "no info";
					}

				} else {
					// var_dump('Not exist in Inteos');

					$brand = "";
					$tpp = "";
					$approval = "";
					$eur1 = "";
					$status_int = "";
				}

				// UPDATE FROM COOIS
				$coois = DB::connection('sqlsrv3')->select(DB::raw("
					SELECT 
						DISTINCT wc 
					FROM [trebovanje].[dbo].[sap_coois]
					WHERE po like '%".$data_local[0]->pro."%' "));
				// var_dump($data_local[0]->pro);
				// var_dump($coois);

				if (isset($coois[0]->wc)){
					// dd($coois[0]->wc);
						 
					$q_coois = '';
					for ($a=0; $a < count($coois); $a++) { 

						// var_dump($coois[$a]->wc);
						if ($coois[$a]->wc == 'WC03I') {
							$q_coois = "Subotica";
						} elseif ($coois[$a]->wc == 'WC03O') {
							$q_coois = "Subotica";
						} elseif ($coois[$a]->wc == 'WC03I_K') {
							$q_coois = "Kikinda";
						} elseif ($coois[$a]->wc == 'WC03O_K') {
							$q_coois = "Kikinda";
						} elseif ($coois[$a]->wc == 'WCPS') {
							$q_coois = "Utdtex";
						}
					}
				} else {
					$q_coois = "no info";
				}
				if ($q_coois == '') {
					$q_coois = "no info";
				}

				// UPDATE 
				$sql = DB::connection('sqlsrv')->select(DB::raw("SET NOCOUNT ON;
						UPDATE pro
						SET 
						plo_fr = '".$data_fr[$i]->plo_fr."',
						created_fr = '".$data_fr[$i]->created_fr."', 
						delivery_date = '".$data_fr[$i]->delivery_date."',
						delivery_date_orig = '".$data_fr[$i]->delivery_date_orig."',
						qty = '".$data_fr[$i]->qty."',
						brand = '".$brand."',
						tpp = '".$tpp."',
						approval = '".$approval."',
						eur1 = '".$eur1."',
						status_int = '".$status_int."',
						location = '".$q_coois."'

						WHERE pro_fr = '".$data_fr[$i]->pro_fr."';
						SELECT TOP 1 id FROM pro;"));
	
			} else  {
				// var_dump("not exist");	
				// dd($data_local[0]);

				$pro_fr = $data_fr[$i]->pro_fr;
				// var_dump($pro_fr);

				$po_array = explode('::', $pro_fr);

				$brcrtica = substr_count($po_array[0],"-");
				if ($brcrtica == 1)
				{
					list($one, $two) = explode('-', $po_array[0]);
					$po = substr($one,-6,6);
					
				} else {
					$po = substr($po_array[0],-6,6);
				}
				// var_dump($po);
				// dd($po);
				$pro = substr($po_array[0],3);
				// var_dump($pro_fr);
				// dd($pro);
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
								
				// $get_brand =DB::connection('sqlsrv2')->select(DB::raw("SELECT brand FROM [settings].[dbo].[styles] WHERE style = '".$style."' "));
				// dd($get_brand);

				// if (isset($get_brand[0]->brand)) {
				// 	$brand = $get_brand[0]->brand;
				// } else {
				// 	$brand = 'no info';
				// }

				$now = date("Y-m-d H:i:s");

				//UPDATE FROM INTEOS
				$inteos = DB::connection('sqlsrv4')->select(DB::raw("
					SELECT POnum
					      ,[Brand] as brand
					      ,[TPP] as tpp
					      ,[Approval] as approval
					      ,[EUR1] as eur1
					      ,[POClosed] as status_int
					FROM [BdkCLZG].[dbo].[CNF_PO]
					WHERE POnum like '%".$pro."'
       			    UNION
					SELECT POnum
					      ,[Brand] as brand
					      ,[TPP] as tpp
					      ,[Approval] as approval
					      ,[EUR1] as eur1
					      ,[POClosed] as status_int
					FROM [SBT-SQLDB01P\INTEOSKKA].[BdkCLZKKA].[dbo].[CNF_PO]
					WHERE POnum like '%".$pro."' "));
				// dd($inteos);

				if (isset($inteos[0]->brand)) {
					// dd('set');

					$brands = trim($inteos[0]->brand);
					if ($brands == 'TZN') {
						$brand = "Tezenis";
					} else if ($brands == 'CLZ') {
						$brand = "Calzedonia";
					} else if ($brands == 'INT') {
						$brand = "Intimissimi";
					} else {
						$brand = "Outlet";
					}
					$tpp = trim($inteos[0]->tpp);
					$approval = trim($inteos[0]->approval);
					$eur1 = trim($inteos[0]->eur1);
					$status_int = $inteos[0]->status_int;

					if (is_null($status_int) OR ($status_int == 0)) {
						$status_int = "Open";
					} else if ($status_int == 1) {
						$status_int = "Closed";
					} else {
						$status_int = "no info";
					}

				} else {
					// var_dump('Not exist in Inteos');

					$brand = "";
					$tpp = "";
					$approval = "";
					$eur1 = "";
					$status_int = "";
				}

				// UPDATE FROM COOIS
				$coois = DB::connection('sqlsrv3')->select(DB::raw("
					SELECT
						DISTINCT wc 
					FROM [trebovanje].[dbo].[sap_coois]
					WHERE po like '%".$pro."%' "));
				// var_dump($data_local[0]->pro);
				// var_dump($coois);
				// dd($coois);

				if (isset($coois[0]->wc)){
					// dd($coois[0]->wc);
						 
					$q_coois = '';
					for ($a=0; $a < count($coois); $a++) { 

						// var_dump($coois[$a]->wc);
						if ($coois[$a]->wc == 'WC03I') {
							$q_coois = "Subotica";
						} elseif ($coois[$a]->wc == 'WC03O') {
							$q_coois = "Subotica";
						} elseif ($coois[$a]->wc == 'WC03I_K') {
							$q_coois = "Kikinda";
						} elseif ($coois[$a]->wc == 'WC03O_K') {
							$q_coois = "Kikinda";
						} elseif ($coois[$a]->wc == 'WCPS') {
							$q_coois = "Utdtex";
						}
					}
				} else {
					$q_coois = "no info";
				}
				if ($q_coois == '') {
					$q_coois = "no info";
				}

				// var_dump($q_coois);

				$sql = DB::connection('sqlsrv')->select(DB::raw("SET NOCOUNT ON;
						INSERT INTO pro
					           ([pro]
					           ,[pro_fr]
					           ,[po]
					           ,[plo_fr]

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

					           ,[brand]
					           ,[tpp]
					           ,[approval]
					           ,[eur1]
					           ,[status_int]
					           ,[location]

							   ,[created_fr]
							   ,[delivery_date]
							   ,[delivery_date_orig]

							   ,[qty]
							   ,[created_at]
							   ,[updated_at])
					           
					 	VALUES
					          ('".$pro."'
					           ,'".$data_fr[$i]->pro_fr."'
					           ,'".$po."'
							   ,'".$data_fr[$i]->plo_fr."'

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

					           ,'".$brand."'
					           ,'".$tpp."'
					           ,'".$approval."'
					           ,'".$eur1."'
					           ,'".$status_int."'
					           ,'".$q_coois."'

					           ,'".$data_fr[$i]->created_fr."'
					           ,'".$data_fr[$i]->delivery_date."'
					           ,'".$data_fr[$i]->delivery_date_orig."'

					           ,'".$data_fr[$i]->qty."'
					           ,'".$now."'
					           ,'".$now."'
							   );
					
						 SELECT TOP 1 [id] FROM pro;
						
						"));

			}

		}


		// UPDATE FROM Inteos


		// $inteos_new = DB::connection('sqlsrv4')->select(DB::raw("

		// 	"));


		// dd('q');

		return Redirect::to('/pro');
	}

	public function update_pro_inteos()
	{
		//
		$data_int = DB::connection('sqlsrv4')->select(DB::raw("
		  "));
		
		// dd($data_fr);

		for ($i=0; $i < count($data_int); $i++) { 
			
			$pro_fr = $data_int[$i]->pro_fr;
			// var_dump($pro_fr);

			$po_array = explode('::', $pro_fr);

			$brcrtica = substr_count($po_array[0],"-");
			if ($brcrtica == 1)
			{
				list($one, $two) = explode('-', $po_array[0]);
				$po = substr($one,-6,6);
				
			} else {
				$po = substr($po_array[0],-6,6);
			}
			// var_dump($po);
			// dd($po);
			$pro_s = substr($po_array[0],3);
			// dd($pro_s);

			$data_local = DB::connection('sqlsrv')->select(DB::raw("SELECT * FROM pro WHERE pro like '%".$pro_s."%' "));
			// $data_local = DB::connection('sqlsrv')->select(DB::raw("SELECT * FROM pro WHERE pro_fr like '".$data_fr[$i]->pro_fr"' "));
			// dd($data_local);

			if (isset($data_local[0]->id)) {
				// var_dump("exist");
				// dd("SET");

				//-----UPDATE FROM INTEOS
				$inteos = DB::connection('sqlsrv4')->select(DB::raw("
					SELECT POnum
					      ,[Brand] as brand
					      ,[TPP] as tpp
					      ,[Approval] as approval
					      ,[EUR1] as eur1
					      ,[POClosed] as status_int
					FROM [BdkCLZG].[dbo].[CNF_PO]
					WHERE POnum like '%".$data_local[0]->pro."'
       			    UNION
					SELECT POnum
					      ,[Brand] as brand
					      ,[TPP] as tpp
					      ,[Approval] as approval
					      ,[EUR1] as eur1
					      ,[POClosed] as status_int
					FROM [SBT-SQLDB01P\INTEOSKKA].[BdkCLZKKA].[dbo].[CNF_PO]
					WHERE POnum like '%".$data_local[0]->pro."' "));

				// dd($inteos);

				if (isset($inteos[0]->brand)) {
					// dd('set');

					$brands = trim($inteos[0]->brand);
					if ($brands == 'TZN') {
						$brand = "Tezenis";
					} else if ($brands == 'CLZ') {
						$brand = "Calzedonia";
					} else if ($brands == 'INT') {
						$brand = "Intimissimi";
					} else {
						$brand = "Outlet";
					}
					$tpp = trim($inteos[0]->tpp);
					$approval = trim($inteos[0]->approval);
					$eur1 = trim($inteos[0]->eur1);
					$status_int = $inteos[0]->status_int;

					if (is_null($status_int) OR ($status_int == 0)) {
						$status_int = "Open";
					} else if ($status_int == 1) {
						$status_int = "Closed";
					} else {
						$status_int = "no info";
					}

				} else {
					// var_dump('Not exist in Inteos');

					$brand = "";
					$tpp = "";
					$approval = "";
					$eur1 = "";
					$status_int = "";
				}

				// UPDATE FROM COOIS
				$coois = DB::connection('sqlsrv3')->select(DB::raw("
					SELECT 
						DISTINCT wc 
					FROM [trebovanje].[dbo].[sap_coois]
					WHERE po like '%".$data_local[0]->pro."%' "));
				// var_dump($data_local[0]->pro);
				// var_dump($coois);

				if (isset($coois[0]->wc)){
					// dd($coois[0]->wc);
						 
					$q_coois = '';
					for ($a=0; $a < count($coois); $a++) { 

						// var_dump($coois[$a]->wc);
						if ($coois[$a]->wc == 'WC03I') {
							$q_coois = "Subotica";
						} elseif ($coois[$a]->wc == 'WC03O') {
							$q_coois = "Subotica";
						} elseif ($coois[$a]->wc == 'WC03I_K') {
							$q_coois = "Kikinda";
						} elseif ($coois[$a]->wc == 'WC03O_K') {
							$q_coois = "Kikinda";
						} elseif ($coois[$a]->wc == 'WCPS') {
							$q_coois = "Utdtex";
						}
					}
				} else {
					$q_coois = "no info";
				}
				if ($q_coois == '') {
					$q_coois = "no info";
				}

				// UPDATE 
				$sql = DB::connection('sqlsrv')->select(DB::raw("SET NOCOUNT ON;
						UPDATE pro
						SET 
						plo_fr = '".$data_fr[$i]->plo_fr."',
						created_fr = '".$data_fr[$i]->created_fr."', 
						delivery_date = '".$data_fr[$i]->delivery_date."',
						delivery_date_orig = '".$data_fr[$i]->delivery_date_orig."',
						qty = '".$data_fr[$i]->qty."',
						brand = '".$brand."',
						tpp = '".$tpp."',
						approval = '".$approval."',
						eur1 = '".$eur1."',
						status_int = '".$status_int."',
						location = '".$q_coois."'

						WHERE pro_fr = '".$data_fr[$i]->pro_fr."';
						SELECT TOP 1 id FROM pro;"));
	
			} else  {
				// var_dump("not exist");	
				// dd($data_local[0]);

				$pro_fr = $data_fr[$i]->pro_fr;
				// var_dump($pro_fr);

				$po_array = explode('::', $pro_fr);

				$brcrtica = substr_count($po_array[0],"-");
				if ($brcrtica == 1)
				{
					list($one, $two) = explode('-', $po_array[0]);
					$po = substr($one,-6,6);
					
				} else {
					$po = substr($po_array[0],-6,6);
				}
				// var_dump($po);
				// dd($po);
				$pro = substr($po_array[0],3);
				// var_dump($pro_fr);
				// dd($pro);
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
								
				// $get_brand =DB::connection('sqlsrv2')->select(DB::raw("SELECT brand FROM [settings].[dbo].[styles] WHERE style = '".$style."' "));
				// dd($get_brand);

				// if (isset($get_brand[0]->brand)) {
				// 	$brand = $get_brand[0]->brand;
				// } else {
				// 	$brand = 'no info';
				// }

				$now = date("Y-m-d H:i:s");

				//UPDATE FROM INTEOS
				$inteos = DB::connection('sqlsrv4')->select(DB::raw("
					SELECT POnum
					      ,[Brand] as brand
					      ,[TPP] as tpp
					      ,[Approval] as approval
					      ,[EUR1] as eur1
					      ,[POClosed] as status_int
					FROM [BdkCLZG].[dbo].[CNF_PO]
					WHERE POnum like '%".$pro."'
       			    UNION
					SELECT POnum
					      ,[Brand] as brand
					      ,[TPP] as tpp
					      ,[Approval] as approval
					      ,[EUR1] as eur1
					      ,[POClosed] as status_int
					FROM [SBT-SQLDB01P\INTEOSKKA].[BdkCLZKKA].[dbo].[CNF_PO]
					WHERE POnum like '%".$pro."' "));
				// dd($inteos);

				if (isset($inteos[0]->brand)) {
					// dd('set');

					$brands = trim($inteos[0]->brand);
					if ($brands == 'TZN') {
						$brand = "Tezenis";
					} else if ($brands == 'CLZ') {
						$brand = "Calzedonia";
					} else if ($brands == 'INT') {
						$brand = "Intimissimi";
					} else {
						$brand = "Outlet";
					}
					$tpp = trim($inteos[0]->tpp);
					$approval = trim($inteos[0]->approval);
					$eur1 = trim($inteos[0]->eur1);
					$status_int = $inteos[0]->status_int;

					if (is_null($status_int) OR ($status_int == 0)) {
						$status_int = "Open";
					} else if ($status_int == 1) {
						$status_int = "Closed";
					} else {
						$status_int = "no info";
					}

				} else {
					// var_dump('Not exist in Inteos');

					$brand = "";
					$tpp = "";
					$approval = "";
					$eur1 = "";
					$status_int = "";
				}

				// UPDATE FROM COOIS
				$coois = DB::connection('sqlsrv3')->select(DB::raw("
					SELECT
						DISTINCT wc 
					FROM [trebovanje].[dbo].[sap_coois]
					WHERE po like '%".$pro."%' "));
				// var_dump($data_local[0]->pro);
				// var_dump($coois);
				// dd($coois);

				if (isset($coois[0]->wc)){
					// dd($coois[0]->wc);
						 
					$q_coois = '';
					for ($a=0; $a < count($coois); $a++) { 

						// var_dump($coois[$a]->wc);
						if ($coois[$a]->wc == 'WC03I') {
							$q_coois = "Subotica";
						} elseif ($coois[$a]->wc == 'WC03O') {
							$q_coois = "Subotica";
						} elseif ($coois[$a]->wc == 'WC03I_K') {
							$q_coois = "Kikinda";
						} elseif ($coois[$a]->wc == 'WC03O_K') {
							$q_coois = "Kikinda";
						} elseif ($coois[$a]->wc == 'WCPS') {
							$q_coois = "Utdtex";
						}
					}
				} else {
					$q_coois = "no info";
				}
				if ($q_coois == '') {
					$q_coois = "no info";
				}

				// var_dump($q_coois);

				$sql = DB::connection('sqlsrv')->select(DB::raw("SET NOCOUNT ON;
						INSERT INTO pro
					           ([pro]
					           ,[pro_fr]
					           ,[po]
					           ,[plo_fr]

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

					           ,[brand]
					           ,[tpp]
					           ,[approval]
					           ,[eur1]
					           ,[status_int]
					           ,[location]

							   ,[created_fr]
							   ,[delivery_date]
							   ,[delivery_date_orig]

							   ,[qty]
							   ,[created_at]
							   ,[updated_at])
					           
					 	VALUES
					          ('".$pro."'
					           ,'".$data_fr[$i]->pro_fr."'
					           ,'".$po."'
							   ,'".$data_fr[$i]->plo_fr."'

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

					           ,'".$brand."'
					           ,'".$tpp."'
					           ,'".$approval."'
					           ,'".$eur1."'
					           ,'".$status_int."'
					           ,'".$q_coois."'

					           ,'".$data_fr[$i]->created_fr."'
					           ,'".$data_fr[$i]->delivery_date."'
					           ,'".$data_fr[$i]->delivery_date_orig."'

					           ,'".$data_fr[$i]->qty."'
					           ,'".$now."'
					           ,'".$now."'
							   );
					
						 SELECT TOP 1 [id] FROM pro;
						
						"));

			}

		}


		// UPDATE FROM Inteos


		// $inteos_new = DB::connection('sqlsrv4')->select(DB::raw("

		// 	"));


		// dd('q');

		return Redirect::to('/pro');
	}

	public function edit(Request $request, $id)
	{
		//
		$input = $request->all(); // change use (delete or comment user Requestl; )
		$pro = PRO::findOrFail($id);
		return view('PRO.edit', compact('pro'));
	}

	public function edit_save(Request $request, $id)
	{
		//
		$input = $request->all(); // change use (delete or comment user Requestl; )
		// dd($input);
		// dd($input['pdm']);

		$table = pro::findOrFail($id);
		$table->pdm = $input['pdm'];
		$table->flash_type = $input['flash_type'];
		$table->ec_cost = $input['ec_cost'];
		$table->pref_origin = $input['pref_origin'];
		$table->release = $input['release'];
		$table->sent_to_inteos = $input['sent_to_inteos'];
		$table->tpp_shipments = $input['tpp_shipments'];
		$table->tpp_wastage = $input['tpp_wastage'];
		$table->skeda = $input['skeda'];
		// dd($input['sent_to_inteos']);
		$table->save();
		
		return Redirect::to('/pro');
	}

	public function conf(Request $request, $id)
	{
		//
		$input = $request->all(); // change use (delete or comment user Requestl; )
		//var_dump($input);

		$data_local = DB::connection('sqlsrv')->select(DB::raw("SELECT pro_fr FROM pro WHERE id = '".$id."' "));
		
		/*
		$data = DB::connection('sqlsrv')->select(DB::raw("SELECT  --o.*
				--o.ORDER_ID
				o.ORDER_NAME as pro_fr
				--,o.ORIGINAL_NAME
				--,o.PRODUCT_ID
				--,o.CREATED_DATE as created_fr
				--,o.CUSTOMER_ID
				--,o.TIMETABLE_ID
				--,o.STATUS as status_fr
				--,o.FLOW_ID
				--,o.LAST_IN_CUST
				--,o.CHANGE_DATE
				--,o.RECEIVED_DATE
				--,o.*
				,c.CUSTOMER_NAME as segment
				,p.PRODUCT_NAME as material
		        --,p.DESCRIPTION as color_desc
		        --,p.PROD_TYPE_ID
		        --,pt.PROD_TYPE_NAME
		        --,pt.DESCRIPTION
		        --pt.*
		        --,od.[ORIG_DEL_DATE] as delivery_date_orig
		        --,od.[DEL_DATE] as delivery_date
		        ,od.DEL_QTY as qty
		        --,l.*
		        --,l.LC_NAME
		        --,l.LC_ID
		        --,ol.QTY_PROGRESS
		        --,udf.*
		        --,udf.UD_FIELD_VALUE
		        --,pu.*
		        --,pu.
		        
		        ,pu.UPDATE_QTY as conf_qty
		        --,pu.PLAN_QTY
		        --,s.*
		        --,s.QUANTITY
		        --,s.QTY_MADE
		        --,s.STRIP_START
		        --,s.STRIP_END
		        ,pr.[ROW_NAME] as line
		        ,pg.[GROUP_NAME] as line_group
		        ,od.[DEL_DATE] as del_date
		        
		        
		  FROM [FR_Gordon].[dbo].[_ORDERS] as o
		  JOIN [FR_Gordon].[dbo].[_CUSTOMERS] as c ON c.[CUSTOMER_ID] = o.[CUSTOMER_ID]
		  JOIN [FR_Gordon].[dbo].[_PRODUCTS] as p ON  p.PRODUCT_ID = o.PRODUCT_ID
		  JOIN [FR_Gordon].[dbo].[_PROD_TYPES] as pt ON pt.PROD_TYPE_ID = p.PROD_TYPE_ID
		  JOIN [FR_Gordon].[dbo].[_ORDER_DELIVERIES] as od ON od.ORDER_ID = o.ORDER_ID
		  
		  --JOIN [FR_Gordon].[dbo].[_STRIP_DATA] as s ON s.ORDER_ID = o.ORDER_ID
		  --JOIN [FR_Gordon].[dbo].[_PLAN_ROWS] as pr ON pr.ROW_ID = s.ROW_ID -- for strip
		  --JOIN [FR_Gordon].[dbo].[_PLAN_GROUPS] as pg ON pg.[GROUP_ID] = pr.[GROUP_ID] -- for strip
		  
		  --JOIN [FR_Gordon].[dbo].[_ORDER_LOADCENTRES] ol ON o.ORDER_ID = ol.ORDER_ID
		  --JOIN [FR_Gordon].[dbo].[_LOADCENTRES] as l ON l.[LC_ID] = ol.[LC_ID] --AND LC_NAME = '400 Sewing out'				 --more lines
		  
		  --JOIN [FR_Gordon].[dbo].[_PLAN_UPDATES] as pu ON pu.ORDER_ID = o.ORDER_ID AND pu.ROW_ID = s.ROW_ID --for strip
		  JOIN [FR_Gordon].[dbo].[_PLAN_UPDATES] as pu ON pu.ORDER_ID = o.ORDER_ID --AND pu.ROW_ID = pr.ROW_ID --for update
		  JOIN [FR_Gordon].[dbo].[_PLAN_ROWS] as pr ON pr.ROW_ID = pu.ROW_ID -- for update
		  JOIN [FR_Gordon].[dbo].[_PLAN_GROUPS] as pg ON pg.[GROUP_ID] = pr.[GROUP_ID] -- for update
		  
		  --JOIN [FR_Gordon].[dbo].[_ORDER_USER_DEFINED_VALUES] as udf ON o.ORDER_ID = udf.ORDER_ID  --more lines
		  
		  --WHERE o.ORDER_NAME like '%6818728%'
		  --WHERE o.ORDER_ID = '6818862'
		  WHERE  o.ORDER_NAME = '".$data_local[0]->pro_fr."' 	"));
		  */
		
		$data = DB::connection('sqlsrv')->select(DB::raw("SELECT  --o.*
				--o.ORDER_ID
				o.ORDER_NAME as pro_fr
				--,o.ORIGINAL_NAME
				--,o.PRODUCT_ID
				--,o.CREATED_DATE as created_fr
				--,o.CUSTOMER_ID
				--,o.TIMETABLE_ID
				--,o.STATUS as status_fr
				--,o.FLOW_ID
				--,o.LAST_IN_CUST
				--,o.CHANGE_DATE
				--,o.RECEIVED_DATE
				--,o.*
				,c.CUSTOMER_NAME as segment
				,p.PRODUCT_NAME as material
		        --,p.DESCRIPTION as color_desc
		        --,p.PROD_TYPE_ID
		        --,pt.PROD_TYPE_NAME
		        --,pt.DESCRIPTION
		        --pt.*
		        --,od.[ORIG_DEL_DATE] as delivery_date_orig
		        --,od.[DEL_DATE] as delivery_date
		        ,od.DEL_QTY as qty
		        --,l.*
		        --,l.LC_NAME
		        --,l.LC_ID
		        --,ol.QTY_PROGRESS
		        --,udf.*
		        --,udf.UD_FIELD_VALUE
		        --,pu.*
		        --,pu.
		        --,SUM(pu.UPDATE_QTY) as conf_qty
		        --,pu.UPDATE_QTY as conf_qty
		        --,pu.PLAN_QTY
		        --,s.*
		        --,s.QUANTITY
		        --,s.QTY_MADE
		        --,s.STRIP_START
		        --,s.STRIP_END
		        --,pr.[ROW_NAME] as line
		        --,pg.[GROUP_NAME] as line_group
		        --,od.[DEL_DATE] as del_date
		        --,ol.LC_ID
		        ,(SELECT QTY_PROGRESS FROM [FR_Gordon].[dbo].[_ORDER_LOADCENTRES] WHERE LC_ID = '3' AND ORDER_ID = o.ORDER_ID) as cut_pcs
		        ,(SELECT QTY_PROGRESS FROM [FR_Gordon].[dbo].[_ORDER_LOADCENTRES] WHERE LC_ID = '162' AND ORDER_ID = o.ORDER_ID) as sw_in
		        ,(SELECT QTY_PROGRESS FROM [FR_Gordon].[dbo].[_ORDER_LOADCENTRES] WHERE LC_ID = '8' AND ORDER_ID = o.ORDER_ID) as sw_out
		        
		        
		  FROM [FR_Gordon].[dbo].[_ORDERS] as o
		  JOIN [FR_Gordon].[dbo].[_CUSTOMERS] as c ON c.[CUSTOMER_ID] = o.[CUSTOMER_ID]
		  JOIN [FR_Gordon].[dbo].[_PRODUCTS] as p ON  p.PRODUCT_ID = o.PRODUCT_ID
		  JOIN [FR_Gordon].[dbo].[_PROD_TYPES] as pt ON pt.PROD_TYPE_ID = p.PROD_TYPE_ID
		  JOIN [FR_Gordon].[dbo].[_ORDER_DELIVERIES] as od ON od.ORDER_ID = o.ORDER_ID
		  
		  --JOIN [FR_Gordon].[dbo].[_STRIP_DATA] as s ON s.ORDER_ID = o.ORDER_ID
		  --JOIN [FR_Gordon].[dbo].[_PLAN_ROWS] as pr ON pr.ROW_ID = s.ROW_ID -- for strip
		  --JOIN [FR_Gordon].[dbo].[_PLAN_GROUPS] as pg ON pg.[GROUP_ID] = pr.[GROUP_ID] -- for strip
		  
		  JOIN [FR_Gordon].[dbo].[_ORDER_LOADCENTRES] ol ON o.ORDER_ID = ol.ORDER_ID
		  --JOIN [FR_Gordon].[dbo].[_LOADCENTRES] as l ON l.[LC_ID] = ol.[LC_ID] --AND LC_NAME = '400 Sewing out'				 --more lines
		  
		  --JOIN [FR_Gordon].[dbo].[_PLAN_UPDATES] as pu ON pu.ORDER_ID = o.ORDER_ID AND pu.ROW_ID = s.ROW_ID --for strip
		  --JOIN [FR_Gordon].[dbo].[_PLAN_UPDATES] as pu ON pu.ORDER_ID = o.ORDER_ID --AND pu.ROW_ID = pr.ROW_ID --for update
		  --JOIN [FR_Gordon].[dbo].[_PLAN_ROWS] as pr ON pr.ROW_ID = pu.ROW_ID -- for update
		  --JOIN [FR_Gordon].[dbo].[_PLAN_GROUPS] as pg ON pg.[GROUP_ID] = pr.[GROUP_ID] -- for update
		  
		  --JOIN [FR_Gordon].[dbo].[_ORDER_USER_DEFINED_VALUES] as udf ON o.ORDER_ID = udf.ORDER_ID  --more lines
		  
		  --WHERE o.ORDER_NAME like '%6818728%'
		  --WHERE o.ORDER_ID = '6818492'
		  WHERE  o.ORDER_NAME = '".$data_local[0]->pro_fr."'

		  GROUP BY 
				--o.*
				o.ORDER_ID
				,o.ORDER_NAME 
				--,o.ORIGINAL_NAME
				--,o.PRODUCT_ID
				--,o.CREATED_DATE as created_fr
				--,o.CUSTOMER_ID
				--,o.TIMETABLE_ID
				--,o.STATUS as status_fr
				--,o.FLOW_ID
				--,o.LAST_IN_CUST
				--,o.CHANGE_DATE
				--,o.RECEIVED_DATE
				--,o.*
				,c.CUSTOMER_NAME 
				,p.PRODUCT_NAME 
		        --,p.DESCRIPTION as color_desc
		        --,p.PROD_TYPE_ID
		        --,pt.PROD_TYPE_NAME
		        --,pt.DESCRIPTION
		        --pt.*
		        --,od.[ORIG_DEL_DATE] as delivery_date_orig
		        --,od.[DEL_DATE] as delivery_date
		        ,od.DEL_QTY 
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
		        --,od.[DEL_DATE] as del_date
		        --,ol.LC_ID

		"));

		// dd($data);

		return view('PRO.index_conf', compact('data'));
	}

	public function strip(Request $request, $id)
	{
		//
		$input = $request->all(); // change use (delete or comment user Requestl; )
		//var_dump($input);
		
		$data_local = DB::connection('sqlsrv')->select(DB::raw("SELECT pro_fr FROM pro WHERE id = '".$id."' "));

		$data = DB::connection('sqlsrv')->select(DB::raw("SELECT  --o.*
		--o.ORDER_ID
		o.ORDER_NAME as pro_fr
		--,o.ORIGINAL_NAME
		--,o.PRODUCT_ID
		--,o.CREATED_DATE
		--,o.CUSTOMER_ID
		--,o.TIMETABLE_ID
		--,o.STATUS
		--,o.FLOW_ID
		--,o.LAST_IN_CUST
		--,o.CHANGE_DATE
		--,o.RECEIVED_DATE
		--,o.*
		,c.CUSTOMER_NAME as segment
		,p.PRODUCT_NAME as material
        --,p.DESCRIPTION
        --,p.PROD_TYPE_ID
        --,pt.PROD_TYPE_NAME 
        --,pt.DESCRIPTION
        --pt.*
        --,od.[ORIG_DEL_DATE] as delivery_date_orig
        --,od.[DEL_DATE] as delivery_date
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
        ,s.QUANTITY as qty_plan
        ,s.QTY_MADE as qty_made
        ,s.STRIP_START as s_start
        ,s.STRIP_END as s_end
        ,pr.[ROW_NAME] as line
        ,pg.[GROUP_NAME] as line_group
        
        
		  FROM [FR_Gordon].[dbo].[_ORDERS] as o
		  JOIN [FR_Gordon].[dbo].[_CUSTOMERS] as c ON c.[CUSTOMER_ID] = o.[CUSTOMER_ID]
		  JOIN [FR_Gordon].[dbo].[_PRODUCTS] as p ON  p.PRODUCT_ID = o.PRODUCT_ID
		  JOIN [FR_Gordon].[dbo].[_PROD_TYPES] as pt ON pt.PROD_TYPE_ID = p.PROD_TYPE_ID
		  JOIN [FR_Gordon].[dbo].[_ORDER_DELIVERIES] as od ON od.ORDER_ID = o.ORDER_ID
		  
		  JOIN [FR_Gordon].[dbo].[_STRIP_DATA] as s ON s.ORDER_ID = o.ORDER_ID
		  JOIN [FR_Gordon].[dbo].[_PLAN_ROWS] as pr ON pr.ROW_ID = s.ROW_ID
		  JOIN [FR_Gordon].[dbo].[_PLAN_GROUPS] as pg ON pg.[GROUP_ID] = pr.[GROUP_ID]
		  
		  --JOIN [FR_Gordon].[dbo].[_ORDER_LOADCENTRES] ol ON o.ORDER_ID = ol.ORDER_ID
		  --JOIN [FR_Gordon].[dbo].[_LOADCENTRES] as l ON l.[LC_ID] = ol.[LC_ID] --AND LC_NAME = '400 Sewing out'				 --more lines
		  
		  --JOIN [FR_Gordon].[dbo].[_PLAN_UPDATES] as pu ON pu.ORDER_ID = o.ORDER_ID AND pu.ROW_ID = s.ROW_ID
		  
		  --JOIN [FR_Gordon].[dbo].[_ORDER_USER_DEFINED_VALUES] as udf ON o.ORDER_ID = udf.ORDER_ID  --more lines
		  
		  --WHERE o.ORDER_NAME like '%6848698%'
		  --WHERE o.ORDER_ID = '6818862'
		  WHERE o.ORDER_NAME = '".$data_local[0]->pro_fr."' "));

		return view('PRO.index_strip', compact('data'));
	}

	public function coois(Request $request, $id)
	{
		//
		$input = $request->all(); // change use (delete or comment user Requestl; )
		//var_dump($input);
		
		$data_local = DB::connection('sqlsrv')->select(DB::raw("SELECT pro FROM pro WHERE id = '".$id."' "));
		// dd($data_local[0]->pro);

		$data = DB::connection('sqlsrv')->select(DB::raw("SELECT [po]
		      ,[fg]
		      ,[activity]
		      ,[wc]
		      ,[list]
		      ,[material]
		      ,[uom]
		      ,[description]
		      ,[standard_qty]
		      ,[uom_desc]
		      ,[created_at]
		      ,[updated_at]
		  FROM [trebovanje].[dbo].[sap_coois]
		  WHERE po = '".$data_local[0]->pro."' ORDER BY wc asc "));
		// dd($data);

		return view('PRO.index_coois', compact('data'));
	}

	
}
