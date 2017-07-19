
<div class="pagination pagination-mini pagination-right">
	<ul>
	    <!-- Previous Page Link -->
	    @if ($paginator->onFirstPage())
	        <li class="disabled"><span>&laquo;</span></li>
	        <li class="disabled"><span>&lsaquo;</span></li>
	    @else
	        <li><a href="{{ url()->current() }}" title="First">&laquo;</a></li>
	        <li><a href="{{ $paginator->previousPageUrl() }}" title="prev">&lsaquo;</a></li>
	    @endif

	    <!-- Pagination Elements -->
	    @foreach ($elements as $element)
	        <!-- "Three Dots" Separator -->
	        @if (is_string($element))
	            <li class="disabled"><span>{{ $element }}</span></li>
	        @endif

	        <!-- Array Of Links -->
	        @if (is_array($element))
	            @foreach ($element as $page => $url)
	                @if ($page == $paginator->currentPage())
	                    <li class="active"><span>{{ $page }}</span></li>
	                @else
	                    <li><a href="{{ $url }}">{{ $page }}</a></li>
	                @endif
	            @endforeach
	        @endif
	    @endforeach

	    <!-- Next Page Link -->
	    @if ($paginator->hasMorePages())
	        <li><a href="{{ $paginator->nextPageUrl() }}" title="next">&rsaquo;</a></li>
	        <li><a href="{{ $paginator->url($page) }}" title="Last">&raquo;</a></li>
	    @else
	        <li class="disabled"><span>&rsaquo;</span></li>
	        <li class="disabled"><span>&raquo;</span></li>
	    @endif
	</ul>
</div>