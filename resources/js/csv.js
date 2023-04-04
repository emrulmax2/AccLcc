(function () {
    if (!$("#csvListTable").length) {
        return;
    }
    const addModal = tailwind.Modal.getOrCreateInstance(document.querySelector("#addCSVModal"));
    //const editModal = tailwind.Modal.getOrCreateInstance(document.querySelector("#editNewStorageModal"));
    const succModal = tailwind.Modal.getOrCreateInstance(document.querySelector("#successModal"));
    const confModal = tailwind.Modal.getOrCreateInstance(document.querySelector("#confirmModal"));
    let confModalDelTitle = 'Are you sure?';
    let confModalDelDescription = 'Do you really want to delete these records? <br>This process cannot be undone.';
    let confModalRestDescription = 'Do you really want to re-store these records? Click agree to continue.';


    // Redirect On Click Success
    $('.successBTN').on('click', function(e){
        var redirect = $(this).attr('data-redirect');
        if(redirect != undefined && redirect != '#' && redirect != 'reload'){
            succModal.hide();
            window.location.href = redirect;
        }else if(redirect != undefined && redirect == 'reload'){
            window.location.reload();
        }else{
            succModal.hide();
        }
        return false;
    });

    // Enable/Disable submit button
    $('.csv_row .category_id, .csv_row .method_id, .csv_row .bank_id').on('change', function(){
        var $this = $(this);
        var $row = $this.parent('td').parent('.csv_row');
        if($('.category_id', $this).val() != '' && $('.method_id', $this).val() != '' && $('.bank_id', $this).val() != ''){
            $('.rowSubmitBtn', $row).removeAttr('disabled');
        }else{
            $('.rowSubmitBtn', $row).attr('disabled', 'disabled');
        }
    });


    //Submit CSV data
    $('.csvRowForm').on('submit', function(e){
        e.preventDefault();
        var $form = $(this);
        var formID = $form.attr('id');
        const form = document.getElementById(formID);

        $('.rowSubmitBtn', $form).attr('disabled', 'disabled');
        $form.find('input, select').removeClass('border-danger');

        let form_data = new FormData(form);
        console.log(form_data);
        form_data.append("file", $('input[name=transaction_doc_name]', $form)[0].files[0]);

        axios({
            method: "post",
            url: route('csv.to.transaction'),
            data: form_data,
            headers: { "Content-Type": "multipart/form-data", 'X-CSRF-TOKEN' :  $('meta[name="csrf-token"]').attr('content')},
        }).then(response => {
            $('.rowSubmitBtn', $form).attr('disabled', 'disabled');

            if (response.status == 200) {
                succModal.show();
                document.getElementById('successModal').addEventListener('shown.tw.modal', function(event){
                    $('#successModal .successModalTitle').html('Congratulations!');
                    $('#successModal .successModalDesc').html('CSV Data Success Fully Imported!');

                    $('#successModal button.successBTN').attr('data-redirect', 'reload');
                });
            }

        }).catch(error => {
            document.querySelector('#saveCSV').removeAttribute('disabled');
            document.querySelector('#saveCSV svg').style.cssText = 'display: none;';
            if (error.response) {
                if (error.response.status == 422) {
                    for (const [key, val] of Object.entries(error.response.data.errors)) {
                        $(`[name="${key}"]`, $form).addClass('border-danger')
                    }
                } else {
                    console.log('error');
                }
            }
        });

    })


    // CSV From Submission
    $('#addCSVForm').on('submit', function(e){
        e.preventDefault();
        const form = document.getElementById('addCSVForm');

        $('#addCSVForm').find('input').removeClass('border-danger')
        $('#addCSVForm').find('.acc__input-error').html('')

        document.querySelector('#saveCSV').setAttribute('disabled', 'disabled');
        document.querySelector('#saveCSV svg').style.cssText = 'display: inline-block;';

        let form_data = new FormData(form);
        form_data.append("file", csv.files[0]);

        axios({
            method: "post",
            url: route('csv.store'),
            data: form_data,
            headers: { "Content-Type": "multipart/form-data", 'X-CSRF-TOKEN' :  $('meta[name="csrf-token"]').attr('content')},
        }).then(response => {
            document.querySelector('#saveCSV').removeAttribute('disabled');
            document.querySelector('#saveCSV svg').style.cssText = 'display: none;';

            if (response.status == 200) {
                document.querySelector('#addCSVForm select[name="bank_id"]').value = ''; 
                document.querySelector('#addCSVForm input[name="csv"]').value = null;
                addModal.hide();

                succModal.show();
                document.getElementById('successModal').addEventListener('shown.tw.modal', function(event){
                    $('#successModal .successModalTitle').html('Congratulations!');
                    $('#successModal .successModalDesc').html('CSV Data Success Fully Imported!');

                    $('#successModal button.successBTN').attr('data-redirect', response.data.redirect);
                });
            }

        }).catch(error => {
            document.querySelector('#saveCSV').removeAttribute('disabled');
            document.querySelector('#saveCSV svg').style.cssText = 'display: none;';
            if (error.response) {
                if (error.response.status == 422) {
                    for (const [key, val] of Object.entries(error.response.data.errors)) {
                        $(`#addCSVForm .${key}`).addClass('border-danger')
                        $(`#addCSVForm  .error-${key}`).html(val)
                    }
                } else {
                    console.log('error');
                }
            }
        });

    });

})()