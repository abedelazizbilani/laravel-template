@extends('front.layout')

@section('main')
    <div class="container">
        <div class="card card-login mx-auto mt-5">
            <div class="card-header">
                <h3>@lang('Reset Password')</h3>
            </div>
            <div class="card-body">
                <form role="form" method="POST" action="{{ route('password.confirm') }}">
                    {{ csrf_field() }}
                    <div class="form-group">
                        <label for="email">@lang('Email address')</label>
                        <input id="email" placeholder="@lang('Email')" type="email" class="form-control" name="email"
                               value="{{ old('email') }}" required>
                        @if ($errors->has('email'))
                            @component('front.components.error')
                                {{ $errors->first('email') }}
                            @endcomponent
                        @endif
                    </div>
                    <div class="form-group">
                        <label for="password">@lang('Password')</label>
                        <input id="password" placeholder="@lang('Password')" type="password" class="form-control"
                               name="password" required>
                        @if ($errors->has('password'))
                            @component('front.components.error')
                                {{ $errors->first('password') }}
                            @endcomponent
                        @endif
                    </div>
                    <div class="form-group">
                        <label for="code">@lang('Code')</label>
                        <input id="code" placeholder="@lang('Enter your Code')" type="text" class="form-control"
                               name="confirmation_code" required>
                    </div>
                    <input class="btn btn-primary btn-block" type="submit" value="@lang('Reset Password')">
                </form>
            </div>
        </div>
    </div>

@endsection
