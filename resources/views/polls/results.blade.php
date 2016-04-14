@extends('layouts.app')

@section('content')

    <div class="container">
        <div class="col-md-6 col-md-offset-3">
            <p>
                Vaši odgovori su obeleženi sa <span class="glyphicon glyphicon-ok"></span> znakom.
            </p>
            <h3>{{ $poll->title }}</h3>
            @foreach($poll->questions as $question)
                <div class="col-md-12">
                    <h4>{{ $question->question }}</h4>
                    @foreach($question->answers as $answer)
                        <h5>{{ $answer->answer }}@if(in_array($answer->id, $userAnswers->pluck('answer_id')->toArray())) - <span class="glyphicon glyphicon-ok"></span>@endif</h5>
                    @endforeach
                </div>
            @endforeach
        </div>
    </div>

@endsection