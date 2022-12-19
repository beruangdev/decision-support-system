@php
    $rand = Str::random(5);
@endphp

<div class="relative popover-wrapper">
    <button data-popover-target="popover-left-{{ $rand }}" data-popover-placement="left" type="button" class="text-gray-700 focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium rounded-full p-1 text-sm text-center">
        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor" class="w-6 h-6">
            <path fill-rule="evenodd"
                d="M5.25 2.25a3 3 0 00-3 3v4.318a3 3 0 00.879 2.121l9.58 9.581c.92.92 2.39 1.186 3.548.428a18.849 18.849 0 005.441-5.44c.758-1.16.492-2.629-.428-3.548l-9.58-9.581a3 3 0 00-2.122-.879H5.25zM6.375 7.5a1.125 1.125 0 100-2.25 1.125 1.125 0 000 2.25z"
                clip-rule="evenodd" />
        </svg>
    </button>
    <div data-popover id="popover-left-{{ $rand }}" role="tooltip"
        class="absolute z-10 invisible inline-block w-64 text-sm font-light text-gray-500 transition-opacity duration-300 bg-white border border-gray-200 rounded-lg shadow-sm opacity-0 dark:text-gray-400 dark:border-gray-600 dark:bg-gray-800 left-0 bottom-0 translate-x-[-100%] translate-y-[28%]">
        <div class="px-3 py-2 bg-gray-200 border-b border-gray-200 rounded-t-lg dark:border-gray-600 dark:bg-gray-700">
            <h3 class="font-semibold text-gray-900 dark:text-white">Taxonomies</h3>
        </div>
        <div class="px-3 py-2">
            @forelse ($alternative->alternative_taxonomies as $alternative_taxonomy)
                <ul>
                    <li class="grid grid-cols-2 gap-2 border-b py-1">
                        <div>{{ $alternative_taxonomy->key }}</div>
                        <div>{{ $alternative_taxonomy->value }}</div>
                    </li>
                </ul>
            @empty
            <p>Taxanomies Empty</p>
            @endforelse
        </div>
        <div data-popper-arrow class="right-0 top-[50%]"></div>
    </div>

</div>
