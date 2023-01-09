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
                    <div class="mb-10">

                        <div id="accordion-collapse" data-accordion="collapse">
                            <h2 id="accordion-collapse-heading-1">
                                <button type="button"
                                    class="flex items-center justify-between w-full p-5 font-medium text-left text-gray-500 border border-gray-200 rounded-t-xl focus:ring-4 focus:ring-gray-200 dark:focus:ring-gray-800 dark:border-gray-700 dark:text-gray-400 hover:bg-gray-100 dark:hover:bg-gray-800"
                                    data-accordion-target="#accordion-collapse-body-1" aria-expanded="false" aria-controls="accordion-collapse-body-1">
                                    <span>Calculate</span>
                                    <svg data-accordion-icon class="w-6 h-6 rotate-180 shrink-0" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg">
                                        <path fill-rule="evenodd" d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z" clip-rule="evenodd"></path>
                                    </svg>
                                </button>
                            </h2>
                            <div id="accordion-collapse-body-1" class="hidden" aria-labelledby="accordion-collapse-heading-1">
                                <div class="p-5 font-light border border-gray-200 dark:border-gray-700 dark:bg-gray-900">

                                    <ul class="criteria-initial list-disc list-inside">
                                    </ul>

                                    <div class="mb-4 border-b border-gray-200 dark:border-gray-700">
                                        <ul class="flex flex-wrap -mb-px text-sm font-medium text-center" id="myTab" data-tabs-toggle="#method-result-tab" role="tablist">
                                            <li class="mr-2" role="presentation">
                                                <button class="inline-block p-4 rounded-t-lg border-b-2" id="comparision-matrix-tab" data-tabs-target="#comparision-matrix" type="button" role="tab" aria-controls="comparision-matrix"
                                                    aria-selected="false">Comparison Matrix</button>
                                            </li>
                                            <li class="mr-2" role="presentation">
                                                <button class="inline-block p-4 rounded-t-lg border-b-2 border-transparent hover:text-gray-600 hover:border-gray-300 dark:hover:text-gray-300" id="calculate-weight-tab"
                                                    data-tabs-target="#calculate-weight" type="button" role="tab" aria-controls="calculate-weight" aria-selected="false">Weight</button>
                                            </li>
                                            <li class="mr-2" role="presentation">
                                                <button class="inline-block p-4 rounded-t-lg border-b-2 border-transparent hover:text-gray-600 hover:border-gray-300 dark:hover:text-gray-300" id="calculate-lambda-tab"
                                                    data-tabs-target="#calculate-lambda" type="button" role="tab" aria-controls="calculate-lambda" aria-selected="false">Lambda</button>
                                            </li>
                                            <li role="presentation">
                                                <button class="inline-block p-4 rounded-t-lg border-b-2 border-transparent hover:text-gray-600 hover:border-gray-300 dark:hover:text-gray-300" id="check-consistency-tab"
                                                    data-tabs-target="#check-consistency" type="button" role="tab" aria-controls="check-consistency" aria-selected="false">Check Consistency</button>
                                            </li>
                                        </ul>
                                    </div>
                                    <div id="method-result-tab">
                                        <div class="hidden p-4 bg-gray-50 rounded-lg dark:bg-gray-800" id="comparision-matrix" role="tabpanel" aria-labelledby="comparision-matrix-tab">

                                            <table id="table-comparison-matrix" class="display" width="100%"></table>

                                        </div>
                                        <div class="hidden p-4 bg-gray-50 rounded-lg dark:bg-gray-800" id="calculate-weight" role="tabpanel" aria-labelledby="calculate-weight-tab">
                                            <table id="table-weight" class="display" width="100%"></table>
                                        </div>
                                        <div class="hidden p-4 bg-gray-50 rounded-lg dark:bg-gray-800" id="calculate-lambda" role="tabpanel" aria-labelledby="calculate-lambda-tab">
                                            <table id="table-lambda" class="display" width="100%"></table>
                                        </div>
                                        <div class="hidden p-4 bg-gray-50 rounded-lg dark:bg-gray-800" id="check-consistency" role="tabpanel" aria-labelledby="check-consistency-tab">

                                            <table id="table-check-consistency" class="display" width="100%"></table>

                                        </div>
                                    </div>

                                </div>
                            </div>
                        </div>

                    </div>


                    <form method="post" action="{{ route('project_method.update', ['project' => Route::input('project'), 'method' => $project_method->id]) }}"
                        action-update_weight="{{ route('criteria.update_weight', [
                            'project' => Route::input('project'),
                            'project_method' => $project_method->id,
                        ]) }}"
                        data-attribute_keys='@json($attribute_keys)' x-data="editProjectMethod($el)" x-init="this.init" @submit.prevent="submit" data-old_value='@json($project_method)'>
                        @csrf
                        @method('PUT')

                        <div class="flex flex-wrap justify-between">
                            <h2 class="text-lg font-medium text-gray-900 flex">
                                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-6 h-6 mr-2">
                                    <path stroke-linecap="round" stroke-linejoin="round"
                                        d="M12 10.5v6m3-3H9m4.06-7.19l-2.12-2.12a1.5 1.5 0 00-1.061-.44H4.5A2.25 2.25 0 002.25 6v12a2.25 2.25 0 002.25 2.25h15A2.25 2.25 0 0021.75 18V9a2.25 2.25 0 00-2.25-2.25h-5.379a1.5 1.5 0 01-1.06-.44z" />
                                </svg>
                                {{ __('Edit Method') }}
                            </h2>

                            <div class="flex justify-end gap-2">
                                @if (Auth::user()->role == 'admin')
                                    <x-button class="reset-criteria-rasio bg-gray-700 text-white hover:bg-gray-900" @click="resetCriteriaRasio">
                                        Reset Rasio
                                    </x-button>
                                @endif
                                <x-button class="bg-indigo-500 hover:bg-indigo-600 dark:hover:bg-indigo-600 text-white dark:text-white" data-modal-toggle="create-calculate">{{ __('Calculate') }}</x-button>
                                <x-button class="bg-gray-700 text-white hover:!bg-gray-900" type="submit">
                                    {{ __('Update') }}
                                </x-button>
                            </div>
                        </div>

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

                                            <template x-for="(criteria, index) in body.criterias" :key="index">
                                                <div class="container-criteria-item flex items-center justify-between px-4 rounded border border-gray-200 dark:border-gray-700">
                                                    <div class="pr-2 flex h-full items-center">
                                                        <input :id="'checkbox-method-edit-criteria-' + criteria.slug" type="checkbox" :value="criteria.slug" name="criterias"
                                                            class="w-4 h-4 text-blue-600 bg-gray-100 rounded border-gray-300 focus:ring-blue-500 dark:focus:ring-blue-600 dark:ring-offset-gray-800 focus:ring-2 dark:bg-gray-700 dark:border-gray-600 mt-[0.1rem]"
                                                            @change="onCriteriaUpdate(index, criteria)" x-model="criteria.checked" />
                                                        <label :for="'checkbox-method-edit-criteria-' + criteria.slug" class="ml-2 flex items-center w-full h-full text-sm font-medium text-gray-900 dark:text-gray-300"
                                                            x-text="criteria.name"></label>
                                                    </div>

                                                    <div class="py-2">
                                                        <select
                                                            class="block w-full py-1 px-2 pr-4 text-sm text-gray-900 border border-gray-300 rounded-lg bg-gray-50 focus:ring-blue-500 focus:border-blue-500 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500 min-w-max"
                                                            name="type" x-model="criteria.type" :value="criteria.type">
                                                            <option value="cost">Cost</option>
                                                            <option value="benefit">Benefit</option>
                                                        </select>
                                                    </div>
                                                </div>
                                            </template>
                                        </div>
                                    </div>
                                </div>
                                {{-- RIGHT END --}}

                            </div>

                            <div class="mb-2 md:mb-4">

                                {{-- Specify Criterias Rasio --}}
                                <div class="container-weight">
                                    <label class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Criterion comparison</label>
                                    <div class="grid grid-cols-1 md:grid-cols-2 gap-2">
                                        <template x-for="(criteria, index) in body.criteria_rasios" :key="index">
                                            <template x-if="criteria.checked">
                                                <div class="flex flex-col mb-4 px-4 pt-2 pb-4 rounded-md border border-gray-300 dark:border-gray-700">
                                                    <div class="mb-3 grid grid-cols-12 gap-1">

                                                        <p x-text="criteria.names[0]" class="col-span-5 md:col-span-5 text-[0.8rem]"></p>

                                                        <div class="col-span-2 flex items-center gap-2">
                                                            <p x-text="weights[criteria.value].label"
                                                                class="aspect-square flex items-center border justify-center  border-gray-300 text-xs font-semibold  dark:border-gray-700 rounded-md w-[2rem]"></p>

                                                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" class="w-5 h-5">
                                                                <path stroke-linecap="round" stroke-linejoin="round" d="M7.5 21L3 16.5m0 0L7.5 12M3 16.5h13.5m0-13.5L21 7.5m0 0L16.5 12M21 7.5H7.5" />
                                                            </svg>

                                                            <p x-text="getRasioWeightLabel(1,criteria)"
                                                                class="aspect-square flex items-center border text-xs font-semibold justify-center  border-gray-300 dark:border-gray-700 rounded-md w-[2rem]"></p>
                                                        </div>

                                                        <p x-text="criteria.names[1]" class="col-span-5 md:col-span-5 text-[0.8rem] text-right"></p>
                                                    </div>
                                                    <input type="range" x-model="criteria.value" min="0" max="16" class="w-full h-2 bg-gray-200 rounded-lg appearance-none cursor-pointer dark:bg-gray-700"
                                                        @change="onChangeRasio()">
                                                </div>
                                            </template>
                                        </template>
                                    </div>
                                </div>
                            </div>


                        </div>
                    </form>




                </div>
            </div>
        </div>
    </div>
