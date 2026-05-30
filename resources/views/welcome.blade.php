@extends('layouts.app')

@section('title', __('Main page'))

@section('content')
    <div class="w-full px-6 py-12 bg-white text-black min-h-screen">
        <h1 style="font-size: 2.5rem; font-weight: 700; line-height: 1.1;" class="tracking-tight mb-6 text-black">{{ __('Hello from Hexlet!') }}</h1>
        <h3 class="text-xl font-normal text-gray-400 tracking-wide">{{ __('This is simple task manager on Laravel') }}</h3>
    </div>
@endsection
