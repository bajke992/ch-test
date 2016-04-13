<tr>
    <td>{{ $poll->id }}</td>
    <td>{{ $poll->title }}</td>
    <td>{{ $poll->questions->count() }}</td>
    <td>{{ $poll->created_at }}</td>
    <td>{{ $poll->visibility }}</td>
    <td>{{ $poll->status }}</td>
    <td class="btn-group">
        <a href="{{ URL::route('admin.poll.view', [$poll->id]) }}" class="btn btn-default btn-sm actions"><i class="fa fa-info"></i></a>
        <a href="{{ URL::route('admin.poll.update', [$poll->id]) }}" class="btn btn-default btn-sm actions"><i class="fa fa-edit"></i></a>
        <a href="{{ URL::route('admin.poll.archive', [$poll->id]) }}" class="btn btn-default btn-sm actions"><i class="fa fa-archive"></i></a>
        <a href="{{ URL::route('admin.poll.delete', [$poll->id]) }}" class="btn btn-default btn-sm actions"><i class="fa fa-trash-o"></i></a>
    </td>
</tr>