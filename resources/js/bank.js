import xlsx from "xlsx";
import { createIcons, icons } from "lucide";
import Tabulator from "tabulator-tables";

"use strict";
var bankListDatatable = function () {
    var _tableGen = function () {
        // Setup Tabulator
        let storageName = ($('#storage_name').val() != '' ? $('#storage_name').val() : '');
        let status = ($('#status').val() != '' ? $('#status').val() : '');
        
        let bankListTable = new Tabulator("#bankListTable", {
            ajaxURL: route('banksList'),
            ajaxParams:{storageName: storageName, status: status},
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
                    title:"Image", 
                    field:"bank_image",
                    hozAlign: "left",
                    headerHozAlign: 'left',
                    vertAlign: "middle",
                    width: '120',
                    print: false,
                    download: false,
                    headerSort: false,
                    formatter(cell, formatterParams) {
                        if(cell.getData.bank_image != ''){
                            return `<div class="flex lg:justify-center">
                                <div class="intro-x w-10 h-10 image-fit">
                                    <img alt="Midone - HTML Admin Template" class="rounded-full" src="${
                                        cell.getData().bank_image
                                    }">
                                </div>
                            </div>`;
                        }else{
                            return '';
                        }
                        
                    },
                },
                {
                    title:"Storage", 
                    field:"bank_name",
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
                        btns += '<button data-id="'+cell.getData().id+'" data-tw-toggle="modal" data-tw-target="#editNewStorageModal"  type="button" class="eidt_btn btn-rounded btn btn-success text-white p-0 w-9 h-9"><i data-lucide="edit-3" class="w-4 h-4"></i></a>';
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
            bankListTable.redraw();
            createIcons({
                icons,
                "stroke-width": 1.5,
                nameAttr: "data-lucide",
            });
        });

        // Export
        $("#tabulator-export-csv").on("click", function (event) {
            bankListTable.download("csv", "data.csv");
        });

        $("#tabulator-export-json").on("click", function (event) {
            bankListTable.download("json", "data.json");
        });

        $("#tabulator-export-xlsx").on("click", function (event) {
            window.XLSX = xlsx;
            bankListTable.download("xlsx", "data.xlsx", {
                sheetName: "Bank Storages",
            });
        });

        $("#tabulator-export-html").on("click", function (event) {
            bankListTable.download("html", "data.html", {
                style: true,
            });
        });

        // Print
        $("#tabulator-print").on("click", function (event) {
            bankListTable.print();
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
    if ($("#bankListTable").length) {
        // Init Table 
        bankListDatatable.init();

        // Filter function
        function filterHTMLForm() {
            bankListDatatable.init();
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

(function () {
    if (!$("#bankListTable").length) {
        return;
    }
    const addModal = tailwind.Modal.getOrCreateInstance(document.querySelector("#addNewStorageModal"));
    const editModal = tailwind.Modal.getOrCreateInstance(document.querySelector("#editNewStorageModal"));
    const succModal = tailwind.Modal.getOrCreateInstance(document.querySelector("#successModal"));
    const confModal = tailwind.Modal.getOrCreateInstance(document.querySelector("#confirmModal"));
    let confModalDelTitle = 'Are you sure?';
    let confModalDelDescription = 'Do you really want to delete these records? <br>This process cannot be undone.';
    let confModalRestDescription = 'Do you really want to re-store these records? Click agree to continue.';

    document.getElementById('confirmModal').addEventListener('hidden.tw.modal', function(event){
        $('#confirmModal .agreeWith').attr('data-id', '0');
        $('#confirmModal .agreeWith').attr('data-action', 'none');
    });

    document.getElementById('editNewStorageModal').addEventListener('hidden.tw.modal', function(event){
        $('#editNewStorageModal input[name="bank_name"]').val('');
        $('#editNewStorageModal input[name="id"]').val('');
        document.querySelector('#editNewStorageModal input[name="status"]').checked=true;
        document.querySelector('#editNewStorageModal .downloadFile').setAttribute('href', '#');
        document.querySelector('#editNewStorageModal .downloadFile').style.cssText = 'display: none; bottom: -3px;';
    });

    $('#bankListTable').on('click', '.restore_btn', function(){
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

    $('#bankListTable').on('click', '.delete_btn', function(){
        let $statusBTN = $(this);
        let bankId = $statusBTN.attr('data-id');

        confModal.show();
        document.getElementById('confirmModal').addEventListener('shown.tw.modal', function(event){
            $('#confirmModal .confModTitle').html(confModalDelTitle);
            $('#confirmModal .confModDesc').html(confModalDelDescription);
            $('#confirmModal .agreeWith').attr('data-id', bankId);
            $('#confirmModal .agreeWith').attr('data-action', 'DELETE');
        });
    });

    $('#confirmModal .agreeWith').on('click', function(){
        let $agreeBTN = $(this);
        let recordID = $agreeBTN.attr('data-id');
        let action = $agreeBTN.attr('data-action');

        $('#confirmModal button').attr('disabled', 'disabled');
        if(action == 'DELETE'){
            axios({
                method: 'DELETE',
                url: route('banksDestory', recordID),
                headers: {'X-CSRF-TOKEN' :  $('meta[name="csrf-token"]').attr('content')},
            }).then(response => {
                if (response.status == 200) {
                    $('#confirmModal button').removeAttr('disabled');
                    confModal.hide();

                    succModal.show();
                    document.getElementById('successModal').addEventListener('shown.tw.modal', function(event){
                        $('#successModal .successModalTitle').html('Congratulations!');
                        $('#successModal .successModalDesc').html('Storage Item Success Fully Deleted!');
                    });
                }
                bankListDatatable.init();
            }).catch(error =>{
                console.log(error)
            });
        }else if(action == 'RESTORE'){
            axios({
                method: 'post',
                url: route('banksRestore', recordID),
                headers: {'X-CSRF-TOKEN' :  $('meta[name="csrf-token"]').attr('content')},
            }).then(response => {
                if (response.status == 200) {
                    $('#confirmModal button').removeAttr('disabled');
                    confModal.hide();

                    succModal.show();
                    document.getElementById('successModal').addEventListener('shown.tw.modal', function(event){
                        $('#successModal .successModalTitle').html('Congratulations!');
                        $('#successModal .successModalDesc').html('Storage Item Successfully Restored!');
                    });
                }
                bankListDatatable.init();
            }).catch(error =>{
                console.log(error)
            });
        }
    })


    $('#bankListTable').on('change', '.status_updater', function(){
        let $statusBTN = $(this);
        let bankId = $statusBTN.attr('data-id');
        let status = (this.checked ? 1 : 2);

        $statusBTN.attr('disabled', 'disabled');

        axios({
            method: "post",
            url: route('banksUpdateStatus'),
            data: {id : bankId, status : status},
            headers: {'X-CSRF-TOKEN' :  $('meta[name="csrf-token"]').attr('content')},
        }).then(response => {
            if (response.status == 200) {
                $statusBTN.removeAttr('disabled');

                succModal.show();
                document.getElementById('successModal').addEventListener('shown.tw.modal', function(event){
                    $('#successModal .successModalTitle').html('Congratulations!');
                    $('#successModal .successModalDesc').html('Storage Item Status Success Fully Updated!');
                });
            }
            bankListDatatable.init();
        }).catch(error =>{
            console.log(error)
        });

        bankListDatatable.init();
    });


    $('#bankListTable').on('click', '.eidt_btn', function(){
        let $editBtn = $(this);
        let editId = $editBtn.attr('data-id');

        axios({
            method: "post",
            url: route('bankShow', editId),
            data: {id : editId},
            headers: {'X-CSRF-TOKEN' :  $('meta[name="csrf-token"]').attr('content')},
        }).then(response => {
            if (response.status == 200) {
                $('#editNewStorageForm input[name="bank_name"]').val(response.data.bank_name);
                if(response.data.status == 2){
                    document.querySelector('#editNewStorageForm input[name="status"]').checked=false;
                }else{
                    document.querySelector('#editNewStorageForm input[name="status"]').checked=true;
                }
                if(response.data.bank_image != ''){
                    document.querySelector('#editNewStorageForm .downloadFile').setAttribute('href', response.data.bank_image);
                    document.querySelector('#editNewStorageForm .downloadFile').style.cssText += 'display: inline-flex;';
                }else{
                    document.querySelector('#editNewStorageForm .downloadFile').setAttribute('href', '#');
                    document.querySelector('#editNewStorageForm .downloadFile').style.cssText = 'display: none; bottom: -3px;';
                }
                $('#editNewStorageForm input[name="id"]').val(editId);
            }
        }).catch(error =>{
            console.log(error);
        });
    });

    

    $('#editNewStorageForm').on('submit', function(e){
        e.preventDefault();
        const form = document.getElementById('editNewStorageForm');

        $('#editNewStorageForm').find('input').removeClass('border-danger');
        $('#editNewStorageForm').find('.acc__input-error').html('');

        document.querySelector('#updateStorate').setAttribute('disabled', 'disabled');
        document.querySelector('#updateStorate svg').style.cssText = 'display: inline-block;';

        let form_data = new FormData(form);
        form_data.append("file", bank_image.files[0]);
        
        let bankID = $('#editNewStorageForm input[name="id"]').val();

        axios({
            method: "post",
            url: route('bankUpdate', bankID),
            data: form_data,
            headers: { "Content-Type": "multipart/form-data", 'X-CSRF-TOKEN' :  $('meta[name="csrf-token"]').attr('content')},
        }).then(response => {
            document.querySelector('#updateStorate').removeAttribute('disabled');
            document.querySelector('#updateStorate svg').style.cssText = 'display: none;';
            
            if (response.status == 200) {
                document.querySelector('#editNewStorageForm input[name="bank_name"]').value = ''; 
                document.querySelector('#editNewStorageForm input[name="bank_image"]').value = null;
                document.querySelector('#editNewStorageForm input[name="status"]').checked=true;
                document.querySelector('#editNewStorageForm .downloadFile').setAttribute('href', '#');
                document.querySelector('#editNewStorageForm .downloadFile').style.cssText = 'display: none; bottom: -3px;';
                editModal.hide();

                succModal.show();
                document.getElementById('successModal').addEventListener('shown.tw.modal', function(event){
                    $('#successModal .successModalTitle').html('Congratulations!');
                    $('#successModal .successModalDesc').html('Storage Data Success Fully Updated!');
                });
            }
            bankListDatatable.init();
        }).catch(error => {
            document.querySelector('#updateStorate').removeAttribute('disabled');
            document.querySelector('#updateStorate svg').style.cssText = 'display: none;';
            if (error.response) {
                if (error.response.status == 422) {
                    for (const [key, val] of Object.entries(error.response.data.errors)) {
                        $(`#editNewStorageForm .${key}`).addClass('border-danger')
                        $(`#editNewStorageForm  .error-${key}`).html(val)
                    }
                } else {
                    console.log('error');
                }
            }
        });
    })

    $('#addNewStorageForm').on('submit', function(e){
        e.preventDefault();
        const form = document.getElementById('addNewStorageForm');

        $('#addNewStorageForm').find('input').removeClass('border-danger')
        $('#addNewStorageForm').find('.acc__input-error').html('')

        document.querySelector('#saveStorate').setAttribute('disabled', 'disabled');
        document.querySelector('#saveStorate svg').style.cssText = 'display: inline-block;';

        let form_data = new FormData(form);
        form_data.append("file", bank_image.files[0]);

        axios({
            method: "post",
            url: route('banksStore'),
            data: form_data,
            headers: { "Content-Type": "multipart/form-data", 'X-CSRF-TOKEN' :  $('meta[name="csrf-token"]').attr('content')},
        }).then(response => {
            document.querySelector('#saveStorate').removeAttribute('disabled');
            document.querySelector('#saveStorate svg').style.cssText = 'display: none;';
            
            if (response.status == 200) {
                document.querySelector('#addNewStorageForm input[name="bank_name"]').value = ''; 
                document.querySelector('#addNewStorageForm input[name="bank_image"]').value = null;
                document.querySelector('#addNewStorageForm input[name="status"]').checked=true;
                addModal.hide();

                succModal.show();
                document.getElementById('successModal').addEventListener('shown.tw.modal', function(event){
                    $('#successModal .successModalTitle').html('Congratulations!');
                    $('#successModal .successModalDesc').html('Storage Data Success Fully Inserted!');
                });
            }

            bankListDatatable.init();
        }).catch(error => {
            document.querySelector('#saveStorate').removeAttribute('disabled');
            document.querySelector('#saveStorate svg').style.cssText = 'display: none;';
            if (error.response) {
                if (error.response.status == 422) {
                    for (const [key, val] of Object.entries(error.response.data.errors)) {
                        $(`#addNewStorageForm .${key}`).addClass('border-danger')
                        $(`#addNewStorageForm  .error-${key}`).html(val)
                    }
                } else {
                    console.log('error');
                }
            }
        });

    });
})();