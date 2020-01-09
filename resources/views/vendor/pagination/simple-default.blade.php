@if ($paginator->hasPages())
    <ul class="pagination" role="navigation">
        {{-- Next Page Link --}}
        @if ($paginator->hasMorePages())
            <li><button type="submit" class="btn btn_quiz"><a rel="next" class="next" >Next</a></button></li>
        @else
            <li class="disabled" aria-disabled="true"><a href="JavaScript:Void(0)" onclick="geek();" data-toggle="modal" data-target="#AddQueModal" class="editquiz" ><button type="button" id="confirmQuiz" class="btn btn_quiz confirmQuiz">Submit</button></a></li>
        @endif
    </ul>

    <div class="modal" id="AddQueModal" style="top:156px;">
        <div class="modal-dialog">      
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title headergreen">Confirm Submit</h4>
                    <button type="button" class="close" data-dismiss="modal" style="color: inherit!important">&times;</button>
                </div>
                <div class="modal-body">
                    <div class="row" style="margin: 10px 0px">
                        <div class="col-md-9">
                            <div class="filter-content" style="margin: 30px 0px">                   
                                <div class="form-group">
                                    <div class="row">
                                        <div class="col-md-12">
                                            <p>Are you sure you want to submit the quiz?</p>
                                        </div>                                  
                                        
                                    </div>
                                </div>  
                                <div class="form-group">
                                    <div class="row">
                                        <div class="col-md-6">
                                            <label for="num-questions" class="control-label">  </label>
                                        </div>
                                        <div class="col-md-6">
                                            
                                        </div>
                                    </div>
                                </div>            
                            
                            </div>                          
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn_cancel" data-dismiss="modal" style="width: 88px; background-color:rgb(150, 38, 166); color: white;">Close</button>
                    <button type="submit" class="btn btn_quiz">Submit</button>
                </div>
            </div>
        </div>
    </div>
@endif
