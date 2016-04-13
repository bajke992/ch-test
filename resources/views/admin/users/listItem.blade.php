<tr>
    <td>{{ $user->id }}</td>
    <td>{{ $user->email }}</td>
    <td>{{ $user->type }}</td>
    <td>{{ $user->status }}</td>
    <td>{{ $user->verified }}</td>
    <td class="btn-group">
        <a href="{{ URL::route('admin.user.view', [$user->id]) }}" class="btn btn-default btn-sm actions"><i class="fa fa-info"></i></a>
        <a href="{{ URL::route('admin.user.update', [$user->id]) }}" class="btn btn-default btn-sm actions"><i class="fa fa-edit"></i></a>
        <a href="{{ URL::route('admin.user.ban', [$user->id]) }}" class="btn btn-default btn-sm actions"><i class="fa fa-ban"></i></a>
        <a href="{{ URL::route('admin.user.delete', [$user->id]) }}" class="btn btn-default btn-sm actions"><i class="fa fa-trash-o"></i></a>
    </td>
</tr>