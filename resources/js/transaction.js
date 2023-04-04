import TomSelect from "tom-select";
import xlsx from "xlsx";
import { createIcons, icons } from "lucide";
import Tabulator from "tabulator-tables";
import { isEmpty } from "lodash";

"use strict";
var transactionListDatatable = function () {
    var _tableGen = function () {
        // Setup Tabulator
        let srcArgs = {};
        srcArgs['transactionCode'] = ($('#transaction_code').val() != '' ? $('#transaction_code').val() : '');
        srcArgs['startDate'] = ($('#start_date').val() != '' ? $('#start_date').val() : '');
        srcArgs['endDate'] = ($('#end_date').val() != '' ? $('#end_date').val() : '');
        srcArgs['invoiceNo'] = ($('#invoice_no').val() != '' ? $('#invoice_no').val() : '');
        srcArgs['flow'] = ($('input#src_inflow:checked').length ? 0 : ($('input#src_outflow:checked').length ? 1 : ''));
        srcArgs['categoryID'] = ($('#src_category').val() != '' ? $('#src_category').val() : '');
        srcArgs['methodID'] = ($('#src_method').val() != '' ? $('#src_method').val() : '');
        srcArgs['bankID'] = ($('#src_bank').val() != '' ? $('#src_bank').val() : '');
        srcArgs['detailsDesc'] = ($('#details_desc').val() != '' ? $('#details_desc').val() : '');
        srcArgs['amountFrom'] = ($('#amount_form').val() != '' ? $('#amount_form').val() : '');
        srcArgs['amountTo'] = ($('#amount_to').val() != '' ? $('#amount_to').val() : '');
        
        let transactionListTable = new Tabulator("#transactionListTable", {
            ajaxURL: route('transactions.list'),
            ajaxParams:{srcArgs: srcArgs},
            ajaxFiltering: true,
            ajaxSorting: true,
            printAsHtml: true,
            printStyled: true,
            pagination: "remote",
            paginationSize: 10,
            paginationSizeSelector: [5, 10, 20, 30, 40, 50, 100, 200, 500, true],
            layout: "fitColumns",
            responsiveLayout: "collapse",
            placeholder: "No matching records found",
            columns: [ 
                {
                    title:"Code", 
                    field:"transaction_code",
                    hozAlign: 'left',
                    headerHozAlign: 'left',
                    vertAlign: 'middle', //docs
                    formatter(cell, formatterParams) {
                        if(cell.getData().docs != ''){
                            return '<a target="_blank" class="text-success" href="'+cell.getData().docs+'">'+cell.getData().transaction_code+'</a>';
                        }else{
                            return cell.getData().transaction_code;
                        }
                        btns += '<button data-id="'+cell.getData().id+'" data-tw-toggle="modal" data-tw-target="#editNewStorageModal"  type="button" class="eidt_btn btn-rounded btn btn-success text-white p-0 w-9 h-9"><i data-lucide="edit-3" class="w-4 h-4"></i></a>';
                        btns += '<button data-id="'+cell.getData().id+'"  class="view_btn btn btn-linkedin text-white btn-rounded ml-1 p-0 w-9 h-9"><i data-lucide="eye-off" class="w-4 h-4"></i></button>';
                        
                        return btns;
                    }
                },
                {
                    title:"Date", 
                    field:"transaction_date",
                    hozAlign: 'left',
                    headerHozAlign: 'left',
                    vertAlign: 'middle'
                },
                {
                    title:"Invoice", 
                    field:"invoice_no",
                    hozAlign: 'left',
                    headerHozAlign: 'left',
                    vertAlign: 'middle'
                },
                {
                    title:"Inv. Date", 
                    field:"invoice_date",
                    hozAlign: 'left',
                    headerHozAlign: 'left',
                    vertAlign: 'middle'
                },
                {
                    title:"Details", 
                    field:"detail",
                    hozAlign: 'left',
                    headerHozAlign: 'left',
                    vertAlign: 'middle'
                },
                {
                    title:"Description", 
                    field:"description",
                    hozAlign: 'left',
                    headerHozAlign: 'left',
                    vertAlign: 'middle'
                },
                {
                    title:"Category", 
                    field:"category",
                    hozAlign: 'left',
                    headerHozAlign: 'left',
                    vertAlign: 'middle'
                },
                {
                    title:"Method", 
                    field:"method",
                    hozAlign: 'left',
                    headerHozAlign: 'left',
                    vertAlign: 'middle'
                },
                {
                    title:"Storage", 
                    field:"storage",
                    hozAlign: 'left',
                    headerHozAlign: 'left',
                    vertAlign: 'middle'
                },
                {
                    title:"Amount", 
                    field:"transaction_amount",
                    hozAlign: 'left',
                    headerHozAlign: 'left',
                    vertAlign: 'middle'
                },
                { 
                    title: 'Actions', 
                    field: 'actions',
                    headerSort: false,
                    hozAlign: 'right',
                    headerHozAlign: 'right',
                    width: '180',
                    vertAlign: 'middle',
                    download:false,
                    print:false,
                    formatter(cell, formatterParams) {
                        var btns = '';
                        btns += '<button data-id="'+cell.getData().id+'" data-tw-toggle="modal" data-tw-target="#editTransactionModal"  type="button" class="eidt_btn btn-rounded btn btn-success text-white p-0 w-9 h-9"><i data-lucide="edit-3" class="w-4 h-4"></i></button>';
                        btns += '<a href="'+route('transactions.show', cell.getData().id)+'"  class="btn btn-linkedin text-white btn-rounded ml-1 p-0 w-9 h-9"><i data-lucide="eye-off" class="w-4 h-4"></i></a>';
                        
                        return btns;
                    }
                },
            ],
            rowFormatter:function(row){
                var data = row.getData();
            
                if(data.transaction_type == "0"){
                    row.getElement().style.backgroundColor = "#d6e9c6";
                }else{
                    row.getElement().style.backgroundColor = "#fcf8e3";
                }
            },
            renderComplete() {
                createIcons({
                    icons,
                    "stroke-width": 1.5,
                    nameAttr: "data-lucide",
                });
            },
        });

        // Redraw table onresize
        window.addEventListener("resize", () => {
            transactionListTable.redraw();
            createIcons({
                icons,
                "stroke-width": 1.5,
                nameAttr: "data-lucide",
            });
        });

        // Export
        $("#tabulator-export-csv").on("click", function (event) {
            transactionListTable.download("csv", "Transactions.csv");
        });

        $("#tabulator-export-json").on("click", function (event) {
            transactionListTable.download("json", "Transactions.json");
        });

        $("#tabulator-export-xlsx").on("click", function (event) {
            window.XLSX = xlsx;
            transactionListTable.download("xlsx", "data.xlsx", {
                sheetName: "Transactions",
            });
        });

        $("#tabulator-export-html").on("click", function (event) {
            transactionListTable.download("html", "Transactions.html", {
                style: true,
            });
        });

        // Print
        $("#tabulator-print").on("click", function (event) {
            transactionListTable.print();
        });


    }
    return {
        init: function () {
            _tableGen();
        }
    };
}();

