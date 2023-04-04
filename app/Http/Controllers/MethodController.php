<?php
namespace App\Http\Controllers;

use App\Models\Method;
use Illuminate\Http\Request;
use App\Http\Requests\MethodStoreRequest;
use App\Http\Requests\MethodUpdateReques;

class MethodController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(){
        return view('pages/methods/index', [
            'title' => 'Transection Methods - LCC Account Management'
        ]);
    }

    public function list(Request $request){
        $methodName = (isset($request->methodName) && $request->methodName > 0 ? $request->methodName : '');
        $status = (isset($request->status) && $request->status > 0 ? $request->status : '');

        $page = (isset($request->page) && $request->page > 0 ? $request->page : 0);
        $perpage = (isset($request->size) && $request->size > 0 ? $request->size : 10);
        $total_rows = $count = Method::count();
        $last_page = $total_rows > 0 ? ceil($total_rows / $perpage) : '';

        $sorters = (isset($request->sorters) && !empty($request->sorters) ? $request->sorters : array(['field' => 'id', 'dir' => 'asc']));
        $sorts = [];
        foreach($sorters as $sort):
            $sorts[] = $sort['field'].' '.$sort['dir'];
        endforeach;
        
        $limit = $perpage;
        $offset = ($page > 0 ? ($page - 1) * $perpage : 0);

        $query = Method::orderByRaw(implode(',', $sorts));
        if(!empty($methodName)):
            $query->where('method_name','LIKE','%'.$methodName.'%');
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
        $methods = $query->skip($offset)
               ->take($limit)
               ->get();

        $res = array();
        if(!empty($methods)):
            $i = 1;
            foreach($methods as $mth):
                $res[] = [
                    'id' => $mth->id,
                    'sl' => $i,
                    'method_name' => $mth->method_name,
                    'status' => $mth->status,
                    'deleted_at' => $mth->deleted_at
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
    public function store(MethodStoreRequest $request){
        $method = Method::create([
            'method_name' => $request->method_name,
            'status' => (isset($request->status) && $request->status > 0 ? $request->status : 2)
        ]);

        return response()->json($method);
    }

    /**
     * Update method status.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function update_status(Request $request){
        $method = Method::where('id', $request->id)->update([
            'status' => $request->status
        ]);

        return response()->json($method);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Method  $method
     * @return \Illuminate\Http\Response
     */
    public function show(Request $request){
        $method = Method::find($request->id);
        return response()->json($method);
    }


    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Method  $method
     * @return \Illuminate\Http\Response
     */
    public function update(MethodUpdateReques $request, Method $method){
        $methodID = $request->id;

        $method = Method::where('id', $methodID)->update([
            'method_name' => $request->method_name,
            'status' => (isset($request->status) && $request->status > 0 ? $request->status : 2)
        ]);

        return response()->json($method);
    }


    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Method  $method
     * @return \Illuminate\Http\Response
     */
    public function destroy($id){
        $method = Method::find($id)->delete();
        return response()->json($method);
    }

    /**
     *  Restore Method data
     * 
     * @param Method $id
     * 
     */
    public function restore($id) {
        $method = Method::where('id', $id)->withTrashed()->restore();

        response()->json($method);
    }
}
