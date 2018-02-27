@extends('back.layout')
@section('main')

    <div class="row">
        <!-- left column -->
        <div class="col-md-12">
            @if (session('user-updated'))
                @component('back.components.alert')
                    @slot('type')
                        success
                    @endslot
                    {!! session('user-updated') !!}
                @endcomponent
            @endif
        </div>
    </div>
    {!! Form::open(['route' => 'users.store', 'method' => 'POST']) !!}
    <div class="box box-primary">
        <div class="box-body">
            <div class="row">
                <div class="col-md-4">
                    {{ Form::text('name','',['required', 'placeholder'=>'Name']) }}
                </div>
                <div class="col-md-4">
                    {{ Form::text('username','',['required', 'placeholder'=>'Username']) }}
                </div>
            </div>
            <div class="row">
                <div class="col-md-4">
                    {{ Form::text('email','',['required', 'placeholder'=>'Email']) }}
                </div>
                <div class="col-md-4">
                    {{ Form::password('password',['required', 'placeholder'=>'Password']) }}
                </div>
            </div>
            <div class="row">
                <div class="col-md-4">
                    {{ Form::select('roles[]',$roles, null, ['multiple']) }}
                </div>
            </div>
            <div class="checkbox">
                {{ Form::checkbox('active',1) }}
            </div>
        </div>
        <div class="box-footer text-right">
            {{ Form::submit('Submit') }}
        </div>
    </div>
    {!! Form::close() !!}
@endsection

