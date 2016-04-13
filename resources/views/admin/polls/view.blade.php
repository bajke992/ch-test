@extends('layouts.admin')

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

            <div class="form-group">
                <button type="submit" class="btn btn-success">Submit</button>
            </div>
        </form>
    </div>

@endsection