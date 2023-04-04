import xlsx from "xlsx";
import { createIcons, icons } from "lucide";
import Tabulator from "tabulator-tables";
import TomSelect from "tom-select";

"use strict";
var inflowCategoryListDatatable = function () {
    var _tableGen = function () {
        // Setup Tabulator
        let categoryName = ($('#inflow_category_name').val() != '' ? $('#inflow_category_name').val() : '');
        let status = ($('#inflow_status').val() != '' ? $('#inflow_status').val() : '');
        
        let inflowCategoryListTable = new Tabulator("#inflowCategoryListTable", {
            ajaxURL: route('category.list', '0'),
            ajaxParams:{categoryName: categoryName, status: status},
            ajaxResponse:function(url, params, response){
                return response.data;
            },
            ajaxFiltering: true,
            ajaxSorting: true,

            printAsHtml: true,
            printStyled: true,

            pagination: 'local',

            dataTree:true,
            dataTreeStartExpanded:true,

            paginationSize: 10,
            paginationSizeSelector: [5, 10, 20, 30, 40],
            layout: "fitColumns",
            responsiveLayout: "collapse",
            placeholder: "No matching records found",

            dataTreeChildIndent: 10,

            columns: [ 
                {
                    title:"#ID", 
                    field:"id",
                    width: '180',
                },
                {
                    title:"Category Name", 
                    field:"category_name",
                    headerHozAlign: 'left',
                },
                /*{
                    title:"Status", 
                    field:"active",
                    headerSort: false,
                    hozAlign: 'left',
                    headerHozAlign: 'left',
                    width: '180',
                    formatter(cell, formatterParams){
                        if(cell.getData().status == 1){
                            return '<div class="form-check form-switch"><input data-id="'+cell.getData().id+'" checked value="'+cell.getData().active+'" type="checkbox" class="status_updater form-check-input"> </div>';
                        }else{
                            return '<div class="form-check form-switch"> <input data-id="'+cell.getData().id+'" value="'+cell.getData().active+'" type="checkbox" class="status_updater form-check-input"> </div>';
                        }
                    }
                },*/
                { 
                    title: 'Actions', 
                    field: 'actions',
                    headerSort: false,
                    hozAlign: 'right',
                    headerHozAlign: 'right',
                    width: '180',
                    formatter(cell, formatterParams) {
                        var btns = '';
                        btns += '<button data-id="'+cell.getData().id+'" data-tw-toggle="modal" data-tw-target="#editCategoryModal"  type="button" class="eidt_btn btn-rounded btn btn-success text-white p-0 w-9 h-9"><i data-lucide="edit-3" class="w-4 h-4"></i></a>';
                        if(cell.getData().deleted_at == null){
                            btns += '<button data-id="'+cell.getData().id+'"  class="delete_btn btn btn-danger text-white btn-rounded ml-1 p-0 w-9 h-9"><i data-lucide="trash" class="w-4 h-4"></i></button>';
                        }else if(cell.getData().deleted_at != null){
                            btns += '<button data-id="'+cell.getData().id+'"  class="restore_btn btn btn-linkedin text-white btn-rounded ml-1 p-0 w-9 h-9"><i data-lucide="rotate-cw" class="w-4 h-4"></i></button>';
                        }
                        return btns;
                    }
                },
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
            inflowCategoryListTable.redraw();
            createIcons({
                icons,
                "stroke-width": 1.5,
                nameAttr: "data-lucide",
            });
        });

        // Export
        $("#tabulator-export-csv-inflow").on("click", function (event) {
            inflowCategoryListTable.download("csv", "data.csv");
        });

        $("#tabulator-export-json-inflow").on("click", function (event) {
            inflowCategoryListTable.download("json", "data.json");
        });

        $("#tabulator-export-xlsx-inflow").on("click", function (event) {
            window.XLSX = xlsx;
            inflowCategoryListTable.download("xlsx", "data.xlsx", {
                sheetName: "Bank Storages",
            });
        });

        $("#tabulator-export-html-inflow").on("click", function (event) {
            inflowCategoryListTable.download("html", "data.html", {
                style: true,
            });
        });

        // Print
        $("#tabulator-print-inflow").on("click", function (event) {
            inflowCategoryListTable.print();
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
    if ($("#inflowCategoryListTable").length) {
        // Init Table 
        inflowCategoryListDatatable.init();

        // Filter function
        function inflowFilterHTMLForm() {
            inflowCategoryListDatatable.init();
        }

        // On submit filter form
        $("#tabulatorInflowFilterForm")[0].addEventListener(
            "keypress",
            function (event) {
                let keycode = event.keyCode ? event.keyCode : event.which;
                if (keycode == "13") {
                    event.preventDefault();
                    inflowFilterHTMLForm();
                }
            }
        );

        // On click go button
        $("#tabulator-html-filter-go-inflow").on("click", function (event) {
            inflowFilterHTMLForm();
        });

        // On reset filter form
        $("#tabulator-html-filter-reset-inflow").on("click", function (event) {
            $("#inflow_category_name").val("");
            $("#inflow_statusstatus").val("");
            inflowFilterHTMLForm();
        });
    }
})();


var outflowCategoryListDatatable = function () {
    var _tableGen = function () {
        // Setup Tabulator
        let categoryName = ($('#outflow_category_name').val() != '' ? $('#outflow_category_name').val() : '');
        let status = ($('#outflow_status').val() != '' ? $('#outflow_status').val() : '');
        
        let outflowCategoryListTable = new Tabulator("#outfolowCategoryListTable", {
            ajaxURL: route('category.list', '1'),
            ajaxParams:{categoryName: categoryName, status: status},
            ajaxResponse:function(url, params, response){
                return response.data;
            },
            ajaxFiltering: true,
            ajaxSorting: true,

            printAsHtml: true,
            printStyled: true,

            pagination: 'local',

            dataTree:true,
            dataTreeStartExpanded:true,

            paginationSize: 10,
            paginationSizeSelector: [5, 10, 20, 30, 40],
            layout: "fitColumns",
            responsiveLayout: "collapse",
            placeholder: "No matching records found",

            dataTreeChildIndent: 10,

            columns: [ 
                {
                    title:"#ID", 
                    field:"id",
                    width: '180',
                },
                {
                    title:"Category Name", 
                    field:"category_name",
                    headerHozAlign: 'left',
                },
                /*{
                    title:"Status", 
                    field:"active",
                    headerSort: false,
                    hozAlign: 'left',
                    headerHozAlign: 'left',
                    width: '180',
                    formatter(cell, formatterParams){
                        if(cell.getData().status == 1){
                            return '<div class="form-check form-switch"><input data-id="'+cell.getData().id+'" checked value="'+cell.getData().active+'" type="checkbox" class="status_updater form-check-input"> </div>';
                        }else{
                            return '<div class="form-check form-switch"> <input data-id="'+cell.getData().id+'" value="'+cell.getData().active+'" type="checkbox" class="status_updater form-check-input"> </div>';
                        }
                    }
                },*/
                { 
                    title: 'Actions', 
                    field: 'actions',
                    headerSort: false,
                    hozAlign: 'right',
                    headerHozAlign: 'right',
                    width: '180',
                    formatter(cell, formatterParams) {
                        var btns = '';
                        btns += '<button data-id="'+cell.getData().id+'" data-tw-toggle="modal" data-tw-target="#editCategoryModal"  type="button" class="eidt_btn btn-rounded btn btn-success text-white p-0 w-9 h-9"><i data-lucide="edit-3" class="w-4 h-4"></i></a>';
                        if(cell.getData().deleted_at == null){
                            btns += '<button data-id="'+cell.getData().id+'"  class="delete_btn btn btn-danger text-white btn-rounded ml-1 p-0 w-9 h-9"><i data-lucide="trash" class="w-4 h-4"></i></button>';
                        }else if(cell.getData().deleted_at != null){
                            btns += '<button data-id="'+cell.getData().id+'"  class="restore_btn btn btn-linkedin text-white btn-rounded ml-1 p-0 w-9 h-9"><i data-lucide="rotate-cw" class="w-4 h-4"></i></button>';
                        }
                        return btns;
                    }
                },
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
            outflowCategoryListTable.redraw();
            createIcons({
                icons,
                "stroke-width": 1.5,
                nameAttr: "data-lucide",
            });
        });

        // Export
        $("#tabulator-export-csv-outflow").on("click", function (event) {
            outflowCategoryListTable.download("csv", "data.csv");
        });

        $("#tabulator-export-json-outflow").on("click", function (event) {
            outflowCategoryListTable.download("json", "data.json");
        });

        $("#tabulator-export-xlsx-outflow").on("click", function (event) {
            window.XLSX = xlsx;
            outflowCategoryListTable.download("xlsx", "data.xlsx", {
                sheetName: "Outflow Categories",
            });
        });

        $("#tabulator-export-html-outflow").on("click", function (event) {
            outflowCategoryListTable.download("html", "data.html", {
                style: true,
            });
        });

        // Print
        $("#tabulator-print-outflow").on("click", function (event) {
            outflowCategoryListTable.print();
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
    if ($("#outfolowCategoryListTable").length) {
        // Init Table 
        outflowCategoryListDatatable.init();

        // Filter function
        function outflowFilterHTMLForm() {
            outflowCategoryListDatatable.init();
        }

        // On submit filter form
        $("#tabulatorOutflowFilterForm")[0].addEventListener(
            "keypress",
            function (event) {
                let keycode = event.keyCode ? event.keyCode : event.which;
                if (keycode == "13") {
                    event.preventDefault();
                    outflowFilterHTMLForm();
                }
            }
        );

        // On click go button
        $("#tabulator-html-filter-go-outflow").on("click", function (event) {
            outflowFilterHTMLForm();
        });

        // On reset filter form
        $("#tabulator-html-filter-reset-outflow").on("click", function (event) {
            $("#outflow_category_name").val("");
            $("#outflow_statusstatus").val("");
            outflowFilterHTMLForm();
        });
    }
})();


(function(){
    if (!$("#inflowCategoryListTable").length) {
        return;
    }
    const addModal = tailwind.Modal.getOrCreateInstance(document.querySelector("#addCategoryModal"));
    const editModal = tailwind.Modal.getOrCreateInstance(document.querySelector("#editCategoryModal"));
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
    if ($('#parent_id').data("placeholder")) {
        optionsList.placeholder = $("#parent_id").data("placeholder");
    }
    let parent_id = document.getElementById('parent_id');
    let addParentIds = new TomSelect(parent_id, optionsList);
    
    let edit_parent_id = document.getElementById('edit_parent_id');
    let editParentIds = new TomSelect(edit_parent_id, optionsList);

    document.getElementById('editCategoryModal').addEventListener('hidden.tw.modal', function(event){
        $('#editCategoryModal input[name="method_name"]').val('');
        $('#editCategoryModal input[name="id"]').val('');
        document.querySelector('#editCategoryModal input[name="status"]').checked=true;
    });

    document.getElementById('addCategoryModal').addEventListener('hidden.tw.modal', function(event){
        $('#addCategoryModal').find('input').removeClass('border-danger')
        $('#addCategoryModal').find('.acc__input-error').html('')

        $('#addCategoryModal input[name="category_name"]').val('');
        $('#addCategoryModal select[name="parent_id"]').val('');
        document.querySelector('#addCategoryModal input[name="status"]').checked=true;
    });

    // Toggle Trans Type Add Form
    $('#addCategoryForm').on('change', 'input[name="trans_type"]', function(e){
        var trans_type = document.querySelector('#addCategoryForm input[name="trans_type"]:checked').value;
        $('#addCategoryForm select[name="parent_id"]').attr('disabled', 'disabled');
        $('#addCategoryForm #saveCategory').attr('disabled', 'disabled');

        axios({
            method: "post",
            url: route('category.options'),
            data: {trans_type : trans_type},
            headers: {'X-CSRF-TOKEN' :  $('meta[name="csrf-token"]').attr('content')},
        }).then(response => {
            if (response.status == 200) {
                $('#addCategoryForm select[name="parent_id"]').removeAttr('disabled');
                $('#addCategoryForm #saveCategory').removeAttr('disabled');
                
                addParentIds.destroy();
                $('#addCategoryForm select[name="parent_id"]').html(response.data.html);
                addParentIds = new TomSelect(parent_id, optionsList);

            }
        }).catch(error =>{
            console.log(error);
        });
    });

    // Toggle Trans Type Edit Form
    $('#editCategoryForm').on('change', 'input[name="trans_type"]', function(e){
        var trans_type = document.querySelector('#editCategoryForm input[name="trans_type"]:checked').value;
        $('#editCategoryForm select[name="parent_id"]').attr('disabled', 'disabled');
        $('#editCategoryForm #updateCategory').attr('disabled', 'disabled');

        axios({
            method: "post",
            url: route('category.options'),
            data: {trans_type : trans_type},
            headers: {'X-CSRF-TOKEN' :  $('meta[name="csrf-token"]').attr('content')},
        }).then(response => {
            if (response.status == 200) {
                $('#editCategoryForm select[name="parent_id"]').removeAttr('disabled');
                $('#editCategoryForm #updateCategory').removeAttr('disabled');
                
                editParentIds.destroy();
                $('#editCategoryForm select[name="parent_id"]').html(response.data.html);
                editParentIds = new TomSelect(edit_parent_id, optionsList);

            }
        }).catch(error =>{
            console.log(error);
        });
    });

    // Agree With Confirm Modal
    $('#confirmModal .agreeWith').on('click', function(){
        let $agreeBTN = $(this);
        let recordID = $agreeBTN.attr('data-id');
        let action = $agreeBTN.attr('data-action');

        $('#confirmModal button').attr('disabled', 'disabled');
        if(action == 'DELETE'){
            axios({
                method: 'DELETE',
                url: route('category.delete', recordID),
                headers: {'X-CSRF-TOKEN' :  $('meta[name="csrf-token"]').attr('content')},
            }).then(response => {
                if (response.status == 200) {
                    $('#confirmModal button').removeAttr('disabled');
                    confModal.hide();

                    succModal.show();
                    document.getElementById('successModal').addEventListener('shown.tw.modal', function(event){
                        $('#successModal .successModalTitle').html('Congratulations!');
                        $('#successModal .successModalDesc').html('Category Item Success Fully Deleted!');
                    });
                }
                outflowCategoryListDatatable.init();
                inflowCategoryListDatatable.init();
            }).catch(error =>{
                console.log(error)
            });
        }else if(action == 'RESTORE'){
            axios({
                method: 'post',
                url: route('method.restore', recordID),
                headers: {'X-CSRF-TOKEN' :  $('meta[name="csrf-token"]').attr('content')},
            }).then(response => {
                if (response.status == 200) {
                    $('#confirmModal button').removeAttr('disabled');
                    confModal.hide();

                    succModal.show();
                    document.getElementById('successModal').addEventListener('shown.tw.modal', function(event){
                        $('#successModal .successModalTitle').html('Congratulations!');
                        $('#successModal .successModalDesc').html('Method Item Successfully Restored!');
                    });
                }
                outflowCategoryListDatatable.init();
                inflowCategoryListDatatable.init();
            }).catch(error =>{
                console.log(error)
            });
        }
    })

    // Delete Method
    $('#inflowCategoryListTable, #outfolowCategoryListTable').on('click', '.delete_btn', function(){
        let $statusBTN = $(this);
        let categoryID = $statusBTN.attr('data-id');

        confModal.show();
        document.getElementById('confirmModal').addEventListener('shown.tw.modal', function(event){
            $('#confirmModal .confModTitle').html(confModalDelTitle);
            $('#confirmModal .confModDesc').html(confModalDelDescription);
            $('#confirmModal .agreeWith').attr('data-id', categoryID);
            $('#confirmModal .agreeWith').attr('data-action', 'DELETE');
        });
    });

    // Populate Edit Modal Data
    $('#inflowCategoryListTable, #outfolowCategoryListTable').on('click', '.eidt_btn', function(){
        let $editBtn = $(this);
        let editId = $editBtn.attr('data-id');

        axios({
            method: "post",
            url: route('category.show', editId),
            data: {id : editId},
            headers: {'X-CSRF-TOKEN' :  $('meta[name="csrf-token"]').attr('content')},
        }).then(response => {
            if (response.status == 200) {
                $('#editCategoryForm input[name="category_name"]').val(response.data.category_name);   
                document.querySelector('#editCategoryForm input[name="trans_type"][value="'+response.data.trans_type+'"').checked=true;

                if(response.data.status == 2){
                    document.querySelector('#editCategoryForm input[name="status"]').checked=false;
                }else{
                    document.querySelector('#editCategoryForm input[name="status"]').checked=true;
                }
                $('#editCategoryForm input[name="id"]').val(editId);

                
                editParentIds.destroy();
                $('#editCategoryForm select[name="parent_id"]').html(response.data.options).val(response.data.parent_id);
                editParentIds = new TomSelect(edit_parent_id, optionsList);
            }
        }).catch(error =>{
            console.log(error);
        });
    });

    // Update Category
    $('#editCategoryForm').on('submit', function(e){
        e.preventDefault();
        const form = document.getElementById('editCategoryForm');

        $('#editCategoryForm').find('input').removeClass('border-danger')
        $('#editCategoryForm').find('.acc__input-error').html('')

        document.querySelector('#updateCategory').setAttribute('disabled', 'disabled');
        document.querySelector('#updateCategory svg').style.cssText = 'display: inline-block;';

        let form_data = new FormData(form);
        let categoryID = $('#editCategoryForm input[name="id"]').val();
        let trans_type = document.querySelector('#editCategoryForm input[name="trans_type"]:checked').value;

        axios({
            method: "post",
            url: route('category.update', categoryID),
            data: form_data,
            headers: {'X-CSRF-TOKEN' :  $('meta[name="csrf-token"]').attr('content')},
        }).then(response => {
            document.querySelector('#updateCategory').removeAttribute('disabled');
            document.querySelector('#updateCategory svg').style.cssText = 'display: none;';
            
            if (response.status == 200) {
                document.querySelector('#editCategoryForm input[name="category_name"]').value = ''; 
                document.querySelector('#editCategoryForm select[name="parent_id"]').value = ''; 
                document.querySelector('#editCategoryForm input[name="trans_type"][value="0"').checked=true;
                document.querySelector('#editCategoryForm input[name="status"]').checked=true;
                editModal.hide();

                succModal.show();
                document.getElementById('successModal').addEventListener('shown.tw.modal', function(event){
                    $('#successModal .successModalTitle').html('Congratulations!');
                    $('#successModal .successModalDesc').html('Category Data Success Fully Updated!');
                });
            }

            outflowCategoryListDatatable.init();
            inflowCategoryListDatatable.init();
        }).catch(error => {
            document.querySelector('#updateCategory').removeAttribute('disabled');
            document.querySelector('#updateCategory svg').style.cssText = 'display: none;';
            if (error.response) {
                if (error.response.status == 422) {
                    for (const [key, val] of Object.entries(error.response.data.errors)) {
                        $(`#editCategoryForm .${key}`).addClass('border-danger')
                        $(`#editCategoryForm  .error-${key}`).html(val)
                    }
                } else {
                    console.log('error');
                }
            }
        });

    });

    // Update Category Status
    $('#inflowCategoryListTable, #outfolowCategoryListTable').on('change', '.status_updater', function(){
        let $statusBTN = $(this);
        let categoryID = $statusBTN.attr('data-id');
        let status = (this.checked ? 1 : 2);

        $statusBTN.attr('disabled', 'disabled');

        axios({
            method: "post",
            url: route('category.upddate.status'),
            data: {id : categoryID, status : status},
            headers: {'X-CSRF-TOKEN' :  $('meta[name="csrf-token"]').attr('content')},
        }).then(response => {
            if (response.status == 200) {
                $statusBTN.removeAttr('disabled');

                succModal.show();
                document.getElementById('successModal').addEventListener('shown.tw.modal', function(event){
                    $('#successModal .successModalTitle').html('Congratulations!');
                    $('#successModal .successModalDesc').html('Category Item Status Success Fully Updated!');
                });
            }

            outflowCategoryListDatatable.init();
            inflowCategoryListDatatable.init();
        }).catch(error =>{
            console.log(error)
        });
    });

    // Add Method
    $('#addCategoryForm').on('submit', function(e){
        e.preventDefault();
        const form = document.getElementById('addCategoryForm');
        var trans_type = document.querySelector('#addCategoryForm input[name="trans_type"]:checked').value;

        $('#addCategoryForm').find('input').removeClass('border-danger')
        $('#addCategoryForm').find('.acc__input-error').html('')

        document.querySelector('#saveCategory').setAttribute('disabled', 'disabled');
        document.querySelector('#saveCategory svg').style.cssText = 'display: inline-block;';

        let form_data = new FormData(form);

        axios({
            method: "post",
            url: route('category.store'),
            data: form_data,
            headers: {'X-CSRF-TOKEN' :  $('meta[name="csrf-token"]').attr('content')},
        }).then(response => {
            document.querySelector('#saveCategory').removeAttribute('disabled');
            document.querySelector('#saveCategory svg').style.cssText = 'display: none;';
            
            if (response.status == 200) {
                document.querySelector('#addCategoryModal input[name="category_name"]').value = ''; 
                document.querySelector('#addCategoryModal select[name="parent_id"]').value = ''; 
                document.querySelector('#addCategoryModal input[name="trans_type"][value="0"').checked=true;
                document.querySelector('#addCategoryModal input[name="status"]').checked=true;
                addModal.hide();

                succModal.show();
                document.getElementById('successModal').addEventListener('shown.tw.modal', function(event){
                    $('#successModal .successModalTitle').html('Congratulations!');
                    $('#successModal .successModalDesc').html('Category Data Success Fully Inserted!');
                });
            }
            if(trans_type == 1){
                outflowCategoryListDatatable.init();
            }else{
                inflowCategoryListDatatable.init();
            }
        }).catch(error => {
            document.querySelector('#saveCategory').removeAttribute('disabled');
            document.querySelector('#saveCategory svg').style.cssText = 'display: none;';
            if (error.response) {
                if (error.response.status == 422) {
                    for (const [key, val] of Object.entries(error.response.data.errors)) {
                        $(`#addCategoryForm .${key}`).addClass('border-danger')
                        $(`#addCategoryForm  .error-${key}`).html(val)
                    }
                } else {
                    console.log('error');
                }
            }
        });

    });


})()