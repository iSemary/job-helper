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
        $(document).ready(function() {
            loadKanbanContent();
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
                localData: [{
                    id: "1161", // company id
                    state: "backlog", // apply status
                    label: "Notchnco", // company name
                    hex: "#5dc3f0", // color
                    resourceId: 3, // resource id
                    tags: "/"
                }],
                dataType: "array",
                dataFields: fields
            };
            var dataAdapter = new $.jqx.dataAdapter(source);
            var resourcesAdapterFunc = function() {
                var resourcesSource = {
                    localData: [{
                            id: 3,
                            name: "Notchnco",
                            image: "/assets/images/office-building.png",
                        },

                    ],
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
                columns: [{
                        text: "Backlog",
                        dataField: "backlog"
                    },
                    {
                        text: "Sent Apply",
                        dataField: "sent_apply"
                    },
                    {
                        text: "Sent Reminder",
                        dataField: "sent_reminder"
                    },
                    {
                        text: "No Response",
                        dataField: "no_response"
                    },
                    {
                        text: "Pending Task",
                        dataField: "pending_task"
                    },
                    {
                        text: "First Interview",
                        dataField: "first_interview"
                    },
                    {
                        text: "Second Interview",
                        dataField: "second_interview"
                    },
                    {
                        text: "Final Interview",
                        dataField: "final_interview"
                    },
                    {
                        text: "Rejection",
                        dataField: "rejection"
                    },
                ]
            });
        }
    </script>
@endpush
