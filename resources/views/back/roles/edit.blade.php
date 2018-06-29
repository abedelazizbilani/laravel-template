@extends('back.layout')

@section('css')

@endsection
@section('main')

    <div class="row">
        <!-- left column -->
        <div class="col-md-12">
            @if (session('role-updated'))
                @component('back.components.alert')
                    @slot('type')
                        success
                    @endslot
                    {!! session('role-updated') !!}
                @endcomponent
            @endif
        </div>
    </div>
    <div class="nav-tabs-custom">
        <ul class="nav nav-tabs">
            <li class="nav-item custom-nav-item">
                <a class="nav-link active" href="#tab1" data-toggle="tab">Details</a>
            </li>
            <li class="nav-item custom-nav-item">
                <a class="nav-link" href="#tab2" data-toggle="tab">@lang('Permissions')</a>
            </li>
        </ul>
        <!-- form start -->
        <form role="form" method="POST" action="{{ route('roles.update', [$role->id]) }}">
            {{ csrf_field() }}
            {{ method_field('PUT') }}
            <div class="tab-content">
                <div class="tab-pane fade active show" id="tab1" aria-expanded="true">
                    <div class="box-body">
                        <div class="row">
                            <div class="col-md-4">
                                {{ Form::textField('name',$role->name,['required']) }}
                            </div>
                            <div class="col-md-4">
                                {{ Form::textField('display_name',$role->display_name,['required']) }}
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-4">
                                {{ Form::textField('description',$role->description,[]) }}
                            </div>
                        </div>
                    </div>
                </div>
                <div class="tab-pane fade" id="tab2">
                    <div class="box-body">
                        @foreach($permissions as $permission)
                            @php
                                $permissionRolesIds = [];
                                $permissionRoles = $permission->roles()->get();
                                foreach ($permissionRoles as $permissionRole){
                                $permissionRolesIds[] = $permissionRole->id;
                                }
                            @endphp
                            <div class="row">
                                <div class="col-md-12">
                                    <div class="visible-sm-block visible-md-block visible-lg-block">
                                        <label class="control-label display-block">{{$permission->display_name}}</label>
                                    </div>
                                    <div class="btn-group" data-toggle="buttons">
                                        <label class="btn active">
                                            <input type="radio" name="permissions[{{$permission->id}}]"
                                                   @if(in_array($role->id, $permissionRolesIds)) {{'checked'}} @endif value="1">
                                            <i class="fa fa-circle-o fa-2x"></i>
                                            <i class="fa fa-dot-circle-o fa-2x"></i>
                                            <span>  Allow</span>
                                        </label>
                                        <label class="btn">
                                            <input type="radio" name="permissions[{{$permission->id}}]"
                                                   @if(!in_array($role->id, $permissionRolesIds)) {{'checked'}} @endif value="0">
                                            <i class="fa fa-circle-o fa-2x"></i>
                                            <i class="fa fa-dot-circle-o fa-2x"></i>
                                            <span> Deny</span>
                                        </label>
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>
            </div>
            <div class="box-footer text-right">
                <button type="submit" class="btn btn-primary">@lang('Submit')</button>
                {{Form::submitField('Submit')}}
            </div>
        </form>
    </div>
@endsection