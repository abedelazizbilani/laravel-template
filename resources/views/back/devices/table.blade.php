@foreach($devices as $device)
    <tr>
        <td>{{ $device->id }}</td>
        <td>{{ $device->type }}</td>
        <td>{{ $device->version }}</td>
        <td>{{ $device->uuid }}</td>
        <td>@php echo $device->active == 1 ? \Lang::trans("Active") : \Lang::trans("Inactive") @endphp </td>
        <td>{{ $device->locale }}</td>
        <td>{{ $device->last_access }}</td>
        <td>{{ $device->latitude }}</td>
        <td>{{ $device->longitude }}</td>
        <td>{{ $device->created_at }}</td>
    </tr>
@endforeach