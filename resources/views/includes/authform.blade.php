<div class="auth-container">
        <div class="auth-card">
            <h2 class="text-center mb-4">Welcome</h2>

            <form id="loginForm" method="POST">
                @csrf
                <div class="mb-3">
                    <label for="email" class="form-label">Login</label>
                    <input type="text" class="form-control" id="email" name="email" placeholder="E-mail">
                </div>

                <div class="mb-3">
                    <label for="password" class="form-label">Password</label>
                    <input type="password" class="form-control" id="password" name="password" placeholder="Password">
                </div>

                <div class="d-flex justify-content-between mb-3">
                    <a href="{{ route('password.request') }}">Forgot your password?</a>
                    <a href="{{ route('register') }}">Registration</a>
                </div>

                <button type="submit" class="btn btn-primary w-100">Login</button>
            </form>

            <div id="loginMessage" class="mt-3 text-center"></div>
        </div>
    </div>