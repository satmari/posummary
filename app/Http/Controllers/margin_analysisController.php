<?php namespace App\Http\Controllers;

use App\Http\Requests;
use App\Http\Controllers\Controller;

use Illuminate\Http\Request;

use App\User;
use Bican\Roles\Models\Role;
use Bican\Roles\Models\Permission;
use Illuminate\Support\Facades\Redirect;
use Auth;

use App\margin_analysis;

use DB;
use Log;
use Session;

class margin_analysisController extends Controller {

	public function index()
	{
		//
		return view('margin_analysis.margin_analysis_date');
	}

	public function margin_analysis_post(Request $request) {

		// dd($request);

		$input = $request->all();
		$date = $input['date'];
		// dd($date);

		return view('margin_analysis.margin_analysis_import', compact('date'));

	}

// PLM costing
	public function plm_costing(Request $request) {

		return view('daily_plan.import_plm_costing');
	}

// // BOM cons
// 	public function bom_cons()
// 	{
// 		//
// 		return view('daily_plan.import_bom_cons');
// 	}

// // BOM cons ratio
// 	public function bom_cons_ratio()
// 	{
// 		//
// 		return view('daily_plan.import_bom_cons_ratio');
// 	}

}
