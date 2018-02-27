@extends('back.layout')

@section('css')

@endsection

@section('main')
    <div class="row">
        <!-- left column -->
        <div class="col-md-12">
            @if (session('profile-updated'))
                @component('back.components.alert')
                    @slot('type')
                        success
                @endslot
                {!! session('profile-updated') !!}
            @endcomponent
        @endif
        <!-- general form elements -->
            <div class="box box-primary">
                <!-- form start -->
                <form role="form" method="POST" action="{{ route('profiles.update', [$profile->id]) }}" enctype="multipart/form-data">
                    {{ csrf_field() }}
                    {{ method_field('PUT') }}
                    <div class="box-body">
                        <div class="row">
                            <div class="col-md-4">
                                <div class="form-group {{ $errors->has('first_name') ? 'has-error' : '' }}">
                                    <label for="name">@lang('First Name')</label>
                                    <input type="text" class="form-control" id="first_name" name="first_name"
                                           value="{{ old('first_name', $profile->first_name) }}" required>
                                    {!! $errors->first('first_name', '<small class="help-block">:message</small>') !!}
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-group {{ $errors->has('middle_name') ? 'has-error' : '' }}">
                                    <label for="username">@lang('Middle Name')</label>
                                    <input type="text" class="form-control" id="middle_name" name="middle_name"
                                           value="{{ old('middle_name', $profile->last_name) }}" required>
                                    {!! $errors->first('middle_name', '<small class="help-block">:message</small>') !!}
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-group {{ $errors->has('last_name') ? 'has-error' : '' }}">
                                    <label for="username">@lang('Last Name')</label>
                                    <input type="text" class="form-control" id="last_name" name="last_name"
                                           value="{{ old('last_name', $profile->last_name) }}" required>
                                    {!! $errors->first('last_name', '<small class="help-block">:message</small>') !!}
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-4">
                                <div class="form-group {{ $errors->has('phone') ? 'has-error' : ''}}">
                                    <label for="email">@lang('Phone')</label>
                                    <input type="text" class="form-control" id="phone" name="phone"
                                           value="{{ old('phone', $profile->phone) }}" required>
                                    {!! $errors->first('phone', '<small class="help-block">:message</small>') !!}
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label for="email">@lang('Country')</label>
                                    <select class="form-control" name="country_id">
                                        @foreach($countryList as $key => $country)
                                            <option value="{{$key}} " {{ old('phone', $profile->country_id) == $key ? 'selected' : '' }}> {{ $country }} </option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label for="email">@lang('Date of Birth')</label>
                                    <div class='input-group date' id='datetimepicker1' data-provide="datepicker" data-date-orientation="bottom" data-date-format="yyyy-mm-dd">
                                        <input type='text' class="form-control" name="dob"  value="{{old('dob', $profile->dob)}}"/>
                                        <span class="input-group-addon">
                                            <i class="fa fa-calendar"></i>
                                        </span>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-4">
                                <div class="form-group {{ $errors->has('gender') ? 'has-error' : ''}}">
                                    <label>@lang('Gender')</label><br>
                                    <input type="radio" name="gender" value="male" {{ old('gender', $profile->gender) == 'male' ? 'checked' : '' }}> @lang('Male')&nbsp;
                                    <input type="radio" name="gender" value="female" {{ old('gender', $profile->gender) == 'female' ? 'checked' : '' }}> @lang('Female')
                                    {!! $errors->first('gender', '<small class="help-block">:message</small>') !!}
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-group {{ $errors->has('image') ? 'has-error' : ''}}">
                                    <label>@lang('Image')</label><br>
                                    <input type="file" name="image" value="{{old('image', $profile->image)}}">
                                    <span>@php {{ basename(old('image', $profile->image), ".png").PHP_EOL; }} @endphp</span>
                                </div>
                            </div>
                    </div>
                    <!-- /.box-body -->
                    <div class="box-footer">
                        <button type="submit" class="btn btn-primary">@lang('Submit')</button>
                    </div>
                </form>
            </div>
            <!-- /.box -->
        </div>
        <!--/.col (right) -->
    </div>
    <!-- /.row -->
@endsection

