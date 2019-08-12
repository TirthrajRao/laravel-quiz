@extends('layouts.app')
@section('content')
<div class="page-min-height"  style="background-color: rgb(69, 77, 102)">
    <div class="container">
        <div class="main">
            <h3>Sign Up</h3>
            <form method="POST" action="{{ route('register') }}">
                @csrf
                <input type="text" class="@error('name') is-invalid @enderror" placeholder="  Name" onfocus="this.placeholder = ''"
                onblur="this.placeholder = '  Name'" name="name" value="{{ old('name') }}" required>
                @error('name')
                <span class="invalid-feedback" role="alert">
                    <strong>{{ $message }}</strong>
                </span>
                @enderror

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

                <input type="password" name="password_confirmation" placeholder="  Confirm Password" onfocus="this.placeholder = ''"
                onblur="this.placeholder = '  Confirm Password'" required>

                <input type="submit" value="Sign Up" class="btn btn_quiz">
            </form>
        </div>
    </div>
</div>
@endsection
