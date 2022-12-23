<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Dashboard') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6">

                    <h2 class="text-lg font-medium text-gray-900 flex">
                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-6 h-6 mr-2">
                            <path stroke-linecap="round" stroke-linejoin="round"
                                d="M12 10.5v6m3-3H9m4.06-7.19l-2.12-2.12a1.5 1.5 0 00-1.061-.44H4.5A2.25 2.25 0 002.25 6v12a2.25 2.25 0 002.25 2.25h15A2.25 2.25 0 0021.75 18V9a2.25 2.25 0 00-2.25-2.25h-5.379a1.5 1.5 0 01-1.06-.44z" />
                        </svg>
                        {{ __('Edit Method') }}
                    </h2>

                    <form method="post" action="{{ route('project_method.update', $project_method->id) }}" data-alternative_taxonomy_keys='@json($alternative_taxonomy_keys)' x-data="editProjectMethod($el)" x-init="init"
                        @submit.prevent="submit" data-old_value='@json($project_method)'>
                        @csrf
                        @method('PUT')

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
                                        <x-input-float data-value="{{ $project_method->name }}" label-text="Name" label-class="" name="name" x-model="body.name" />
                                    </div>

                                    {{-- DESCRIPTION --}}
                                    <div>
                                        <x-textarea-float data-value="{{ $project_method->description }}" name="description" label-text="Description" rows="4" x-model="body.description">
                                        </x-textarea-float>
                                    </div>

                                    {{-- SELECT METHOD --}}
                                    <div>
                                        <select
                                            class="border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-800 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500"
                                            name="method_id" x-model="body.method_id" data-value="{{ $project_method->method_id }}">
                                            <option disabled value="">--- Choice method you want to use ----</option>
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
                                                            @change="updateAlternativeTaxonomyKeys(atk, index)" x-model="atk.checked" />
                                                        <label x-bind:for="'checkbox-method-criteria-' + atk.key_slug" class="ml-2 w-full text-sm font-medium text-gray-900 dark:text-gray-300" x-text="atk.key"></label>
                                                    </div>

                                                    <div>
                                                        <select
                                                            class="block w-full py-1 px-2 pr-4 text-sm text-gray-900 border border-gray-300 rounded-lg bg-gray-50 focus:ring-blue-500 focus:border-blue-500 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500 min-w-max"
                                                            name="type" x-model="atk.type" :value="atk.type">
                                                            <option value="cost">Cost</option>
                                                            <option value="benefit">Benefit</option>
                                                        </select>
                                                    </div>
                                                </div>
                                            </template>
                                        </div>
                                    </div>

                                    {{-- Specify Criterias Rasio --}}
                                    <div class="container-weight">
                                        <label class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Specify criteria rasio<span class="text-xs">*select at least 3 criteria</span></label>
                                        <template x-for="(criteria, index) in criterias">
                                            <div class="flex flex-col mb-4 px-4 pt-2 pb-4 rounded-md border border-gray-700">
                                                <div class="mb-3 grid grid-cols-12 md:grid-cols-11 gap-2">

                                                    <p x-text="criteria.label1" class="col-span-5 md:col-span-5 text-[0.9rem]"></p>

                                                    <p x-text="weights[criteria.value].label" class="col-span-2 md:col-span-1 aspect-square flex items-center border justify-center  border-gray-700 rounded-md w-[2rem]"></p>

                                                    <p x-text="criteria.label2" class="col-span-5 md:col-span-5 text-[0.9rem]"></p>
                                                </div>
                                                <input :name="`${criteria.slug1}+${criteria.slug2}`" type="range" :value="criteria_values[`${criteria.slug1}+${criteria.slug2}`]" min="0" max="16"
                                                    class="w-full h-2 bg-gray-200 rounded-lg appearance-none cursor-pointer dark:bg-gray-700" @change="updateCriteriaValue(index, `${criteria.slug1}+${criteria.slug2}`)">
                                            </div>
                                        </template>
                                    </div>
                                </div>
                                {{-- RIGHT END --}}

                            </div>
                        </div>

                        <div class="mt-6 mb-6 flex justify-end">
                            <x-secondary-button data-modal-toggle="modal-create-project-method" class="close-modal">
                                {{ __('Cancel') }}
                            </x-secondary-button>

                            <x-secondary-button class="ml-3 bg-gray-700 text-white hover:!bg-gray-900" type="submit">
                                {{ __('Update') }}
                            </x-secondary-button>
                        </div>
                    </form>




                </div>
            </div>
        </div>
    </div>
</x-app-layout>
