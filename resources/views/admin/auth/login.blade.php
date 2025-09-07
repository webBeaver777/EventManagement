<!doctype html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <title>Login | AdminLTE</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
</head>

<body class="login-page bg-body-secondary">

    <div class="login-box">
        <div class="login-logo">
            <a href="{{ route('admin.login') }}"><b>Admin</b>LTE</a>
        </div>

        <div class="card shadow">
            <div class="card-body login-card-body">
                <p class="login-box-msg">Авторизация</p>

                <form id="loginForm">
                    <div class="input-group mb-3">
                        <input type="text" name="login" class="form-control" placeholder="Логин" required>
                        <div class="input-group-text"><i class="bi bi-person"></i></div>
                    </div>
                    <div class="input-group mb-3">
                        <input type="password" name="password" class="form-control" placeholder="Пароль" required>
                        <div class="input-group-text"><i class="bi bi-lock"></i></div>
                    </div>
                    <div class="row">
                        <div class="col-12">
                            <button type="submit" class="btn btn-primary btn-block w-100">Войти</button>
                        </div>
                    </div>
                </form>

                <p class="mb-0 mt-3">
                    <a href="{{ route('admin.register') }}" class="text-center">Регистрация</a>
                </p>
            </div>
        </div>
    </div>

    @vite('resources/css/app.css')
    @vite('resources/js/app.js')

</body>

</html>
