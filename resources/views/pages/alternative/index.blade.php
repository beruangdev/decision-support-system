<x-app-layout>
    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">

                    <table class="setup-datatable stripe hover display" style="width:100%; padding-top: 1em;  padding-bottom: 1em;">
                        <thead>
                            <tr>
                                <th></th>
                                <th class="min-w-[10rem] md:min-w-[15rem]">Name</th>
                                <th>Description</th>
                                <th class="min-w-[15rem]">Attributes</th>
                                <th></th>
                                <th></th>
                            </tr>
                        </thead>
                        <tbody></tbody>
                    </table>

                </div>
            </div>
        </div>
    </div>
</x-app-layout>

{{-- Modal EDIT Alternative --}}
<x-modal name="modal-edit-alternative" focusable>
    <form method="post" action="{{ route('alternative.index', ['project' => Route::input('project')]) }}" class="p-6 form-edit-alternative" x-data="editAltenative($el)" x-init="init" @submit.prevent="submitEditAltenative">
        @csrf

        <h2 class="text-lg font-medium text-gray-900 flex flex-wrap mb-6">
            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-6 h-6 mr-2">
                <path stroke-linecap="round" stroke-linejoin="round"
                    d="M19 7.5v3m0 0v3m0-3h3m-3 0h-3m-2.25-4.125a3.375 3.375 0 11-6.75 0 3.375 3.375 0 016.75 0zM4 19.235v-.11a6.375 6.375 0 0112.75 0v.109A12.318 12.318 0 0110.374 21c-2.331 0-4.512-.645-6.374-1.766z" />
            </svg>
            {{ __('Edit Alternative') }}
        </h2>

        <div class="mb-2">
            <template x-if="body.name.error">
                <label for="alternative-edit-name">
                    <p class="-mb-[0.8rem] px-2 py-1 bg-white relative ml-2 w-fit text-sm text-red-500 leading-3" x-text="body.name.message"></p>
                </label>
            </template>
            <input type="text" id="alternative-edit-name" name="name" placeholder="Name" :value="body.name.value" x-model="body.name.value" class="border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 shadow-sm rounded-md mt-1 block w-full"
                data-required>
        </div>
        <div class="mb-2">
            <template x-if="body.uuid.error">
                <label for="alternative-edit-uuid">
                    <p class="-mb-[0.8rem] px-2 py-1 bg-white relative ml-2 w-fit text-sm text-red-500 leading-3" x-text="body.uuid.message"></p>
                </label>
            </template>
            <input type="text" id="alternative-edit-uuid" name="uuid" placeholder="Unix ID" :value="body.uuid.value" x-model="body.uuid.value" class="border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 shadow-sm rounded-md mt-1 block w-full">
        </div>
        <div class="mb-4">
            <template x-if="body.description.error">
                <label for="alternative-edit-description">
                    <p class="-mb-[0.8rem] px-2 py-1 bg-white relative ml-2 w-fit  text-sm text-red-500 leading-3" x-text="body.description.message"></p>
                </label>
            </template>
            <textarea id="alternative-edit-description" name="description" placeholder="Description" class="mt-1 block w-full rounded-md" x-text="body.description.value" :value="body.description.value" x-model="body.description.value" id="" cols="30" rows="4"></textarea>
        </div>


        <div class="mb-4">
            <p class="mb-1">Add Alternative Attributes (if number just fill numerik value)</p>
            <div class="grid grid-cols-12 gap-2">
                <x-text-input id="alternative-edit-key" name="key" type="text" placeholder="Key" class="col-span-5" />
                <x-text-input id="alternative-edit-value" name="value" type="text" placeholder="Value" class="col-span-5 md:col-span-6" />
                <x-secondary-button class="px-3 py-1 col-span-2 md:col-span-1 flex flex-wrap justify-center items-center bg-gray-600 hover:!bg-gray-700" type="button" @click.prevent="addAttribute">
                    <svg class="w-5 h-5 text-white" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2.5" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M6 12L3.269 3.126A59.768 59.768 0 0121.485 12 59.77 59.77 0 013.27 20.876L5.999 12zm0 0h7.5" />
                    </svg>
                </x-secondary-button>
            </div>
        </div>

        <div class="mb-6 overflow-auto">
            <p class="mb-1">Alternative Attributes</p>
            <table class="table-fixed w-full border-separate">
                <thead>
                    <tr>
                        <th class="text-sm text-slate-700 dark:text-gray-300 text-left pl-3 py-2 border-2 border-slate-400 w-5/12">KEY</th>
                        <th class="text-sm text-slate-700 dark:text-gray-300 text-left pl-3 py-2 border-2 border-slate-400 w-5/12 md:w-6/12">VALUE</th>
                        <th class="text-sm text-slate-700 dark:text-gray-300 text-left pl-3 py-2 w-2/12 md:w-1/12"></th>
                    </tr>
                </thead>
                <tbody>
                    <template x-for="(attribute, index) in attributes" :key="index">
                        <tr>
                            <td class="p-0">
                                <input type="text" :value="attribute.key" @keydown="updateAttribute(index, 'key', $el.value)" class="border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 shadow-sm w-[-webkit-fill-available]">
                            </td>
                            <td class="p-0">
                                <input type="text" :value="attribute.value" @keydown="updateAttribute(index, 'value', $el.value)" class="border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 shadow-sm w-[-webkit-fill-available]">
                            </td>
                            {{-- <td x-text="attribute.key"></td> --}}
                            {{-- <td x-text="attribute.value"></td> --}}
                            <td class="p-0">
                                <div class="flex flex-wrap justify-end items-center">
                                    <x-danger-button @click.prevent="deleteAttribute(index)" class="px-2 py-2">
                                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-5 h-5">
                                            <path stroke-linecap="round" stroke-linejoin="round"
                                                d="M12 9.75L14.25 12m0 0l2.25 2.25M14.25 12l2.25-2.25M14.25 12L12 14.25m-2.58 4.92l-6.375-6.375a1.125 1.125 0 010-1.59L9.42 4.83c.211-.211.498-.33.796-.33H19.5a2.25 2.25 0 012.25 2.25v10.5a2.25 2.25 0 01-2.25 2.25h-9.284c-.298 0-.585-.119-.796-.33z" />
                                        </svg>
                                    </x-danger-button>
                                </div>
                            </td>
                        </tr>
                    </template>
                </tbody>
            </table>
        </div>


        <div class="flex justify-end">
            <x-secondary-button class="close-alternative-edit-modal" x-on:click="$dispatch('close')">
                {{ __('Cancel') }}
            </x-secondary-button>

            <x-secondary-button class="ml-3 bg-gray-700 text-white hover:!bg-gray-900" type="submit">
                {{ __('Update') }}
            </x-secondary-button>
        </div>
    </form>
</x-modal>
{{-- Modal EDIT Alternative END --}}

<script type="text/javascript">
    $(function() {
        if (document.querySelector(".setup-datatable")) {
            var table_alternative = $('.setup-datatable').DataTable({
                responsive: true,
                processing: true,
                serverSide: true,
                // deferRender: true,
                ajax: {
                    url: "{{ route('alternative.list', ['project' => Route::input('project')]) }}",
                },
                columns: [{
                        // data: 'id',
                        // name: 'id',
                        data: 'DT_RowIndex',
                        name: 'DT_RowIndex',
                        // orderable: false,
                        // searchable: false
                    },
                    {
                        data: 'name',
                        name: 'name',
                    },
                    {
                        data: 'description',
                        name: 'description',
                    },

                    {
                        data: 'attributes',
                        name: 'attributes',
                        orderable: false,
                        searchable: false,
                    },
                    {
                        data: 'action',
                        name: 'action',
                        orderable: false,
                        searchable: false
                    },
                    {
                        data: 'attributes',
                        name: 'attributes',
                        visible: false,
                    },
                ],
            });


            window.table_alternative = table_alternative
        }
    });
</script>
