@extends('layouts.app')

@section('title', __('task.create'))

@section('header', __('task.create'))

@section('content')
    {{ html()->modelForm($task, 'POST', route('tasks.store'))->open() }}
        @include('tasks.form')

    <div class="mt-4">
        {{ html()->submit(__('button.create'))->class('bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded') }}
    </div>
    {{ html()->closeModelForm() }}
@endsection
