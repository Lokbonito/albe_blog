@if ($paginator->hasPages())
    <nav class="mt-12 flex justify-center" aria-label="Pagination">
        <ul class="inline-flex items-center -space-x-px">

            {{-- Nút Về trang đầu --}}
            @if ($paginator->onFirstPage())
                <li class="disabled">
                    <span
                        class="py-2 px-3 ml-0 leading-tight text-gray-400 bg-white rounded-l-lg border border-gray-300">&laquo;</span>
                </li>
            @else
                <li>
                    <a href="{{ $paginator->url(1) }}"
                        class="py-2 px-3 ml-0 leading-tight text-gray-500 bg-white rounded-l-lg border border-gray-300 hover:bg-gray-100 hover:text-gray-700">&laquo;</a>
                </li>
            @endif

            {{-- Nút Lùi 1 trang --}}
            @if ($paginator->onFirstPage())
                <li class="disabled">
                    <span class="py-2 px-3 leading-tight text-gray-400 bg-white border border-gray-300">&lsaquo;</span>
                </li>
            @else
                <li>
                    <a href="{{ $paginator->previousPageUrl() }}"
                        class="py-2 px-3 leading-tight text-gray-500 bg-white border border-gray-300 hover:bg-gray-100 hover:text-gray-700">&lsaquo;</a>
                </li>
            @endif

            {{-- Hiển thị các trang --}}
            @foreach ($elements as $element)
                {{-- Dấu "..." --}}
                @if (is_string($element))
                    <li class="disabled">
                        <span
                            class="py-2 px-3 leading-tight text-gray-500 bg-white border border-gray-300">{{ $element }}</span>
                    </li>
                @endif

                {{-- Mảng các trang --}}
                @if (is_array($element))
                    @foreach ($element as $page => $url)
                        @if ($page == $paginator->currentPage())
                            <li class="active">
                                <span aria-current="page"
                                    class="py-2 px-3 text-white bg-green-500 border border-green-500">{{ $page }}</span>
                            </li>
                        @else
                            <li>
                                <a href="{{ $url }}"
                                    class="py-2 px-3 leading-tight text-gray-500 bg-white border border-gray-300 hover:bg-gray-100 hover:text-gray-700">{{ $page }}</a>
                            </li>
                        @endif
                    @endforeach
                @endif
            @endforeach

            {{-- Nút Tiến 1 trang --}}
            @if ($paginator->hasMorePages())
                <li>
                    <a href="{{ $paginator->nextPageUrl() }}"
                        class="py-2 px-3 leading-tight text-gray-500 bg-white border border-gray-300 hover:bg-gray-100 hover:text-gray-700">&rsaquo;</a>
                </li>
            @else
                <li class="disabled">
                    <span class="py-2 px-3 leading-tight text-gray-400 bg-white border border-gray-300">&rsaquo;</span>
                </li>
            @endif

            {{-- Nút Đến trang cuối --}}
            @if ($paginator->hasMorePages())
                <li>
                    <a href="{{ $paginator->url($paginator->lastPage()) }}"
                        class="py-2 px-3 leading-tight text-gray-500 bg-white rounded-r-lg border border-gray-300 hover:bg-gray-100 hover:text-gray-700">&raquo;</a>
                </li>
            @else
                <li class="disabled">
                    <span
                        class="py-2 px-3 leading-tight text-gray-400 bg-white rounded-r-lg border border-gray-300">&raquo;</span>
                </li>
            @endif

        </ul>
    </nav>
@endif
