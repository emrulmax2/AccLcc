@extends('../layout/' . $layout)

@section('subhead')
    <title>{{ $title }}</title>
@endsection

@section('subcontent')
    <div class="intro-y flex flex-col sm:flex-row items-center mt-8">
        <h2 class="text-lg font-medium mr-auto">All Categories</h2>
        <div class="w-full sm:w-auto flex mt-4 sm:mt-0">
            <a href="javascript:void(0);" data-tw-toggle="modal" data-tw-target="#addCategoryModal" class="btn btn-primary shadow-md mr-2">Add New Category</a>
            <div class="dropdown ml-auto sm:ml-0">
                <button class="dropdown-toggle btn px-2 box" aria-expanded="false" data-tw-toggle="dropdown">
                    <span class="w-5 h-5 flex items-center justify-center">
                        <i class="w-4 h-4" data-lucide="plus"></i>
                    </span>
                </button>
                <div class="dropdown-menu w-40">
                    <ul class="dropdown-content">
                        <li>
                            <a href="" class="dropdown-item">
                                <i data-lucide="file-plus" class="w-4 h-4 mr-2"></i> New Category
                            </a>
                        </li>
                        <li>
                            <a href="" class="dropdown-item">
                                <i data-lucide="users" class="w-4 h-4 mr-2"></i> New Group
                            </a>
                        </li>
                    </ul>
                </div>
            </div>
        </div>
    </div>
    <!-- BEGIN: HTML Table Data -->
    <div class="grid grid-cols-2 gap-6">
        <div class="intro-y box p-5 mt-5">
            <h2 class="text-lg font-medium mr-auto pb-5">Inflow</h2>
            <div class="flex flex-col sm:flex-row sm:items-end xl:items-start">
                <form id="tabulatorInflowFilterForm" class="xl:flex sm:mr-auto" >
                    <div class="sm:flex items-center sm:mr-4 mt-2 xl:mt-0">
                        <label class="w-12 flex-none xl:w-auto xl:flex-initial mr-2">Category</label>
                        <input id="inflow_category_name" name="category_name" type="text" class="form-control sm:w-40 2xl:w-full mt-2 sm:mt-0"  placeholder="Search...">
                    </div>
                    <div class="sm:flex items-center sm:mr-4 mt-2 xl:mt-0">
                        <label class="w-12 flex-none xl:w-auto xl:flex-initial mr-2">Status</label>
                        <select id="inflow_status" name="status" class="form-select w-full mt-2 sm:mt-0 sm:w-auto" >
                            <option value="">Status</option>
                            <option value="1">Active</option>
                            <option value="2">In Active</option>
                            <option value="3">Archived</option>
                        </select>
                    </div>
                    <div class="mt-2 xl:mt-0">
                        <button id="tabulator-html-filter-go-inflow" type="button" class="btn btn-primary w-full sm:w-16" >Go</button>
                        <button id="tabulator-html-filter-reset-inflow" type="button" class="btn btn-secondary w-full sm:w-16 mt-2 sm:mt-0 sm:ml-1" >Reset</button>
                    </div>
                </form>
                <div class="flex mt-5 sm:mt-0">
                    <button id="tabulator-print-inflow" class="btn btn-outline-secondary w-1/2 sm:w-auto mr-2">
                        <i data-lucide="printer" class="w-4 h-4 mr-2"></i> Print
                    </button>
                    <div class="dropdown w-1/2 sm:w-auto">
                        <button class="dropdown-toggle btn btn-outline-secondary w-full sm:w-auto" aria-expanded="false" data-tw-toggle="dropdown">
                            <i data-lucide="file-text" class="w-4 h-4 mr-2"></i> Export <i data-lucide="chevron-down" class="w-4 h-4 ml-auto sm:ml-2"></i>
                        </button>
                        <div class="dropdown-menu w-40">
                            <ul class="dropdown-content">
                                <li>
                                    <a id="tabulator-export-csv-inflow" href="javascript:;" class="dropdown-item">
                                        <i data-lucide="file-text" class="w-4 h-4 mr-2"></i> Export CSV
                                    </a>
                                </li>
                                <li>
                                    <a id="tabulator-export-json-inflow" href="javascript:;" class="dropdown-item">
                                        <i data-lucide="file-text" class="w-4 h-4 mr-2"></i> Export JSON
                                    </a>
                                </li>
                                <li>
                                    <a id="tabulator-export-xlsx-inflow" href="javascript:;" class="dropdown-item">
                                        <i data-lucide="file-text" class="w-4 h-4 mr-2"></i> Export XLSX
                                    </a>
                                </li>
                                <li>
                                    <a id="tabulator-export-html-inflow" href="javascript:;" class="dropdown-item">
                                        <i data-lucide="file-text" class="w-4 h-4 mr-2"></i> Export HTML
                                    </a>
                                </li>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
            <div class="overflow-x-auto scrollbar-hidden">
                <div id="inflowCategoryListTable" class="mt-5 table-report table-report--tabulator"></div>
            </div>
        </div>
        <div class="intro-y box p-5 mt-5">
            <h2 class="text-lg font-medium mr-auto pb-5">Outflow</h2>
            <div class="flex flex-col sm:flex-row sm:items-end xl:items-start">
                <form id="tabulatorOutflowFilterForm" class="xl:flex sm:mr-auto" >
                    <div class="sm:flex items-center sm:mr-4 mt-2 xl:mt-0">
                        <label class="w-12 flex-none xl:w-auto xl:flex-initial mr-2">Category</label>
                        <input id="outflow_category_name" name="category_name" type="text" class="form-control sm:w-40 2xl:w-full mt-2 sm:mt-0"  placeholder="Search...">
                    </div>
                    <div class="sm:flex items-center sm:mr-4 mt-2 xl:mt-0">
                        <label class="w-12 flex-none xl:w-auto xl:flex-initial mr-2">Status</label>
                        <select id="outflow_status" name="status" class="form-select w-full mt-2 sm:mt-0 sm:w-auto" >
                            <option value="">Status</option>
                            <option value="1">Active</option>
                            <option value="2">In Active</option>
                            <option value="3">Archived</option>
                        </select>
                    </div>
                    <div class="mt-2 xl:mt-0">
                        <button id="tabulator-html-filter-go-outflow" type="button" class="btn btn-primary w-full sm:w-16" >Go</button>
                        <button id="tabulator-html-filter-reset-outflow" type="button" class="btn btn-secondary w-full sm:w-16 mt-2 sm:mt-0 sm:ml-1" >Reset</button>
                    </div>
                </form>
                <div class="flex mt-5 sm:mt-0">
                    <button id="tabulator-print-outflow" class="btn btn-outline-secondary w-1/2 sm:w-auto mr-2">
                        <i data-lucide="printer" class="w-4 h-4 mr-2"></i> Print
                    </button>
                    <div class="dropdown w-1/2 sm:w-auto">
                        <button class="dropdown-toggle btn btn-outline-secondary w-full sm:w-auto" aria-expanded="false" data-tw-toggle="dropdown">
                            <i data-lucide="file-text" class="w-4 h-4 mr-2"></i> Export <i data-lucide="chevron-down" class="w-4 h-4 ml-auto sm:ml-2"></i>
                        </button>
                        <div class="dropdown-menu w-40">
                            <ul class="dropdown-content">
                                <li>
                                    <a id="tabulator-export-csv-outflow" href="javascript:;" class="dropdown-item">
                                        <i data-lucide="file-text" class="w-4 h-4 mr-2"></i> Export CSV
                                    </a>
                                </li>
                                <li>
                                    <a id="tabulator-export-json-outflow" href="javascript:;" class="dropdown-item">
                                        <i data-lucide="file-text" class="w-4 h-4 mr-2"></i> Export JSON
                                    </a>
                                </li>
                                <li>
                                    <a id="tabulator-export-xlsx-outflow" href="javascript:;" class="dropdown-item">
                                        <i data-lucide="file-text" class="w-4 h-4 mr-2"></i> Export XLSX
                                    </a>
                                </li>
                                <li>
                                    <a id="tabulator-export-html-outflow" href="javascript:;" class="dropdown-item">
                                        <i data-lucide="file-text" class="w-4 h-4 mr-2"></i> Export HTML
                                    </a>
                                </li>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
            <div class="overflow-x-auto scrollbar-hidden">
                <div id="outfolowCategoryListTable" class="mt-5 table-report table-report--tabulator"></div>
            </div>
        </div>
    </div>
    <!-- END: HTML Table Data -->

    <!-- BEGIN: Add Storage Modal -->
    <div id="addCategoryModal" class="modal" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog">
            <form method="POST" action="#" id="addCategoryForm">
                <div class="modal-content">
                    <div class="modal-header">
                        <h2 class="font-medium text-base mr-auto">Add Method</h2>
                    </div>
                    <div class="modal-body">
                        <div>
                            <label for="category_name" class="form-label">Category Name <span class="text-danger">*</span></label>
                            <input id="category_name" name="category_name" type="text" class="form-control" placeholder="Category Name">
                            <div class="acc__input-error error-category_name text-danger mt-2"></div>
                        </div>
                        <div class="mt-5">
                            <div class="flex flex-col sm:flex-row mt-2">
                                <label class="mr-2">Type <span class="text-danger">*</span></label>
                                <div class="form-check mr-2">
                                    <input id="inflow" class="form-check-input" checked name="trans_type" type="radio" value="0">
                                    <label class="form-check-label" for="inflow">Inflow</label>
                                </div>
                                <div class="form-check mr-2 mt-2 sm:mt-0">
                                    <input id="outflow" class="form-check-input" name="trans_type" type="radio" value="1">
                                    <label class="form-check-label" for="outflow">Outflow</label>
                                </div>
                            </div>
                            <div class="acc__input-error error-trans_type text-danger mt-2"></div>
                        </div>
                        <div class="mt-5">
                            <label for="parent_id" class="form-label">Parent Category</label>
                            <select data-placeholder="Select Parent Category" id="parent_id" name="parent_id" class="form-control">
                                <option value="">Select Parent Category</option>
                                @foreach($categories as $category)
                                    <option value="{{ $category->id }}">{{ $category->category_name }}</option>
                                    @if(count($category->childrens))
                                        @include('pages/categories/child-option', [ 'childs' => $category->childrens, 'level' => $lavel ])
                                    @endif
                                @endforeach
                            </select>
                            <div class="acc__input-error error-parent_id text-danger mt-2"></div>
                        </div>
                        <div class="mt-5">
                            <div>
                                <div class="form-check form-switch">
                                    <label class="form-check-label mr-2 ml-0" for="status">Status <span class="text-danger">*</span></label>
                                    <input id="status" checked class="form-check-input" value="1" name="status" type="checkbox">
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" data-tw-dismiss="modal" class="btn btn-outline-secondary w-20 mr-1">Cancel</button>
                        <button type="submit" id="saveCategory" class="btn btn-primary w-auto">
                            Add Category
                            <svg style="display: none;" width="25" viewBox="-2 -2 42 42" xmlns="http://www.w3.org/2000/svg" stroke="white" class="w-4 h-4 ml-2">
                                <g fill="none" fill-rule="evenodd">
                                    <g transform="translate(1 1)" stroke-width="4">
                                        <circle stroke-opacity=".5" cx="18" cy="18" r="18"></circle>
                                        <path d="M36 18c0-9.94-8.06-18-18-18">
                                            <animateTransform attributeName="transform" type="rotate" from="0 18 18" to="360 18 18" dur="1s" repeatCount="indefinite"></animateTransform>
                                        </path>
                                    </g>
                                </g>
                            </svg>
                        </button> 
                    </div>
                </div>
            </form>
        </div>
    </div>
    <!-- END: Add Storage Modal -->

    <!-- BEGIN: Edit Storage Modal -->
    <div id="editCategoryModal" class="modal" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog">
            <form method="POST" action="#" id="editCategoryForm">
                <div class="modal-content">
                    <div class="modal-header">
                        <h2 class="font-medium text-base mr-auto">Edit Category</h2>
                    </div>
                    <div class="modal-body">
                    <div>
                            <label for="edit_category_name" class="form-label">Category Name <span class="text-danger">*</span></label>
                            <input id="edit_category_name" name="category_name" type="text" class="form-control" placeholder="Category Name">
                            <div class="acc__input-error error-category_name text-danger mt-2"></div>
                        </div>
                        <div class="mt-5">
                            <div class="flex flex-col sm:flex-row mt-2">
                                <label class="mr-2">Type <span class="text-danger">*</span></label>
                                <div class="form-check mr-2">
                                    <input id="edit_inflow" class="form-check-input" checked name="trans_type" type="radio" value="0">
                                    <label class="form-check-label" for="edit_inflow">Inflow</label>
                                </div>
                                <div class="form-check mr-2 mt-2 sm:mt-0">
                                    <input id="edit_outflow" class="form-check-input" name="trans_type" type="radio" value="1">
                                    <label class="form-check-label" for="edit_outflow">Outflow</label>
                                </div>
                            </div>
                            <div class="acc__input-error error-trans_type text-danger mt-2"></div>
                        </div>
                        <div class="mt-5">
                            <label for="edit_parent_id" class="form-label">Parent Category</label>
                            <select data-placeholder="Select Parent Category" id="edit_parent_id" name="parent_id" class="form-control">
                                <option value="">Select Parent Category</option>
                                @foreach($categories as $category)
                                    <option value="{{ $category->id }}">{{ $category->category_name }}</option>
                                    @if(count($category->childrens))
                                        @include('pages/categories/child-option', [ 'childs' => $category->childrens, 'level' => $lavel ])
                                    @endif
                                @endforeach
                            </select>
                            <div class="acc__input-error error-parent_id text-danger mt-2"></div>
                        </div>
                        <div class="mt-5">
                            <div>
                                <div class="form-check form-switch">
                                    <label class="form-check-label mr-2 ml-0" for="edit_status">Status <span class="text-danger">*</span></label>
                                    <input id="edit_status" checked class="form-check-input" value="1" name="status" type="checkbox">
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" data-tw-dismiss="modal" class="btn btn-outline-secondary w-20 mr-1">Cancel</button>
                        <button type="submit" id="updateCategory" class="btn btn-primary w-auto">
                            Update Category
                            <svg style="display: none;" width="25" viewBox="-2 -2 42 42" xmlns="http://www.w3.org/2000/svg" stroke="white" class="w-4 h-4 ml-2">
                                <g fill="none" fill-rule="evenodd">
                                    <g transform="translate(1 1)" stroke-width="4">
                                        <circle stroke-opacity=".5" cx="18" cy="18" r="18"></circle>
                                        <path d="M36 18c0-9.94-8.06-18-18-18">
                                            <animateTransform attributeName="transform" type="rotate" from="0 18 18" to="360 18 18" dur="1s" repeatCount="indefinite"></animateTransform>
                                        </path>
                                    </g>
                                </g>
                            </svg>
                        </button> 
                        <input type="hidden" name="id" value="0"/>
                    </div>
                </div>
            </form>
        </div>
    </div>
    <!-- END: Edit Storage Modal -->

    <!-- BEGIN: Modal Content -->
    <div id="successModal" class="modal" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-body p-0">
                    <div class="p-5 text-center">
                        <i data-lucide="check-circle" class="w-16 h-16 text-success mx-auto mt-3"></i>
                        <div class="text-3xl mt-5 successModalTitle">Good job!</div>
                        <div class="text-slate-500 mt-2 successModalDesc">You clicked the button!</div>
                    </div>
                    <div class="px-5 pb-8 text-center">
                        <button type="button" data-tw-dismiss="modal" class="btn btn-primary w-24">Ok</button>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- END: Modal Content -->

    <!-- BEGIN: Modal Content -->
    <div id="confirmModal" class="modal" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-body p-0">
                    <div class="p-5 text-center">
                        <i data-lucide="x-circle" class="w-16 h-16 text-danger mx-auto mt-3"></i>
                        <div class="text-3xl mt-5 confModTitle">Are you sure?</div>
                        <div class="text-slate-500 mt-2 confModDesc">Do you really want to delete these records? <br>This process cannot be undone.</div>
                    </div>
                    <div class="px-5 pb-8 text-center">
                        <button type="button" data-tw-dismiss="modal" class="btn btn-outline-secondary w-24 mr-1">No, Cancel</button>
                        <button type="button" data-id="0" data-action="none" class="agreeWith btn btn-danger w-auto">Yes, I agree</button>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- END: Modal Content -->
@endsection