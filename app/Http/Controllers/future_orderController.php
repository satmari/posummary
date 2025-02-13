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
use App\future_orders;

use DB;
use Log;
use Session;

class future_orderController extends Controller {

	public function index()
	{
		//

		return view('future_orders.index');
	}

	public function future_order_1(Request $request)
	{	
		$this->validate($request, ['order_group'=>'required', 'order_group_macro'=>'required']);
		$input = $request->all(); // change use (delete or comment user Requestl; )
		// dd($input);


		$order_group_macro = $input['order_group_macro'];
		$order_group = $input['order_group'];

		return view('future_orders.import', compact('order_group_macro','order_group'));
	}

	public function future_order_status() {

		$data = DB::connection('sqlsrv')->select(DB::raw("SELECT DISTINCT[order_group]
			  FROM [posummary].[dbo].[future_orders] 
			  ORDER BY order_group asc  "));

		return view('future_orders.order_group_list', compact('data'));
	}

	public function future_order_2(Request $request) {	

		$this->validate($request, ['order_group_selected'=>'required', 'status_selected'=>'required']);
		$input = $request->all(); // change use (delete or comment user Requestl; )

		// dd($input);
		$status_selected = $input['status_selected'];
		$order_group_selected = $input['order_group_selected'];
		  

  		$data = DB::connection('sqlsrv')->update(DB::raw("UPDATE [posummary].[dbo].[future_orders]
  			SET status =  '".$status_selected."' 
  			WHERE order_group = '".$order_group_selected."' "));

  		$msgs = 'Edit status completed';
  		return view('future_orders.index',compact('msgs'));
	}

	public function future_order_update()
	{
		//
		return view('future_orders.update');
	}



	
}
