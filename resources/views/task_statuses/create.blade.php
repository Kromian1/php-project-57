@extends('layouts.app')

@section('title', __('status.create'))

@section('header', __('status.create'))

@section('content')
    {{ html()->modelForm($status, 'POST', route('task_statuses.store'))->open() }}
    @include('task_statuses.form')

    <div class="mt-4">
        {{ html()->submit(__('status.create'))->class('bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded') }}
    </div>
    {{ html()->closeModelForm() }}
@endsection
