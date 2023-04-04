import xlsx from "xlsx";
import { createIcons, icons } from "lucide";
import Tabulator from "tabulator-tables";

"use strict";
var methodListDatatable = function () {
    var _tableGen = function () {
        // Setup Tabulator
        let methodName = ($('#method_name').val() != '' ? $('#method_name').val() : '');
        let status = ($('#status').val() != '' ? $('#status').val() : '');
        
        let methodListTable = new Tabulator("#methodListTable", {
            ajaxURL: route('method.list'),
            ajaxParams:{methodName: methodName, status: status},
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
                    title:"#ID", 
                    field:"id",
                    width: '180',
                },
                {
                    title:"Method Name", 
                    field:"method_name",
                    headerHozAlign: 'left',
                },
                {
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
                },
                { 
                    title: 'Actions', 
                    field: 'actions',
                    headerSort: false,
                    hozAlign: 'right',
                    headerHozAlign: 'right',
                    width: '180',
                    formatter(cell, formatterParams) {
                        var btns = '';
                        btns += '<button data-id="'+cell.getData().id+'" data-tw-toggle="modal" data-tw-target="#editMethodModal"  type="button" class="eidt_btn btn-rounded btn btn-success text-white p-0 w-9 h-9"><i data-lucide="edit-3" class="w-4 h-4"></i></a>';
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
            methodListTable.redraw();
            createIcons({
                icons,
                "stroke-width": 1.5,
                nameAttr: "data-lucide",
            });
        });

        // Export
        $("#tabulator-export-csv").on("click", function (event) {
            methodListTable.download("csv", "data.csv");
        });

        $("#tabulator-export-json").on("click", function (event) {
            methodListTable.download("json", "data.json");
        });

        $("#tabulator-export-xlsx").on("click", function (event) {
            window.XLSX = xlsx;
            methodListTable.download("xlsx", "data.xlsx", {
                sheetName: "Bank Storages",
            });
        });

        $("#tabulator-export-html").on("click", function (event) {
            methodListTable.download("html", "data.html", {
                style: true,
            });
        });

        // Print
        $("#tabulator-print").on("click", function (event) {
            methodListTable.print();
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
    if ($("#methodListTable").length) {
        // Init Table 
        methodListDatatable.init();

        // Filter function
        function filterHTMLForm() {
            methodListDatatable.init();
        }

        // On submit filter form
        $("#tabulatorFilterForm")[0].addEventListener(
            "keypress",
            function (event) {
                let keycode = event.keyCode ? event.keyCode : event.which;
                if (keycode == "13") {
                    event.preventDefault();
                    filterHTMLForm();
                }
            }
        );

        // On click go button
        $("#tabulator-html-filter-go").on("click", function (event) {
            filterHTMLForm();
        });

        // On reset filter form
        $("#tabulator-html-filter-reset").on("click", function (event) {
            $("#storage_name").val("");
            $("#status").val("");
            filterHTMLForm();
        });
    }
})();


(function(){
    if (!$("#methodListTable").length) {
        return;
    }
    const addModal = tailwind.Modal.getOrCreateInstance(document.querySelector("#addNewMethodModal"));
    const editModal = tailwind.Modal.getOrCreateInstance(document.querySelector("#editMethodModal"));
    const succModal = tailwind.Modal.getOrCreateInstance(document.querySelector("#successModal"));
    const confModal = tailwind.Modal.getOrCreateInstance(document.querySelector("#confirmModal"));
    let confModalDelTitle = 'Are you sure?';
    let confModalDelDescription = 'Do you really want to delete these records? <br>This process cannot be undone.';
    let confModalRestDescription = 'Do you really want to re-store these records? Click agree to continue.';

    document.getElementById('editMethodModal').addEventListener('hidden.tw.modal', function(event){
        $('#editMethodModal input[name="method_name"]').val('');
        $('#editMethodModal input[name="id"]').val('');
        document.querySelector('#editMethodModal input[name="status"]').checked=true;
    });

    // Restore Method
    $('#methodListTable').on('click', '.restore_btn', function(){
        let $statusBTN = $(this);
        let bankId = $statusBTN.attr('data-id');

        confModal.show();
        document.getElementById('confirmModal').addEventListener('shown.tw.modal', function(event){
            $('#confirmModal .confModTitle').html(confModalDelTitle);
            $('#confirmModal .confModDesc').html(confModalRestDescription);
            $('#confirmModal .agreeWith').attr('data-id', bankId);
            $('#confirmModal .agreeWith').attr('data-action', 'RESTORE');
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
                url: route('method.delete', recordID),
                headers: {'X-CSRF-TOKEN' :  $('meta[name="csrf-token"]').attr('content')},
            }).then(response => {
                if (response.status == 200) {
                    $('#confirmModal button').removeAttr('disabled');
                    confModal.hide();

                    succModal.show();
                    document.getElementById('successModal').addEventListener('shown.tw.modal', function(event){
                        $('#successModal .successModalTitle').html('Congratulations!');
                        $('#successModal .successModalDesc').html('Methods Item Success Fully Deleted!');
                    });
                }
                methodListDatatable.init();
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
                methodListDatatable.init();
            }).catch(error =>{
                console.log(error)
            });
        }
    })

    // Delete Method
    $('#methodListTable').on('click', '.delete_btn', function(){
        let $statusBTN = $(this);
        let methodID = $statusBTN.attr('data-id');

        confModal.show();
        document.getElementById('confirmModal').addEventListener('shown.tw.modal', function(event){
            $('#confirmModal .confModTitle').html(confModalDelTitle);
            $('#confirmModal .confModDesc').html(confModalDelDescription);
            $('#confirmModal .agreeWith').attr('data-id', methodID);
            $('#confirmModal .agreeWith').attr('data-action', 'DELETE');
        });
    });

    // Update Method
    $('#editMethodForm').on('submit', function(e){
        e.preventDefault();
        const form = document.getElementById('editMethodForm');

        $('#editMethodForm').find('input').removeClass('border-danger');
        $('#editMethodForm').find('.acc__input-error').html('');

        document.querySelector('#updateMethod').setAttribute('disabled', 'disabled');
        document.querySelector('#updateMethod svg').style.cssText = 'display: inline-block;';

        let form_data = new FormData(form);
        
        let methodID = $('#editMethodForm input[name="id"]').val();

        axios({
            method: "post",
            url: route('method.update', methodID),
            data: form_data,
            headers: { 'X-CSRF-TOKEN' :  $('meta[name="csrf-token"]').attr('content')},
        }).then(response => {
            document.querySelector('#updateMethod').removeAttribute('disabled');
            document.querySelector('#updateMethod svg').style.cssText = 'display: none;';
            
            if (response.status == 200) {
                document.querySelector('#editMethodForm input[name="method_name"]').value = ''; 
                document.querySelector('#editMethodForm input[name="status"]').checked=true;
                editModal.hide();

                succModal.show();
                document.getElementById('successModal').addEventListener('shown.tw.modal', function(event){
                    $('#successModal .successModalTitle').html('Congratulations!');
                    $('#successModal .successModalDesc').html('Method Data Success Fully Updated!');
                });
            }
            methodListDatatable.init();
        }).catch(error => {
            document.querySelector('#updateMethod').removeAttribute('disabled');
            document.querySelector('#updateMethod svg').style.cssText = 'display: none;';
            if (error.response) {
                if (error.response.status == 422) {
                    for (const [key, val] of Object.entries(error.response.data.errors)) {
                        $(`#editMethodForm .${key}`).addClass('border-danger')
                        $(`#editMethodForm  .error-${key}`).html(val)
                    }
                } else {
                    console.log('error');
                }
            }
        });
    })

    // Populate Edit Modal Data
    $('#methodListTable').on('click', '.eidt_btn', function(){
        let $editBtn = $(this);
        let editId = $editBtn.attr('data-id');

        axios({
            method: "post",
            url: route('method.show', editId),
            data: {id : editId},
            headers: {'X-CSRF-TOKEN' :  $('meta[name="csrf-token"]').attr('content')},
        }).then(response => {
            if (response.status == 200) {
                $('#editMethodForm input[name="method_name"]').val(response.data.method_name);
                if(response.data.status == 2){
                    document.querySelector('#editMethodForm input[name="status"]').checked=false;
                }else{
                    document.querySelector('#editMethodForm input[name="status"]').checked=true;
                }
                $('#editMethodForm input[name="id"]').val(editId);
            }
        }).catch(error =>{
            console.log(error);
        });
    });

    // Update Method Status
    $('#methodListTable').on('change', '.status_updater', function(){
        let $statusBTN = $(this);
        let methodID = $statusBTN.attr('data-id');
        let status = (this.checked ? 1 : 2);

        $statusBTN.attr('disabled', 'disabled');

        axios({
            method: "post",
            url: route('bank.upddate.status'),
            data: {id : methodID, status : status},
            headers: {'X-CSRF-TOKEN' :  $('meta[name="csrf-token"]').attr('content')},
        }).then(response => {
            if (response.status == 200) {
                $statusBTN.removeAttr('disabled');

                succModal.show();
                document.getElementById('successModal').addEventListener('shown.tw.modal', function(event){
                    $('#successModal .successModalTitle').html('Congratulations!');
                    $('#successModal .successModalDesc').html('Method Item Status Success Fully Updated!');
                });
            }
            bankListDatatable.init();
        }).catch(error =>{
            console.log(error)
        });

        methodListDatatable.init();
    });

    // Add Method
    $('#addNewMethodForm').on('submit', function(e){
        e.preventDefault();
        const form = document.getElementById('addNewMethodForm');

        $('#addNewMethodForm').find('input').removeClass('border-danger')
        $('#addNewMethodForm').find('.acc__input-error').html('')

        document.querySelector('#saveMethod').setAttribute('disabled', 'disabled');
        document.querySelector('#saveMethod svg').style.cssText = 'display: inline-block;';

        let form_data = new FormData(form);

        axios({
            method: "post",
            url: route('method.store'),
            data: form_data,
            headers: {'X-CSRF-TOKEN' :  $('meta[name="csrf-token"]').attr('content')},
        }).then(response => {
            document.querySelector('#saveMethod').removeAttribute('disabled');
            document.querySelector('#saveMethod svg').style.cssText = 'display: none;';
            
            if (response.status == 200) {
                document.querySelector('#addNewMethodModal input[name="method_name"]').value = ''; 
                document.querySelector('#addNewMethodModal input[name="status"]').checked=true;
                addModal.hide();

                succModal.show();
                document.getElementById('successModal').addEventListener('shown.tw.modal', function(event){
                    $('#successModal .successModalTitle').html('Congratulations!');
                    $('#successModal .successModalDesc').html('Method Data Success Fully Inserted!');
                });
            }

            methodListDatatable.init();
        }).catch(error => {
            document.querySelector('#saveMethod').removeAttribute('disabled');
            document.querySelector('#saveMethod svg').style.cssText = 'display: none;';
            if (error.response) {
                if (error.response.status == 422) {
                    for (const [key, val] of Object.entries(error.response.data.errors)) {
                        $(`#addNewMethodForm .${key}`).addClass('border-danger')
                        $(`#addNewMethodForm  .error-${key}`).html(val)
                    }
                } else {
                    console.log('error');
                }
            }
        });

    });

})()