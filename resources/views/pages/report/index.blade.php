@extends('../layout/' . $layout)

@section('subhead')
    <title>{{ $title }}</title>
@endsection

@section('subcontent')
    <div class="intro-y flex flex-col sm:flex-row items-center mt-8">
        <h2 class="text-lg font-medium mr-auto">Generate Reports</h2>
    </div>
    <!-- BEGIN: HTML Table Data -->
    <div class="intro-y box p-5 mt-5">
        <form method="post" action="#" id="reportSearchForm">
            <div class="flex flex-col sm:flex-row sm:items-end xl:items-start">
                <div class="xl:flex sm:mr-auto" >
                    <div class="sm:flex items-center sm:mr-6 mt-2 xl:mt-0">
                        <label class="w-auto flex-none xl:w-40 xl:flex-initial">Start Date <span class="text-danger">*</span></label>
                        <input required id="start_date" name="start_date" type="text" class="form-control sm:w-40 2xl:w-full mt-2 sm:mt-0"  placeholder="DD-MM-YYYY">
                        <div class="acc__input-error error-start_date text-danger mt-2"></div>
                    </div>
                    <div class="sm:flex items-center sm:mr-4 mt-2 xl:mt-0">
                        <label class="w-auto flex-none xl:w-40 xl:flex-initial">End Date <span class="text-danger">*</span></label>
                        <input required id="end_date" name="end_date" type="text" class="form-control sm:w-40 2xl:w-full mt-2 sm:mt-0"  placeholder="DD-MM-YYYY">
                        <div class="acc__input-error error-end_date text-danger mt-2"></div>
                    </div>
                </div>
                <div class="flex mt-5 sm:mt-0">
                    <button type="submit" id="reportSubmit" class="btn btn-primary w-auto">
                        Generate Report
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
    <!-- END: HTML Table Data -->

    <!-- BEGIN: Report Data -->
    <div class="intro-y box p-5 mt-5" >

    </div>
    <!-- END: Report Data -->

@endsection