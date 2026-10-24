
    <div class="content d-flex flex-column flex-column-fluid" id="kt_content">
        <div class="post d-flex flex-column-fluid" id="kt_post">
            <div id="kt_content_container" class="container-xxl">

                @if(session('success'))
                    <div class="alert alert-success alert-dismissible fade show" role="alert">
                        {{ session('success') }}
                        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                    </div>
                @endif

                @if ($errors->any())
                    <div class="alert alert-danger">
                        <ul class="mb-0">
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif

                <div class="card">
                    <div class="card-header">
                        <div class="card-title fs-3 fw-bolder">{{$title}}</div>
                    </div>
                    <div class="card-body border-top p-9">
                        





                    <form method="POST"
                                action="{{ route('user.save',[$user->id??null]) }}"
                                id="kt_user_form"
                                enctype="multipart/form-data">

                                @csrf
                                    
                            
                            <div class="row     mb-6">
                                <label class="col-lg-4 col-form-label required fw-bold fs-6">Name</label>
                                <div class="col-lg-8">
                                    <input type="text" name="name" id="name"
                                           class="form-control form-control-lg form-control-solid"
                                           value="{{ old('name', $user->name ?? '') }}"
                                           placeholder="Enter  Name"/>
                                </div>
                            </div>

                            
                            
                            


                            
                        <div class="row mb-6">
                                <label class="col-lg-4 col-form-label required fw-bold fs-6">Email</label>
                                <div class="col-lg-8">
                                    <input type="email" name="email" id="email"
                                           class="form-control form-control-lg form-control-solid"
                                           value="{{ old('email', $user->email ?? '') }}"
                                           placeholder="Enter email"/>
                                </div>
                            </div>

                            <div class="row mb-6">
                                <label class="col-lg-4 col-form-label required fw-bold fs-6">Password</label>
                                <div class="col-lg-8">
                                    <input type="password " name="password" id="password"
                                           class="form-control form-control-lg form-control-solid"
                                           value="{{ old('password', $user->email ?? '') }}"
                                           placeholder="Enter Password"/>
                                </div>
                            </div>

                                <!-- Fields -->

                                <div class="card-footer d-flex justify-content-end py-6 px-9">
                                    <a href="{{ route('chat.index') }}" class="btn btn-light btn-active-light-primary me-2">
                                        Cancel
                                    </a>

                                    <button type="submit" class="btn btn-primary" id="kt_user_submit">
                                        <span class="indicator-label">Save</span>
                                        <span class="indicator-progress">
                                            Please wait...
                                            <span class="spinner-border spinner-border-sm align-middle ms-2"></span>
                                        </span>
                                    </button>
                                </div>

                    </form>
                    </div>

                    
                </div>

            </div>
        </div>
    </div>


@push('scripts')
    <script src="https://cdn.ckeditor.com/ckeditor5/39.0.1/classic/ckeditor.js"></script>

   

<style>
    body{
        background:#f5f8fa;
    }

    .card{
        border:none;
        border-radius:12px;
        box-shadow:0 4px 20px rgba(0,0,0,.08);
    }

    .card-header{
        background:#fff;
        border-bottom:1px solid #e9ecef;
        padding:20px;
    }

    .card-title{
        color:#181c32;
        font-weight:700;
    }

    .card-body{
        background:#fff;
        padding:30px;
    }

    .form-control-solid{
        background:#f8f9fa !important;
        border:1px solid #e4e6ef !important;
        transition:.3s;
    }

    .form-control-solid:focus{
        background:#fff !important;
        border-color:#009ef7 !important;
        box-shadow:0 0 0 .15rem rgba(0,158,247,.15);
    }

    label.required:after{
        content:" *";
        color:#f1416c;
    }

    .btn-primary{
        background:#009ef7;
        border-color:#009ef7;
        border-radius:8px;
        padding:10px 24px;
        font-weight:600;
    }

    .btn-primary:hover{
        background:#0086d1;
        border-color:#0086d1;
    }

    .btn-light{
        border-radius:8px;
        padding:10px 24px;
        font-weight:600;
    }

    .alert{
        border-radius:10px;
    }

    .invalid-feedback{
        font-size:13px;
        font-weight:500;
    }

    .fv-plugins-message-container{
        margin-top:5px;
    }

    .spinner-border-sm{
        width:1rem;
        height:1rem;
    }

    .card-footer{
        background:#fff;
        border-top:1px solid #e9ecef;
    }

    @media (max-width:768px){
        .card-body{
            padding:20px;
        }

        .btn-primary,
        .btn-light{
            width:100%;
            margin-bottom:10px;
        }

        .card-footer{
            flex-direction:column;
        }
    }
</style>