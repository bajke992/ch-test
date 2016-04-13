@extends('layouts.admin')

@section('content')
    <div class="container">
        <form action="{{ URL::route('admin.flowCreate.answer') }}" method="POST" class="col-md-6 col-md-offset-3">
            {!! csrf_field() !!}

            <input type="hidden" id="poll_id" name="poll_id" value="{{ $poll->id }}"/>

            <div id="clone">
                <div class="form-group">
                    <label for="question">Question</label>
                    <textarea required name="question[]" id="question" class="form-control">@if($errors->any()){{ old('question') }}@else{{ $question->getQuestion() }}@endif</textarea>
                </div>

                @include('components.select', [
                    'name' => 'type[]',
                    'label' => 'Type',
                    'items' => \App\Models\Question::$VALID_TYPES,
                    'selected' => $question->getType()
                ])
            </div>

            <div id="questions">
                <a href="javascript:;" id="add_question" class="btn btn-info">Add Question</a>

            </div>
            <br/>
            <br/>

            <button type="submit" class="btn btn-success">Next Step</button>
        </form>
    </div>
@endsection

@section('js')
    <script>
        $submitted = false;
        $('form').submit(function () {
            $submitted = true;
        });

        $('#add_question').click(function () {
            $clone = $('#clone').html();

            $('#questions').append($clone);
        });
        $(window).bind('beforeunload',function(){
            if(!$submitted) {
                $id = $('#poll_id').val();
                $.get('{{ URL::route('admin.poll.delete', ['']) }}/' + $id);
            }
        });
    </script>
@endsection