(function () {
    // Tabulator
    if ($("#transactionListTable").length) {
        // Init Table 
        transactionListDatatable.init();

        // Filter function
        function filterHTMLForm() {
            transactionListDatatable.init();
        }

        // On click go button
        $("#tabulator-trans-html-filter-go").on("click", function (event) {
            filterHTMLForm();
        });

        
    }
})();

var transactionLogListDatatable = function () {
    var _tableGen = function () {
        // Setup Tabulator
        let transactionID = $('#transactionLogListTable').attr('data-transactionid');
        
        let transactionLogListTable = new Tabulator("#transactionLogListTable", {
            ajaxURL: route('transactions.log.list'),
            ajaxParams:{transactionID: transactionID},
            ajaxFiltering: true,
            ajaxSorting: true,
            printAsHtml: true,
            printStyled: true,
            pagination: "remote",
            paginationSize: 10,
            paginationSizeSelector: [5, 10, 20, 30, 40],
            layout: "fitColumns",
            responsiveLayout: "collapse",
            placeholder: "No matching records found",
            columns: [ 
                {
                    title:"ID", 
                    field:"id",
                    hozAlign: 'left',
                    headerHozAlign: 'left'
                },
                {
                    title:"Log Time", 
                    field:"log_date",
                    hozAlign: 'left',
                    headerHozAlign: 'left'
                },
                {
                    title:"Log Type", 
                    field:"log_type",
                    hozAlign: 'left',
                    headerHozAlign: 'left'
                },
                {
                    title:"Done By", 
                    field:"done_by",
                    hozAlign: 'left',
                    headerHozAlign: 'left'
                },
                {
                    title:"Previous Amount", 
                    field:"old_amount",
                    hozAlign: 'left',
                    headerHozAlign: 'left'
                },
                {
                    title:"New Amount", 
                    field:"new_amount",
                    hozAlign: 'left',
                    headerHozAlign: 'left'
                }
            ],
            renderComplete() {
                createIcons({
                    icons,
                    "stroke-width": 1.5,
                    nameAttr: "data-lucide",
                });
            },
        });

        // Redraw table onresize
        window.addEventListener("resize", () => {
            transactionListTable.redraw();
            createIcons({
                icons,
                "stroke-width": 1.5,
                nameAttr: "data-lucide",
            });
        });
    }
    return {
        init: function () {
            _tableGen();
        }
    };
}();


