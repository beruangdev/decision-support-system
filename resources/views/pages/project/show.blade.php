<x-app-layout>
    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 ">
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">

                    <table class="datatable hover bordered display nowrap w-full text-sm text-left text-gray-500 dark:text-gray-400" style="width:100%; padding-top: 1em;  padding-bottom: 1em;">
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
        if (document.querySelector("table.datatable")) {
            var table_project_show = $('table.datatable').DataTable({
                ...dt_options,
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
