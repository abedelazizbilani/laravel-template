@extends('back.layout')
@section('main')
    <div class="row">
        <!-- left column -->
        <div class="col-md-12">
            @if (session('%%crudNameSingular%%-updated'))
                @component('back.components.alert')
                    @slot('type')
                        success
                    @endslot
                    {!! session('%%crudNameSingular%%-updated') !!}
                @endcomponent
            @endif
        </div>
    </div>
    {!! Form::open(['route' => 'posts.store', 'method' => 'POST']) !!}
    <div class="box box-primary">
        <div class="box-body">
            <div class="row">
                <div class="col-md-4">
                    {{ Form::textField('title' , '', ['required']) }}
                </div>
            </div>
            <div class="separator-15"></div>
            <div class="row">
                <div class="col-md-4">
                    {{ Form::textareaField('body') }}
                </div>
            </div>
            <div class="separator-15"></div>
        </div>
    </div>
    <div class="box-footer text-right">
        {{ Form::submitField('Submit') }}
    </div>
    {!! Form::close() !!}
@endsection