(function(){
    if ($("#transactionLogListTable").length) {
        transactionLogListDatatable.init();
    }

    if (!$("#transactionListTable").length) {
        return;
    }

    const addModal = tailwind.Modal.getOrCreateInstance(document.querySelector("#addTransactionModal"));
    const editModal = tailwind.Modal.getOrCreateInstance(document.querySelector("#editTransactionModal"));
    const succModal = tailwind.Modal.getOrCreateInstance(document.querySelector("#successModal"));
    const confModal = tailwind.Modal.getOrCreateInstance(document.querySelector("#confirmModal"));
    let confModalDelTitle = 'Are you sure?';
    let confModalDelDescription = 'Do you really want to delete these records? <br>This process cannot be undone.';
    let confModalRestDescription = 'Do you really want to re-store these records? Click agree to continue.';

    // Enable Tom Selects
    let optionsList = {
        plugins: {
            dropdown_input: {},
        },
        allowEmptyOption: true,
    };
    if ($('#category_id').data("placeholder")) {
        optionsList.placeholder = $("#category_id").data("placeholder");
    }
    let add_category_id = document.getElementById('category_id');
    let addCategoryID = new TomSelect(add_category_id, optionsList);
    
    if ($('#edit_category_id').data("placeholder")) {
        optionsList.placeholder = $("#edit_category_id").data("placeholder");
    }
    let edit_category_id = document.getElementById('edit_category_id');
    let editCategoryID = new TomSelect(edit_category_id, optionsList);

    if ($('#src_category').data("placeholder")) {
        optionsList.placeholder = $("#src_category").data("placeholder");
    }
    let src_category_id = document.getElementById('src_category');
    let srcCategoryID = new TomSelect(src_category_id, optionsList);

    // On reset filter form
    $("#tabulator-trans-html-filter-reset").on("click", function (event) {
        $('#transaction_code').val('');
        $('#start_date').val('');
        $('#end_date').val('');
        $('#invoice_no').val('');
   
        document.getElementById('src_inflow').checked=false;
        document.getElementById('src_outflow').checked=false;

        $('#src_category').val('');
        srcCategoryID.destroy();
        $('#tabulatorTransactionFilterForm select[name="src_category"]').html('<option value="">Select Transaction Category</option>').val('');
        srcCategoryID = new TomSelect(src_category_id, optionsList);
        
        $('#src_method').val('');
        $('#src_bank').val('');
        $('#details_desc').val('');
        $('#amount_form').val('');
        $('#amount_to').val('');

        transactionListDatatable.init();
    });

    // Toggle Trans Type Add Form
    $('#addTransactionForm').on('change', 'input[name="transaction_type"]', function(e){
        var trans_type = document.querySelector('#addTransactionForm input[name="transaction_type"]:checked').value;
        $('#addTransactionForm select[name="category_id"]').attr('disabled', 'disabled');
        $('#addTransactionForm #saveTransaction').attr('disabled', 'disabled');

        axios({
            method: "post",
            url: route('transactions.options'),
            data: {trans_type : trans_type},
            headers: {'X-CSRF-TOKEN' :  $('meta[name="csrf-token"]').attr('content')},
        }).then(response => {
            if (response.status == 200) {
                $('#addTransactionForm select[name="category_id"]').removeAttr('disabled');
                $('#addTransactionForm #saveTransaction').removeAttr('disabled');
                
                addCategoryID.destroy();
                $('#addTransactionForm select[name="category_id"]').html(response.data.html);
                addCategoryID = new TomSelect(add_category_id, optionsList);

            }
        }).catch(error =>{
            console.log(error);
        });
    });
    $('#editTransactionModal').on('change', 'input[name="transaction_type"]', function(e){
        var trans_type = document.querySelector('#editTransactionModal input[name="transaction_type"]:checked').value;
        $('#editTransactionModal select[name="category_id"]').attr('disabled', 'disabled');
        $('#editTransactionModal #updateTransaction').attr('disabled', 'disabled');
        
        axios({
            method: "post",
            url: route('transactions.options'),
            data: {trans_type : trans_type},
            headers: {'X-CSRF-TOKEN' :  $('meta[name="csrf-token"]').attr('content')},
        }).then(response => {
            if (response.status == 200) {
                $('#editTransactionModal select[name="category_id"]').removeAttr('disabled');
                $('#editTransactionModal #updateTransaction').removeAttr('disabled');
                
                editCategoryID.destroy();
                $('#editTransactionModal select[name="category_id"]').html(response.data.html);
                editCategoryID = new TomSelect(edit_category_id, optionsList);

            }
        }).catch(error =>{
            console.log(error);
        });
    });

    // Toggle Trans type Search Form
    $('#tabulatorTransactionFilterForm').on('change', 'input[name="transaction_type"]', function(e){
        var trans_type = document.querySelector('#tabulatorTransactionFilterForm input[name="transaction_type"]:checked').value;
        
        axios({
            method: "post",
            url: route('transactions.options'),
            data: {trans_type : trans_type},
            headers: {'X-CSRF-TOKEN' :  $('meta[name="csrf-token"]').attr('content')},
        }).then(response => {
            if (response.status == 200) {
                
                srcCategoryID.destroy();
                $('#tabulatorTransactionFilterForm select[name="src_category"]').html(response.data.html);
                srcCategoryID = new TomSelect(src_category_id, optionsList);

            }
        }).catch(error =>{
            console.log(error);
        });
    });

    // Toggle Cheque Details
    $('#addTransactionForm select[name="method_id"]').on('change', function(){
        var $this = $(this);
        var tx = this.options[this.selectedIndex].text;
        if(tx === 'Cheque'){
            $('#addTransactionForm .chequeDetails').fadeIn(250);
            $('#addTransactionForm .chequeDetails input').val('');
        }else{
            $('#addTransactionForm .chequeDetails').val('');
            $('#addTransactionForm .chequeDetails').fadeOut();
        }
    });
    $('#editTransactionForm select[name="method_id"]').on('change', function(){
        var $this = $(this);
        var tx = this.options[this.selectedIndex].text;
        if(tx === 'Cheque'){
            $('#editTransactionForm .chequeDetails').fadeIn(250);
            $('#editTransactionForm .chequeDetails input').val('');
        }else{
            $('#editTransactionForm .chequeDetails').val('');
            $('#editTransactionForm .chequeDetails').fadeOut();
        }
    });

    // On click the Edit BTN
    $('#transactionListTable').on('click', '.eidt_btn', function(){
        let $editBtn = $(this);
        let editId = $editBtn.attr('data-id');

        axios({
            method: "post",
            url: route('transactions.edit', editId),
            data: {id : editId},
            headers: {'X-CSRF-TOKEN' :  $('meta[name="csrf-token"]').attr('content')},
        }).then(response => {
            if (response.status == 200) {
                document.getElementById('edit_inflow_'+response.data.transaction_type).checked=true;

                editCategoryID.destroy();
                $('#editTransactionForm select[name="category_id"]').html(response.data.type_options).val(response.data.category_id);
                editCategoryID = new TomSelect(edit_category_id, optionsList);

                $('#editTransactionForm input[name="transaction_date"]').val(response.data.transaction_date);
                $('#editTransactionForm input[name="invoice_no"]').val(response.data.invoice_no);
                $('#editTransactionForm input[name="invoice_date"]').val(response.data.invoice_date);
                $('#editTransactionForm textarea[name="detail"]').val(response.data.detail);
                $('#editTransactionForm textarea[name="description"]').val(response.data.description);
                $('#editTransactionForm input[name="transaction_amount"]').val(response.data.transaction_amount);
                if(response.data.transaction_doc_name != ''){
                    document.querySelector('#editTransactionForm .downloadFile').setAttribute('href', response.data.transaction_doc_name);
                    document.querySelector('#editTransactionForm .downloadFile').style.cssText += 'display: inline-flex;';
                }else{
                    document.querySelector('#editTransactionForm .downloadFile').setAttribute('href', '#');
                    document.querySelector('#editTransactionForm .downloadFile').style.cssText = 'display: none; bottom: -3px;';
                }
                $('#editTransactionForm select[name="method_id"]').val(response.data.method_id);
                $('#editTransactionForm select[name="bank_id"]').val(response.data.bank_id);
                if(response.data.method_names == 'Cheque'){
                    $('#editTransactionForm .chequeDetails').fadeIn(250);
                    $('#editTransactionForm input[name="cheque_no"]').val(response.data.cheque_no);
                    $('#editTransactionForm input[name="cheque_date"]').val(response.data.cheque_date);
                }else{
                    $('#editTransactionForm .chequeDetails').fadeOut(250);
                    $('#editTransactionForm input[name="cheque_no"]').val('');
                    $('#editTransactionForm input[name="cheque_date"]').val('');
                }
                
                $('#editTransactionForm input[name="id"]').val(editId);
            }
        }).catch(error =>{
            console.log(error);
        });
    });

    //Update Transaction
    $('#editTransactionForm').on('submit', function(e){
        e.preventDefault();
        const form = document.getElementById('editTransactionForm');

        $('#editTransactionForm').find('input').removeClass('border-danger');
        $('#editTransactionForm').find('.acc__input-error').html('');

        document.querySelector('#updateTransaction').setAttribute('disabled', 'disabled');
        document.querySelector('#updateTransaction svg').style.cssText = 'display: inline-block;';

        let form_data = new FormData(form);
        form_data.append("file", transaction_doc_name.files[0]);

        axios({
            method: "post",
            url: route('transactions.update'),
            data: form_data,
            headers: { "Content-Type": "multipart/form-data", 'X-CSRF-TOKEN' :  $('meta[name="csrf-token"]').attr('content')},
        }).then(response => {
            document.querySelector('#updateTransaction').removeAttribute('disabled');
            document.querySelector('#updateTransaction svg').style.cssText = 'display: none;';
            
            if (response.status == 200) {
                document.querySelector('#editTransactionForm input[name="transaction_date"]').value = ''; 
                document.querySelector('#editTransactionForm input[name="invoice_no"]').value = ''; 
                document.querySelector('#editTransactionForm input[name="invoice_date"]').value = ''; 
                document.querySelector('#editTransactionForm textarea[name="detail"]').value = ''; 
                document.querySelector('#editTransactionForm textarea[name="description"]').value = ''; 
                document.querySelector('#editTransactionForm input[name="transaction_amount"]').value = ''; 
                document.querySelector('#editTransactionForm select[name="method_id"]').value = ''; 
                document.querySelector('#editTransactionForm input[name="cheque_no"]').value = ''; 
                document.querySelector('#editTransactionForm input[name="cheque_date"]').value = ''; 
                document.querySelector('#editTransactionForm select[name="bank_id"]').value = ''; 
                document.querySelector('#editTransactionForm input[name="transaction_doc_name"]').value = null; 
                editModal.hide();

                succModal.show();
                document.getElementById('successModal').addEventListener('shown.tw.modal', function(event){
                    $('#successModal .successModalTitle').html('Congratulations!');
                    $('#successModal .successModalDesc').html('Transaction Data Success Fully Updated!');
                });
            }
            transactionListDatatable.init();
        }).catch(error => {
            document.querySelector('#updateTransaction').removeAttribute('disabled');
            document.querySelector('#updateTransaction svg').style.cssText = 'display: none;';
            if (error.response) {
                if (error.response.status == 422) {
                    for (const [key, val] of Object.entries(error.response.data.errors)) {
                        $(`#editTransactionForm .${key}`).addClass('border-danger')
                        $(`#editTransactionForm  .error-${key}`).html(val)
                    }
                } else {
                    console.log('error');
                }
            }
        });
    })

    // Add Method
    $('#addTransactionForm').on('submit', function(e){
        e.preventDefault();
        const form = document.getElementById('addTransactionForm');

        $('#addTransactionForm').find('input').removeClass('border-danger')
        $('#addTransactionForm').find('.acc__input-error').html('')

        document.querySelector('#saveTransaction').setAttribute('disabled', 'disabled');
        document.querySelector('#saveTransaction svg').style.cssText = 'display: inline-block;';

        let form_data = new FormData(form);
        form_data.append("file", transaction_doc_name.files[0]);

        axios({
            method: "post",
            url: route('transactions.store'),
            data: form_data,
            headers: {"Content-Type": "multipart/form-data", 'X-CSRF-TOKEN' :  $('meta[name="csrf-token"]').attr('content')},
        }).then(response => {
            document.querySelector('#saveTransaction').removeAttribute('disabled');
            document.querySelector('#saveTransaction svg').style.cssText = 'display: none;';
            
            if (response.status == 200) {
                document.querySelector('#addTransactionForm input[name="transaction_date"]').value = ''; 
                document.querySelector('#addTransactionForm input[name="invoice_no"]').value = ''; 
                document.querySelector('#addTransactionForm input[name="invoice_date"]').value = ''; 
                document.querySelector('#addTransactionForm textarea[name="detail"]').value = ''; 
                document.querySelector('#addTransactionForm textarea[name="description"]').value = ''; 
                document.querySelector('#addTransactionForm input[name="transaction_amount"]').value = ''; 
                document.querySelector('#addTransactionForm select[name="method_id"]').value = ''; 
                document.querySelector('#addTransactionForm input[name="cheque_no"]').value = ''; 
                document.querySelector('#addTransactionForm input[name="cheque_date"]').value = ''; 
                document.querySelector('#addTransactionForm select[name="bank_id"]').value = ''; 
                document.querySelector('#addTransactionForm input[name="transaction_doc_name"]').value = null; 
                addModal.hide();

                succModal.show();
                document.getElementById('successModal').addEventListener('shown.tw.modal', function(event){
                    $('#successModal .successModalTitle').html('Congratulations!');
                    $('#successModal .successModalDesc').html('Transaction Data Success Fully Inserted!');
                });
            }
            transactionListDatatable.init();
        }).catch(error => {
            document.querySelector('#saveTransaction').removeAttribute('disabled');
            document.querySelector('#saveTransaction svg').style.cssText = 'display: none;';
            if (error.response) {
                if (error.response.status == 422) {
                    for (const [key, val] of Object.entries(error.response.data.errors)) {
                        $(`#addTransactionForm .${key}`).addClass('border-danger')
                        $(`#addTransactionForm  .error-${key}`).html(val)
                    }
                } else {
                    console.log('error');
                }
            }
        });

    });

})()