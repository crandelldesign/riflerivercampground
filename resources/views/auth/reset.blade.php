<!DOCTYPE html>
<html>
    <head>
        @include('layouts.admin-head')
    </head>
    <body class="hold-transition login-page">
        <div class="login-box">
            <div class="login-logo">
                <a href="{{url('/admin')}}">Rifle River Campground Admin</a>
            </div>
            <div class="login-box-body">

                    <form method="POST" action="{{url('/password/reset')}}">
                        {!! csrf_field() !!}
                        <input type="hidden" name="token" value="{{ $token }}">

                        @if (count($errors) > 0)
                            <ul>
                                @foreach ($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        @endif

                        <div class="form-group{{ $errors->has('email') ? ' has-error' : '' }}">
                            <input type="email" class="form-control" name="email" value="{{ old('email') }}" placeholder="Email">
                        </div>

                        <div class="form-group{{ $errors->has('password') ? ' has-error' : '' }}">
                            <input type="password" name="password" class="form-control" placeholder="Password">
                        </div>

                        <div class="form-group{{ $errors->has('password_confirmation') ? ' has-error' : '' }}">
                            <input type="password" name="password_confirmation" class="form-control" placeholder="Confirm Password">
                        </div>

                        <div class="row">
                            <div class="col-sm-6 col-sm-offset-6">
                                <button type="submit" class="btn btn-primary btn-block btn-flat">
                                    Reset Password
                                </button>
                            </div>
                        </div>
                    </form>
            </div>
        </div>
        <script type="text/javascript" src="{{ elixir('js/admin.js') }}"></script>
    </body>
</html>