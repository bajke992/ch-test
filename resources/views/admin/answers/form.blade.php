@extends('layouts.admin')

@section('content')
    <div class="container">
        <form action="" method="POST" class="col-md-6 col-md-offset-3">
            {!! csrf_field() !!}

            <div class="form-group">
                <label for="answer">Answer</label>
                <textarea name="answer" id="answer"
                          class="form-control">@if($errors->any()){{ old('answer') }}@else{{ $answer->getAnswer() }}@endif</textarea>
            </div>

            <button type="submit" class="btn btn-success">Submit</button>
        </form>
    </div>
@endsection