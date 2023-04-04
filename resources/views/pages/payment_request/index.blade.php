@extends('../layout/' . $layout)

@section('head')
    <title>{{ $title }}</title>
@endsection

@section('content')
    <div class="container sm:px-10">
        <div class="block xl:grid grid-cols-2 gap-4">
            <!-- BEGIN: Login Info -->
            <div class="hidden xl:flex flex-col min-h-screen">
                <a href="" class="-intro-x flex items-center pt-5">
                    <img alt="Icewall Tailwind HTML Admin Template" class="w-6" src="{{ asset('build/assets/images/logo.svg') }}">
                    <span class="text-white text-lg ml-3">
                        LCC
                    </span>
                </a>
                <div class="my-auto">
                    <img alt="Icewall Tailwind HTML Admin Template" class="-intro-x w-1/2 -mt-16" src="{{ asset('build/assets/images/illustration.svg') }}">
                    <div class="-intro-x text-white font-medium text-4xl leading-tight mt-10">A few more clicks to <br> sign in to your account.</div>
                    <div class="-intro-x mt-5 text-lg text-white text-opacity-70 dark:text-slate-400">Manage all your e-commerce accounts in one place</div>
                </div>
            </div>
            <!-- END: Login Info -->
            <!-- BEGIN: Login Form -->
            <div class="h-screen xl:h-auto flex py-5 xl:py-0 my-10 xl:my-0">
                <div class="my-auto mx-auto xl:ml-20 bg-white dark:bg-darkmode-600 xl:bg-transparent px-5 sm:px-8 py-8 xl:p-0 rounded-md shadow-md xl:shadow-none w-full sm:w-3/4 lg:w-2/4 xl:w-auto">
                    <h2 class="intro-x font-bold text-2xl xl:text-3xl text-center xl:text-left">Payment Request</h2>
                    <form method="post" action="#" id="paymentRequestForm">
                        <div class="intro-x mt-8">
                                <div>
                                    <label for="request_amount" class="form-label">Amount <span class="text-danger">*</span></label>
                                    <input required id="request_amount" name="amount" type="number" class="form-control">
                                    <div class="acc__input-error error-amount text-danger mt-2"></div>
                                </div>
                                <div class="mt-5">
                                    <label for="request_reason" class="form-label">Details of Payment & Reason <span class="text-danger">*</span></label>
                                    <textarea required id="request_reason" name="description" rows="2" class="form-control"></textarea>
                                    <div class="acc__input-error error-description text-danger mt-2"></div>
                                </div>
                                <div class="mt-5">
                                    <label for="request_doc" class="form-label">Related Document</label>
                                    <input id="request_doc" accept=".jpg,.png,.jpeg,.gif,.pdf,.docx,.doc,.xl,.xls,.xlsx" name="request_doc" type="file" class="form-control">
                                    <div class="acc__input-error error-upload text-danger mt-2"></div>
                                </div>
                                <div class="mt-5 userCodeWrap" id="userCodeWrap" style="display: none;">
                                    <label for="user_code" class="form-label">User Code <span class="text-danger">*</span></label>
                                    <input id="user_code" name="user_code" type="text" class="form-control">
                                    <div class="acc__input-error error-user_code text-danger mt-2"></div>
                                </div>
                        </div>
                        <div class="intro-x mt-5 xl:mt-8 text-center xl:text-left">
                            <button id="paymentRequestSubmit" class="btn btn-primary py-3 px-4 w-auto align-top">Submit Request</button>
                        </div>
                    </form>
                </div>
            </div>
            <!-- END: Login Form -->
        </div>
    </div>
@endsection

@section('script')
    <script type="module">
        $('#paymentRequestForm').on('submit', function(e){
            e.preventDefault();
            var $form = $(this);
            const form = document.getElementById('paymentRequestForm');
            let userCodeWrap = document.getElementById('userCodeWrap');

            $('#paymentRequestForm').find('input').removeClass('border-danger');
            $('#paymentRequestForm').find('.acc__input-error').html('');


            if(window.getComputedStyle(userCodeWrap).display === "none"){
                $('#paymentRequestForm .userCodeWrap').fadeIn('fast', function(){
                    $('#paymentRequestForm .userCodeWrap input').val('');
                    $('#paymentRequestForm button').html('Confirm Request');
                });
            }else{
                let form_data = new FormData(form);
                form_data.append("file", request_doc.files[0]);

                document.querySelector('#paymentRequestSubmit').setAttribute('disabled', 'disabled');

                axios({
                    method: "post",
                    url: "{{ route('payment_request.store') }}",
                    data: form_data,
                    headers: { "Content-Type": "multipart/form-data", 'X-CSRF-TOKEN' :  $('meta[name="csrf-token"]').attr('content')},
                }).then(response => {
                    document.querySelector('#paymentRequestSubmit').removeAttribute('disabled');
                    
                    if (response.status == 200) {
                        alert('hi')
                    }
                }).catch(error => {
                    document.querySelector('#paymentRequestSubmit').removeAttribute('disabled');
                    if (error.response) {
                        if (error.response.status == 422) {
                            for (const [key, val] of Object.entries(error.response.data.errors)) {
                                $(`#paymentRequestForm .${key}`).addClass('border-danger')
                                $(`#paymentRequestForm  .error-${key}`).html(val)
                            }
                        } else {
                            console.log('error');
                        }
                    }
                });
            }
        })
    </script>
@endsection