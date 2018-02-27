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
                    {{ Form::text('name',$user->name,['required']) }}
                </div>
                <div class="col-md-4">
                    {{ Form::text('username',$user->username,['required']) }}
                </div>
                <div class="col-md-4">
                    {{ Form::text('email',$user->email,['required']) }}
                </div>
            </div>
            <div class="row">
                <div class="col-md-4">
                    {{ Form::select('roles[]',$roles, $user->roles, ['multiple']) }}
                </div>
            </div>
            <div class="checkbox">
                {{ Form::checkbox('active',1 , $user->active) }}
            </div>
            <a href="{{ route('password.request') }}">@lang('Reset password')</a>
        </div>
        <!-- /.box-body -->
        <div class="box-footer text-right">
            {{ Form::submit('Submit') }}
        </div>
    </div>
    {!! Form::close() !!}
@endsection

