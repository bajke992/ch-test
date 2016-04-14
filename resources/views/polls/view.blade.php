@extends('layouts.app')

@section('content')

    <div class="container">

        <form action="" method="POST" class="col-md-6 col-md-offset-3">
            {!! csrf_field() !!}

            <input type="hidden" name="poll_id" value="{{ $poll->id }}"/>
            <h3>#{{ $poll->id }} - {{ $poll->title }}</h3>
            @foreach($poll->questions as $question)
                <h4>{{ $question->question }}</h4>

                @if($question->type === \App\Models\Question::TYPE_SINGLE)
                    @foreach($question->answers as $answer)
                        @include('components.radio', [
                            'name' => 'answer['.$question->id.']',
                            'id' => 'someId',
                            'value' => $answer->id,
                            'label' => $answer->answer
                        ])
                    @endforeach
                @else
                    @foreach($question->answers as $answer)
                        @include('components.checkbox', [
                            'name' => 'answer['.$question->id.']['.$answer->id.']',
                            'id' => 'someId',
                            'value' => $answer->id,
                            'label' => $answer->answer,
                            'checked' => false,
                        ])
                    @endforeach
                @endif
            @endforeach

            @if(Auth::check())
                @if(Auth::user()->isAdmin())
                    <div class="form-group">
                        Administratorni ne mogu učestvovati na anketama.
                    </div>
                @else
                    <div class="form-group">
                        <button type="submit" class="btn btn-success">Submit</button>
                    </div>
                @endif
            @else
                <div class="form-group">
                    Molimo Vas <a href="{{ URL::route('auth.login') }}">ulogujte se</a> ili <a
                            href="{{ URL::route('auth.register') }}">registrujte</a> nalog kako bi učestvovali u anketi.
                </div>
            @endif
        </form>
    </div>

@endsection