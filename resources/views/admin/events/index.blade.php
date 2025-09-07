@extends('layouts.admin')
@section('title', 'События')
@section('page-title', 'Все события')
@section('content')
<div class="row">
    <div class="col-md-3">
        @include('admin.events.partials.all-events')
        @include('admin.events.partials.my-events')
    </div>
    <div class="col-md-9">
        <div class="card">
            <div class="card-body text-center text-muted">
                Выберите событие слева для просмотра
            </div>
        </div>
    </div>
</div>
@endsection
@vite('resources/js/admin/events-index.js')
