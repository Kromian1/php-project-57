@extends('layouts.app')

@section('title', __('status.edit'))

@section('header', __('status.edit'))

@section('content')
    {{ html()->modelForm($status, 'PATCH', route('task_statuses.update', $status))->open() }}
    @include('task_statuses.form')

    <div class="mt-3">
        {{ html()->submit(__('button.update'))->class('btn btn-primary') }}
        <a href="{{ route('task_statuses.index') }}" class="btn btn-secondary">
            {{ __('button.cancel') }}
        </a>
    </div>
    {{ html()->closeModelForm() }}
@endsection
