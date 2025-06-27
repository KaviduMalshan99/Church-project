<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Login</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            background: #ffffff;
            min-height: 100vh;
            display: flex;
            justify-content: center;
            align-items: center;
            position: relative;
            overflow: hidden;
        }

        /* Animated background circles */
        body::before {
            content: '';
            position: absolute;
            top: -50%;
            left: -50%;
            width: 200%;
            height: 200%;
            background: radial-gradient(circle, rgba(220, 38, 38, 0.03) 1px, transparent 1px);
            background-size: 50px 50px;
            animation: float 20s ease-in-out infinite;
        }

        @keyframes float {
            0%, 100% { transform: translateY(0px) rotate(0deg); }
            50% { transform: translateY(-20px) rotate(5deg); }
        }

        .main-container {
            background: rgba(255, 255, 255, 1);
            backdrop-filter: blur(20px);
            border-radius: 0px;
            box-shadow: 0 20px 40px rgba(0, 0, 0, 0.08);
            overflow: hidden;
            width: 900px;
            max-width: 90vw;
            min-height: 500px;
            display: flex;
            position: relative;
            z-index: 1;
            animation: slideIn 0.8s ease-out;
            border: 1px solid #f3f4f6;
        }

        @keyframes slideIn {
            from { opacity: 0; transform: translateY(30px); }
            to { opacity: 1; transform: translateY(0); }
        }

        .logo-section {
            flex: 1;
            background: linear-gradient(45deg, #dc2626 0%, #ef4444 100%);
            display: flex;
            flex-direction: column;
            justify-content: center;
            align-items: center;
            padding: 40px;
            position: relative;
            overflow: hidden;
        }

        .logo-section::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            background: url('data:image/svg+xml,<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 100 100"><circle cx="20" cy="20" r="2" fill="rgba(255,255,255,0.1)"/><circle cx="80" cy="80" r="2" fill="rgba(255,255,255,0.1)"/><circle cx="40" cy="70" r="1" fill="rgba(255,255,255,0.1)"/><circle cx="70" cy="30" r="1.5" fill="rgba(255,255,255,0.1)"/></svg>');
            animation: sparkle 3s ease-in-out infinite;
        }

        @keyframes sparkle {
            0%, 100% { opacity: 0.3; }
            50% { opacity: 0.7; }
        }

        .logo-section img {
            max-width: 200px;
            max-height: 200px;
            object-fit: contain;
            border-radius: 15px;
            box-shadow: 0 10px 30px rgba(0, 0, 0, 0.2);
            margin-bottom: 20px;
            transition: transform 0.3s ease;
        }

        .logo-section img:hover {
            transform: scale(1.05);
        }

        .welcome-text {
            color: white;
            text-align: center;
            margin-top: 20px;
        }

        .welcome-text h3 {
            font-size: 28px;
            font-weight: 700;
            margin-bottom: 10px;
            text-shadow: 0 2px 4px rgba(0, 0, 0, 0.3);
        }

        .welcome-text p {
            font-size: 16px;
            opacity: 0.9;
            line-height: 1.5;
        }

        .login-section {
            flex: 1;
            padding: 60px 50px;
            display: flex;
            flex-direction: column;
            justify-content: center;
        }

        .login-header {
            text-align: center;
            margin-bottom: 40px;
        }

        .login-header h4 {
            font-size: 32px;
            font-weight: 700;
            color: #1f2937;
            margin-bottom: 10px;
        }

        .login-header p {
            color: #6b7280;
            font-size: 16px;
        }

        .form-group {
            position: relative;
            margin-bottom: 25px;
        }

        .form-group label {
            font-weight: 600;
            color: #374151;
            margin-bottom: 8px;
            font-size: 14px;
            text-transform: uppercase;
            letter-spacing: 0.5px;
        }

        .form-control {
            border: 2px solid #e5e7eb;
            border-radius: 0px;
            padding: 15px 20px;
            font-size: 16px;
            transition: all 0.3s ease;
            background-color: #ffffff;
        }

        .form-control:focus {
            border-color: #dc2626;
            box-shadow: 0 0 0 0.2rem rgba(220, 38, 38, 0.15);
            background-color: white;
            transform: translateY(-2px);
        }

        .input-group {
            position: relative;
        }

        .input-group-append {
            position: absolute;
            right: 15px;
            top: 50%;
            transform: translateY(-50%);
            cursor: pointer;
            z-index: 10;
        }

        .input-group-text {
            background: none;
            border: none;
            color: #6b7280;
            font-size: 18px;
            transition: color 0.3s ease;
        }

        .input-group-append:hover .input-group-text {
            color: #dc2626;
        }

        .btn-login {
            background: linear-gradient(45deg, #dc2626 0%, #b91c1c 100%);
            border: none;
            border-radius: 0px;
            padding: 15px;
            font-size: 18px;
            font-weight: 600;
            color: white;
            text-transform: uppercase;
            letter-spacing: 1px;
            transition: all 0.3s ease;
            position: relative;
            overflow: hidden;
        }

        .btn-login::before {
            content: '';
            position: absolute;
            top: 0;
            left: -100%;
            width: 100%;
            height: 100%;
            background: linear-gradient(90deg, transparent, rgba(255, 255, 255, 0.2), transparent);
            transition: left 0.5s;
        }

        .btn-login:hover::before {
            left: 100%;
        }

        .btn-login:hover {
            transform: translateY(-2px);
            box-shadow: 0 10px 25px rgba(220, 38, 38, 0.4);
        }

        .btn-login:active {
            transform: translateY(0);
        }

        .alert {
            border-radius: 12px;
            border: none;
            padding: 15px 20px;
            margin-bottom: 25px;
            animation: shake 0.5s ease-in-out;
        }

        @keyframes shake {
            0%, 100% { transform: translateX(0); }
            25% { transform: translateX(-5px); }
            75% { transform: translateX(5px); }
        }

        .alert-danger {
            background: linear-gradient(45deg, #dc2626, #b91c1c);
            color: white;
            box-shadow: 0 5px 15px rgba(220, 38, 38, 0.3);
        }

        /* Responsive design */
        @media (max-width: 768px) {
            .main-container {
                flex-direction: column;
                width: 95vw;
                max-height: 90vh;
            }

            .logo-section {
                padding: 30px 20px;
                min-height: 200px;
            }

            .logo-section img {
                max-width: 120px;
                max-height: 120px;
            }

            .welcome-text h3 {
                font-size: 24px;
            }

            .login-section {
                padding: 30px 25px;
            }

            .login-header h4 {
                font-size: 28px;
            }
        }

        /* Loading animation */
        .btn-login.loading {
            pointer-events: none;
            opacity: 0.7;
        }

        .btn-login.loading::after {
            content: '';
            position: absolute;
            width: 20px;
            height: 20px;
            top: 50%;
            left: 50%;
            margin-left: -10px;
            margin-top: -10px;
            border: 2px solid transparent;
            border-top: 2px solid white;
            border-radius: 50%;
            animation: spin 1s linear infinite;
        }

        @keyframes spin {
            0% { transform: rotate(0deg); }
            100% { transform: rotate(360deg); }
        }

        /* Floating elements */
        .floating-elements {
            position: absolute;
            width: 100%;
            height: 100%;
            overflow: hidden;
            z-index: 0;
        }

        .floating-elements::before,
        .floating-elements::after {
            content: '';
            position: absolute;
            width: 100px;
            height: 100px;
            border-radius: 50%;
            background: rgba(220, 38, 38, 0.05);
            animation: float-around 15s ease-in-out infinite;
        }

        .floating-elements::before {
            top: 20%;
            left: 10%;
            animation-delay: 0s;
        }

        .floating-elements::after {
            bottom: 20%;
            right: 10%;
            animation-delay: 7s;
        }

        @keyframes float-around {
            0%, 100% { transform: translateY(0px) translateX(0px); }
            25% { transform: translateY(-20px) translateX(10px); }
            50% { transform: translateY(0px) translateX(20px); }
            75% { transform: translateY(20px) translateX(10px); }
        }
    </style>
</head>
<body>
    <div class="floating-elements"></div>
    
    <div class="main-container">
        <div class="logo-section">
            <img src="data:image/jpeg;base64,{{ base64_encode(file_get_contents(public_path('backend/assets/logo.jpg'))) }}" alt="Company Logo">
            <div class="welcome-text">
                <h3>Welcome Back!</h3>
                <p>Access your admin dashboard with secure authentication</p>
            </div>
        </div>

        <div class="login-section">
            <div class="login-header">
                <h4>Admin Login</h4>
                <p>Please sign in to your account</p>
            </div>

            @if ($errors->any())
                <div class="alert alert-danger">
                    <i class="fas fa-exclamation-triangle mr-2"></i>
                    {{ $errors->first() }}
                </div>
            @endif

            <form action="{{ route('admin.login.post') }}" method="POST" id="loginForm">
                @csrf
                <div class="form-group">
                    <label for="email">
                        <i class="fas fa-envelope mr-1"></i>
                        Email Address
                    </label>
                    <input type="email" class="form-control" id="email" name="email" placeholder="Enter your email" required>
                </div>

                <div class="form-group">
                    <label for="password">
                        <i class="fas fa-lock mr-1"></i>
                        Password
                    </label>
                    <div class="input-group">
                        <input type="password" class="form-control" id="password" name="password" placeholder="Enter your password" required>
                        <div class="input-group-append" onclick="togglePasswordVisibility()">
                            <span class="input-group-text">
                                <i id="toggle-password-icon" class="fas fa-eye"></i>
                            </span>
                        </div>
                    </div>
                </div>

                <button type="submit" class="btn btn-login btn-block" id="loginBtn">
                    <i class="fas fa-sign-in-alt mr-2"></i>
                    Sign In
                </button>
            </form>
        </div>
    </div>

    <script>
        function togglePasswordVisibility() {
            const passwordInput = document.getElementById('password');
            const toggleIcon = document.getElementById('toggle-password-icon');

            if (passwordInput.type === 'password') {
                passwordInput.type = 'text';
                toggleIcon.classList.remove('fa-eye');
                toggleIcon.classList.add('fa-eye-slash');
            } else {
                passwordInput.type = 'password';
                toggleIcon.classList.remove('fa-eye-slash');
                toggleIcon.classList.add('fa-eye');
            }
        }

        // Enhanced form submission with loading state
        document.getElementById('loginForm').addEventListener('submit', function(e) {
            const loginBtn = document.getElementById('loginBtn');
            loginBtn.classList.add('loading');
            loginBtn.innerHTML = '<span>Signing In...</span>';
        });

        // Add smooth focus effects
        document.querySelectorAll('.form-control').forEach(input => {
            input.addEventListener('focus', function() {
                this.parentElement.classList.add('focused');
            });
            
            input.addEventListener('blur', function() {
                this.parentElement.classList.remove('focused');
            });
        });

        // Add enter key support for better UX
        document.addEventListener('keypress', function(e) {
            if (e.key === 'Enter') {
                const form = document.getElementById('loginForm');
                if (document.activeElement.tagName === 'INPUT') {
                    form.submit();
                }
            }
        });
    </script>
</body>
</html>