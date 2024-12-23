@extends ('AdminDashboard.master')

@section('content')

<div class="content-header">
    <div>
        <h2 class="content-title card-title">Company Details</h2>
    </div>
</div>

<div class="card mb-4">
    <div class="card-body">
        <form id="generalSection" method="POST" action="{{ route('manage_company.store') }}" enctype="multipart/form-data">
            @csrf
            <div class="row">
                <div class="col-lg-12">
                    <div class="row gx-3">
                        <div class="col-6 mb-3">
                            <label class="form-label">Title</label>
                            <input class="form-control" type="text" name="title" placeholder="Type here" value="{{ old('title', $company->title ?? '') }}" required />
                        </div>
                        <div class="col-6 mb-3">
                            <label class="form-label">Address</label>
                            <input class="form-control" type="text" name="address" placeholder="Type here" value="{{ old('address', $company->address ?? '') }}" required />
                        </div>
                        <div class="col-lg-6 mb-3">
                            <label class="form-label">Email</label>
                            <input class="form-control" type="email" name="email" placeholder="example@mail.com" value="{{ old('email', $company->email ?? '') }}" required />
                        </div>
                        <div class="col-lg-6 mb-3">
                            <label class="form-label">Contact</label>
                            <input class="form-control" type="tel" name="contact" placeholder="+1234567890" value="{{ old('contact', $company->contact ?? '') }}" required />
                        </div>
                        <div class="col-lg-6 mb-3">
                            <label class="form-label">Website</label>
                            <input class="form-control" type="text" name="website" placeholder="Type here" value="{{ old('website', $company->website ?? '') }}" />
                        </div>
                        
                        <div class="col-lg-6 mb-3 text-center">
                            <div>
                                <img id="logoPreview" src="{{ asset($company->logo ?? '/backend/assets/imgs/placeholder-logo.png') }}" 
                                    alt="Logo Preview" class="img-fluid mb-3" style="max-height: 150px;">
                            </div>
                            <input class="form-control" type="file" name="logo" accept="image/*" onchange="previewLogo(event)" />
                        </div>
                    </div>
                </div>
            </div>
            <button class="btn btn-primary" type="submit">Save changes</button>
        </form>
    </div>
</div>

<script>
    function previewLogo(event) {
        const logoPreview = document.getElementById('logoPreview');
        const file = event.target.files[0];
        
        if (file) {
            logoPreview.src = URL.createObjectURL(file);
        }
    }
</script>

@endsection
