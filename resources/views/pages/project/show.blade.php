<x-app-layout>
    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 ">
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">

                    {{--  --}}
                    <div class="flex flex-wrap w-full mb-6">
                        <x-dropdown-link data-modal-toggle="modal-create-project-method"
                            class="text-white bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:ring-blue-300 font-medium rounded-lg text-sm px-5 py-2.5 mr-2 mb-2 dark:bg-blue-600 dark:hover:bg-blue-700 focus:outline-none dark:focus:ring-blue-800 w-fit">
                            {{ __('Add Method') }}
                        </x-dropdown-link>
                    </div>
                    {{--  --}}

                    <table class="setup-datatable stripe hover display" style="width:100%; padding-top: 1em;  padding-bottom: 1em;">
                        <thead>
                            <tr>
                                <th></th>
                                <th class="min-w-[10rem] md:min-w-[15rem]">Name</th>
                                <th>Description</th>
                                <th>Method</th>
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

<script type="text/javascript">
    $(function() {
        if (document.querySelector(".setup-datatable")) {
            var table_project_show = $('.setup-datatable').DataTable({
                responsive: true,
                processing: true,
                serverSide: true,
                deferRender: true,
                ajax: "{{ route('project.show.list', $project_id) }}",
                columns: [{
                        data: 'DT_RowIndex',
                        name: 'DT_RowIndex',
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
                        data: 'method',
                        name: 'method',
                    },
                    {
                        data: 'action',
                        name: 'action',
                        orderable: false,
                        searchable: false
                    },
                ],
            });

            window.table_project_show = table_project_show
        }
    });
</script>

{{-- Modal Create Project Method --}}

