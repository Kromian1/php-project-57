@extends('layouts.app')

@section('title', __('Create status'))

@section('header', __('Create status'))

@section('content')
    {{ html()->modelForm($status, 'POST', route('task_statuses.store'))->open() }}
    @include('task_statuses.form')

    <div class="mt-4">
        {{ html()->submit(__('Create status'))->class('bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded') }}
    </div>
    {{ html()->closeModelForm() }}
@endsection
