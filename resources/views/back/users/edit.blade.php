@extends('back.layout')

@section('css')

@endsection

@section('main')

    <div class="row">
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
    {!! Form::open(['route' => ['users.update',$user->id], 'method' => 'PUT']) !!}
    <div class="box box-primary">
        <div class="box-body">
            <div class="row">
                <div class="col-md-4">
                    {{ Form::textField('name',$user->name,['required']) }}
                </div>
                <div class="col-md-4">
                    {{ Form::textField('username',$user->username,['required']) }}
                </div>
                <div class="col-md-4">
                    {{ Form::textField('email',$user->email,['required']) }}
                </div>
            </div>
            <div class="row">
                <div class="col-md-4">
                    {{ Form::selectField('roles',$roles, $user->roles, ['multiple']) }}
                </div>
            </div>
            <div class="col-md-4">
                {{ Form::booleanField('active',1 , $user->active) }}
            </div>
            <a href="{{ route('password.request') }}">@lang('Reset password')</a>
        </div>
        <!-- /.box-body -->
        <div class="box-footer text-right">
            {{ Form::submitField('Submit') }}
        </div>
    </div>
    {!! Form::close() !!}
@endsection

