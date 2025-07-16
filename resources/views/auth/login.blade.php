<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="utf-8" />
        <meta http-equiv="X-UA-Compatible" content="IE=edge" />
        <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />
        <meta name="description" content="" />
        <meta name="author" content="" />
        <title>Login - Sisa</title>
        <link href="css/styles.css" rel="stylesheet" />
        <link rel="shortcut icon" href="https://th.bing.com/th/id/R.18f8da0495751e5017579933b4e5415d?rik=SgGxbmMvF7IYVA&riu=http%3a%2f%2f4.bp.blogspot.com%2f-2YukCxOfSxo%2fT8e_NXB1tCI%2fAAAAAAAAASs%2fDabSIdCLmeU%2fs1600%2fSISAfinal.png&ehk=EGxIf0uJxEA7Zj640QQLEVJvnsqdcmqIBY84Ud3Zy9I%3d&risl=&pid=ImgRaw&r=0" type="image/x-icon">
        <script src="https://use.fontawesome.com/releases/v6.3.0/js/all.js" crossorigin="anonymous"></script>
        @vite(['resources/css/app.css', 'resources/js/app.js'])
    </head>
    <body class="bg-primary">
        <div id="layoutAuthentication">
            <div id="layoutAuthentication_content">
                <main>
                    <div class="container">
                        <div class="row justify-content-center">
                            <div class="col-lg-5">
                                <div class="card shadow-lg border-0 rounded-lg mt-5">
                                    <div class="card-header"><h3 class="text-center font-weight-light my-4">
                                        <img src="https://th.bing.com/th/id/R.18f8da0495751e5017579933b4e5415d?rik=SgGxbmMvF7IYVA&riu=http%3a%2f%2f4.bp.blogspot.com%2f-2YukCxOfSxo%2fT8e_NXB1tCI%2fAAAAAAAAASs%2fDabSIdCLmeU%2fs1600%2fSISAfinal.png&ehk=EGxIf0uJxEA7Zj640QQLEVJvnsqdcmqIBY84Ud3Zy9I%3d&risl=&pid=ImgRaw&r=0" alt="Sisa" width="200">
                                    </h3></div>
                                    <div class="card-body">
                                            @if (session('error'))
                                                <div class="alert alert-danger">
                                                    {{ session('error') }}
                                                </div>
                                            @endif
                                        <form action="{{ route('login.store') }}" method="POST">
                                            @csrf
                                            @method("POST")
                                            <div class="form-floating mb-3">
                                                <input class="form-control" id="email" type="email" placeholder="name@example.com" name="email"/>
                                                <label for="email">Email address</label>
                                            </div>
                                            <div class="form-floating mb-3">
                                                <input class="form-control" id="password" type="password" placeholder="Password" name="password"/>
                                                <label for="inputPassword">Password</label>
                                            </div>
                                            <div class="form-check mb-3">
                                                <input class="form-check-input" id="remember" type="checkbox" value="" name="remember" />
                                                <label class="form-check-label" for="remember">Remember Password</label>
                                            </div>
                                            <div class="d-flex align-items-center justify-content-between mt-4 mb-0">
                                                <a class="small" href="{{ route('forgot.password') }}">Forgot Password?</a>
                                                <input type="submit" class="btn btn-primary">Login</a>
                                            </div>
                                        </form>
                                    </div>
                                    <div class="card-footer text-center py-3">
                                        <div class="small"><a href="{{ route('register') }}">Need an account? Sign up!</a></div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </main>
            </div>
            <div id="layoutAuthentication_footer">
                <footer class="py-4 bg-light mt-auto">
                    <div class="container-fluid px-4">
                        <div class="d-flex align-items-center justify-content-between small">
                            <div class="text-muted">Copyright &copy; Sisa 2025</div>
                            <div>
                                <a href="#">Privacy Policy</a>
                                &middot;
                                <a href="#">Terms &amp; Conditions</a>
                            </div>
                        </div>
                    </div>
                </footer>
            </div>
        </div>
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js" crossorigin="anonymous"></script>
        <script src="js/scripts.js"></script>
    </body>
</html>
