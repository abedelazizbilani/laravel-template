@foreach($roles as $role)

    <tr>
        <td>{{ $role->id }}</td>
        <td>{{ $role->name }}</td>
        <td>{{ $role->display_name }}</td>
        <td>{{ $role->description }}</td>
        <td>{{ $role->created_at->formatLocalized('%c') }}</td>
        <td><a class="btn btn-warning btn-xs btn-block" href="{{ route('roles.edit', [$role->id]) }}" role="button"
               title="@lang('Edit')"><span class="fa fa-edit"></span></a></td>
        <td><a class="btn btn-danger btn-xs btn-block" href="{{ route('roles.destroy', [$role->id]) }}" role="button"
               title="@lang('Destroy')"><span class="fa fa-remove"></span></a></td>
    </tr>
@endforeach

