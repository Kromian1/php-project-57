@extends('layouts.app')

@section('title', __('Create label'))

@section('header', __('Create label'))

@section('content')
    {{ html()->modelForm($label, 'POST', route('labels.store'))->open() }}
    @include('labels.form')

    <div class="mt-4">
        {{ html()->submit(__('Create label'))->class('bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded') }}
    </div>
    {{ html()->closeModelForm() }}
@endsection
