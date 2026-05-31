@extends('layouts.app')

@section('title', __('label.create'))

@section('header', __('label.create'))

@section('content')
    {{ html()->modelForm($label, 'POST', route('labels.store'))->open() }}
    @include('labels.form')

    <div class="mt-4">
        {{ html()->submit(__('label.create'))->class('bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded') }}
    </div>
    {{ html()->closeModelForm() }}
@endsection
