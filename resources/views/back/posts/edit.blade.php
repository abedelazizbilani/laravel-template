@extends('back.layout')
@section('css')
@endsection

@section('main')
    <div class="panel-body">
        <a href="{{ url('/dashboard/posts') }}" title="Back">
            <button class="btn btn-warning btn-xs"><i class="fa fa-arrow-left" aria-hidden="true"></i> Back</button>
        </a>
        <br/>
        <br/>
    </div>
    {!! Form::open(['route' => ['posts.update', $post->id], 'method' => 'PUT']) !!}
    <div class="box box-primary">
        <div class="box-body">
            <div class="row">
                <div class="col-md-4">
                    {{ Form::textField('title' , $post->title , ['required']) }}
                </div>
            </div>
            <div class="row">
                <div class="col-md-4">
                    {{ Form::textareaField('body',$post->body) }}
                </div>
            </div>
            <div class="separator-15"></div>
        </div>
        <!-- /.box-body -->
    </div>
    <div class="box-footer text-right">
        {{ Form::submitField('Update') }}
    </div>
    {!! Form::close() !!}
@endsection
