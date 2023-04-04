@extends('../layout/' . $layout)

@section('subhead')
    <title>{{ $title }}</title>
@endsection

@section('subcontent')
    <div class="intro-y flex flex-col sm:flex-row items-center mt-8">
        <h2 class="text-lg font-medium mr-auto">Transaction Details</h2>
        <div class="w-full sm:w-auto flex mt-4 sm:mt-0">
            <a href="{{ route('transactions') }}" class="btn btn-primary shadow-md">Back to List</a>
        </div>
    </div>
    <!-- BEGIN: HTML Table Data -->
    <div class="intro-y box px-5 py-8 mt-5">
        <div class="grid grid-cols-3 gap-4">
            <div>
                <div class="grid grid-cols-12 gap-0">
                    <div class="col-span-4 font-bold mr-5 pt-2">Transacton Code</div>
                    <div class="col-span-8">
                        <div class="py-2 px-3 bg-slate-100 text-slate-500 font-medium dark:bg-darkmode-800 dark:text-slate-300 mr-1">{{ $transaction->transaction_code }}</div>
                    </div>
                </div>
            </div>
            <div>
                <div class="grid grid-cols-12 gap-0">
                    <div class="col-span-4 font-bold mr-5 pt-2">Transacton Ype</div>
                    <div class="col-span-8">
                        <div class="py-2 px-3 bg-slate-100 text-slate-500 font-medium dark:bg-darkmode-800 dark:text-slate-300 mr-1">
                            @if($transaction->transaction_type == 1)
                                Outflow
                            @else 
                                Inflow
                            @endif
                        </div>
                    </div>
                </div>
            </div>
            <div>
                <div class="grid grid-cols-12 gap-0">
                    <div class="col-span-4 font-bold mr-5 pt-2">Transacton Date</div>
                    <div class="col-span-8">
                        <div class="py-2 px-3 bg-slate-100 text-slate-500 font-medium dark:bg-darkmode-800 dark:text-slate-300 mr-1">
                            {{ date('d-m-Y', strtotime($transaction->transaction_date)) }}
                        </div>
                    </div>
                </div>
            </div>
            @if(!is_null($transaction->invoice_no ))
            <div>
                <div class="grid grid-cols-12 gap-0">
                    <div class="col-span-4 font-bold mr-5 pt-2">Invoice No</div>
                    <div class="col-span-8">
                        <div class="py-2 px-3 bg-slate-100 text-slate-500 font-medium dark:bg-darkmode-800 dark:text-slate-300 mr-1">
                            {{ $transaction->invoice_no }}
                        </div>
                    </div>
                </div>
            </div>
            @endif
            @if(!is_null($transaction->invoice_date ))
            <div>
                <div class="grid grid-cols-12 gap-0">
                    <div class="col-span-4 font-bold mr-5 pt-2">Invoice Date</div>
                    <div class="col-span-8">
                        <div class="py-2 px-3 bg-slate-100 text-slate-500 font-medium dark:bg-darkmode-800 dark:text-slate-300 mr-1">
                            {{ date('d-m-Y', strtotime($transaction->invoice_date)) }}
                        </div>
                    </div>
                </div>
            </div>
            @endif
            <div>
                <div class="grid grid-cols-12 gap-0">
                    <div class="col-span-4 font-bold mr-5 pt-2">Transaction Amount</div>
                    <div class="col-span-8">
                        <div class="py-2 px-3 bg-slate-100 text-slate-500 font-medium dark:bg-darkmode-800 dark:text-slate-300 mr-1">
                            £{{ $transaction->transaction_amount }}
                        </div>
                    </div>
                </div>
            </div>
            <div>
                <div class="grid grid-cols-12 gap-0">
                    <div class="col-span-4 font-bold mr-5 pt-2">Category</div>
                    <div class="col-span-8">
                        <div class="py-2 px-3 bg-slate-100 text-slate-500 font-medium dark:bg-darkmode-800 dark:text-slate-300 mr-1">
                            {{ $transaction->category->category_name }}
                        </div>
                    </div>
                </div>
            </div>
            <div>
                <div class="grid grid-cols-12 gap-0">
                    <div class="col-span-4 font-bold mr-5 pt-2">Method</div>
                    <div class="col-span-8">
                        <div class="py-2 px-3 bg-slate-100 text-slate-500 font-medium dark:bg-darkmode-800 dark:text-slate-300 mr-1">
                            {{ $transaction->method->method_name }}
                        </div>
                    </div>
                </div>
            </div>
            <div>
                <div class="grid grid-cols-12 gap-0">
                    <div class="col-span-4 font-bold mr-5 pt-2">Storage</div>
                    <div class="col-span-8">
                        <div class="py-2 px-3 bg-slate-100 text-slate-500 font-medium dark:bg-darkmode-800 dark:text-slate-300 mr-1">
                            {{ $transaction->bank->bank_name }}
                        </div>
                    </div>
                </div>
            </div>
            @if(!is_null($transaction->cheque_no) && $transaction->method->method_name == 'Cheque')
            <div>
                <div class="grid grid-cols-12 gap-0">
                    <div class="col-span-4 font-bold mr-5 pt-2">Cheque No.</div>
                    <div class="col-span-8">
                        <div class="py-2 px-3 bg-slate-100 text-slate-500 font-medium dark:bg-darkmode-800 dark:text-slate-300 mr-1">
                            {{ $transaction->cheque_no }}
                        </div>
                    </div>
                </div>
            </div>
            @endif
            @if(!is_null($transaction->cheque_date) && $transaction->method->method_name == 'Cheque')
            <div>
                <div class="grid grid-cols-12 gap-0">
                    <div class="col-span-4 font-bold mr-5 pt-2">Cheque Date</div>
                    <div class="col-span-8">
                        <div class="py-2 px-3 bg-slate-100 text-slate-500 font-medium dark:bg-darkmode-800 dark:text-slate-300 mr-1">
                            {{ date('d-m-Y', strtotime($transaction->cheque_date)) }}
                        </div>
                    </div>
                </div>
            </div>
            @endif
            @if(!is_null($transaction->transaction_doc_name))
            <div>
                <div class="grid grid-cols-12 gap-0">
                    <div class="col-span-4 font-bold mr-5 pt-2">Document</div>
                    <div class="col-span-8">
                        <div class="py-2 px-3 bg-slate-100 text-primary font-medium dark:bg-darkmode-800 dark:text-slate-300 mr-1">
                            <a href="{{ asset('storage/transactions/'.$transaction->transaction_doc_name) }}">Download</a>
                        </div>
                    </div>
                </div>
            </div>
            @endif
            @if(!is_null($transaction->detail))
            <div>
                <div class="grid grid-cols-12 gap-0">
                    <div class="col-span-4 font-bold mr-5 pt-2">Details</div>
                    <div class="col-span-8">
                        <div class="py-2 px-3 bg-slate-100 text-slate-500 font-medium dark:bg-darkmode-800 dark:text-slate-300 mr-1">
                            {{ $transaction->detail }}
                        </div>
                    </div>
                </div>
            </div>
            @endif
            @if(!is_null($transaction->description))
            <div>
                <div class="grid grid-cols-12 gap-0">
                    <div class="col-span-4 font-bold mr-5 pt-2">Description</div>
                    <div class="col-span-8">
                        <div class="py-2 px-3 bg-slate-100 text-slate-500 font-medium dark:bg-darkmode-800 dark:text-slate-300 mr-1">
                            {{ $transaction->description }}
                        </div>
                    </div>
                </div>
            </div>
            @endif
        </div>
    </div>
    <!-- END: HTML Table Data -->

    <div class="intro-y flex flex-col sm:flex-row items-center mt-8">
        <h2 class="text-lg font-medium mr-auto">Transaction Logs</h2>
        <div class="w-full sm:w-auto flex mt-4 sm:mt-0">
            <a href="{{ route('transactions') }}" class="btn btn-primary shadow-md">Back to List</a>
        </div>
    </div>
    <div class="intro-y box p-5 mt-5">
        <div class="overflow-x-auto scrollbar-hidden">
            <div id="transactionLogListTable" data-transactionid="{{ $transaction->id }}" class="mt-5 table-report table-report--tabulator"></div>
        </div>
    </div>
@endsection