@foreach($posts as $item)
    <tr>
        <td>{{ $item->id}}</td>
        <td>{{ $item->title }}</td><td>{{ $item->body }}</td>

       <td>
           <a class="btn btn-warning btn-xs" href="{{ route('posts.edit', [$item->id]) }}" role="button"
                       title="@lang('Edit')"><span class="fa fa-edit"></span>
           </a>
           <a class="btn btn-danger btn-xs" href="{{ route('posts.destroy', [$item->id]) }}" role="button"
               title="@lang('Destroy')"><span class="fa fa-remove"></span>
           </a>
        </td>
    </tr>
@endforeach