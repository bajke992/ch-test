@extends('layouts.admin')

@section('content')

    <div class="container">
        @include('admin.polls.form', ['poll' => $poll])
    </div>

@endsection