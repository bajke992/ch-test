@extends('layouts.admin')

@section('content')

    <div class="container">
        <a href="{{ URL::route('admin.flowCreate.poll') }}" class="btn btn-info">Create Poll (Flow)</a>
        <a href="{{ URL::route('admin.poll.create') }}" class="btn btn-info">Create Poll</a>
        <table class="table">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Title</th>
                    <th># of Questions</th>
                    <th>Created</th>
                    <th>Visibility</th>
                    <th>Status</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                @forelse($polls as $poll)
                    @include('admin.polls.listItem')
                @empty
                    <tr>
                        <td>No data</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>

@endsection