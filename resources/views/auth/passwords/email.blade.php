@extends('front.layout')

@section('main')

    @if (session('status'))
        @component('front.components.alert')
            @slot('type')
                success
            @endslot
            <p>{{ session('status') }}</p>
        @endcomponent
    @endif
    <div class="container">
        <div class="card card-login mx-auto mt-5">
            <div class="card-header">
                @lang('Reset Password')
            </div>
            <div class="card-body">
                <div class="text-center mt-4 mb-5">
                    <h4>@lang('Forgot your password?')</h4>
                    <p>@lang('Enter your email address and we will send you instructions on how to reset your password.')</p>
                </div>
                <form role="form" method="POST" action="{{ route('password.request') }}">
                    {{ csrf_field() }}
                    <div class="form-group">
                        <input type="email" class="form-control" id="email" aria-describedby="emailHelp" name="email"
                               value="{{ old('email') }}" placeholder="@lang('Email')">

                        @if ($errors->has('email'))
                            @component('front.components.error')
                                {{ $errors->first('email') }}
                            @endcomponent
                        @endif

                    </div>
                    <button class="btn btn-primary btn-block" type="submit" value="@lang('Send Password Reset Link')">
                        Reset Password
                    </button>
                </form>
                <br>
                <div class="text-center">
                    <a class="d-block small" href="/login">Login Page</a>
                </div>
            </div>
        </div>
    </div>
@endsection
