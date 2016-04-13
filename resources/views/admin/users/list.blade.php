@extends('layouts.admin')

@section('content')

    <div class="container">
        <a href="{{ URL::route('admin.user.create') }}" class="btn btn-info">Create User</a>
        <table class="table">
            <thead>
            <tr>
                <th>ID</th>
                <th>Email</th>
                <th>Type</th>
                <th>Status</th>
                <th>Verified</th>
                <th>Actions</th>
            </tr>
            </thead>
            <tbody>
            @forelse($users as $user)
                @include('admin.users.listItem')
            @empty
                <tr>
                    <td>No data</td>
                </tr>
            @endforelse
            </tbody>
        </table>
    </div>

@endsection