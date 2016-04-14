@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-10 col-md-offset-1">
            <div class="panel panel-default">
                <div class="panel-heading">Polls</div>

                <div class="panel-body">
                    @forelse($polls as $poll)
                        <a href="{{ URL::route('poll', [$poll->id]) }}">
                            <h4>{{ $poll->title }}</h4>
                        </a>
                    @empty
                        No active polls.
                    @endforelse
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
