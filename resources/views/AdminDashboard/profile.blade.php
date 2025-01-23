@extends ('AdminDashboard.master')

@section('content')

<div class="content-header">
    <h2 class="content-title">Profile Setting</h2>
</div>
<div class="card">
    <div class="card-body">
        <div class="col-lg-12">
            <section class="content-body p-xl-4">
                <!-- General Section -->
                <form id="editUserForm" action="{{ route('profile.update') }}" method="POST" enctype="multipart/form-data">
    @csrf
    @method('PATCH')
    <div class="row">
        <div class="col-md-6">
            <!-- Name Input -->
            <div class="mb-3">
                <label for="edit_name" class="form-label">Name</label>
                <input 
                    type="text" 
                    class="form-control @error('name') is-invalid @enderror" 
                    id="edit_name" 
                    name="name" 
                    placeholder="Name" 
                    value="{{ old('name', $admin->name) }}" 
                    required>
                @error('name')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>

            <!-- Email Input -->
            <div class="mb-3">
                <label for="edit_email" class="form-label">Email</label>
                <input 
                    type="email" 
                    class="form-control @error('email') is-invalid @enderror" 
                    id="edit_email" 
                    name="email" 
                    placeholder="Email" 
                    value="{{ old('email', $admin->email) }}" 
                    required>
                @error('email')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>

            <!-- Contact Input -->
            <div class="mb-3">
                <label for="edit_contact" class="form-label">Contact</label>
                <input 
                    type="tel" 
                    class="form-control @error('contact') is-invalid @enderror" 
                    id="edit_contact" 
                    name="contact" 
                    placeholder="Contact" 
                    value="{{ old('contact', $admin->contact) }}" 
                    required>
                @error('contact')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>

             <!-- Signature Input -->
             <div class="mb-3">
                <label for="edit_signature" class="form-label">eSignature</label>
                <input 
                    type="file" 
                    class="form-control @error('signature') is-invalid @enderror" 
                    id="edit_signature" 
                    name="signature" 
                    accept="image/*">
                @error('signature')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror

                @if($admin->signature)
                    <div class="mt-2">
                        <img 
                            id="edit_signature_preview" 
                            src="{{ asset('storage/' . $admin->signature) }}" 
                            alt="Signature Preview" 
                            class="img-thumbnail" 
                            style="max-width: 200px; max-height: 100px;">
                    </div>
                @endif
            </div>
        </div>

        <div class="col-md-6">
            <!-- Current Password -->
            <div class="mb-3">
                <label for="edit_current_password" class="form-label">Current Password</label>
                <input 
                    type="password" 
                    class="form-control @error('current_password') is-invalid @enderror" 
                    id="edit_current_password" 
                    name="current_password" 
                    placeholder="Enter current password" 
                    required>
                @error('current_password')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>

            <!-- New Password -->
            <div class="mb-3">
                <label for="edit_password" class="form-label">New Password</label>
                <input 
                    type="password" 
                    class="form-control @error('password') is-invalid @enderror" 
                    id="edit_password" 
                    name="password" 
                    placeholder="New Password">
                @error('password')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>

            <!-- Confirm New Password -->
            <div class="mb-3">
                <label for="edit_password_confirmation" class="form-label">Confirm New Password</label>
                <input 
                    type="password" 
                    class="form-control @error('password_confirmation') is-invalid @enderror" 
                    id="edit_password_confirmation" 
                    name="password_confirmation" 
                    placeholder="Confirm New Password">
                @error('password_confirmation')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>
        </div>
    </div>

    <!-- Save Button -->
    <div class="text-end">
        <button type="submit" class="btn btn-primary">Save Changes</button>
    </div>
</form>

            </section>
        </div>
    </div>
</div>

@endsection