</x-app-layout>



<!-- Main modal -->
<div id="create-calculate" tabindex="-1" aria-hidden="true" class="fixed top-0 left-0 right-0 z-50 hidden w-full p-4 overflow-x-hidden overflow-y-auto md:inset-0 h-modal md:h-full">
    <div class="relative w-full h-full max-w-xl md:h-auto">
        <!-- Modal content -->
        <div class="relative bg-white rounded-lg shadow dark:bg-gray-840">
            <button type="button" class="absolute top-3 right-2.5 text-gray-400 bg-transparent hover:bg-gray-200 hover:text-gray-900 rounded-lg text-sm p-1.5 ml-auto inline-flex items-center dark:hover:bg-gray-800 dark:hover:text-white"
                data-modal-toggle="create-calculate">
                <svg aria-hidden="true" class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg">
                    <path fill-rule="evenodd"
                        d="M4.293 4.293a1 1 0 011.414 0L10 8.586l4.293-4.293a1 1 0 111.414 1.414L11.414 10l4.293 4.293a1 1 0 01-1.414 1.414L10 11.414l-4.293 4.293a1 1 0 01-1.414-1.414L8.586 10 4.293 5.707a1 1 0 010-1.414z"
                        clip-rule="evenodd"></path>
                </svg>
                <span class="sr-only">Close modal</span>
            </button>
            <div class="px-6 py-6 lg:px-8">
                <h3 class="mb-4 text-xl font-medium text-gray-900 dark:text-white">Make new calculation</h3>
                <form method="POST" class="space-y-6"
                    action="{{ route('calculate.store', [
                        'project' => $project_method->project->id,
                        'project_method' => $project_method->id,
                    ]) }}"
                    x-data="createCalculate($el)" x-init="this.init">
                    @csrf

                    {{-- NAME --}}
                    <div>
                        <x-input-float value="" label-text="Name" label-class="" class="" name="name"/>
                    </div>

                    {{-- DESCRIPTION --}}
                    <div>
                        <x-textarea-float name="description" label-text="Description" rows="4">
                        </x-textarea-float>
                    </div>


                    <div>
                        <label for="input-algorithms" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Select an algorithm</label>
                        <select id="input-algorithms" name="algorithm"
                            class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500"
                            x-model="body.algorithm">
                            <option selected value="">Choose an algorithm</option>
                            @foreach (App\Models\Algorithm::all() as $algorithm)
                                <option value="{{ $algorithm->id }}" selected>{{ $algorithm->name }}</option>
                            @endforeach
                        </select>
                    </div>

                    <button type="submit"
                        class="w-full text-white bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium rounded-lg text-sm px-5 py-2.5 text-center dark:bg-blue-600 dark:hover:bg-blue-700 dark:focus:ring-blue-800">
                        Create
                    </button>

                </form>
            </div>
        </div>
    </div>
</div>


{{-- <script>
    $(document).ready(function() {
        const selector = `[data-modal-toggle="create-calculate"]`
        var theInterval = setInterval(() => {
            if (document.querySelector(selector)) {
                document.querySelector(selector).click()
                clearInterval(theInterval)
            }
        }, 10);
    });
</script> --}}
