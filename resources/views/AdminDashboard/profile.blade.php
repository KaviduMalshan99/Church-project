@extends ('AdminDashboard.master')

@section('content')

<div class="content-header">
    <h2 class="content-title">Profile setting</h2>
</div>
<div class="card">
    <div class="card-body">
        <div class="row gx-5">
            <aside class="col-lg-3 border-end">
                <nav class="nav nav-pills flex-lg-column mb-4">
                    <a class="nav-link active" id="general-tab" href="#" onclick="showSection('general')">General</a>
                    <a class="nav-link" id="password-tab" href="#" onclick="showSection('password')">Password</a>
                </nav>
            </aside>
            <div class="col-lg-9">
                <section class="content-body p-xl-4">
                    <!-- General Section -->
                    <form id="generalSection" action="{{ route('admin.profile.update') }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        <div class="row">
                            <div class="col-lg-8">
                                <div class="row gx-3">
                                    <div class="col-12 mb-3">
                                        <label class="form-label">Name</label>
                                        <input class="form-control" type="text" id="name" name="name" value="{{ $admin->name }}" required placeholder="Type here" />
                                    </div>
                                    <div class="col-lg-12 mb-3">
                                        <label class="form-label">Email</label>
                                        <input class="form-control" type="email" id="email" name="email" value="{{ $admin->email }}" required placeholder="example@mail.com" />
                                    </div>
                                    <div class="col-lg-12 mb-3">
                                        <label class="form-label">Phone</label>
                                        <input class="form-control" type="tel" id="contact" name="contact" value="{{ $admin->contact }}" required placeholder="+1234567890" />
                                    </div>
                                </div>
                            </div>
                            <aside class="col-lg-4">
                                <figure class="text-lg-center">
                                    <img id="profileImage" src="{{ asset('storage/user_images/' . session('image', 'default-user.png')) }}" alt="Profile Image" class="img-lg mb-3 img-avatar">
                                    <figcaption>
                                        <!-- Hidden file input -->
                                        <input type="file" id="profileImageInput" name="image" accept="image/*" style="display: none;" onchange="previewImage(event)">
                                        <a class="btn btn-light rounded font-md" href="javascript:void(0);" onclick="document.getElementById('profileImageInput').click();">
                                            <i class="icons material-icons md-backup font-md"></i> Upload
                                        </a>
                                    </figcaption>
                                </figure>
                            </aside>
                        </div>
                        <button class="btn btn-primary" type="submit">Save changes</button>
                    </form>

                    <!-- Password Section -->
                    <form action="{{ route('admin.profile.password.update') }}" method="POST" id="passwordSection" style="display: none;">
                    @csrf
                        <div class="row">
                        @if ($errors->any())
                                <div class="alert alert-danger">
                                    <ul>
                                        @foreach ($errors->all() as $error)
                                            <li>{{ $error }}</li>
                                        @endforeach
                                    </ul>
                                </div>
                            @endif

                            @if (session('success'))
                                <div class="alert alert-success">
                                    {{ session('success') }}
                                </div>
                            @endif

                            <div class="col-lg-8">
                                <div class="mb-3">
                                    <label class="form-label">Current Password</label>
                                    <div class="input-group">
                                        <input type="password" class="form-control" id="current_password" name="current_password" placeholder="Enter current password" />
                                        <span class="input-group-text" onclick="togglePasswordVisibility('current_password', this)">
                                            <i class="fas fa-eye"></i>
                                        </span>
                                    </div>
                                </div>
                                <div class="mb-3">
                                    <label class="form-label">New Password</label>
                                    <div class="input-group">
                                        <input type="password" class="form-control" id="new_password" name="new_password" placeholder="Enter new password" />
                                        <span class="input-group-text" onclick="togglePasswordVisibility('new_password', this)">
                                            <i class="fas fa-eye"></i>
                                        </span>
                                    </div>
                                </div>
                                <div class="mb-3">
                                    <label class="form-label">Confirm New Password</label>
                                    <div class="input-group">
                                        <input type="password" class="form-control" id="new_password_confirmation" name="new_password_confirmation" placeholder="Confirm new password" />
                                        <span class="input-group-text" onclick="togglePasswordVisibility('new_password_confirmation', this)">
                                            <i class="fas fa-eye"></i>
                                        </span>
                                    </div>
                                </div>
                                <button class="btn btn-primary" type="submit">Save Password</button>
                            </div>
                        </div>
                    </form>
                    <hr class="my-5" />
                </section>
            </div>
        </div>
    </div>
</div>

<script>
    // Toggle between General and Password sections
    function showSection(section) {
        if (section === 'general') {
            document.getElementById('generalSection').style.display = 'block';
            document.getElementById('passwordSection').style.display = 'none';
            document.getElementById('general-tab').classList.add('active');
            document.getElementById('password-tab').classList.remove('active');
        } else if (section === 'password') {
            document.getElementById('generalSection').style.display = 'none';
            document.getElementById('passwordSection').style.display = 'block';
            document.getElementById('password-tab').classList.add('active');
            document.getElementById('general-tab').classList.remove('active');
        }
    }

    // Toggle password visibility
    function togglePasswordVisibility(inputId, iconElement) {
        const input = document.getElementById(inputId);
        const icon = iconElement.querySelector('i');
        
        if (input.type === "password") {
            input.type = "text";
            icon.classList.replace("fa-eye", "fa-eye-slash");
        } else {
            input.type = "password";
            icon.classList.replace("fa-eye-slash", "fa-eye");
        }
    }
</script>

<script>
    // JavaScript function to preview the selected image
    function previewImage(event) {
        const file = event.target.files[0];
        if (file) {
            const reader = new FileReader();
            reader.onload = function(e) {
                document.getElementById('profileImage').src = e.target.result;
            };
            reader.readAsDataURL(file);
        }
    }
</script>

@endsection
