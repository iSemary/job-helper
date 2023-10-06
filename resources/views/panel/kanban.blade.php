@extends('layout.switcher')
@section('switcher')
    <link rel="stylesheet" href="{{ asset('assets/plugins/jqwidgets/jqx.base.css') }}">
    <div class="kanban-page">
        <h5 class="text-center"><i class="far fa-building"></i> Organize Company Leads</h5>
        <div id="kanbanContent" class="m-0 w-100">

        </div>
    </div>
@endsection

@push('extra-scripts')
    <script src="{{ asset('assets/plugins/jqwidgets/jqxcore.js') }}"></script>
    <script src="{{ asset('assets/plugins/jqwidgets/jqxdata.js') }}"></script>
    <script src="{{ asset('assets/plugins/jqwidgets/jqxsortable.js') }}"></script>
    <script src="{{ asset('assets/plugins/jqwidgets/jqxkanban.js') }}"></script>
    <script>
        if (typeof kanbanStatuses == 'undefined') {
            var kanbanStatuses = {!! $statuses !!}
        }

        if (typeof kanbanSource == 'undefined') {
            var kanbanSource = kanbanResource = {!! $kanbanCompanies !!}
        }
        $(document).ready(function() {
            loadKanbanContent();

            $('#kanbanContent').on('itemMoved', function(event) {
                var args = event.args;
                var itemId = args.itemData.id;
                var newStatusId = args.newColumn.id;

                $.ajax({
                    type: "POST",
                    url: `{{ route('panel.companies.updateStatus') }}`,
                    data: {
                        id: itemId,
                        status: newStatusId,
                        _token: csrfToken,
                    },
                    dataType: "json",
                    beforeSend: function() {
                        waitingLoad();
                    },
                    success: function(response) {
                        normalLoad();
                    },
                    error: function(response) {
                        errorLoad();
                    }
                });
            });

            function loadKanbanContent() {
                var fields = [{
                        name: "id",
                        type: "string"
                    },
                    {
                        name: "status",
                        map: "state",
                        type: "string"
                    },
                    {
                        name: "text",
                        map: "label",
                        type: "string"
                    },
                    {
                        name: "tags",
                        type: "string"
                    },
                    {
                        name: "color",
                        map: "hex",
                        type: "string"
                    },
                    {
                        name: "resourceId",
                        type: "number"
                    }
                ];
                var source = {
                    localData: kanbanSource,
                    dataType: "array",
                    dataFields: fields
                };
                var dataAdapter = new $.jqx.dataAdapter(source);
                var resourcesAdapterFunc = function() {
                    var resourcesSource = {
                        localData: kanbanResource,
                        dataType: "array",
                        dataFields: [{
                                name: "id",
                                type: "number"
                            },
                            {
                                name: "name",
                                type: "string"
                            },
                            {
                                name: "image",
                                type: "string"
                            },
                            {
                                name: "common",
                                type: "boolean"
                            }
                        ]
                    };
                    var resourcesDataAdapter = new $.jqx.dataAdapter(resourcesSource);
                    return resourcesDataAdapter;
                }
                $('#kanbanContent').jqxKanban({
                    resources: resourcesAdapterFunc(),
                    source: dataAdapter,
                    columns: kanbanStatuses
                });
            }
        });
    </script>
@endpush
