@foreach($posts as $item)
    <tr>
        <td>{{ $loop->iteration or $item->id}}</td>
        <td>{{ $item->title }}</td><td>{{ $item->body }}</td>
        <td>
            <a href="{{ url('/posts/' . $item->id) }}" title="View %%modelName%%">
                <button class="btn btn-info btn-xs">
                    <i class="fa fa-eye" aria-hidden="true"></i> View
                </button>
            </a>
            <a href="{{ url('/posts/' . $item->id . '/edit') }}" title="Edit %%modelName%%">
                <button class="btn btn-primary btn-xs">
                    <i class="fa fa-pencil-square-o" aria-hidden="true"></i> Edit
                </button>
            </a>

            <a href="{{ route('posts.destroy', [$item->id]) }}" title="Delete %%modelName%%">
                <button class="btn btn-primary btn-xs btn-danger">
                    <i class="fa fa-remove" aria-hidden="true"></i> Delete
                </button>
            </a>
         </td>
    </tr>
@endforeach