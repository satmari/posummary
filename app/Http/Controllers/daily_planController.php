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

class daily_planController extends Controller {

	public function index() {
		// dd("test");
		
		$data = DB::connection('sqlsrv')->select(DB::raw("SELECT * FROM [posummary].[dbo].[daily_plans] 
			WHERE  ([date]  > DATEADD(day,-1,GETDATE()) and  [date]  < DATEADD(day,0,GETDATE()) )"));
		return view('daily_plan.index', compact('data'));
	}

	public function index_all() {
		// dd("test");
		
		$data = DB::connection('sqlsrv')->select(DB::raw("SELECT * FROM [posummary].[dbo].[daily_plans] 
			ORDER BY [date] desc "));
		return view('daily_plan.index_all', compact('data'));
	}

	public function import_daily_plan() {

		return view('daily_plan.import_daily_plan');	
	}
	
	public function date_daily_plan(Request $request) {

		$input = $request->all();
		$import_date = $input['import_date'];
		// dd($import_date);

		return view('daily_plan.import_daily_plan_complete', compact('import_date'));		

	}

	

}
