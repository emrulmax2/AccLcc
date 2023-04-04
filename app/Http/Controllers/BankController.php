<?php

namespace App\Http\Controllers;

use App\Models\Bank;
use Illuminate\Http\Request;
use App\Http\Requests\BankStoreRequest;
use App\Http\Requests\BankUpdateRequest;
use Illuminate\Support\Facades\Storage;

class BankController extends Controller
{
    public function index(){
        return view('pages/banks/index', [
            'title' => 'Bank Storage - LCC Account Management'
        ]);
    }

    public function list(Request $request){
        $storageName = (isset($request->storageName) && $request->storageName > 0 ? $request->storageName : '');
        $status = (isset($request->status) && $request->status > 0 ? $request->status : '');

        $page = (isset($request->page) && $request->page > 0 ? $request->page : 0);
        $perpage = (isset($request->size) && $request->size > 0 ? $request->size : 10);
        $total_rows = $count = Bank::count();
        $last_page = $total_rows > 0 ? ceil($total_rows / $perpage) : '';

        $sorters = (isset($request->sorters) && !empty($request->sorters) ? $request->sorters : array(['field' => 'id', 'dir' => 'asc']));
        $sorts = [];
        foreach($sorters as $sort):
            $sorts[] = $sort['field'].' '.$sort['dir'];
        endforeach;
        
        $limit = $perpage;
        $offset = ($page > 0 ? ($page - 1) * $perpage : 0);

        $query = Bank::orderByRaw(implode(',', $sorts));
        if(!empty($storageName)):
            $query->where('bank_name','LIKE','%'.$storageName.'%');
        endif;
        if(!empty($status) && $status > 0):
            if($status == 3):
                $query->onlyTrashed();
            else:
                $query->where('status', $status);
            endif;
        else:
            $query->where('status', 1);
        endif;
        $banks = $query->skip($offset)
               ->take($limit)
               ->get();

        $res = array();
        if(!empty($banks)):
            $i = 1;
            foreach($banks as $bnk):
                $res[] = [
                    'id' => $bnk->id,
                    'sl' => $i,
                    'bank_name' => $bnk->bank_name,
                    'bank_image' => (isset($bnk->bank_image) && !empty($bnk->bank_image) ? asset('storage/storages/'.$bnk->bank_image) : ''),
                    'status' => $bnk->status,
                    'deleted_at' => $bnk->deleted_at
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
    public function store(BankStoreRequest $request){

        if($request->hasFile('bank_image')):
            $imageName = 'storage_'.time() . '.' . $request->bank_image->getClientOriginalExtension();
            $path = $request->file('bank_image')->storeAs('public/storages', $imageName);
        endif;

        $bank = Bank::create([
            'bank_name' => $request->bank_name,
            'bank_image' => ($imageName ? $imageName : ''),
            'status' => (isset($request->status) && $request->status > 0 ? $request->status : 2)
        ]);

        return response()->json($bank);
        
    }

    public function show($id){
        $bank = Bank::find($id);
        $url = (isset($bank->bank_image) && !empty($bank->bank_image) ? asset('storage/storages/'.$bank->bank_image) : '');
        $bank->bank_image = $url;
        return response()->json($bank);
    }

    public function update(BankUpdateRequest $request, Bank $bank){
        $bankID = $request->id;
        $bankOldRow = Bank::find($bankID);

        $imageName = (isset($bankOldRow->bank_image) ? $bankOldRow->bank_image : '');
        if($request->hasFile('bank_image')):
            $imageName = 'storage_'.time() . '.' . $request->bank_image->getClientOriginalExtension();
            $path = $request->file('bank_image')->storeAs('public/storages', $imageName);
            if(isset($bankOldRow->bank_image) && !empty($bankOldRow->bank_image)):
                if (Storage::disk('local')->exists('public/storages/'.$bankOldRow->bank_image)):
                    Storage::delete('public/storages/'.$bankOldRow->bank_image);
                endif;
            endif;
        endif;

        $bank = Bank::where('id', $bankID)->update([
            'bank_name' => $request->bank_name,
            'bank_image' => ($imageName ? $imageName : ''),
            'status' => (isset($request->status) && $request->status > 0 ? $request->status : 2)
        ]);

        return response()->json($bank);
    }

    public function update_status(Request $request){
        $bank = Bank::where('id', $request->id)->update([
            'status' => $request->status
        ]);

        return response()->json($bank);
    }

    /**
     * Delete bank data
     * 
     * @param Bank $bank
     * 
     * @return \Illuminate\Http\Response
     */
    public function destroy($id){
        $bank = Bank::find($id)->delete();
        return response()->json($bank);
    }

    /**
     *  Restore bank data
     * 
     * @param Bank $user
     * 
     */
    public function restore($id) {
        $bank = Bank::where('id', $id)->withTrashed()->restore();

        response()->json($bank);
    }
}
