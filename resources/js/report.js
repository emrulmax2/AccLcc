(function () {
    if (!$("#reportSearchForm").length) {
        return;
    }

    $('#reportSearchForm').on('submit', function(e){
        e.preventDefault();
        const form = document.getElementById('reportSearchForm');

        $('#reportSearchForm').find('input').removeClass('border-danger')
        $('#reportSearchForm').find('.acc__input-error').html('')

        document.querySelector('#reportSubmit').setAttribute('disabled', 'disabled');
        document.querySelector('#reportSubmit svg').style.cssText = 'display: inline-block;';

        let form_data = new FormData(form);

        axios({
            method: "post",
            url: route('report.list'),
            data: form_data,
            headers: { 'X-CSRF-TOKEN' :  $('meta[name="csrf-token"]').attr('content')},
        }).then(response => {
            document.querySelector('#reportSubmit').removeAttribute('disabled');
            document.querySelector('#reportSubmit svg').style.cssText = 'display: none;';
            
            if (response.status == 200) {
                
            }

            bankListDatatable.init();
        }).catch(error => {
            document.querySelector('#reportSubmit').removeAttribute('disabled');
            document.querySelector('#reportSubmit svg').style.cssText = 'display: none;';
            if (error.response) {
                if (error.response.status == 422) {
                    for (const [key, val] of Object.entries(error.response.data.errors)) {
                        $(`#reportSearchForm .${key}`).addClass('border-danger')
                        $(`#reportSearchForm  .error-${key}`).html(val)
                    }
                } else {
                    console.log('error');
                }
            }
        });

    });
    
})();