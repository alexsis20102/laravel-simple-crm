<div class="auth-container">
        <div class="auth-card">
            <h2 class="text-center mb-4">Registering a new user</h2>

            <form id="registrationForm" method="POST">
                @csrf
                <div class="mb-3">
                    <label for="Name" class="form-label">Name</label>
                    <input type="text" class="form-control" id="Name" name="Name" placeholder="Your Name" required>
                </div>

                <div class="mb-3">
                    <label for="email" class="form-label">E-mail</label>
                    <input type="text" class="form-control" id="email" name="email" placeholder="E-mail" required>
                </div>

                <div class="mb-3">
                    <label for="password" class="form-label">Password</label>
                    <input type="password" class="form-control" id="password" name="password" placeholder="Enter your password" required>
                </div>

                
                <div class="mb-3">
                    <label for="password-repeat" class="form-label">Repeat password</label>
                    <input type="password" class="form-control" id="password-repeat" name="password_confirmation" placeholder="Enter your password" required>
                </div>

                <div class="d-flex justify-content-between mb-3">
                    <a href="{{ route('password.request') }}">Forgot your password?</a>
                    <a href="{{ route('home') }}">Home</a>
                </div>

                <button type="submit" class="btn btn-primary w-100">Registration</button>
            </form>

            <div id="RegistrationMessage" class="mt-3 text-center"></div>
        </div>
    </div>