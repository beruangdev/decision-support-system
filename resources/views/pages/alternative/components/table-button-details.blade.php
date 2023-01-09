@php
    $rand = Str::random(5);
@endphp


<div class="overflow-x-auto relative sm:rounded-lg">
    <table class="w-full text-sm text-left text-gray-500 dark:text-gray-400 dark:bg-gray-840">
        <thead class="text-xs text-gray-700 uppercase bg-gray-50 dark:bg-gray-600 dark:text-gray-400">
            <tr>
                <th scope="col" class=" w-1/2 !p-0 !border-0">
                </th>
                <th scope="col" class=" w-1/2 !p-0 !border-0">
                </th>
            </tr>
        </thead>
        <tbody>
            @forelse (json_decode($alternative->attributes) as $key => $value)
                <tr class="{{ $loop->last ? '' : 'border-b' }} dark:border-gray-700">
                    <th scope="row" class="py-4 px-6 font-medium text-gray-900 whitespace-nowrap dark:text-white border-r">
                        {{ $key }}
                    </th>
                    <td class="py-4 px-6">
                        {{ $value }}
                    </td>
                </tr>
            @empty
                <tr class="dark:border-gray-700">
                    <th scope="row" colspan="2" class="py-4 px-6 font-medium text-gray-900 whitespace-nowrap dark:text-white">
                        Attributes is empty
                    </th>
                </tr>
            @endforelse


        </tbody>
    </table>
</div>
