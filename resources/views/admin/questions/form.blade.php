@extends('layouts.admin')

@section('content')
    <div class="container">
        <form action="" method="POST" class="col-md-6 col-md-offset-3">
            {!! csrf_field() !!}

            <div class="form-group">
                <label for="question">Question</label>
                <textarea name="question" id="question"
                          class="form-control">@if($errors->any()){{ old('question') }}@else{{ $question->getQuestion() }}@endif</textarea>
            </div>

            @include('components.select', [
                'name' => 'type',
                'label' => 'Type',
                'items' => \App\Models\Question::$VALID_TYPES,
                'selected' => $question->getType()
            ])

            <button type="submit" class="btn btn-success">Submit</button>
        </form>
    </div>
@endsection