@extends('layouts.app')
@section('content')
<div class="page-min-height"  style="background-color: rgb(69, 77, 102)">
    <div class="container">
        <div class="main">
            <h3>Verification Step</h3>
            <form method="POST" action="{{ route('verify_step') }}">
                @csrf
                <input type="hidden" name="userId" id="userId" value="{{$id}}">
                <input type="text" placeholder="  ID Card No./Employee ID" onfocus="this.placeholder = ''"
                onblur="this.placeholder = '  ID Card No./Employee ID'" name="idCardNo" id="idCardNo" required>              

                <input type="text" placeholder="  Designation" onfocus="this.placeholder = ''"
                onblur="this.placeholder = '  Designation'" name="designation" id="designation" required>                

                <input type="text" placeholder="  Qualification" onfocus="this.placeholder = ''"
                onblur="this.placeholder = '  Qualification'" name="qualification" id="qualification" required>
                @error('password')
                <span class="invalid-feedback" role="alert">
                    <strong>{{ $message }}</strong>
                </span>
                @enderror

                <input type="submit" value="Sign Up" class="btn btn_quiz">
            </form>
        </div>
    </div>
</div>
@endsection
