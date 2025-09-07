@extends('layouts.admin')

@section('title', 'Событие')
@section('page-title', 'Детали события')

@section('content')
<div class="row">
    <div class="col-md-3">
        @include('admin.events.partials.all-events')
        @include('admin.events.partials.my-events')
    </div>
    <div class="col-md-9">
        <div class="card">
            <div class="card-header">
                <h3 class="card-title" id="event-title">Загрузка...</h3>
            </div>
            <div class="card-body">
                <p><strong>Описание:</strong> <span id="event-description">Загрузка...</span></p>
                <p><strong>Дата:</strong> <span id="event-date">Загрузка...</span></p>
                <h5 class="mt-4">Участники</h5>
                <table class="table table-striped">
                    <tbody id="event-participants">
                        <tr>
                            <td class="text-muted">Загрузка...</td>
                        </tr>
                    </tbody>
                </table>
                <div class="mt-3" id="event-action-btn"></div>
            </div>
        </div>
    </div>
</div>
@endsection

@vite('resources/js/admin/event-show.js')
