@if ($paginator->hasPages())
    <nav>
        <div class="flex justify-between items-center">
            <div class="flex justify-start items-center">            
                <span>Showing</span>
                    <form action="{{ route('note.index') }}" method="GET" class="flex justify-end border border-gray-300 px-1 rounded-full ml-1 mr-2">
                        <select name="perPage" class="ml-2 mr-2" onchange="this.form.submit()">
                            @foreach ([5, 10, 25, 50] as $option)
                                <option value="{{ $option }}" {{ request('perPage') == $option ? 'selected' : '' }}>{{ $option }}</option>
                            @endforeach
                        </select>
                    </form>
                <span> of {{ $paginator->total() }} entries</span>

            </div>
            <ul class="flex justify-center items-center">
                {{-- Previous Page Link --}}
                @if ($paginator->onFirstPage())
                    <li class="px-3 py-2 text-gray-400 cursor-not-allowed" aria-disabled="true">
                        <span>&laquo;</span>
                    </li>
                @else
                    <li class="px-3 py-2 text-gray-600 hover:text-gray-800">
                        <a href="{{ $paginator->previousPageUrl() }}" rel="prev">&laquo;</a>
                    </li>
                @endif

                {{-- Pagination Elements --}}
                @foreach ($elements as $element)
                    {{-- "Three Dots" Separator --}}
                    @if (is_string($element))
                        <li class="px-3 py-2 text-gray-400 cursor-not-allowed" aria-disabled="true">
                            <span>{{ $element }}</span>
                        </li>
                    @endif

                    {{-- Array Of Links --}}
                    @if (is_array($element))
                        @foreach ($element as $page => $url)
                            @if ($page == $paginator->currentPage())
                                <li class="px-3 py-2 text-gray-800 bg-gray-200 rounded" aria-current="page">
                                    <span>{{ $page }}</span>
                                </li>
                            @else
                                <li class="px-3 py-2 text-gray-600 hover:text-gray-800">
                                    <a href="{{ $url }}">{{ $page }}</a>
                                </li>
                            @endif
                        @endforeach
                    @endif
                @endforeach

                {{-- Next Page Link --}}
                @if ($paginator->hasMorePages())
                    <li class="px-3 py-2 text-gray-600 hover:text-gray-800">
                        <a href="{{ $paginator->nextPageUrl() }}" rel="next">&raquo;</a>
                    </li>
                @else
                    <li class="px-3 py-2 text-gray-400 cursor-not-allowed" aria-disabled="true">
                        <span>&raquo;</span>
                    </li>
                @endif
            </ul>
        </div>
    </nav>

@else
    <div class="flex justify-between items-center">
        <div class="flex justify-start items-center">            
            <span>Show</span>
            <form action="{{ route('note.index') }}" method="GET" class="flex justify-end">
                <select name="perPage" class="ml-2" onchange="this.form.submit()">
                    @foreach ([5, 10, 25, 50] as $option)
                        <option value="{{ $option }}" {{ request('perPage') == $option ? 'selected' : '' }}>{{ $option }}</option>
                    @endforeach
                </select>
            </form>
            <span class="ml-2">entries</span>
        </div>
        <p class="flex justify-end text-gray-400">Showing all {{ $paginator->total() }} notes on one page.</p>

    </div>

@endif