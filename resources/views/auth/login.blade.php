@extends('front.layout')

@section('main')
    @if (session('confirmation-success'))
        @component('front.components.alert')
            @slot('type')
                success
            @endslot
            {!! session('confirmation-success') !!}
        @endcomponent
    @endif
    @if (session('confirmation-danger'))
        @component('front.components.alert')
            @slot('type')
                error
            @endslot
            {!! session('confirmation-danger') !!}
        @endcomponent
    @endif
    <form role="form" method="POST" action="{{ route('login') }}">
        {{ csrf_field() }}
        @if ($errors->has('log'))
            @component('front.components.error')
                {{ $errors->first('log') }}
            @endcomponent
        @endif
        <div class="container">
            <div class="card card-login mx-auto mt-5">
                <div class="card-header">
                    @lang('Login')
                </div>
                <div class="card-body">
                    <div class="form-group">
                        <label for="log">@lang('Email address')</label>
                        <input type="email" class="form-control" id="log" name="log" value="{{ old('log') }}"
                               aria-describedby="emailHelp" placeholder="@lang('Login')">
                    </div>
                    <div class="form-group">
                        <label for="password">@lang('Password')</label>
                        <input type="password" class="form-control" id="password" placeholder="@lang('Password')"
                               name="password">
                    </div>
                    <div class="form-group">
                        <div class="form-check">
                            <label class="form-check-label">
                                <input type="checkbox" class="form-check-input" {{ old('remember') ? 'checked' : '' }}>
                                @lang('Remember me')
                            </label>
                        </div>
                    </div>
                    <div class="form-group">
                            <a class="btn btn-primary btn-block" href="{{url('/redirect')}}" class="btn btn-primary">Login with Facebook</a>
                    </div>
                    <button class="btn btn-primary btn-block" value="@lang('Login')">Login</button>
                    <br>
                    <div class="text-center">
                        <a class="d-block small"
                           href="{{ route('password.request') }}">@lang('Forgot Your Password?')</a>
                    </div>
                </div>
            </div>
        </div>
    </form>
@endsection
