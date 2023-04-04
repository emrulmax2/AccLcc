<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests\CsvStoreRequest;
use App\Http\Requests\MigrateCsvEntryRequest;
use App\Models\Transaction_csv_data;
use App\Models\Bank;
use App\Models\Category;
use App\Models\Method;
use App\Models\Transaction;
use App\Models\Transaction_log;

class TransactionCsvDataController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index($fileName = null){
        return view('pages/csv/index', [
            'title' => 'CSV - LCC Account Management',
            'storage' => Bank::where('status', 1)->get(),
            'csvfiles' => Transaction_csv_data::select('file_name')->groupBy('file_name')->get(),
            'fileName' => ($fileName != null ? urldecode(base64_decode($fileName)) : ''),
            'methods' => Method::where('status', 1)->get(),
            'entries'  => ($fileName != null ? $this->list(urldecode(base64_decode($fileName))) : [])
        ]);
    }

    protected function list($fileName = null){
        $CSVData = Transaction_csv_data::orderBy('id', 'ASC')->where('file_name','=', $fileName)->get();

        $res = array();
        if(!empty($CSVData)):
            $i = 1;
            foreach($CSVData as $csv):
                $res[] = [
                    'id' => $csv->id,
                    'sl' => $i,
                    'trans_date' => (isset($csv->trans_date) && !empty($csv->trans_date) ? date('d-m-Y', strtotime($csv->trans_date)) : ''),
                    'transaction_type' => $csv->transaction_type,
                    'invoice' => '',
                    'invoice_date' => '',
                    'details' => $csv->description,
                    'description' => '',
                    'bank_id' => $csv->bank_id,
                    'amount' => $csv->amount,
                    'categories'  => Category::whereNull('parent_id')->where('trans_type', $csv->transaction_type)->get()
                ];
                $i++;
            endforeach;
        endif;

        return $res;
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(CsvStoreRequest $request){
        if($request->hasFile('csv')):
            $bank_id = $request->bank_id;
            $fileOrgName = $request->csv->getClientOriginalName();
            $fileOrgName = str_replace(' ', '_', $fileOrgName);
            $fileRows = Transaction_csv_data::where('file_name', $fileOrgName)->count();
            if($fileRows > 0):
                return response()->json(['message' => 'Uploaded CSV file already exist in the system.', 'errors' => ['csv' => 'Uploaded CSV file allready exist in the system']], 422);
            else:
                $path = $request->file('csv')->getRealPath();
                $data = array_map('str_getcsv', file($path));
                if(!empty($data)):
                    $i = 1;
                    foreach($data as $d):
                        if($i > 1):
                            Transaction_csv_data::create([
                                'file_name'         => trim($fileOrgName),
                                'trans_date'        => ((isset($d[0]) && $d[0] != '') ? date('Y-m-d', strtotime($d[0])) : ''),
                                'description'       => $d[2],
                                'amount'            => str_replace('-', '', $d[3]),
                                'transaction_type'  => (($d[3] < 0) ? 1 : 0),
                                'bank_id'           => $bank_id
                            ]);
                        endif;
                        $i++;
                    endforeach;
                    return response()->json(['message' => 'CSV data successfully imported.', 'redirect' => route('csv').'/'.base64_encode(urlencode($fileOrgName))], 200);
                else:
                    return response()->json(['message' => 'Uploaded file is empty.', 'errors' => ['csv' => 'Uploaded CSV file is empty']], 422);
                endif;
            endif;
        endif;

    }

    public function migrate_csv(MigrateCsvEntryRequest $request){
        $csvID = $request->id;
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
            'invoice_no' => (!empty($request->invoice_no) ? $request->invoice_no : null),
            'invoice_date' => (!empty($request->invoice_date) ? date('Y-m-d', strtotime($request->invoice_date)) : null),
            'detail' => (isset($request->detail) ? $request->detail : ''),
            'description' => (isset($request->description) ? $request->description : ''),
            'category_id' => ($request->category_id > 0 ? $request->category_id : 0),
            'bank_id' => ($request->bank_id > 0 ? $request->bank_id : 0),
            'method_id' => ($request->method_id > 0 ? $request->method_id : 0),
            'transaction_type' => (isset($request->transaction_type) ? $request->transaction_type : 0),
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

            Transaction_csv_data::where('id', $csvID)->delete();
        endif;

        return response()->json($transaction);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Transaction_csv_data  $transaction_csv_data
     * @return \Illuminate\Http\Response
     */
    public function show(Transaction_csv_data $transaction_csv_data)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Transaction_csv_data  $transaction_csv_data
     * @return \Illuminate\Http\Response
     */
    public function edit(Transaction_csv_data $transaction_csv_data)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Transaction_csv_data  $transaction_csv_data
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Transaction_csv_data $transaction_csv_data)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Transaction_csv_data  $transaction_csv_data
     * @return \Illuminate\Http\Response
     */
    public function destroy(Transaction_csv_data $transaction_csv_data)
    {
        //
    }
}
