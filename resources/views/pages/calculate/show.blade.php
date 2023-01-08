<x-app-layout>
    @php
        $criterias = $calculate->project_method->criterias->where('checked', true);
    @endphp
    <div class="py-12" data-calculate='@json($calculate)' x-data="showCalculate($el)" x-init="this.init"
        url-alternative-list="{{ route('calculate.alternative.list', [
            'project' => $project_id,
            'project_method' => $project_method_id,
            'calculate_id' => $calculate_id,
        ]) }}">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-4 md:p-6">
                    <template x-if="alternative_count > 1000">
                        <div class="p-4 mb-4 text-sm text-yellow-700 bg-yellow-100 rounded-lg dark:bg-gray-840 dark:text-yellow-400" role="alert">
                            <span class="font-medium">Warning!</span> records are too large. Maybe the browser will freeze in a few minutes
                        </div>
                    </template>
                    @php
                        $alphabet = ['A', 'B', 'C', 'D', 'E', 'F', 'G', 'H', 'I', 'J', 'K', 'L', 'M', 'N', 'O', 'P', 'Q', 'R', 'S', 'T', 'U', 'V', 'W', 'X', 'Y', 'Z'];
                        $alphabet = ['C2', 'C4', 'C5', 'C1', 'C3', 'F', 'G', 'H', 'I', 'J', 'K', 'L', 'M', 'N', 'O', 'P', 'Q', 'R', 'S', 'T', 'U', 'V', 'W', 'X', 'Y', 'Z'];
                    @endphp
                    <ul class="criteria-initial list-disc list-inside text-xs md:text-sm mb-4">
                        @foreach ($criterias as $key => $criteria)
                            <li>{{ $alphabet[$key] }} &nbsp; = &nbsp; {{ $criteria->name }}</li>
                        @endforeach
                    </ul>

                    <div class="mb-4 border-b border-gray-200 dark:border-gray-700">
                        <ul class="flex flex-wrap justify-between md:justify-start md:gap-2 text-sm font-medium text-center" id="myTab" data-tabs-toggle="#tab-edas" role="tablist">
                            <li role="presentation">
                                <button class="inline-block px-2 py-1 md:p-4 rounded-t-lg border-b-2" id="decision_matrix-tab" data-tabs-target="#decision_matrix" type="button" role="tab" aria-controls="decision_matrix"
                                    aria-selected="false">Matrix</button>
                            </li>
                            {{-- <li role="presentation" class="hidden">
                                <button class="inline-block px-2 py-1 md:p-4 rounded-t-lg border-b-2 border-transparent hover:text-gray-600 hover:border-gray-300 dark:hover:text-gray-300" id="average_solution-tab"
                                    data-tabs-target="#average_solution" type="button" role="tab" aria-controls="average_solution" aria-selected="false">AV</button>
                            </li> --}}
                            <li role="presentation">
                                <button class="inline-block px-2 py-1 md:p-4 rounded-t-lg border-b-2 border-transparent hover:text-gray-600 hover:border-gray-300 dark:hover:text-gray-300" id="positive_negative_distance-tab"
                                    data-tabs-target="#positive_negative_distance" type="button" role="tab" aria-controls="positive_negative_distance" aria-selected="false">PDA/NDA</button>
                            </li>
                            <li role="presentation">
                                <button class="inline-block px-2 py-1 md:p-4 rounded-t-lg border-b-2 border-transparent hover:text-gray-600 hover:border-gray-300 dark:hover:text-gray-300" id="sum_weight-tab" data-tabs-target="#sum_weight"
                                    type="button" role="tab" aria-controls="sum_weight" aria-selected="false">SP/SN</button>
                            </li>
                            <li role="presentation">
                                <button class="inline-block px-2 py-1 md:p-4 rounded-t-lg border-b-2 border-transparent hover:text-gray-600 hover:border-gray-300 dark:hover:text-gray-300" id="normalization-tab"
                                    data-tabs-target="#normalization" type="button" role="tab" aria-controls="normalization" aria-selected="false">NSP/NSN</button>
                            </li>
                            <li role="presentation">
                                <button class="inline-block px-2 py-1 md:p-4 rounded-t-lg border-b-2 border-transparent hover:text-gray-600 hover:border-gray-300 dark:hover:text-gray-300" id="score_rating-tab"
                                    data-tabs-target="#score_rating" type="button" role="tab" aria-controls="score_rating" aria-selected="false">AS</button>
                            </li>
                        </ul>
                    </div>
                    <div id="tab-edas" class="text-xs">

                        <div class="hidden bg-gray-50 rounded-lg dark:bg-gray-800 hide-dt-paginate" id="decision_matrix" role="tabpanel" aria-labelledby="decision_matrix-tab">
                            <div class="">
                                <div class="w-full bg-gray-200 rounded-full h-1.5 mb-4 dark:bg-gray-700">
                                    <div class="bg-blue-600 h-1.5 rounded-full dark:bg-blue-500 transition-all  duration-500 " :style="`width: ${decision_matrix_progress}%`"></div>
                                </div>
                                <table id="table-decision_matrix" class="bordered display nowrap w-full text-sm text-left text-gray-500 dark:text-gray-400" width="100%">
                                    <thead class="text-xs text-gray-700 text-center bg-gray-50 dark:bg-gray-700 dark:text-gray-400">
                                        <tr>
                                            <th rowspan="3" class="py-1 px-2 !text-center">NO</th>
                                            <th rowspan="3" class="py-1 px-2 !text-center">Alternative</th>
                                            @foreach ($criterias as $criteria)
                                                <th class="py-1 px-2 !text-center">{{ $criteria->name }}</th>
                                            @endforeach
                                        </tr>
                                        <tr>
                                            @foreach ($criterias as $criteria)
                                                <th class="capitalize !text-center py-1 px-2">{{ $criteria->type }}</th>
                                            @endforeach
                                        </tr>
                                        <tr>
                                            @foreach ($criterias as $criteria)
                                                <th class="!text-center py-1 !px-7">{{ round($criteria->weight, 3) }}</th>
                                            @endforeach
                                        </tr>
                                    </thead>
                                    <tbody>

                                    </tbody>
                                </table>

                                @include('pages.calculate.pagination', ["name" => "decision_matrix"])
                            </div>
                        </div>

                        {{-- <div class="hidden bg-gray-50 rounded-lg dark:bg-gray-800 hide-dt-paginate" id="average_solution" role="tabpanel" aria-labelledby="average_solution-tab">
                            <table id="table-average_solution" class="bordered display nowrap w-full text-sm text-left text-gray-500 dark:text-gray-400" width="100%">
                                <thead class="text-xs text-gray-700 text-center bg-gray-50 dark:bg-gray-700 dark:text-gray-400">
                                    <tr>
                                        <th class="py-4 px-5 !text-center">&nbsp;</th>
                                        @foreach ($criterias as $criteria)
                                            <th class="py-4 px-1 !text-center">{{ $criteria->name }}</th>
                                        @endforeach
                                    </tr>
                                </thead>
                                <tbody>

                                </tbody>
                            </table>
                        </div> --}}


                        <div class="hidden bg-gray-50 rounded-lg dark:bg-gray-800 hide-dt-paginate" id="positive_negative_distance" role="tabpanel" aria-labelledby="positive_negative_distance-tab">

                            <table id="table-positive_negative_distance" class="bordered display nowrap w-full text-sm text-left text-gray-500 dark:text-gray-400" width="100%">
                                <thead class="text-xs text-gray-700 text-center bg-gray-50 dark:bg-gray-700 dark:text-gray-400">
                                    <tr>
                                        <th rowspan="2" class="py-1 px-2 !text-center">Alternative</th>
                                        <th colspan="{{ count($criterias) }}" class="py-1 px-2 !text-center">PDA</th>
                                        <th colspan="{{ count($criterias) }}" class="py-1 px-2 !text-center">NDA</th>
                                    </tr>
                                    <tr>
                                        @foreach ($criterias as $key => $criteria)
                                            <th class="capitalize !text-center py-1 px-2">{{ $alphabet[$key] }}</th>
                                        @endforeach
                                        @foreach ($criterias as $key => $criteria)
                                            <th class="capitalize !text-center py-1 px-2">{{ $alphabet[$key] }}</th>
                                        @endforeach
                                    </tr>

                                </thead>
                                <tbody>

                                </tbody>
                            </table>

                            @include('pages.calculate.pagination', ["name" => "positive_negative_distance"])
                        </div>

                        <div class="hidden bg-gray-50 rounded-lg dark:bg-gray-800 hide-dt-paginate" id="sum_weight" role="tabpanel" aria-labelledby="sum_weight-tab">

                            <table id="table-sum_weight" class="bordered display nowrap w-full text-sm text-left text-gray-500 dark:text-gray-400" width="100%">
                                <thead class="text-xs text-gray-700 text-center bg-gray-50 dark:bg-gray-700 dark:text-gray-400">
                                    <tr>
                                        <th rowspan="2" class="py-1 px-2 !text-center">Alternative</th>
                                        <th colspan="{{ count($criterias) }}" class="py-1 px-2 !text-center">SP</th>
                                        <th rowspan="2" class="py-1 px-2 !text-center">SPi</th>
                                        <th colspan="{{ count($criterias) }}" class="py-1 px-2 !text-center">SN</th>
                                        <th rowspan="2" class="py-1 px-2 !text-center">SNi</th>
                                    </tr>
                                    <tr>
                                        @foreach ($criterias as $key => $criteria)
                                            <th class="capitalize !text-center py-1 px-2">{{ $alphabet[$key] }}</th>
                                        @endforeach
                                        @foreach ($criterias as $key => $criteria)
                                            <th class="capitalize !text-center py-1 px-2">{{ $alphabet[$key] }}</th>
                                        @endforeach
                                    </tr>

                                </thead>
                                <tbody>

                                </tbody>
                            </table>
                            @include('pages.calculate.pagination', ["name" => "sum_weight"])

                        </div>

                        <div class="hidden bg-gray-50 rounded-lg dark:bg-gray-800 hide-dt-paginate" id="normalization" role="tabpanel" aria-labelledby="normalization-tab">

                            <table id="table-normalization" class="bordered display nowrap w-full text-sm text-left text-gray-500 dark:text-gray-400" width="100%" style="width: 100%">
                                <thead class="text-xs text-gray-700 text-center bg-gray-50 dark:bg-gray-700 dark:text-gray-400">
                                    <tr>
                                        <th class="py-1 px-2 !text-center">Alternative</th>
                                        <th class="py-1 px-2 !text-center">NSPi</th>
                                        <th class="py-1 px-2 !text-center">NSNi</th>
                                    </tr>
                                </thead>
                                <tbody>

                                </tbody>
                            </table>
                            @include('pages.calculate.pagination', ["name" => "normalization"])

                        </div>

                        <div class="hidden bg-gray-50 rounded-lg dark:bg-gray-800 hide-dt-paginate" id="score_rating" role="tabpanel" aria-labelledby="score_rating-tab">
                            @php
                                $scores = [0.1, 0.2, 0.3, 0.4, 0.5, 0.6, 0.7, 0.8, 0.9];
                                $random = Str::random(5);
                            @endphp

                            <div class="mb-2">
                                <label for="score_rating-select-{{ $random }}" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Select score</label>
                                <select id="score_rating-select-{{ $random }}" name="score-rating"
                                    class="w-[69px] p-[4px] pl-2 md:w-24 bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-md focus:ring-blue-500 focus:border-blue-500 block dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500">
                                    @foreach ($scores as $index => $score)
                                        <option value="{{ $index }}" {{ $score == 0.5 ? 'selected' : '' }}>{{ $score }}</option>
                                    @endforeach
                                </select>
                            </div>

                            <table id="table-score_rating" class="bordered display nowrap w-full text-sm text-left text-gray-500 dark:text-gray-400" width="100%">
                                <thead class="text-xs text-gray-700 text-center bg-gray-50 dark:bg-gray-700 dark:text-gray-400">
                                    <tr>
                                        <th rowspan="2" class="py-1 px-2 !text-center hidden" data-visible="false">Index</th>
                                        <th rowspan="2" class="py-1 px-2 !text-center">Alternative</th>
                                        <th colspan="{{ count($scores) * 2 }}" class="py-1 px-2 !text-center">AS</th>
                                    </tr>
                                    <tr>
                                        @foreach ($scores as $key => $score)
                                            <th class="capitalize !text-center py-1 px-2" data-visible="false">{{ $score }}</th>
                                            <th class="capitalize !text-center py-1 px-2" data-visible="false">Rank</th>
                                        @endforeach
                                    </tr>

                                </thead>
                                <tbody>

                                </tbody>
                            </table>
                            @include('pages.calculate.pagination', ["name" => "score_rating"])

                        </div>

                    </div>

                </div>
            </div>
        </div>
    </div>

</x-app-layout>

<script>
    $(document).ready(function() {
        const selector = `#sum_weight-tab`
        var theInterval = setInterval(() => {
            if (document.querySelector(selector)) {
                document.querySelector(selector).click()
                clearInterval(theInterval)
            }
        }, 10);

    });
</script>
