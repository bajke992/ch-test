@extends('layouts.admin')

@section('content')
    <div class="container">
        <form action="" method="POST" class="col-md-6 col-md-offset-3">
            {!! csrf_field() !!}

            <div class="form-group">
                <label for="email">Email</label>
                <input required type="email" class="form-control" id="email" name="email" value="@if($errors->any()){{ old('email') }}@else{{ $user->getEmail() }}@endif"/>
            </div>
            <div class="form-group">
                <label for="password">Password</label>
                <input @if(!isset($update))required @endif type="password" class="form-control" id="password" name="password"/>
            </div>
            <div class="form-group">
                <label for="password">Password Repeat</label>
                <input @if(!isset($update))required @endif type="password" class="form-control" id="password" name="password_confirmation"/>
            </div>

            @include('components.select', [
                'name' => 'status',
                'label' => 'Status',
                'items' => \App\Models\User::$VALID_STATUS,
                'selected' => $user->getStatus()
            ])

            @include('components.checkbox', [
                'name' => 'verified',
                'label' => 'Verified',
                'checked' => $user->getVerified()
            ])

            <button type="submit" class="btn btn-success">Submit</button>
        </form>
    </div>
@endsection