@extends('layouts.app')

@section('title', __('label.edit'))

@section('header', __('label.edit'))

@section('content')
    {{ html()->modelForm($label, 'PATCH', route('labels.update', $label))->open() }}
    @include('labels.form')

    <div class="mt-3">
        {{ html()->submit(__('button.update'))->class('btn btn-primary') }}
        <a href="{{ route('labels.index') }}" class="btn btn-secondary">
            {{ __('button.cancel') }}
        </a>
    </div>
    {{ html()->closeModelForm() }}
@endsection
