@extends('layouts.admin')

@section('content')
    <div class="container">
        <form action="{{ URL::route('admin.flowCreate.finish') }}" method="POST" class="col-md-6 col-md-offset-3">
            {!! csrf_field() !!}

            <input type="hidden" name="poll_id" value="{{ $poll->id }}"/>

            @foreach($questions as $question)
                <div id="question-{{ $question->id }}" data-id="{{ $question->id }}">
                    <h4>{{ $question->question }}</h4>
                    <div class="form-group">
                        <label>Answer</label>
                        <textarea required name="answer[{{ $question->id }}][]" class="form-control"></textarea>
                    </div>
                    <div class="form-group">
                        <label>Answer</label>
                        <textarea required name="answer[{{ $question->id }}][]" class="form-control"></textarea>
                    </div>
                    <a href="javascript:;" class="btn btn-info" id="add-{{ $question->id }}"
                       data-id="{{ $question->id }}">Add Answer</a>
                </div>
                <hr/>
            @endforeach

            <button type="submit" class="btn btn-success">Finish</button>
        </form>
    </div>
@endsection

@section('js')
    <script>
        $submitted = false;
        $('form').submit(function () {
            $submitted = true;
        });

        $('[id^=add-]').click(function () {
            $id = $(this).data('id');
            $clone = $('<div/>').attr({class: 'form-group'}).append(
                    $('<label/>').text('Answer')
            ).append(
                    $('<textarea/>').attr({
                        required: true,
                        name: 'answer[' + $id + '][]',
                        class: 'form-control'
                    })
            );
            $('#question-' + $id).append($clone);
        });
        $(window).bind('beforeunload', function () {
            if (!$submitted) {
                $('[id^=question-]').each(function () {
                    $id = $(this).data('id');
                    $.get('{{ URL::route('admin.question.delete', ['']) }}/' + $id);
                });
            }
        });
    </script>
@endsection