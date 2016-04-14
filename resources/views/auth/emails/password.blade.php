@extends('layouts.email')

@section('body')
    <p>Zdravo, <br/>
        Neko ko se predstavio kao vi je poslao zahtev za resetovanje lozinke.</p>
    <p>Ako ste to bili vi, <a
                href="{{ $link = url('password/reset', $token) }}">kliknite
            ovde</a> da resetujete svoju lozinku, ili iskopirajte i otvorite ovaj link u svom web browseru: {{ $link }}
    </p>
    <p>Ako to niste bili vi, jednostavno ignorišite ovu poruku.</p>
@endsection