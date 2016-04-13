<tr>
    <td>{{ $answer->id }}</td>
    <td>{{ $answer->answer }}</td>
    <td class="btn-group">
        <a href="{{ URL::route('admin.answer.view', [$answer->id]) }}" class="btn btn-default btn-sm actions"><i class="fa fa-info"></i></a>
        <a href="{{ URL::route('admin.answer.update', [$answer->id]) }}" class="btn btn-default btn-sm actions"><i class="fa fa-edit"></i></a>
        <a href="{{ URL::route('admin.answer.delete', [$answer->id]) }}" class="btn btn-default btn-sm actions"><i class="fa fa-trash-o"></i></a>
    </td>
</tr>