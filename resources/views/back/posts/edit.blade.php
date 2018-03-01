@extends('back.layout')
@section('css')

@section('main')
    <div class="row">
        <div class="col-md-12">
            @if (session('post-updated'))
                @component('back.components.alert')
                    @slot('type')
                        success
                    @endslot
                    {!! session('post-updated') !!}
                @endcomponent
            @endif
        </div>
    </div>
     <div class="panel-body">
        <a href="{{ url('/dashboard/posts') }}" title="Back"><button class="btn btn-warning btn-xs"><i class="fa fa-arrow-left" aria-hidden="true"></i> Back</button></a>
        <br />
        <br />
     </div>
    {!! Form::open(['route' => ['dashboard/.update', $post->idid], 'method' => 'PUT']) !!}
    <div class="box box-primary">
        <div class="box-body">
           %%formFieldsHtml%%
        </div>
        <!-- /.box-body -->
        <div class="box-footer text-right">
            {{ Form::submit('Update') }}
        </div>
    </div>
    {!! Form::close() !!}
@endsection