<div id="modal-create-project-method" tabindex="-1" class="fixed top-0 left-0 right-0 z-50 hidden w-full p-4 overflow-x-hidden overflow-y-auto md:inset-0 h-modal md:h-full" data-modal-placement="center-center">
    <div class="relative w-full h-full max-w-7xl md:h-auto max-h-[88vh] overflow-y-auto">
        <!-- Modal content -->
        <div class="relative bg-white rounded-lg shadow dark:bg-gray-800">
            <button type="button" class="absolute top-3 right-2.5 text-gray-400 bg-transparent hover:bg-gray-200 hover:text-gray-900 rounded-lg text-sm p-1.5 ml-auto inline-flex items-center dark:hover:bg-gray-800 dark:hover:text-white"
                data-modal-toggle="modal-create-project-method">
                <svg aria-hidden="true" class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg">
                    <path fill-rule="evenodd"
                        d="M4.293 4.293a1 1 0 011.414 0L10 8.586l4.293-4.293a1 1 0 111.414 1.414L11.414 10l4.293 4.293a1 1 0 01-1.414 1.414L10 11.414l-4.293 4.293a1 1 0 01-1.414-1.414L8.586 10 4.293 5.707a1 1 0 010-1.414z"
                        clip-rule="evenodd"></path>
                </svg>
                <span class="sr-only">Close modal</span>
            </button>
            <div class="px-6 py-6 lg:px-8">
                <h2 class="text-lg font-medium text-gray-900 flex">
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-6 h-6 mr-2">
                        <path stroke-linecap="round" stroke-linejoin="round"
                            d="M12 10.5v6m3-3H9m4.06-7.19l-2.12-2.12a1.5 1.5 0 00-1.061-.44H4.5A2.25 2.25 0 002.25 6v12a2.25 2.25 0 002.25 2.25h15A2.25 2.25 0 0021.75 18V9a2.25 2.25 0 00-2.25-2.25h-5.379a1.5 1.5 0 01-1.06-.44z" />
                    </svg>


                    {{ __('Add Method') }}
                </h2>

                <form action="{{ route('project_method.store', $project_id) }}" data-alternative_taxonomy_keys='@json($alternative_taxonomy_keys)' x-data="createProjectMethod($el)" x-init="init" @submit.prevent="submit">

                    <div class="container-error text-red-600 my-3">
                        <p class="error-header">&nbsp;</p>
                        <ul class="text-sm pl-4 list-disc">
                        </ul>
                    </div>

                    <div class="container-input-project-method">

                        <div class="mb-2 md:mb-4 grid grid-cols-1 md:grid-cols-12 gap-3">

                            {{-- LEFT --}}
                            <div class="flex flex-wrap flex-col gap-3 md:col-span-4">
                                {{-- NAME --}}
                                <div>
                                    <x-input-float value="" label-text="Name" label-class="" name="name" x-model="body.name" />
                                </div>

                                {{-- DESCRIPTION --}}
                                <div>
                                    <x-textarea-float name="description" label-text="Description" rows="4" x-model="body.description">
                                    </x-textarea-float>
                                </div>

                                {{-- SELECT METHOD --}}
                                <div>
                                    <select
                                        class="border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-800 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500"
                                        name="method_id" x-model="body.method_id">
                                        <option selected disabled value="">--- Choice method you want to use ----</option>
                                        @foreach ($methods as $method)
                                            <option value="{{ $method->id }}">{{ $method->name }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                            {{-- LEFT END --}}

                            {{-- RIGHT --}}
                            <div class="flex flex-wrap flex-col gap-3 md:col-span-8">

                                {{-- SELECT CRITERIA --}}
                                <div class="container-criterias">
                                    <label class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Choice criteria <span class="text-xs">*select at least 3 criteria</span></label>
                                    <div class="grid lg:grid-cols-2 gap-2">

                                        <template x-for="(atk, index) in alternative_taxonomy_keys" :key="index" @change.prevent="updateAlternativeTaxonomyKeys">
                                            <div class="container-criteria-item flex items-center justify-between px-4 py-2 rounded border border-gray-200 dark:border-gray-700">
                                                <div class="pr-2 flex">
                                                    <input x-bind:id="'checkbox-method-criteria-' + atk.key_slug" type="checkbox" :value="atk.key_slug" name="criterias"
                                                        class="w-4 h-4 text-blue-600 bg-gray-100 rounded border-gray-300 focus:ring-blue-500 dark:focus:ring-blue-600 dark:ring-offset-gray-800 focus:ring-2 dark:bg-gray-700 dark:border-gray-600 mt-[0.1rem]"
                                                        @change="updateAlternativeTaxonomyKeys(atk, index)" />
                                                    <label x-bind:for="'checkbox-method-criteria-' + atk.key_slug" class="ml-2 w-full text-sm font-medium text-gray-900 dark:text-gray-300" x-text="atk.key"></label>
                                                </div>

                                                {{-- <div class="flex items-center">
                                                    <span class="mr-3 text-sm font-medium text-gray-900 dark:text-gray-300">Cost</span>
                                                    <label class="inline-flex relative items-center cursor-pointer">
                                                        <input type="checkbox" value="" class="sr-only peer">
                                                        <div
                                                            class="w-11 h-6 bg-gray-200 peer-focus:outline-none peer-focus:ring-4 peer-focus:ring-blue-300 dark:peer-focus:ring-blue-800 rounded-full peer dark:bg-gray-700 peer-checked:after:translate-x-full peer-checked:after:border-white after:content-[''] after:absolute after:top-[2px] after:left-[2px] after:bg-white after:border-gray-300 after:border after:rounded-full after:h-5 after:w-5 after:transition-all dark:border-gray-600 peer-checked:bg-blue-600">
                                                        </div>
                                                    </label>
                                                    <span class="ml-3 text-sm font-medium text-gray-900 dark:text-gray-300">Benefit</span>
                                                </div> --}}

                                                <div>
                                                    {{-- <label for="small" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Small select</label> --}}
                                                    <select
                                                        class="block w-full py-1 px-2 pr-4 text-sm text-gray-900 border border-gray-300 rounded-lg bg-gray-50 focus:ring-blue-500 focus:border-blue-500 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500 min-w-max"
                                                        name="type">
                                                        <option value="cost" selected>Cost</option>
                                                        <option value="benefit">Benefit</option>
                                                    </select>
                                                </div>
                                            </div>
                                        </template>
                                    </div>
                                </div>

                                {{-- Specify Criterias Rasio --}}
                                <template x-if="Object.keys(criterias).length > 0">
                                    <div class="container-weight">
                                        <label class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Specify criteria rasio<span class="text-xs">*select at least 3 criteria</span></label>
                                        <template x-for="(criteria, index) in criterias.filter(c => c.status)">
                                            <div class="flex flex-col mb-4 px-4 pt-2 pb-4 rounded-md border border-gray-700">
                                                <div class="mb-3 grid grid-cols-12 md:grid-cols-11 gap-2">

                                                    <p x-text="criteria.label1" class="col-span-5 md:col-span-5 text-[0.9rem]"></p>

                                                    <p x-text="weights[criteria.value]" class="col-span-2 md:col-span-1 aspect-square flex items-center border justify-center  border-gray-700 rounded-md w-[2rem]"></p>

                                                    <p x-text="criteria.label2" class="col-span-5 md:col-span-5 text-[0.9rem]"></p>
                                                </div>
                                                <input :name="`${criteria.slug1}+${criteria.slug2}`" type="range" :value="criteria_values[`${criteria.slug1}+${criteria.slug2}`]" min="0" max="16"
                                                    class="w-full h-2 bg-gray-200 rounded-lg appearance-none cursor-pointer dark:bg-gray-700" @change="updateCriteriaValue(index, `${criteria.slug1}+${criteria.slug2}`)">
                                            </div>
                                        </template>
                                    </div>
                                </template>
                            </div>
                            {{-- RIGHT END --}}

                        </div>
                    </div>

                    <div class="mt-6 mb-6 flex justify-end">
                        <x-secondary-button data-modal-toggle="modal-create-project-method" class="close-modal">
                            {{ __('Cancel') }}
                        </x-secondary-button>

                        <x-secondary-button class="ml-3 bg-gray-700 text-white hover:!bg-gray-900" type="submit">
                            {{ __('Add') }}
                        </x-secondary-button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
{{-- Modal Create Project Method END --}}
