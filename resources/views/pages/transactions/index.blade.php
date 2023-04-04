@extends('../layout/' . $layout)

@section('subhead')
    <title>{{ $title }}</title>
@endsection

@section('subcontent')
    <div class="intro-y flex flex-col sm:flex-row items-center mt-8">
        <h2 class="text-lg font-medium mr-auto">All Transactions</h2>
        <div class="w-full sm:w-auto flex mt-4 sm:mt-0">
            <a href="javascript:void(0);" data-tw-toggle="modal" data-tw-target="#addTransactionModal" class="btn btn-primary shadow-md mr-2">Add New Transaction</a>
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
    <div class="intro-y box p-5 mt-5">
        <form id="tabulatorTransactionFilterForm">
            <div id="faq-accordion-2" class="accordion accordion-boxed mb-3">
                <div class="accordion-item">
                    <div id="faq-accordion-content-6" class="accordion-header flex flex-col sm:flex-row items-center">
                        <button class="accordion-button collapsed inline-flex" type="button" data-tw-toggle="collapse" data-tw-target="#faq-accordion-collapse-6" aria-expanded="false" aria-controls="faq-accordion-collapse-6">
                            <i data-lucide="search" class="w-4 h-4 mr-3"></i> Search Transaction
                        </button>
                        <div class="flex mt-5 sm:mt-0">
                            <button type="button" id="tabulator-print" class="btn btn-outline-secondary w-1/2 sm:w-auto mr-2">
                                <i data-lucide="printer" class="w-4 h-4 mr-2"></i> Print
                            </button>
                            <div class="dropdown w-1/2 sm:w-auto">
                                <button type="button" class="dropdown-toggle btn btn-outline-secondary w-full sm:w-auto" aria-expanded="false" data-tw-toggle="dropdown">
                                    <i data-lucide="file-text" class="w-4 h-4 mr-2"></i> Export <i data-lucide="chevron-down" class="w-4 h-4 ml-auto sm:ml-2"></i>
                                </button>
                                <div class="dropdown-menu w-40">
                                    <ul class="dropdown-content">
                                        <li>
                                            <a id="tabulator-export-csv" href="javascript:;" class="dropdown-item">
                                                <i data-lucide="file-text" class="w-4 h-4 mr-2"></i> Export CSV
                                            </a>
                                        </li>
                                        <li>
                                            <a id="tabulator-export-json" href="javascript:;" class="dropdown-item">
                                                <i data-lucide="file-text" class="w-4 h-4 mr-2"></i> Export JSON
                                            </a>
                                        </li>
                                        <li>
                                            <a id="tabulator-export-xlsx" href="javascript:;" class="dropdown-item">
                                                <i data-lucide="file-text" class="w-4 h-4 mr-2"></i> Export XLSX
                                            </a>
                                        </li>
                                        <li>
                                            <a id="tabulator-export-html" href="javascript:;" class="dropdown-item">
                                                <i data-lucide="file-text" class="w-4 h-4 mr-2"></i> Export HTML
                                            </a>
                                        </li>
                                    </ul>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div id="faq-accordion-collapse-6" class="accordion-collapse collapse" aria-labelledby="faq-accordion-content-6" data-tw-parent="#faq-accordion-2">
                        <div class="accordion-body text-slate-600 dark:text-slate-500 leading-relaxed">
                            <div class="grid grid-cols-4 gap-4">
                                <div>
                                    <label>Start Date</label>
                                    <input id="start_date" name="start_date" type="text" class="form-control datepicker" data-format="DD-MM-YYYY" data-single-mode="true"  placeholder="DD-MM-YYYY">
                                </div>
                                <div>
                                    <label>End Date</label>
                                    <input id="end_date" name="end_date" type="text" class="form-control datepicker" data-format="DD-MM-YYYY" data-single-mode="true" placeholder="DD-MM-YYYY">
                                </div>
                                <div>
                                    <label>Trnsaction Code</label>
                                    <input id="transaction_code" name="transaction_code" type="text" class="form-control"  placeholder="Transaction Code">
                                </div>
                                <div>
                                    <label>Invoice No.</label>
                                    <input id="invoice_no" name="invoice_no" type="text" class="form-control"  placeholder="Invoice No">
                                </div>
                                <div>
                                    <label>Transaction Type</label>
                                    <div class="sm:flex items-center mt-2">
                                        <div class="form-check mr-2">
                                            <input id="src_inflow" class="form-check-input src_flow" name="transaction_type" type="radio" value="0">
                                            <label class="form-check-label" for="src_inflow">Inflow</label>
                                        </div>
                                        <div class="form-check mr-2 mt-2 sm:mt-0">
                                            <input id="src_outflow" class="form-check-input src_flow" name="transaction_type" type="radio" value="1">
                                            <label class="form-check-label" for="src_outflow">Outflow</label>
                                        </div>
                                    </div>
                                </div>
                                <div>
                                    <label>Category</label>
                                    <select id="src_category" name="src_category" class="form-control">
                                        <option value="">Select Transaction Category</option>
                                    </select>
                                </div>
                                <div>
                                    <label>Method</label>
                                    <select id="src_method" name="src_method" class="form-control">
                                        <option value="">Select Transaction Method</option>
                                    </select>
                                </div>
                                <div>
                                    <label>Bank/Storage</label>
                                    <select id="src_bank" name="src_bank" class="form-control">
                                        <option value="">Select Bank/Storage</option>
                                    </select>
                                </div>
                                <div>
                                    <label>Detail/Description</label>
                                    <input type="text" id="details_desc" name="details_desc" placeholder="Details or Description" class="form-control"/>
                                </div>
                                <div>
                                    <label>Amount From</label>
                                    <input type="number" id="amount_form" name="amount_form" placeholder="0.00" class="form-control"/>
                                </div>
                                <div>
                                    <label>Amount To</label>
                                    <input type="number" id="amount_to" name="amount_to" placeholder="0.00" class="form-control"/>
                                </div>
                                <div class="pt-5 justify-content-end text-end">
                                    <button id="tabulator-trans-html-filter-go" type="button" class="btn btn-primary w-auto" >Search</button>
                                    <button id="tabulator-trans-html-filter-reset" type="button" class="btn btn-secondary sm:ml-1" >Reset</button>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </form>
        <div class="overflow-x-auto scrollbar-hidden">
            <div id="transactionListTable" class="mt-5 table-report table-report--tabulator"></div>
        </div>
    </div>
    <!-- END: HTML Table Data -->

    <!-- BEGIN: Add Storage Modal -->
    <div id="addTransactionModal" class="modal" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog modal-xl">
            <form method="POST" action="#" id="addTransactionForm" enctype="multipart/form-data">
                <div class="modal-content">
                    <div class="modal-header">
                        <h2 class="font-medium text-base mr-auto">Add Transaction</h2>
                    </div>
                    <div class="modal-body">
                        <div class="grid grid-cols-12 gap-4">
                            <div class="col-span-7">
                                <div>
                                    <div class="flex flex-col sm:flex-row mt-2">
                                        <label class="mr-2">Transaction Type <span class="text-danger">*</span></label>
                                        <div class="form-check mr-2">
                                            <input id="add_inflow" class="form-check-input" checked name="transaction_type" type="radio" value="0">
                                            <label class="form-check-label" for="add_inflow">Inflow</label>
                                        </div>
                                        <div class="form-check mr-2 mt-2 sm:mt-0">
                                            <input id="add_outflow" class="form-check-input" name="transaction_type" type="radio" value="1">
                                            <label class="form-check-label" for="add_outflow">Outflow</label>
                                        </div>
                                    </div>
                                    <div class="acc__input-error error-transaction_type text-danger mt-2"></div>
                                </div>
                                <div class="mt-5">
                                    <label for="transaction_date" class="form-label">Transaction Date <span class="text-danger">*</span></label>
                                    <input id="transaction_date" name="transaction_date" type="text" class="form-control datepicker" data-format="DD-MM-YYYY" placeholder="DD-MM-YYYY" data-single-mode="true">
                                    <div class="acc__input-error error-transaction_date text-danger mt-2"></div>
                                </div>
                                <div class="mt-5">
                                    <div class="grid grid-cols-2 gap-4">
                                        <div>
                                            <label for="invoice_no" class="form-label">Invoice No</label>
                                            <input id="invoice_no" name="invoice_no" type="text" class="form-control" placeholder="Invoice No">
                                        </div>
                                        <div>
                                            <label for="invoice_date" class="form-label">Invoice Date</label>
                                            <input id="invoice_date" name="invoice_date" type="text" class="form-control datepicker" data-format="DD-MM-YYYY" placeholder="DD-MM-YYYY" data-single-mode="true">
                                        </div>
                                    </div>
                                </div>
                                <div class="mt-5">
                                    <label for="detail" class="form-label">Details</label>
                                    <textarea id="detail" name="detail" class="form-control"></textarea>
                                </div>
                                <div class="mt-5">
                                    <label for="description" class="form-label">Description</label>
                                    <textarea id="description" name="description" class="form-control"></textarea>
                                </div>
                                <div class="mt-5">
                                    <label for="transaction_amount" class="form-label">Transaction Amount <span class="text-danger">*</span></label>
                                    <input id="transaction_amount" name="transaction_amount" type="number" class="form-control">
                                    <div class="acc__input-error error-transaction_amount text-danger mt-2"></div>
                                </div>
                                <div class="mt-5">
                                    <label for="transaction_doc_name" class="form-label">Transaction Document</label>
                                    <input id="transaction_doc_name" name="transaction_doc_name" type="file" class="form-control">
                                </div>
                            </div>
                            <div class="col-span-5">
                                <div>
                                    <label for="category_id" class="form-label">Transaction Category <span class="text-danger">*</span></label>
                                    <select id="category_id" name="category_id" class="form-control">
                                        <option value="">Select Transaction Category</option>
                                        @foreach($categories as $category)
                                            <option value="{{ $category->id }}">{{ $category->category_name }}</option>
                                            @if(count($category->childrens))
                                                @include('pages/transactions/category-child-option', [ 'childs' => $category->childrens, 'level' => $lavel ])
                                            @endif
                                        @endforeach
                                    </select>
                                    <div class="acc__input-error error-category_id text-danger mt-2"></div>
                                </div>
                                <div class="mt-5">
                                    <label for="method_id" class="form-label">Transaction Method <span class="text-danger">*</span></label>
                                    <select id="method_id" name="method_id"  class="form-control">
                                        <option value="">Select Transaction Method</option>
                                        @foreach($methods as $mtd)
                                            <option value="{{ $mtd->id }}">{{ $mtd->method_name }}</option>
                                        @endforeach;
                                    </select>
                                    <div class="acc__input-error error-method_id text-danger mt-2"></div>
                                </div>
                                <div class="mt-5 chequeDetails" style="display: none;">
                                    <div>
                                        <label for="cheque_no" class="form-label">Cheque No.</label>
                                        <input id="cheque_no" name="cheque_no" type="text" class="form-control">
                                        <div class="acc__input-error error-cheque_no text-danger mt-2"></div>
                                    </div>
                                    <div class="mt-5">
                                        <label for="cheque_date" class="form-label">Cheque Date</label>
                                        <input id="cheque_date" name="cheque_date" type="text" class="form-control datepicker" data-format="DD-MM-YYYY" placeholder="DD-MM-YYYY" data-single-mode="true">
                                        <div class="acc__input-error error-cheque_date text-danger mt-2"></div>
                                    </div>
                                </div>
                                <div class="mt-5">
                                    <label for="bank_id" class="form-label">Bank / Storage <span class="text-danger">*</span></label>
                                    <select id="bank_id" name="bank_id"  class="form-control">
                                        <option value="">Select Transaction Bank/Storage</option>
                                        @foreach($storages as $strg)
                                            <option value="{{ $strg->id }}">{{ $strg->bank_name }}</option>
                                        @endforeach;
                                    </select>
                                    <div class="acc__input-error error-bank_id text-danger mt-2"></div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" data-tw-dismiss="modal" class="btn btn-outline-secondary w-20 mr-1">Cancel</button>
                        <button type="submit" id="saveTransaction" class="btn btn-primary w-auto">
                            Add Transaction
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
    <div id="editTransactionModal" class="modal" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog modal-xl">
            <form method="POST" action="#" id="editTransactionForm" enctype="multipart/form-data">
                <div class="modal-content">
                    <div class="modal-header">
                        <h2 class="font-medium text-base mr-auto">Edit Transaction</h2>
                    </div>
                    <div class="modal-body">
                    <div class="grid grid-cols-12 gap-4">
                            <div class="col-span-7">
                                <div>
                                    <div class="flex flex-col sm:flex-row mt-2">
                                        <label class="mr-2">Transaction Type <span class="text-danger">*</span></label>
                                        <div class="form-check mr-2">
                                            <input id="edit_inflow_0" class="form-check-input" checked name="transaction_type" type="radio" value="0">
                                            <label class="form-check-label" for="edit_inflow_0">Inflow</label>
                                        </div>
                                        <div class="form-check mr-2 mt-2 sm:mt-0">
                                            <input id="edit_inflow_1" class="form-check-input" name="transaction_type" type="radio" value="1">
                                            <label class="form-check-label" for="edit_inflow_1">Outflow</label>
                                        </div>
                                    </div>
                                    <div class="acc__input-error error-transaction_type text-danger mt-2"></div>
                                </div>
                                <div class="mt-5">
                                    <label for="edit_transaction_date" class="form-label">Transaction Date <span class="text-danger">*</span></label>
                                    <input id="edit_transaction_date" name="transaction_date" type="text" class="form-control datepicker" data-format="DD-MM-YYYY" placeholder="DD-MM-YYYY" data-single-mode="true">
                                    <div class="acc__input-error error-transaction_date text-danger mt-2"></div>
                                </div>
                                <div class="mt-5">
                                    <div class="grid grid-cols-2 gap-4">
                                        <div>
                                            <label for="edit_invoice_no" class="form-label">Invoice No</label>
                                            <input id="edit_invoice_no" name="invoice_no" type="text" class="form-control" placeholder="Invoice No">
                                        </div>
                                        <div>
                                            <label for="edit_invoice_date" class="form-label">Invoice Date</label>
                                            <input id="edit_invoice_date" name="invoice_date" type="text" class="form-control datepicker" data-format="DD-MM-YYYY" placeholder="DD-MM-YYYY" data-single-mode="true">
                                        </div>
                                    </div>
                                </div>
                                <div class="mt-5">
                                    <label for="edit_detail" class="form-label">Details</label>
                                    <textarea id="edit_detail" name="detail" class="form-control"></textarea>
                                </div>
                                <div class="mt-5">
                                    <label for="edit_description" class="form-label">Description</label>
                                    <textarea id="edit_description" name="description" class="form-control"></textarea>
                                </div>
                                <div class="mt-5">
                                    <label for="edit_transaction_amount" class="form-label">Transaction Amount <span class="text-danger">*</span></label>
                                    <input id="edit_transaction_amount" name="transaction_amount" type="number" class="form-control">
                                    <div class="acc__input-error error-transaction_amount text-danger mt-2"></div>
                                </div>
                                <div class="mt-5">
                                    <label for="edit_transaction_doc_name" class="form-label">
                                        Transaction Document
                                        <a href="#" target="_blank" class="downloadFile btn btn-linkedin btn-rounded text-white w-7 p-0 h-7 ml-3 relative" style="display: none; bottom: -3px;">
                                            <i data-lucide="download" class="w-4 h-4"></i>
                                        </a>
                                    </label>
                                    <input id="edit_transaction_doc_name" name="transaction_doc_name" type="file" class="form-control">
                                </div>
                            </div>
                            <div class="col-span-5">
                                <div>
                                    <label for="edit_category_id" class="form-label">Transaction Category <span class="text-danger">*</span></label>
                                    <select id="edit_category_id" name="category_id" class="form-control">
                                        <option value="">Select Transaction Category</option>
                                        @foreach($categories as $category)
                                            <option value="{{ $category->id }}">{{ $category->category_name }}</option>
                                            @if(count($category->childrens))
                                                @include('pages/transactions/category-child-option', [ 'childs' => $category->childrens, 'level' => $lavel ])
                                            @endif
                                        @endforeach
                                    </select>
                                    <div class="acc__input-error error-category_id text-danger mt-2"></div>
                                </div>
                                <div class="mt-5">
                                    <label for="edit_method_id" class="form-label">Transaction Method <span class="text-danger">*</span></label>
                                    <select id="edit_method_id" name="method_id"  class="form-control">
                                        <option value="">Select Transaction Method</option>
                                        @foreach($methods as $mtd)
                                            <option value="{{ $mtd->id }}">{{ $mtd->method_name }}</option>
                                        @endforeach;
                                    </select>
                                    <div class="acc__input-error error-method_id text-danger mt-2"></div>
                                </div>
                                <div class="mt-5 chequeDetails" style="display: none;">
                                    <div>
                                        <label for="edit_cheque_no" class="form-label">Cheque No.</label>
                                        <input id="edit_cheque_no" name="cheque_no" type="text" class="form-control">
                                        <div class="acc__input-error error-cheque_no text-danger mt-2"></div>
                                    </div>
                                    <div class="mt-5">
                                        <label for="edit_cheque_date" class="form-label">Cheque Date</label>
                                        <input id="edit_cheque_date" name="cheque_date" type="text" class="form-control datepicker" data-format="DD-MM-YYYY" placeholder="DD-MM-YYYY" data-single-mode="true">
                                        <div class="acc__input-error error-cheque_date text-danger mt-2"></div>
                                    </div>
                                </div>
                                <div class="mt-5">
                                    <label for="edit_bank_id" class="form-label">Bank / Storage <span class="text-danger">*</span></label>
                                    <select id="edit_bank_id" name="bank_id"  class="form-control">
                                        <option value="">Select Transaction Bank/Storage</option>
                                        @foreach($storages as $strg)
                                            <option value="{{ $strg->id }}">{{ $strg->bank_name }}</option>
                                        @endforeach;
                                    </select>
                                    <div class="acc__input-error error-bank_id text-danger mt-2"></div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" data-tw-dismiss="modal" class="btn btn-outline-secondary w-20 mr-1">Cancel</button>
                        <button type="submit" id="updateTransaction" class="btn btn-primary w-auto">
                            Update Transaction
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

@section('script')
    <script type="module">
        
    </script>
@endsection