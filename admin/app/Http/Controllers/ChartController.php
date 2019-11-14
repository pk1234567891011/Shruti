<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Users;
use DB;
use App\OrderDetails;
use Charts;
use App\UserOrder;

class ChartController extends Controller
{
    public function index()
    {
    	$users = Users::where(DB::raw("(DATE_FORMAT(created_at,'%Y'))"),date('Y'))
    				->get();
        $chart = Charts::database($users, 'bar', 'highcharts')
					->title("Monthly new Register Users")
					->elementLabel("Total Users")
					->dimensions(600, 500)
					->groupByMonth(date('Y'), true);
        return view('reports.users',compact('chart'));
	}
	public function sales()
	{
		$sales= OrderDetails::where(DB::raw("(DATE_FORMAT(created_at,'%Y'))"),date('Y'))
					->get();
		$chart = Charts::database($sales, 'bar', 'highcharts')
					->title("Monthly Product Sales")
					->elementLabel("Total orders")
					->dimensions(600, 500)
					->groupByMonth(date('Y'), true);
		return view('reports.sales',compact('chart'));
	}
	public function couponused()
	{
		$coupon = UserOrder::where([
			[DB::raw("(DATE_FORMAT(created_at,'%Y'))"),date('Y')],
			['coupon_id','!=',NULL]
	
			])
							->get();
		$chart = Charts::database($coupon, 'bar', 'highcharts')
					->title("Monthly Coupon Used")
					->elementLabel("Total Coupons Used")
					->dimensions(600, 500)
					->groupByMonth(date('Y'), true);
		return view('reports.coupons',compact('chart'));
	}
}
