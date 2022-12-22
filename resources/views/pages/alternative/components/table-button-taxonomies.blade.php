@php
    $rand = Str::random(5);
@endphp


<div class="overflow-x-auto relative sm:rounded-lg">
    <table class="w-full text-sm text-left text-gray-500 dark:text-gray-400">
        <thead class="text-xs text-gray-700 uppercase bg-gray-50 dark:bg-gray-700 dark:text-gray-400">
            <tr>
                <th scope="col" class=" w-1/2 !p-0 !border-0">
                </th>
                <th scope="col" class=" w-1/2 !p-0 !border-0">
                </th>
            </tr>
        </thead>
        <tbody>
            @forelse ($alternative->alternative_taxonomies as $alternative_taxonomy)
                <tr class="bg-white {{ $loop->last ? '' : 'border-b' }} dark:bg-gray-800 dark:border-gray-700">
                    <th scope="row" class="py-4 px-6 font-medium text-gray-900 whitespace-nowrap dark:text-white border-r">
                       {{ $alternative_taxonomy["key"] }}
                    </th>
                    <td class="py-4 px-6">
                        {{ $alternative_taxonomy["value"] }}
                    </td>
                </tr>
            @empty
            <tr class="bg-white dark:bg-gray-800 dark:border-gray-700">
                <th scope="row" class="py-4 px-6 font-medium text-gray-900 whitespace-nowrap dark:text-white">
                    Details is empty
                </th>
            </tr>
            @endforelse


        </tbody>
    </table>
</div>
