@foreach($feedbacks as $feedback)
    <tr>
        <td>{{ $feedback->id }}</td>
        <td>{{ $feedback->user_id }}</td>
        <td>{{ $feedback->subject }}</td>
        <td>{{ $feedback->body }}</td>
        <td>{{ $feedback->created_at->formatLocalized('%c') }}</td>
        <td><a class="btn btn-danger btn-xs btn-block" href="{{ route('feedbacks.destroy', [$feedback->id]) }}" role="button" title="@lang('Destroy')"><span class="fa fa-remove"></span></a></td>
    </tr>
@endforeach

