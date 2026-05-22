@extends('layouts.app')

@section('title', __('Edit status'))

@section('header', __('Edit status'))

@section('content')
    {{ html()->modelForm($status, 'PATCH', route('task_statuses.update', $status))->open() }}
    @include('task_statuses.form')

    <div class="mt-3">
        {{ html()->submit(__('Update'))->class('btn btn-primary') }}
        <a href="{{ route('task_statuses.index') }}" class="btn btn-secondary">
            {{ __('Cancel') }}
        </a>
    </div>
    {{ html()->closeModelForm() }}
@endsection
