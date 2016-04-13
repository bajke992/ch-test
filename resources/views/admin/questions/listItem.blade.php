<tr>
    <td>{{ $question->id }}</td>
    <td>{{ $question->question }}</td>
    <td>{{ $question->type }}</td>
    <td>
        <a href="{{ URL::route('admin.question.view', [$question->id]) }}" class="actions"><i class="fa fa-info"></i></a>
        <a href="{{ URL::route('admin.question.update', [$question->id]) }}" class="actions"><i class="fa fa-edit"></i></a>
        <a href="{{ URL::route('admin.question.delete', [$question->id]) }}" class="actions"><i class="fa fa-trash-o"></i></a>
    </td>
</tr>