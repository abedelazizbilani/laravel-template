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
                    {{ Form::textField('name', '', ['required']) }}
                </div>
                <div class="col-md-4">
                    {{Form::label('Email')}}
                    {{ Form::email('email', '', ['required' ,'class'=> 'form-control']) }}
                </div>
                <div class="col-md-4">
                    {{ Form::textField('phone' , '', ['required']) }}
                </div>
            </div>
            <div class="separator-15"></div>
            <div class="row">
                <div class="col-md-4">
                    {{ Form::passwordField('password', ['required']) }}
                </div>
                <div class="col-md-4">
                    {{ Form::passwordField('password_confirmation', ['required'], 'Confirm password') }}
                </div>
                <div class="col-md-4">
                    {{ Form::selectField('roles[]', $roles, null, ['id'=>'roles'], 'roles') }}
                </div>
            </div>
            <div class="separator-15"></div>
        </div>
        <div class="box-footer text-right">
            {{ Form::submitField('Submit') }}
        </div>
    </div>
    {!! Form::close() !!}
@endsection

