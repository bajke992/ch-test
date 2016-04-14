@extends('layouts.email')

@section('body')
    <p>Zdravo, <br/>
        Uspešno ste se registrovali!</p>
    <p>Ipak, da biste mogli da učestvujete u anketama, potrebno je da verifikujete svoju e-mail adresu. <a
                href="{{ route('auth.emailVerify', [ $token ]) }}">Kliknite ovde</a> da biste verifikovali svoju adresu,
        ili iskopirajte i otvorite ovaj link u svom web browseru: {{ route('auth.emailVerify', [ $token ]) }}</p>
@endsection