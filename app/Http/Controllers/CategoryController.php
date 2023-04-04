<?php

namespace App\Http\Controllers;

use App\Models\Category;
use Illuminate\Http\Request;
use App\Http\Requests\CategoryStoreRequest;
use App\Http\Requests\CategoryUpdateRequest;

class CategoryController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index() {
        $categories = Category::whereNull('parent_id')->where('trans_type', 0)->get();
        $allCategories = Category::pluck('category_name','id')->all();
        
        return view('pages/categories/index', [
            'title' => 'Transection Categories - LCC Account Management',
            'categories' => $categories,
            'allCategories' => $allCategories,
            'lavel' => 1
        ]);
    }


    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(CategoryStoreRequest $request){
        $category = Category::create([
            'category_name' => $request->category_name,
            'trans_type' => (isset($request->trans_type) && !empty($request->trans_type) ? $request->trans_type : 0),
            'parent_id' => (isset($request->parent_id) && !empty($request->parent_id) ? $request->parent_id : null),
            'status' => (isset($request->status) && $request->status > 0 ? $request->status : 2)
        ]);

        $categories = Category::with('childrenRecursive')->whereNull('parent_id')->get();

        return response()->json($category);
    }

    
    public function list(Request $request, $type){
        $categoryName = (isset($request->categoryName) && $request->categoryName > 0 ? $request->categoryName : '');
        $status = (isset($request->status) && $request->status > 0 ? $request->status : '');

        $page = (isset($request->page) && $request->page > 0 ? $request->page : 0);
        $perpage = (isset($request->size) && $request->size > 0 ? $request->size : 10);
        $total_rows = $count = Category::count();
        $last_page = $total_rows > 0 ? ceil($total_rows / $perpage) : '';

        $sorters = (isset($request->sorters) && !empty($request->sorters) ? $request->sorters : array(['field' => 'id', 'dir' => 'asc']));
        $sorts = [];
        foreach($sorters as $sort):
            $sorts[] = $sort['field'].' '.$sort['dir'];
        endforeach;
        
        $limit = $perpage;
        $offset = ($page > 0 ? ($page - 1) * $perpage : 0);

        $query = Category::with('childrenRecursive')->orderByRaw(implode(',', $sorts));
        if(!empty($categoryName)):
            $query->where('category_name','LIKE','%'.$categoryName.'%');
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
        $categories = $query->where('trans_type', $type)->whereNull('parent_id')->get();
        
        $res = array();
        if(!empty($categories)):
            $i = 0;
            foreach($categories as $key => $cats):
                $res[] = [
                    'id' => $cats->id,
                    'category_name' => $cats->category_name,
                    'status' => $cats->status,
                    'deleted_at' => $cats->deleted_at,
                    '_children' => $this->recursiv_child($cats->childrens)
                ];
                $i++;
            endforeach;
        endif;
        return response()->json(['data' => $res]);
        
    }

    protected function recursiv_child($childrens){
        if(!empty($childrens)):
            $res = [];
            foreach($childrens as $childs):
                $res[] = [
                    'id' => $childs->id,
                    'category_name' => $childs->category_name,
                    'status' => $childs->status,
                    'deleted_at' => $childs->deleted_at,
                    '_children' => $this->recursiv_child($childs->childrens)
                ];
            endforeach;
            return $res;
        else:
            return [];
        endif;
    }

    public function get_trans_type_options(Request $request){
        $trans_type = $request->trans_type;

        $options = '<option value="">Select Parent Category</option>';
        $categories = Category::with('childrenRecursive')->where('trans_type', $trans_type)->whereNull('parent_id')->where('status', 1)->get();
        if(!empty($categories)):
            foreach($categories as $cats):
                $options .= '<option value="'.$cats->id.'">'.$cats->category_name.'</option>';
                if(!empty($cats->childrens)):
                    $options .= $this->recursiv_child_options($cats->childrens, 1);
                endif;
            endforeach;
        endif;
        return response()->json(['html' => $options]);
    }

    protected function recursiv_child_options($childrens, $level){
        if(!empty($childrens)):
            $options = '';
            foreach($childrens as $childs):
                $options = '<option value="'.$childs->id.'">'.str_repeat('-', $level).$childs->category_name.'</option>';
                if(!empty($childs->childrens)):
                    $level++;
                    $options .= $this->recursiv_child_options($childs->childrens, $level);
                endif;
            endforeach;
            return $options;
        else:
            return '';
        endif;
    }

    /**
     * Update method status.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function update_status(Request $request){
        $method = Category::where('id', $request->id)->update([
            'status' => $request->status
        ]);

        return response()->json($method);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Category  $category
     * @return \Illuminate\Http\Response
     */
    public function show(Request $request)
    {
        $method = Category::find($request->id);
        $trans_type = (isset($method->trans_type) ? $method->trans_type : 0);

        $options = '<option value="">Select Parent Category</option>';
        $categories = Category::with('childrenRecursive')->where('trans_type', $trans_type)->whereNull('parent_id')->where('status', 1)->get();
        if(!empty($categories)):
            foreach($categories as $cats):
                $options .= '<option value="'.$cats->id.'">'.$cats->category_name.'</option>';
                if(!empty($cats->childrens)):
                    $options .= $this->recursiv_child_options($cats->childrens, 1);
                endif;
            endforeach;
        endif;

        $method['options'] = $options;

        return response()->json($method);
    }


    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Category  $category
     * @return \Illuminate\Http\Response
     */
    public function update(CategoryUpdateRequest $request, Category $category){
        $categoryID = $request->id;

        $category = Category::where('id', $categoryID)->update([
            'category_name' => $request->category_name,
            'trans_type' => (isset($request->trans_type) && !empty($request->trans_type) ? $request->trans_type : 0),
            'parent_id' => (isset($request->parent_id) && !empty($request->parent_id) ? $request->parent_id : null),
            'status' => (isset($request->status) && $request->status > 0 ? $request->status : 2)
        ]);

        return response()->json($category);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Method  $method
     * @return \Illuminate\Http\Response
     */
    public function destroy($id){
        $category = Category::find($id)->delete();
        return response()->json($category);
    }

    /**
     *  Restore Method data
     * 
     * @param Method $id
     * 
     */
    public function restore($id) {
        $category = Category::where('id', $id)->withTrashed()->restore();

        response()->json($category);
    }
}
