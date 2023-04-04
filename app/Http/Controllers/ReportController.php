<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests\ReportRequest;
use App\Models\Bank;
use App\Models\Category;
use App\Models\Method;
use App\Models\Transaction;

class ReportController extends Controller{

    public function index(){
        return view('pages/report/index', [
            'title' => 'Reports - LCC Account Management'
        ]);
    }

    public function list(ReportRequest $request){
        $start_date = (isset($request->start_date) && !empty($request->start_date) ? $request->start_date : '');
        $end_date = (isset($request->end_date) && !empty($request->end_date) ? $request->end_date : '');

        if(!empty($start_date) && !empty($end_date)){
            
        }else{
            return response()->json(['message' => 'Start & End date can not be empty!'], 422);
        }

    }

}
