@extends('layouts.app')

@push('css')
    <style>
    </style>
@endpush
@section('content')


<div id="kt_app_content_container" class="app-container">
	<div class="card mb-5 mb-xl-10 w-100 mt-5">
		<div id="kt_account_settings_profile_details">
			<div class="card-body p-9">

                <div class="row flex-row mb-5">
                    <div class="col-md-12">
                        <h2>Dashboard</h2>
                    </div>
                </div>


                <div class="row gy-5 g-xl-10 mb-10">

                    <div class="col-sm-6 col-xl-4">
                        <div class="card border-dark">
                            <div class="card-body d-flex justify-content-center align-items-center flex-column">
                                <div class="d-flex flex-column text-center">
                                    <div class="m-0">
                                        <i class="fa fa-solid fa-users fs-2 text-primary"></i>
                                        <span class="fw-bold fs-6 text-dark px-2">Administrator</span>
                                    </div>
                                    <div class="m-0 text-center">
                                        <span class="fw-bold fs-4x text-gray-800" data-kt-countup="true" data-kt-countup-value="5">0</span>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="col-sm-6 col-xl-4">
                        <div class="card border-dark">
                            <div class="card-body d-flex justify-content-center align-items-center flex-column">
                                <div class="d-flex flex-column text-center">
                                    <div class="m-0">
                                        <i class="fa-solid fa-users fs-2 text-warning"></i>
                                        <span class="fw-bold fs-6 text-dark px-2">Super Admin</span>
                                    </div>
                                    <div class="m-0">
                                        <span class="fw-bold fs-4x text-gray-800" data-kt-countup="true" data-kt-countup-value="3">0</span>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="col-sm-6 col-xl-4">
                        <div class="card border-dark">
                            <div class="card-body d-flex justify-content-center align-items-center flex-column">
                                <div class="d-flex flex-column text-center">
                                    <div class="m-0">
                                        <i class="fa-solid fa-users fs-2 text-info"></i>
                                        <span class="fw-bold fs-6 text-dark px-2">Admin</span>
                                    </div>
                                    <div class="m-0 text-center">
                                        <span class="fw-bold fs-4x text-gray-800" data-kt-countup="true" data-kt-countup-value="2">0</span>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                </div>

			</div>
		</div>
	</div>

</div>

@endsection

@push('script')

    <script src="{{ asset('assets/plugins/custom/draggable/draggable.bundle.js') }}"></script>

    <script>

        $(document).ready(function(){


        })

    </script>

@endpush
