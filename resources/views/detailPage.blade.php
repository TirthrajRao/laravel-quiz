@extends('layouts.app')
@section('content')
<div class="page-min-height"  style="background-color: rgb(69, 77, 102)">
    <section class="all_quiz_list" style="padding: 40px 0px 16px">
    <div class="container">
         <div class="col-md-12">
                @if (count($student) > 0)               
                <table class="rwd-table">
                    <h5 style="color: #fff; margin-bottom: 35px;text-align: center;font-size: 24px; font-weight: 700">Shared With</h5>
                    <tbody>
                        <tr>
                            <th>Name</th>
                            <th>Email</th>
                            <th>Suggestions</th>
                        </tr>
                        @foreach($student as $students)
                        <tr>
                            <td data-th="Name">
                                <a href="{{ route('suggestion',[$students->id,$id]) }}" style="color: #fff; "><?php echo $students->name; ?></a>
                            </td>
                            <td data-th="Email" title="{{ $students->email }}">
                                 <a href="{{ route('suggestion',[$students->id,$id]) }}" style="color: #fff; "><?php echo $students->email; ?></a>
                            </td>                            
                            <td data-th="Suggestions">
                                <?php
                                  $suggestion = \DB::table('suggestion')
                            ->select('name','title','quizid','suggestion.suggestion')
                            ->join('quizzes', 'quizzes.quizid', '=', 'suggestion.quiz_id')
                            ->join('users','users.id','=','suggestion.user_id')
                            ->where('quizid',$id)
                            ->where('users.id','=', $students->id)
                            ->get();
                              if(count($suggestion) > 0){ ?>
                                <a href="{{ route('suggestion',[$students->id,$id]) }}" style="color: #fff; ">Yes</a> 
                             <?php }else{
                                echo "No";
                              }
                                ?>
                            </td>   
                        </tr>
    
                        @endforeach
                    </tbody>
                </table>
                @else
                <h5 style="color: #fff; margin-bottom: 35px;text-align: center;font-size: 24px; font-weight: 700">This Quiz is not yet shared !</h5>
                @endif
                <div style="margin-top: 35px; margin-bottom: 35px;  width: 10%; margin-left:auto; margin-right: auto;"> 
                     {{ $student->links() }}
                </div>
                
    
            </div>
       
    </div>
    </section>
</div>
@endsection