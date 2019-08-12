@if ($paginator->hasPages())
    <ul class="pagination" role="navigation">
        {{-- Next Page Link --}}
        @if ($paginator->hasMorePages())
            <li><button type="submit" class="btn btn_quiz"><a rel="next" class="next" >Next</a></button></li>
        @else
            <li class="disabled" aria-disabled="true"><button type="submit" class="btn btn_quiz">Submit</button></li>
        @endif
    </ul>
@endif
