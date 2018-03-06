@extends('back.layout')
@section('css')
@endsection

@section('main')
     <div class="panel-body">
        <a href="{{ url('/dashboard/posts') }}" title="Back"><button class="btn btn-warning btn-xs"><i class="fa fa-arrow-left" aria-hidden="true"></i> Back</button></a>
        <br />
        <br />
     </div>
    {!! Form::open(['route' => ['posts.update', $post->id], 'method' => 'PUT']) !!}
    <div class="box box-primary">
        <div class="box-body">
           <div class="form-group {{ $errors->has('title') ? 'has-error' : ''}}">
    <label for="title" class="col-md-4 control-label">{{ 'Title' }}</label>
    <div class="col-md-4">
        <input class="form-control" name="title" type="text" id="title" value="{{ $post->title or ''}}" >
        {!! $errors->first('title', '<p class="help-block">:message</p>') !!}
    </div>
</div><div class="form-group {{ $errors->has('body') ? 'has-error' : ''}}">
    <label for="body" class="col-md-4 control-label">{{ 'Body' }}</label>
    <div class="col-md-4">
        <textarea class="form-control" rows="5" name="body" type="textarea" id="body" >{{ $post->body or ''}}</textarea>
        {!! $errors->first('body', '<p class="help-block">:message</p>') !!}
    </div>
</div>
        </div>
        <!-- /.box-body -->
        <div class="box-footer text-right">
            {{ Form::submit('Update') }}
        </div>
    </div>
    {!! Form::close() !!}
@endsection
