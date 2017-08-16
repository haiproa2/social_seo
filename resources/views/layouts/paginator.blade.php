
<nav class="text-center">
	<ul class="pagination">
	    <!-- Previous Page Link -->
	    @if ($paginator->onFirstPage())
	        <li class="disabled"><span>&laquo;</span></li>
	        <li class="disabled"><span>&lsaquo;</span></li>
	    @else
	        <li><a href="{{ url()->current() }}" title="Trang đầu">&laquo;</a></li>
	        <li><a href="{{ $paginator->previousPageUrl() }}" title="Trang trước">&lsaquo;</a></li>
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
	        <li><a href="{{ $paginator->nextPageUrl() }}" title="Trang sau">&rsaquo;</a></li>
	        <li><a href="{{ $paginator->url($page) }}" title="Trang cuối">&raquo;</a></li>
	    @else
	        <li class="disabled"><span>&rsaquo;</span></li>
	        <li class="disabled"><span>&raquo;</span></li>
	    @endif
	</ul>
</nav>