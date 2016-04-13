@extends('layouts.admin')

@section('content')
    <div class="container">
        <form action="" method="POST" class="col-md-6 col-md-offset-3">
            {!! csrf_field() !!}
            <div class="form-group">
                <label for="title">Title</label>
                <input required type="text" class="form-control" name="title" id="title" value="@if($errors->any()){{ old('title') }}@else{{ $poll->getTitle() }}@endif"/>
            </div>

            @include('components.select', [
                'name' => 'visibility',
                'label' => 'Visibility',
                'items' => \App\Models\Poll::$VALID_VISIBILITY,
                'selected' => $poll->getVisibility()
            ])

            @include('components.select', [
                'name' => 'status',
                'label' => 'Status',
                'items' => \App\Models\Poll::$VALID_STATUS,
                'selected' => $poll->getStatus()
            ])

            <button type="submit" class="btn btn-success">Submit</button>
        </form>
    </div>
@endsection