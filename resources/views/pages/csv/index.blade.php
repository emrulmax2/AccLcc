@extends('../layout/' . $layout)

@section('subhead')
    <title>{{ $title }}</title>
@endsection

@section('subcontent')
    <div class="intro-y flex flex-col sm:flex-row items-center mt-8">
        <h2 class="text-lg font-medium mr-auto">CSV</h2>
        <div class="w-full sm:w-auto flex mt-4 sm:mt-0">
            <a href="javascript:void(0);" data-tw-toggle="modal" data-tw-target="#addCSVModal" class="btn btn-primary shadow-md mr-2">Upload CSV</a>
            <div class="dropdown ml-auto sm:ml-0">
                <button class="dropdown-toggle box btn bg-success text-white px-2" aria-expanded="false" data-tw-toggle="dropdown" id="csvFileDropdown">
                    <span class="activeCSVLevel">{{ $fileName ? $fileName : 'Select CSV' }}</span>
                    <span class="w-5 h-5 ml-3 flex items-center justify-center">
                        <i class="w-4 h-4" data-lucide="plus"></i>
                    </span>
                </button>
                <div class="dropdown-menu w-60">
                    <ul class="dropdown-content csvDropDown">
                        @forelse($csvfiles as $csv)
                        <li>
                            <a href="{{ route('csv') }}/{{ base64_encode(urlencode($csv->file_name)) }}" class="dropdown-item csvFiles {{ $fileName == $csv->file_name ? 'active' : '' }}" style="word-break: break-all;">
                                <i data-lucide="file-plus" class="w-4 h-4 mr-2"></i> {{ $csv->file_name }}
                            </a>
                        </li>
                        @empty
                        <li>
                            <a href="javascript:void(0);" class="dropdown-item" style="word-break: break-all;">
                                <i data-lucide="file-plus" class="w-4 h-4 mr-2"></i> CSV Not Found
                            </a>
                        </li>
                        @endforelse
                    </ul>
                </div>
            </div>
        </div>
    </div>
    <!-- BEGIN: HTML Table Data -->
    <div class="intro-y col-span-12 overflow-auto lg:overflow-visible">
        <table class="table table-report mt-2 csvTable" id="csvListTable">
            <thead>
                <tr class="intro-x">
                    <th class="whitespace-nowrap">Date</th>
                    <th class="whitespace-nowrap">Invoice</th>
                    <th class="whitespace-nowrap">Inv Date</th>
                    <th class="whitespace-nowrap">Details</th>
                    <th class="whitespace-nowrap">Description</th>
                    <th class="whitespace-nowrap">Category</th>
                    <th class="whitespace-nowrap">Method</th>
                    <th class="whitespace-nowrap">Storage</th>
                    <th class="whitespace-nowrap">Amount</th>
                    <th class="whitespace-nowrap text-center">File</th>
                    <th class="whitespace-nowrap text-right">Action</th>
                </tr>
            </thead>
            <tbody>
                @forelse($entries as $entry)
                    <form method="post" action="#" class="csvRowForm" enctype="multipart/form-data" id="csvRowForm_{{ $entry['id'] }}">
                        <tr class="intro-x csv_row row_{{ $entry['transaction_type'] == 1 ? 'expense' : 'income' }}" id="dataRow_{{ $entry['id'] }}">
                            <td class="w-30">
                                <input type="text" name="transaction_date" class="form-control datepicker" value="{{ $entry['trans_date'] }}" data-format="DD-MM-YYYY" data-single-mode="true"/>
                            </td>
                            <td class="w-35">
                                <input type="text" name="invoice_no" class="form-control" value="{{ $entry['invoice'] }}"/>
                            </td>
                            <td class="w-30">
                                <input type="text" name="invoice_date" class="form-control datepicker" value="{{ $entry['invoice'] }}" data-format="DD-MM-YYYY" data-single-mode="true"/>
                            </td>
                            <td class="w-70">
                                <textarea name="detail" class="form-control" rows="1">{{ $entry['details'] }}</textarea>
                            </td>
                            <td class="w-70">
                                <textarea name="description" class="form-control" rows="1">{{ $entry['description'] }}</textarea>
                            </td>
                            <td class="w-35">
                                <select name="category_id" class="form-control category_id">
                                    <option value="">Category</option>
                                    @foreach($entry['categories'] as $category)
                                        <option value="{{ $category->id }}">{{ $category->category_name }}</option>
                                        @if(count($category->childrens))
                                            @include('pages/csv/category-child-option', [ 'childs' => $category->childrens, 'level' => 1 ])
                                        @endif
                                    @endforeach
                                </select>
                            </td>
                            <td class="w-35">
                                <select name="method_id" class="form-control method_id">
                                    <option value="">Method</option>
                                    @foreach($methods as $method)
                                        <option value="{{ $method->id }}">{{ $method->method_name }}</option>
                                    @endforeach
                                </select>
                            </td>
                            <td class="w-35">
                                <select name="bank_id" class="form-control bank_id">
                                    <option value="">Storage</option>
                                    @foreach($storage as $strg)
                                        <option {{ $strg->id == $entry['bank_id'] ? 'Selected' : '' }} value="{{ $strg->id }}">{{ $strg->bank_name }}</option>
                                    @endforeach
                                </select>
                            </td>
                            <td class="w-30">
                                <input type="number" name="transaction_amount" class="form-control" value="{{ $entry['amount'] }}"/>
                            </td>
                            <td class="text-center">
                                <label for="transaction_doc_name_{{ $entry['id'] }}" class="btn btn-instagram accUploadBtn text-white btn-rounded p-0 w-9 h-9">
                                    <i data-lucide="cloud-lightning" class="w-4 h-4"></i>
                                    <input type="file" name="transaction_doc_name" id="transaction_doc_name_{{ $entry['id'] }}"/>
                                </label> 
                                <button data-csvid="{{ $entry['id'] }}" class="btn btn-linkedin text-white btn-rounded ml-1 p-0 w-9 h-9"><i data-lucide="link-2" class="w-4 h-4"></i></button> 
                                <input id="linkedRow_{{ $entry['id'] }}" type="hidden" name="linked_row" value="0"/>
                            </td>
                            <td class="text-right">
                                <button disabled class="btn btn-success text-white btn-rounded ml-1 p-0 w-9 h-9 rowSubmitBtn"><i data-lucide="save" class="w-4 h-4"></i></button> 
                                <input type="hidden" name="transaction_type" value="{{ $entry['transaction_type'] }}"/>
                                <input type="hidden" name="id" value="{{ $entry['id'] }}"/>
                            </td>
                        </tr>
                    </form>
                @empty
                    <tr class="intro-x">
                        <td colspan="11" class="text-center">
                            Data not found.
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>
    <!-- END: HTML Table Data -->

    <!-- BEGIN: Add Storage Modal -->
    <div id="addCSVModal" class="modal" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog">
            <form method="POST" action="#" id="addCSVForm"  enctype="multipart/form-data">
                <div class="modal-content">
                    <div class="modal-header">
                        <h2 class="font-medium text-base mr-auto">Upload CSV</h2>
                    </div>
                    <div class="modal-body">
                        <div>
                            <label for="storage" class="form-label">Storage <span class="text-danger">*</span></label>
                            <select id="storage" name="bank_id" class="form-control">
                                <option value="">Please Select Storage</option>
                                @foreach($storage as $strg)
                                    <option value="{{ $strg->id }}">{{ $strg->bank_name }}</option>
                                @endforeach
                            </select>
                            <div class="acc__input-error error-bank_id text-danger mt-2"></div>
                        </div>
                        <div class="mt-5">
                            <label for="csv" class="form-label">Storage Logo <span class="text-danger">*</span></label>
                            <input id="csv" accept=".csv" name="csv" type="file" class="form-control">
                            <div class="acc__input-error error-csv text-danger mt-2"></div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" data-tw-dismiss="modal" class="btn btn-outline-secondary w-20 mr-1">Cancel</button>
                        <button type="submit" id="saveCSV" class="btn btn-primary w-auto">
                            Upload CSV
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
    <div id="editMethodModal" class="modal" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog">
            <form method="POST" action="#" id="editMethodForm" enctype="multipart/form-data">
                <div class="modal-content">
                    <div class="modal-header">
                        <h2 class="font-medium text-base mr-auto">Edit Storage</h2>
                    </div>
                    <div class="modal-body">
                        <div>
                            <label for="bank_method_name" class="form-label">Method Name <span class="text-danger">*</span></label>
                            <input id="bank_method_name" name="method_name" type="text" class="form-control" placeholder="Method Name">
                            <div class="acc__input-error error-method_name text-danger mt-2"></div>
                        </div>
                        <div class="mt-5">
                            <div>
                                <div class="form-check form-switch">
                                    <label class="form-check-label mr-2 ml-0" for="status_edit">Status <span class="text-danger">*</span></label>
                                    <input id="status_edit" checked class="form-check-input" value="1" name="status" type="checkbox">
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" data-tw-dismiss="modal" class="btn btn-outline-secondary w-20 mr-1">Cancel</button>
                        <button type="submit" id="updateMethod" class="btn btn-primary w-auto">
                            Update Method
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
                        <button type="button" data-redirect="#" class="btn btn-primary w-24 successBTN">Ok</button>
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

@section('script')
    <script type="module">
        
    </script>
@endsection