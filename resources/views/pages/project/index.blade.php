<x-app-layout>
    <div class="pb-12 pt-2 sm:pt-6">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-4 md:p-6">
                    <table class="datatable hover bordered display nowrap w-full text-sm text-left text-gray-500 dark:text-gray-400" style="width:100%; padding-top: 1em;  padding-bottom: 1em;">
                        <thead class="text-xs text-gray-700 text-center bg-gray-50 dark:bg-gray-700 dark:text-gray-400">
                            <tr>
                                <th></th>
                                <th class="min-w-[10rem] md:min-w-[15rem]">Name</th>
                                <th class="max-w-[50rem]">Description</th>
                                <th></th>
                            </tr>
                        </thead>
                        <tbody></tbody>
                        {{-- <tfoot>
                        <tr>
                            <th></th>
                            <th>Name</th>
                            <th>Description</th>
                            <th></th>
                        </tr>
                    </tfoot> --}}
                    </table>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>

{{-- Modal EDIT Project --}}
<x-modal name="modal-edit-project" focusable>
    <form method="post" action="{{ route('project.index') }}" class="p-6" x-data="editProject($el)" x-init="init" @submit.prevent="submit">
        @csrf

        <h2 class="text-lg font-medium flex">
            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-6 h-6 mr-2">
                <path stroke-linecap="round" stroke-linejoin="round"
                    d="M12 10.5v6m3-3H9m4.06-7.19l-2.12-2.12a1.5 1.5 0 00-1.061-.44H4.5A2.25 2.25 0 002.25 6v12a2.25 2.25 0 002.25 2.25h15A2.25 2.25 0 0021.75 18V9a2.25 2.25 0 00-2.25-2.25h-5.379a1.5 1.5 0 01-1.06-.44z" />
            </svg>


            {{ __('Edit Project') }}
        </h2>

        <div class="mb-3 mt-6">
            <div class="wrapper-input-floating-label">
                <div class="relative">
                    <input type="text" class="block px-2.5 pb-2.5 pt-4 w-full text-sm text-gray-900 bg-transparent rounded-lg border-1 appearance-none dark:text-white focus:outline-none focus:ring-0 peer" name="name" placeholder=" "
                        :value="body.name.value" x-model="body.name.value" data-required />
                    <label
                        class="absolute text-sm duration-300 transform -translate-y-4 scale-75 top-2 z-10 origin-[0] bg-white dark:bg-gray-800 px-2 peer-focus:px-2 peer-placeholder-shown:scale-100 peer-placeholder-shown:-translate-y-1/2 peer-placeholder-shown:top-1/2 peer-focus:top-2 peer-focus:scale-75 peer-focus:-translate-y-4 left-1">
                        Name
                    </label>
                </div>
                <p class="mt-1 text-xs text-red-600 dark:text-red-400 input-floating-label-error-message" x-text="body.name.message">
                    <span class="font-medium">Oh, snapp!</span> Some error message.
                </p>
            </div>
        </div>

        <div class="mb-3">
            <div class="wrapper-input-floating-label">
                <div class="relative">
                    <textarea name="description" cols="30" rows="4" class="block px-2.5 pb-2.5 pt-4 w-full text-sm text-gray-900 bg-transparent rounded-lg border-1 appearance-none dark:text-white focus:outline-none focus:ring-0 peer" placeholder=" "
                        :value="body.description.value" x-model="body.description.value"></textarea>
                    <label for="outlined_error"
                        class="absolute text-sm duration-300 transform -translate-y-4 scale-75 top-2 z-10 origin-[0] bg-white dark:bg-gray-800 px-2 peer-focus:px-2 peer-placeholder-shown:scale-100 peer-placeholder-shown:-translate-y-1/2 peer-placeholder-shown:top-5 peer-focus:top-2 peer-focus:scale-75 peer-focus:-translate-y-4 left-1">
                        Description
                    </label>
                </div>
                <p class="mt-1 text-xs text-red-600 dark:text-red-400 input-floating-label-error-message" x-text="body.description.message">
                    <span class="font-medium">Oh, snapp!</span> Some error message.
                </p>
            </div>
        </div>

        <div class="mt-6 flex justify-end">
            <x-secondary-button x-on:click="$dispatch('close')" class="modal-close">
                {{ __('Cancel') }}
            </x-secondary-button>

            <x-secondary-button class="ml-3 bg-gray-700 text-white hover:!bg-gray-900 " type="submit">
                {{ __('Update') }}
            </x-secondary-button>
        </div>
    </form>
</x-modal>
{{-- Modal EDIT Project END --}}

<script type="text/javascript">
    $(function() {
        if (document.querySelector("table.datatable")) {
            var table_project = $('table.datatable').DataTable({
                ...dt_options,
                processing: true,
                serverSide: true,
                deferRender: true,
                ajax: {
                    url: "{{ route('project.list') }}",
                },
                columns: [{
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
                        data: 'action',
                        name: 'action',
                        orderable: false,
                        searchable: false
                    },
                ],
            });


            window.table_project = table_project
        }
    });
</script>
