<?php

namespace App\Http\Controllers;

use App\Models\Transaction;
use Illuminate\Http\Request;
use App\Models\Category;
use App\Models\Method;
use App\Models\Bank;
use App\Http\Requests\TransactionStoreRequest;
use Illuminate\Support\Facades\Storage;
use App\Models\Transaction_log;

class TransactionController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(){
        $categories = Category::whereNull('parent_id')->where('trans_type', 0)->get();
        return view('pages/transactions/index', [
            'title' => 'Transections - LCC Account Management',
            'methods' => Method::where('status', 1)->get(),
            'storages' => Bank::where('status', 1)->get(),
            'categories' => $categories,
            'lavel' => 1
        ]);
    }

    public function list(Request $request){
        $srcArgs = (isset($request->srcArgs) && $request->srcArgs > 0 ? $request->srcArgs : []);
        $transactionCode = (isset($srcArgs['transactionCode']) && !empty($srcArgs['transactionCode']) ? $srcArgs['transactionCode'] : '');
        $startDate = (isset($srcArgs['startDate']) && !empty($srcArgs['startDate']) ? date('Y-m-d', strtotime($srcArgs['startDate'])) : '');
        $endDate = (isset($srcArgs['endDate']) && !empty($srcArgs['endDate']) ? date('Y-m-d', strtotime($srcArgs['endDate'])) : '');
        $invoiceNo = (isset($srcArgs['invoiceNo']) && !empty($srcArgs['invoiceNo']) ? date('Y-m-d', strtotime($srcArgs['invoiceNo'])) : '');
        $methodID = (isset($srcArgs['methodID']) && !empty($srcArgs['methodID']) ? $srcArgs['methodID'] : 0);
        $bankID = (isset($srcArgs['bankID']) && !empty($srcArgs['bankID']) ? $srcArgs['bankID'] : 0);
        $detailsDesc = (isset($srcArgs['detailsDesc']) && !empty($srcArgs['detailsDesc']) ? $srcArgs['detailsDesc'] : '');
        $amountFrom = (isset($srcArgs['amountFrom']) && !empty($srcArgs['amountFrom']) ? $srcArgs['amountFrom'] : '');
        $amountTo = (isset($srcArgs['amountTo']) && !empty($srcArgs['amountTo']) ? $srcArgs['amountTo'] : '');

        $flow = (isset($srcArgs['flow']) && $srcArgs['flow'] != null ? $srcArgs['flow'] : '');
        $categoryID = (isset($srcArgs['categoryID']) && !empty($srcArgs['categoryID']) ? $srcArgs['categoryID'] : 0);

        $page = (isset($request->page) && $request->page > 0 ? $request->page : 0);
        $total_rows = $count = Transaction::count();
        $perpage = (isset($request->size) && $request->size == 'true' ? $total_rows : ($request->size > 0 ? $request->size : 10));
        $last_page = $total_rows > 0 ? ceil($total_rows / $perpage) : '';

        $sorters = (isset($request->sorters) && !empty($request->sorters) ? $request->sorters : array(['field' => 'id', 'dir' => 'asc']));
        $sorts = [];
        foreach($sorters as $sort):
            $sorts[] = $sort['field'].' '.$sort['dir'];
        endforeach;
        
        $limit = $perpage;
        $offset = ($page > 0 ? ($page - 1) * $perpage : 0);

        $query = Transaction::orderByRaw(implode(',', $sorts));
        if(!empty($transactionCode)):
            $query->where('transaction_code','LIKE','%'.$transactionCode.'%');
        endif;
        if(!empty($startDate)):
            $query->whereDate('transaction_date', ' >= ', $startDate);
        endif;
        if(!empty($endDate)):
            $query->whereDate('transaction_date', ' <= ', $endDate);
        endif;
        if(!empty($invoiceNo)):
            $query->where('invoice_no', 'LIKE', '%'.$invoiceNo.'%');
        endif;
        if(!empty($methodID) && $methodID > 0):
            $query->where('method_id', '=', $methodID);
        endif;
        if(!empty($bankID) && $bankID > 0):
            $query->where('bank_id', '=', $bankID);
        endif;
        if(!empty($detailsDesc)):
            $query->where('detail', 'LIKE', '%'.$detailsDesc.'%');
            $query->where('description', 'LIKE', '%'.$detailsDesc.'%');
        endif;
        if(!empty($amountFrom)):
            $query->where('transaction_amount', '>=', $amountFrom);
        endif;
        if(!empty($amountTo)):
            $query->where('transaction_amount', '<=', $amountTo);
        endif;
        if($flow != null):
            $query->where('transaction_type', '=', $flow);
            if($categoryID > 0):
                $query->where('category_id', '=', $categoryID);
            endif;
        endif;

        $transactions = $query->skip($offset)
               ->take($limit)
               ->get();
               
        $res = array();
        if(!empty($transactions)):
            $i = 1;
            foreach($transactions as $trns):
                $res[] = [
                    'id' => $trns->id,
                    'sl' => $i,
                    'transaction_code' => $trns->transaction_code,
                    'transaction_date' => (!empty($trns->transaction_date) ? date('d-m-Y', strtotime($trns->transaction_date)) : ''),
                    'invoice_no' => $trns->invoice_no,
                    'invoice_date' => (!empty($trns->invoice_date) ? date('d-m-Y', strtotime($trns->invoice_date)) : ''),
                    'detail' => $trns->detail,
                    'description' => $trns->description,
                    'transaction_amount' => $trns->transaction_amount,
                    'transaction_type' => $trns->transaction_type,
                    'category' => $trns->category->category_name,
                    'method' => $trns->method->method_name,
                    'storage' => $trns->bank->bank_name,
                    'docs' => (isset($trns->transaction_doc_name) && !empty($trns->transaction_doc_name) ? asset('storage/transactions/'.$trns->transaction_doc_name) : ''),
                    'deleted_at' => $trns->deleted_at
                ];
                $i++;
            endforeach;
        endif;
        return response()->json(['last_page' => $last_page, 'data' => $res]);
        
    }

    public function log_list(Request $request){
        $transactionID = (isset($request->transactionID) && $request->transactionID > 0 ? $request->transactionID : 0);
        $page = (isset($request->page) && $request->page > 0 ? $request->page : 0);
        $perpage = (isset($request->size) && $request->size > 0 ? $request->size : 10);
        $total_rows = $count = Transaction_log::count();
        $last_page = $total_rows > 0 ? ceil($total_rows / $perpage) : '';

        $sorters = (isset($request->sorters) && !empty($request->sorters) ? $request->sorters : array(['field' => 'id', 'dir' => 'asc']));
        $sorts = [];
        foreach($sorters as $sort):
            $sorts[] = $sort['field'].' '.$sort['dir'];
        endforeach;
        
        $limit = $perpage;
        $offset = ($page > 0 ? ($page - 1) * $perpage : 0);

        $transactionLogs = Transaction_log::orderByRaw(implode(',', $sorts))->where('transaction_id', $transactionID)->skip($offset)
               ->take($limit)
               ->get();
        
        $res = array();
        if(!empty($transactionLogs)):
            $i = 1;
            foreach($transactionLogs as $log):
                $res[] = [
                    'id' => $log->id,
                    'sl' => $i,
                    'old_amount' => '£'.$log->old_amount,
                    'new_amount' => '£'.$log->new_amount,
                    'log_date' => (!empty($log->log_date) ? date('d-m-Y', strtotime($log->log_date)) : ''),
                    'log_type' => $log->log_type,
                    'user_id' => $log->user_id,
                    'done_by' => $log->user->name,
                ];
                $i++;
            endforeach;
        endif;
        return response()->json(['last_page' => $last_page, 'data' => $res]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(TransactionStoreRequest $request){
        $row = Transaction::latest()->first();
        $t_code = (isset($row->transaction_code)) ? $row->transaction_code : 'TC00000';
        $tcn = substr($t_code, 2, 5) + 1;
        $transaction_code = 'TC'.sprintf("%05s", $tcn);

        $docName = '';
        if($request->hasFile('transaction_doc_name')):
            $docName = 'TRNS_'.time() . '.' . $request->transaction_doc_name->getClientOriginalExtension();
            $path = $request->file('transaction_doc_name')->storeAs('public/transactions', $docName);
        endif;

        $transaction = Transaction::create([
            'transaction_code' => $transaction_code,
            'transaction_date' => (!empty($request->transaction_date) ? date('Y-m-d', strtotime($request->transaction_date)) : null),
            'cheque_no' => (!empty($request->cheque_no) ? $request->cheque_no : null),
            'cheque_date' => (!empty($request->cheque_date) ? date('Y-m-d', strtotime($request->cheque_date)) : null),
            'invoice_no' => (!empty($request->invoice_no) ? $request->invoice_no : null),
            'invoice_date' => (!empty($request->invoice_date) ? date('Y-m-d', strtotime($request->invoice_date)) : null),
            'category_id' => ($request->category_id > 0 ? $request->category_id : 0),
            'bank_id' => ($request->bank_id > 0 ? $request->bank_id : 0),
            'method_id' => ($request->method_id > 0 ? $request->method_id : 0),
            'transaction_type' => (isset($request->transaction_type) ? $request->transaction_type : 0),
            'detail' => (isset($request->detail) ? $request->detail : ''),
            'description' => (isset($request->description) ? $request->description : ''),
            'transaction_amount' => (isset($request->transaction_amount) ? $request->transaction_amount : 0),
            'transaction_doc_name' => ($docName ? $docName : ''),
            'created_by' => auth()->user()->id
        ]);

        if($transaction->id):
            $logs = Transaction_log::create([
                'transaction_id' => $transaction->id,
                'user_id' => auth()->user()->id,
                'old_amount' => 0,
                'new_amount' => (isset($request->transaction_amount) ? $request->transaction_amount : 0),
                'log_date' => date('Y-m-d'),
                'log_type' => 'Add',

            ]);
        endif;

        return response()->json($transaction);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\transaction  $transaction
     * @return \Illuminate\Http\Response
     */
    public function show($id){
        return view('pages/transactions/show', [
            'title' => 'Transection Details - LCC Account Management',
            'transaction' => Transaction::find($id)
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\transaction  $transaction
     * @return \Illuminate\Http\Response
     */
    public function edit(Request $request){
        $transaction = Transaction::find($request->id);
        $url = (isset($transaction->transaction_doc_name) && !empty($transaction->transaction_doc_name) ? asset('storage/transactions/'.$transaction->transaction_doc_name) : '');
        $transaction->transaction_doc_name = $url;
        $transaction->transaction_date = (!empty($transaction->transaction_date) ? date('d-m-Y', strtotime($transaction->transaction_date)) : '');
        $transaction->invoice_date = (!empty($transaction->invoice_date) ? date('d-m-Y', strtotime($transaction->invoice_date)) : '');
        $transaction->cheque_date = (!empty($transaction->cheque_date) ? date('d-m-Y', strtotime($transaction->cheque_date)) : '');

        $type_options = '<option value="">Select Transaction Category</option>';
        $categories = Category::with('childrenRecursive')->where('trans_type', $transaction->transaction_type)->whereNull('parent_id')->where('status', 1)->get();
        if(!empty($categories)):
            foreach($categories as $cats):
                $type_options .= '<option value="'.$cats->id.'">'.$cats->category_name.'</option>';
                if(!empty($cats->childrens)):
                    $type_options .= $this->get_recursiv_transaction_category_child_option_tree($cats->childrens, 1);
                endif;
            endforeach;
        endif;

        $transaction['type_options'] = $type_options;
        $transaction['method_names'] = $transaction->method->method_name;

        return response()->json($transaction);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\transaction  $transaction
     * @return \Illuminate\Http\Response
     */
    public function update(TransactionStoreRequest $request){
        $transactionID = $request->id;
        $transactionOldRow = Transaction::find($transactionID);

        $docName = (isset($transactionOldRow->transaction_doc_name) ? $transactionOldRow->transaction_doc_name : '');
        if($request->hasFile('transaction_doc_name')):
            $docName = 'TRNS_'.time() . '.' . $request->transaction_doc_name->getClientOriginalExtension();
            $path = $request->file('transaction_doc_name')->storeAs('public/transactions', $docName);
            if(isset($transactionOldRow->transaction_doc_name) && !empty($transactionOldRow->transaction_doc_name)):
                if (Storage::disk('local')->exists('public/transactions/'.$transactionOldRow->transaction_doc_name)):
                    Storage::delete('public/transactions/'.$transactionOldRow->transaction_doc_name);
                endif;
            endif;
        endif;

        $transaction = Transaction::where('id', $transactionID)->update([
            'transaction_date' => (!empty($request->transaction_date) ? date('Y-m-d', strtotime($request->transaction_date)) : null),
            'cheque_no' => (!empty($request->cheque_no) ? $request->cheque_no : null),
            'cheque_date' => (!empty($request->cheque_date) ? date('Y-m-d', strtotime($request->cheque_date)) : null),
            'invoice_no' => (!empty($request->invoice_no) ? $request->invoice_no : null),
            'invoice_date' => (!empty($request->invoice_date) ? date('Y-m-d', strtotime($request->invoice_date)) : null),
            'category_id' => ($request->category_id > 0 ? $request->category_id : 0),
            'bank_id' => ($request->bank_id > 0 ? $request->bank_id : 0),
            'method_id' => ($request->method_id > 0 ? $request->method_id : 0),
            'transaction_type' => (isset($request->transaction_type) ? $request->transaction_type : 0),
            'detail' => (isset($request->detail) ? $request->detail : ''),
            'description' => (isset($request->description) ? $request->description : ''),
            'transaction_amount' => (isset($request->transaction_amount) ? $request->transaction_amount : 0),
            'transaction_doc_name' => ($docName ? $docName : ''),
            'updated_by' => auth()->user()->id
        ]);

        if($transaction):
            $logs = Transaction_log::create([
                'transaction_id' => $transactionID,
                'user_id' => auth()->user()->id,
                'old_amount' => (isset($transactionOldRow->transaction_amount) ? $transactionOldRow->transaction_amount : 0),
                'new_amount' => (isset($request->transaction_amount) ? $request->transaction_amount : 0),
                'log_date' => date('Y-m-d'),
                'log_type' => 'Edit',
                
            ]);
        endif;

        return response()->json($transaction);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\transaction  $transaction
     * @return \Illuminate\Http\Response
     */
    public function destroy(transaction $transaction)
    {
        //
    }

    public function get_transaction_category_option_tree(Request $request){
        $trans_type = (isset($request->trans_type) ? $request->trans_type : 0);

        $options = '<option value="">Select Transaction Category</option>';
        $categories = Category::with('childrenRecursive')->where('trans_type', $trans_type)->whereNull('parent_id')->where('status', 1)->get();
        if(!empty($categories)):
            foreach($categories as $cats):
                $options .= '<option value="'.$cats->id.'">'.$cats->category_name.'</option>';
                if(!empty($cats->childrens)):
                    $options .= $this->get_recursiv_transaction_category_child_option_tree($cats->childrens, 1);
                endif;
            endforeach;
        endif;
        return response()->json(['html' => $options]);
    }

    protected function get_recursiv_transaction_category_child_option_tree($childrens, $level){
        if(!empty($childrens)):
            $options = '';
            foreach($childrens as $childs):
                $options .= '<option value="'.$childs->id.'">'.str_repeat('-', $level).$childs->category_name.'</option>';
                if(!empty($childs->childrens)):
                    $level++;
                    $options .= $this->get_recursiv_transaction_category_child_option_tree($childs->childrens, $level);
                endif;
            endforeach;
            return $options;
        else:
            return '';
        endif;
    }
}
