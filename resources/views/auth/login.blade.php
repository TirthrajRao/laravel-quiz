@extends('layouts.app')

@section('content')
<div class="page-min-height"  style="background-color: rgb(69, 77, 102)">
    <div class="container">
        <div class="main" style="height: 300px;">
            <h3>Login</h3>
            <form method="POST" action="{{ route('login') }}">
                @csrf

                <input type="email" class="@error('email') is-invalid @enderror" placeholder="  Email" onfocus="this.placeholder = ''"
                onblur="this.placeholder = '  Email'" name="email" value="{{ old('email') }}" required>
                @error('email')
                <span class="invalid-feedback" role="alert">
                    <strong>{{ $message }}</strong>
                </span>
                @enderror

                <input type="password" class="@error('password') is-invalid @enderror" placeholder="  Password" onfocus="this.placeholder = ''"
                onblur="this.placeholder = '  Password'" name="password" value="{{ old('password') }}" required>
                @error('password')
                <span class="invalid-feedback" role="alert">
                    <strong>{{ $message }}</strong>
                </span>
                @enderror

                <input type="submit" value="Login" class="btn btn_quiz">
            </form>
        </div>
    </div>
</div>
@endsection
