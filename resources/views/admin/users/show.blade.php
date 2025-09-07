@extends('layouts.admin')

@section('title', 'Профиль пользователя')
@section('page-title', 'Информация о пользователе')

@section('content')
<div class="row">
    <div class="col-md-6">
        <div class="card">
            <div class="card-header">
                <h3 class="card-title" id="user-fullname">Загрузка...</h3>
            </div>
            <div class="card-body">
                <ul class="list-group list-group-unbordered mb-3">
                    <li class="list-group-item">
                        <b>ID</b> <span class="float-end" id="user-id">Загрузка...</span>
                    </li>
                    <li class="list-group-item">
                        <b>Логин</b> <span class="float-end" id="user-login">Загрузка...</span>
                    </li>
                    <li class="list-group-item">
                        <b>Имя</b> <span class="float-end" id="user-first-name">Загрузка...</span>
                    </li>
                    <li class="list-group-item">
                        <b>Фамилия</b> <span class="float-end" id="user-last-name">Загрузка...</span>
                    </li>
                    <li class="list-group-item">
                        <b>Дата регистрации</b> <span class="float-end" id="user-registered-at">Загрузка...</span>
                    </li>
                    <li class="list-group-item">
                        <b>Дата рождения</b> <span class="float-end" id="user-birth-date">Загрузка...</span>
                    </li>
                </ul>
            </div>
        </div>
    </div>
</div>
@endsection

@vite('resources/js/admin/user-show.js')
