@extends('layouts.app')

@section('title', __('task.edit'))

@section('header', __('task.edit'))

@section('content')
    {{ html()->modelForm($task, 'PATCH', route('tasks.update', $task))->open() }}
    @include('tasks.form')

    <div class="mt-3">
        {{ html()->submit(__('button.update'))->class('btn btn-primary') }}
        <a href="{{ route('tasks.index') }}" class="btn btn-secondary">
            {{ __('button.update') }}
        </a>
    </div>
    {{ html()->closeModelForm() }}
@endsection
