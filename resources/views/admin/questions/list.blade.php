@extends('layouts.admin')

@section('content')

    <div class="container">
        <a href="{{ URL::route('admin.question.create') }}" class="btn btn-info">Create Question</a>
        <table class="table">
            <thead>
            <tr>
                <th>ID</th>
                <th>Question</th>
                <th>Type</th>
                <th>Actions</th>
            </tr>
            </thead>
            <tbody>
            @forelse($questions as $question)
                @include('admin.questions.listItem')
            @empty
                <tr>
                    <td>No data</td>
                </tr>
            @endforelse
            </tbody>
        </table>
    </div>

@endsection