@extends('layouts.app')

@push('css')
    <style>
        .card-register{
            border-radius: 25px;
            background: #FFFFFFAD;
        }
        .step-icon-number{
            border-radius: 100% !important;
        }
        .stepper.stepper-pills .stepper-item.current .stepper-icon {
            background-color: black;
        }
        .stepper.stepper-pills .stepper-item .stepper-icon .stepper-number {
            color: black;
        }
        .border-circle{
            border: 2px solid #1BB1E6;
            border-radius: 100%;
            padding: 10px;
            color:black;
        }
        .register-info{
            border: 2px solid #1BB1E6;
            color:black !important;
            background-color: #ECFEFF;

        }
    </style>
@endpush
@section('content')

    <div id="kt_app_content_container" class="app-container d-flex justify-content-center align-items-center">
        <div class="card mb-5 mb-xl-10 bg-content-card card-no-border" style="width: 100%;">
            <div id="kt_account_settings_profile_details">
                <div class="card-body p-9">

                    <div class="row flex-row mb-5">
                        <div class="col-md-12 text-start">
                            <a class="btn btn-secondary btn-sm" href="{{ url()->previous() }}"><i class="fa fa-chevron-left"></i> Back</a>
                        </div>
                    </div>

                    <div class="row flex-row mb-5">
                        <div class="col-md-12">
                            <h2>New Admin</h2>
                        </div>
                    </div>

                    <div class="flex-row">

                        <div class="w-100">
                            <form id="daftarForm" class="ajax-form" method="POST" action="{{ route('admin.create') }}" enctype="multipart/form-data">
                                @csrf

                                <h5>Admin information:</h5>

                                <div class="fv-row my-5">
                                    <label class="d-flex align-items-center fs-5 fw-semibold mb-4">
                                        <span class="required">Name</span>
                                        <span class="ms-1" data-bs-toggle="tooltip" title="Specify admin name">
                                            <i class="ki-duotone ki-information-5 text-gray-500 fs-6">
                                                <span class="path1"></span>
                                                <span class="path2"></span>
                                                <span class="path3"></span>
                                            </i>
                                        </span>
                                    </label>
                                    <input type="text" class="form-control" id="name" name="name" placeholder="Enter name" value="" />
                                </div>

                                <div class="fv-row mb-5">
                                    <label class="d-flex align-items-center fs-5 fw-semibold mb-4">
                                        <span class="required">Email</span>
                                        <span class="ms-1" data-bs-toggle="tooltip" title="Specify admin name">
                                            <i class="ki-duotone ki-information-5 text-gray-500 fs-6">
                                                <span class="path1"></span>
                                                <span class="path2"></span>
                                                <span class="path3"></span>
                                            </i>
                                        </span>
                                    </label>
                                    <input type="email" class="form-control" id="email" name="email" placeholder="Enter email" />
                                </div>

                                <div class="fv-row row mb-5">
                                    <div class="col-md-6">
                                        <label class="d-flex align-items-center fs-5 fw-semibold mb-4">
                                            <span class="required">Password</span>
                                            <span class="ms-1" data-bs-toggle="tooltip" title="Specify admin name">
                                                <i class="ki-duotone ki-information-5 text-gray-500 fs-6">
                                                    <span class="path1"></span>
                                                    <span class="path2"></span>
                                                    <span class="path3"></span>
                                                </i>
                                            </span>
                                        </label>
                                        <input type="password" class="form-control" id="password" name="password" placeholder="Enter password" />
                                    </div>
                                    <div class="col-md-6">
                                    <label class="d-flex align-items-center fs-5 fw-semibold mb-4">
                                        <span class="required">Confirm Password</span>
                                        <span class="ms-1" data-bs-toggle="tooltip" title="Specify admin name">
                                            <i class="ki-duotone ki-information-5 text-gray-500 fs-6">
                                                <span class="path1"></span>
                                                <span class="path2"></span>
                                                <span class="path3"></span>
                                            </i>
                                        </span>
                                    </label>
                                    <input type="password" class="form-control" id="password_confirmation" name="password_confirmation" placeholder="Enter confirm password"/>
                                    </div>
                                </div>

                                <div class="fv-row mb-5">
                                    <label class="d-flex align-items-center fs-5 fw-semibold mb-4">
                                        <span class="required">Choose Role</span>
                                        <span class="ms-1" data-bs-toggle="tooltip" title="Select role for admin">
                                            <i class="ki-duotone ki-information-5 text-gray-500 fs-6">
                                                <span class="path1"></span>
                                                <span class="path2"></span>
                                                <span class="path3"></span>
                                            </i>
                                        </span>
                                    </label>
                                    {!! Form::select('role', $roles , null, [
                                        'id' => 'role',
                                        'class' => 'form-select form-control',
                                        'placeholder' => 'Select role',
                                    ]) !!}
                                </div>

                                <div class="row">
                                    <div class="col-md-12 text-end">
                                        <div class="mt-7">
                                            <button type="submit" class="btn btn-primary text-nowrap btn-sm">
                                            Submit <i class="fa fa-hand-pointer text-white fs-4 ms-1 me-0"></i>
                                            </button>
                                        </div>
                                    </div>
                                </div>

                            </form>
                        </div>

                    </div>

                </div>
            </div>
        </div>
    </div>

@endsection

@push('script')

    <script>

        $(document).ready(function(){


        });

    </script>

@endpush
