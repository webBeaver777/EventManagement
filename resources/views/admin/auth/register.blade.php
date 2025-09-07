<!doctype html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <title>Регистрация | AdminLTE</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    @vite('resources/css/app.css')
    @vite('resources/js/auth/register.js')
    @vite('resources/js/vendor/flatpickr.js')
    @vite('resources/css/vendor/flatpickr.css')
</head>

<body class="register-page bg-body-secondary">
    <div class="register-box">
        <div class="register-logo">
            <a href="{{ route('admin.login') }}"><b>Admin</b>LTE</a>
        </div>
        <div class="card">
            <div class="card-body register-card-body">
                <p class="register-box-msg">Регистрация</p>
                <form id="registerForm">
                    <div class="input-group mb-3">
                        <input type="text" name="login" class="form-control" placeholder="Логин" required>
                        <div class="input-group-text"><i class="bi bi-person-badge"></i></div>
                    </div>
                    <div class="input-group mb-3">
                        <input type="text" name="first_name" class="form-control" placeholder="Имя" required>
                        <div class="input-group-text"><i class="bi bi-person"></i></div>
                    </div>
                    <div class="input-group mb-3">
                        <input type="text" name="last_name" class="form-control" placeholder="Фамилия" required>
                        <div class="input-group-text"><i class="bi bi-person"></i></div>
                    </div>
                    <div class="input-group mb-3">
                        <input type="password" name="password" class="form-control" placeholder="Пароль" required>
                        <div class="input-group-text"><i class="bi bi-lock"></i></div>
                    </div>
                    <div class="input-group mb-3">
                        <input type="password" name="password_confirmation" class="form-control"
                            placeholder="Подтвердите пароль" required>
                        <div class="input-group-text"><i class="bi bi-lock"></i></div>
                    </div>
                    <div class="input-group mb-3">
                        <input type="text" name="birth_date" id="birth_date" class="form-control"
                            placeholder="Дата рождения" required readonly>
                        <div class="input-group-text"><i class="bi bi-calendar"></i></div>
                    </div>
                    <div class="row">
                        <div class="col-12">
                            <button type="submit" class="btn btn-primary w-100">Зарегистрироваться</button>
                        </div>
                    </div>
                </form>
                <p class="mt-3 d-flex justify-content-center">
                    <a href="{{ route('admin.login') }}" class="text-center">Уже зарегистрированы?</a>
                </p>
            </div>
        </div>
    </div>
</body>

</html>
