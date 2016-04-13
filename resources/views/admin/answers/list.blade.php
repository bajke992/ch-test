@extends('layouts.admin')

@section('content')

    <div class="container">
        <a href="{{ URL::route('admin.answer.create') }}" class="btn btn-info">Create Answer</a>
        <table class="table">
            <thead>
            <tr>
                <th>ID</th>
                <th>Answer</th>
                <th>Actions</th>
            </tr>
            </thead>
            <tbody>
            @forelse($answers as $answer)
                @include('admin.answers.listItem')
            @empty
                <tr>
                    <td>No data</td>
                </tr>
            @endforelse
            </tbody>
        </table>
    </div>

@endsection