@extends('layouts.email')

@section('body')

    <a href="{{ route('auth.emailVerify', [ $token ]) }}">Kliknite ovde</a>

@endsection