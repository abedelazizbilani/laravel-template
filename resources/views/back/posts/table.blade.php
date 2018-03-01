@foreach($posts as $item)
    <tr>
        <td>{{ $loop->iteration or $item->%%primaryKey%% }}</td>
        %%formBodyHtml%%


        <td>
            <a href="{{ url('/%%routeGroup%%%%viewName%%/' . $item->%%primaryKey%%) }}" title="View %%modelName%%"><button class="btn btn-info btn-xs"><i class="fa fa-eye" aria-hidden="true"></i> View</button></a>
            <a href="{{ url('/%%routeGroup%%%%viewName%%/' . $item->%%primaryKey%% . '/edit') }}" title="Edit %%modelName%%"><button class="btn btn-primary btn-xs"><i class="fa fa-pencil-square-o" aria-hidden="true"></i> Edit</button></a>
        </td>
         <td>
            <a class="btn btn-warning btn-xs btn-block" href="{{ route('%%routeGroup%%.edit', [$item->%%primaryKey%%]) }}" role="button"
                       title="@lang('Edit')"><span class="fa fa-edit"></span></a>
         </td>
         <td>
            <a class="btn btn-danger btn-xs btn-block" href="{{ route('%%routeGroup%%.destroy', [$item->%%primaryKey%%]) }}" role="button"
               title="@lang('Destroy')"><span class="fa fa-remove"></span></a>
         </td>
    </tr>
@endforeach