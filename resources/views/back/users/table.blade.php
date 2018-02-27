@foreach($users as $user)
    <tr>
        <td>{{ $user->id }}</td>
        <td>{{ $user->name }}</td>
        <td>{{ $user->username }}</td>
        <td>{{ $user->email }}</td>
        <td>
            <ul>
                @foreach ($user->roles()->get() as $role)
                    <li>{{$role->display_name}}</li>
                @endforeach
            </ul>
        </td>
        <td>{{ $user->created_at->formatLocalized('%c') }}</td>
        <td><a class="btn btn-warning btn-xs btn-block" href="{{ route('users.edit', [$user->id]) }}" role="button"
               title="@lang('Edit')"><span class="fa fa-edit"></span></a></td>
        <td><a class="btn btn-danger btn-xs btn-block" href="{{ route('users.destroy', [$user->id]) }}" role="button"
               title="@lang('Destroy')"><span class="fa fa-remove"></span></a></td>
    </tr>
@endforeach