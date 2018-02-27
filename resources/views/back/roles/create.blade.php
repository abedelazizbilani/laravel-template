@extends('back.layout')

@section('css')

@endsection

@section('main')

    <div class="row">
        <!-- left column -->
        <div class="col-md-12">
            @if (session('role-created'))
                @component('back.components.alert')
                    @slot('type')
                        success
                    @endslot
                    {!! session('role-created') !!}
                @endcomponent
            @endif
        </div>
    </div>
    <div class="nav-tabs-custom">
        <ul class="nav nav-tabs">
            <li class="nav-item custom-nav-item">
                <a class="nav-link active" href="#tab_1" data-toggle="tab">@lang('Details')</a>
            </li>
            <li class="nav-item custom-nav-item">
                <a class="nav-link" href="#tab_2" data-toggle="tab">@lang('Permissions')</a>
            </li>
        </ul>

        {!! Form::open(['route' => 'roles.store', 'method' => 'POST']) !!}
            <div class="tab-content">
                <div class="tab-pane fade active show" id="tab_1" aria-expanded="true">
                    <div class="box-body">
                        <div class="row">
                            <div class="col-md-4">
                                {{ Form::text('name','',['required', 'placeholder'=>'Name']) }}
                            </div>
                            <div class="col-md-4">
                                {{ Form::text('display_name','',['required', 'placeholder'=>'Display Name']) }}
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-4">
                                {{ Form::text('description','',['placeholder'=>'Description']) }}
                            </div>
                        </div>
                    </div>
                </div>
                <div class="tab-pane fade" id="tab_2">
                    <div class="box-body">
                        @foreach($permissions as $permission)
                            <div class="row">
                                <div class="col-md-12">
                                    <div class="visible-sm-block visible-md-block visible-lg-block">
                                        <label class="control-label display-block">{{$permission->display_name}}</label>
                                    </div>
                                    <div class="btn-group" data-toggle="buttons">
                                        <label class="btn active">
                                            <input type="radio" name="permissions[{{$permission->id}}]"
                                                   value="1"/>
                                            <i class="fa fa-circle-o fa-2x"></i>
                                            <i class="fa fa-dot-circle-o fa-2x"></i>
                                            <span>  @lang('Allow')</span>
                                        </label>
                                        <label class="btn">
                                            <input type="radio" name="permissions[{{$permission->id}}]"
                                                   value="0"/>
                                            <i class="fa fa-circle-o fa-2x"></i>
                                            <i class="fa fa-dot-circle-o fa-2x"></i>
                                            <span> @lang('Deny')</span>
                                        </label>
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>
            </div>
            <div class="box-footer text-right">
                {{ Form::submit('Submit') }}
            </div>
        {!! Form::close() !!}
    </div>
@endsection