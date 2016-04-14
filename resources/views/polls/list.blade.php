@extends('layouts.app')

@section('content')

    <div class="container">

        <div class="col-md-6 col-md-offset-3">
            <p>
                Ovde možete naći ankete na kojima ste učestvovali
            </p>
            @forelse($polls as $poll)
                <a href="{{ URL::route('user.polls.view', [$poll->id]) }}"><h4>{{ $poll->title }}</h4></a>
            @empty
                Nema rezultata
            @endforelse
        </div>
    </div>

@endsection