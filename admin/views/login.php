<?php
if (isset($_POST['login'])) {
    $this->adminLogin($_POST['email'], $_POST['password']);
}




?>

<style>
    .login-card {
            width: 100%;
            max-width: 400px;
            padding: 15px;
            border-radius: 10px;
            box-shadow: 0 4px 6px rgba(0,0,0,0.1);
        }
</style>

    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-6 col-lg-4">
                
                <div class="card login-card border-0">
                    <div class="card-body">

                        <?php include BASE_PATH . 'views/include/flash.php'; ?>
                        
                        <div class="text-center mb-4">
                            <h3 class="fw-bold">Welcome Back</h3>
                            <p class="text-secondary">Please enter your details to sign in.</p>
                        </div>

                        <form method="post" action="">
                            <input type="hidden" name="login" value="adminLogin">
                            <div class="form-floating mb-3">
                                <input type="email" name="email" value="admin@gmail.com" class="form-control" id="floatingInput" placeholder="name@example.com" required>
                                <label for="floatingInput">Email address</label>
                            </div>

                            <div class="form-floating mb-3">
                                <input type="password" name="password" value="123456" class="form-control" id="floatingPassword" placeholder="Password" required>
                                <label for="floatingPassword">Password</label>
                            </div>

                            <div class="d-flex justify-content-between align-items-center mb-4">
                                <div class="form-check">
                                    <input class="form-check-input" type="checkbox" value="" id="rememberMe">
                                    <label class="form-check-label text-secondary" for="rememberMe">
                                        Remember me
                                    </label>
                                </div>
                                <a href="#" class="text-decoration-none text-primary small">Forgot Password?</a>
                            </div>

                            <div class="d-grid mb-3">
                                <button class="btn btn-primary btn-lg" type="submit">Sign In</button>
                            </div>

                        </form>
                    </div>
                </div>
                
            </div>
        </div>
    </div>

