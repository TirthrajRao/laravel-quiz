@extends('layouts.app')
@section('content')
<div class="page-min-height"  style="background-color: rgb(69, 77, 102); padding-bottom:45px;">
    <div class="container">
        <div class="main">
            <h3>Sign Up</h3>
            <form method="POST" action="{{ route('register') }}">
                @csrf
                <input type="text" class="@error('name') is-invalid @enderror reg_input" placeholder="  Name" onfocus="this.placeholder = ''"
                onblur="this.placeholder = '  Name'" name="name" value="{{ old('name') }}" required>
                @error('name')
                <span class="invalid-feedback" role="alert">
                    <strong>{{ $message }}</strong>
                </span>
                @enderror

                <input type="email" class="@error('email') is-invalid @enderror reg_input" placeholder="  Email" onfocus="this.placeholder = ''"
                onblur="this.placeholder = '  Email'" name="email" value="{{ old('email') }}" required>
                @error('email')
                <span class="invalid-feedback" role="alert">
                    <strong>{{ $message }}</strong>
                </span>
                @enderror

                <input type="password" class="@error('password') is-invalid @enderror reg_input" placeholder="  Password" onfocus="this.placeholder = ''"
                onblur="this.placeholder = '  Password'" name="password" value="{{ old('password') }}" required>
                @error('password')
                <span class="invalid-feedback" role="alert">
                    <strong>{{ $message }}</strong>
                </span>
                @enderror

                <input type="password" name="password_confirmation" placeholder="  Confirm Password" class="reg_input" onfocus="this.placeholder = ''"
                onblur="this.placeholder = '  Confirm Password'" required>

                <select id="imA" name="imA" class="reg_input" onchange="addfield();" required="">
                    <option value="">I am a ...</option>
                    <option value="teacher">Teacher</option>
                    <option value="student">Student</option>
                </select></br>

                <div id="showField"> 
                </div>

                <input type="submit" value="Sign Up" class="btn btn_quiz register_btn">

            </form>
        </div>
    </div>
</div>
<script type="text/javascript">
    function addfield(){
        var evalue = $('#imA').val();
        if(evalue == 'student'){            
            $('#showField').html('<input type="text" class="reg_input" placeholder="  Enrollment No." name="eno" id="eno" required><input type="text" placeholder="  Batch" name="batch" class="reg_input" id="batch" required><select id="year" name="year"  class="reg_input" ><option value="1">1st year</option><option value="2">2nd year</option></select>');
        }/*else if(evalue == 'teacher'){
            $('#showField').html('<input type="text" placeholder=" ID Card No." name="idCardNo" id="idCardNo" required>');
        }*/
        else{
            $('#showField').html('');
        }  
    }
</script>
@endsection
