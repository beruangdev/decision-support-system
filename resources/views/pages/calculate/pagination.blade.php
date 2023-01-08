<div>
    <div class="dtc-pagination flex flex-wrap justify-between my-2" table-target="{{ $name }}">
        {{-- info --}}
        <div></div>

        {{-- pagination --}}
        <div class="wrapper-dtc-pagination">
            <button type="button" pagination-target="back">
                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-5 h-5">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M15.75 19.5L8.25 12l7.5-7.5" />
                </svg>
            </button>

            <select class="dtc-pagination">
                <option value="1" selected>1</option>
            </select>

            <button type="button" pagination-target="next">
                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-5 h-5">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M8.25 4.5l7.5 7.5-7.5 7.5" />
                </svg>
            </button>
        </div>
    </div>
</div>
