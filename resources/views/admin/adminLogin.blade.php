@extends('layouts.adminMaster')

@section('content')
<div class="page-min-height"  style="background-color: rgb(69, 77, 102)">
    <div class="container">
        <div class="main" style="height: 300px;">
            <h3 style="color: #009975;">Admin Login</h3>
             @error('email')
                <span class="invalid-feedback" role="alert">
                    <strong>{{ $message }}</strong>
                </span>
              @enderror
              @if ($errors->count() > 0)
                <div class="alert alert-danger hide-class">
                    <ul class="list-unstyled">
                    @foreach($errors->all() as $error)
                    <li>{{ $error }}<button onclick="crossIcon();" type="button" class="close" aria-label="Close"><span aria-hidden="true">&times;</span></button></li>
                    @endforeach
                    </ul>
                </div>
              @endif
            <form method="POST" action="{{ route('adminLogin') }}">
                @csrf

                <input type="email" class="@error('email') is-invalid @enderror" placeholder="  Email" onfocus="this.placeholder = ''"
                onblur="this.placeholder = '  Email'" name="email" value="{{ old('email') }}" required>               

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
<script type="text/javascript">
    function crossIcon() {
    $('.alert-danger').remove();
      }
</script>
@endsection
