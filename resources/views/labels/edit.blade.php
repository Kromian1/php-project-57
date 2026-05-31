@extends('layouts.app')

@section('title', __('Edit label'))

@section('header', __('Edit label'))

@section('content')
    {{ html()->modelForm($label, 'PATCH', route('labels.update', $label))->open() }}
    @include('labels.form')

    <div class="mt-3">
        {{ html()->submit(__('Update'))->class('btn btn-primary') }}
        <a href="{{ route('labels.index') }}" class="btn btn-secondary">
            {{ __('button.cancel') }}
        </a>
    </div>
    {{ html()->closeModelForm() }}
@endsection
