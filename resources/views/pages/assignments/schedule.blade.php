@extends('layouts.app.layout')

@section('title', 'Schedule')

@section('content')
<h1 class="text-2xl font-bold mb-3">Schedule</h1>

    @include('components.calendar')

@endsection
