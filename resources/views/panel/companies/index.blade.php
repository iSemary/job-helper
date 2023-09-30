@extends('layout.switcher')
@section('switcher')
    <div class="companies-page">
        <div class="card">
            <div class="card-header">
                <div class="row">
                    <div class="col-6">
                        <h5><i class="fas fa-database"></i> Companies Dataset</h5>
                    </div>
                    <div class="col-6 text-right">
                        <button class="btn btn-sm btn-success open-modal-btn" data-url={{ route('panel.companies.create') }}
                            type="button">Create</button>
                        <button class="btn btn-sm btn-outline-success open-modal-btn"
                            data-url={{ route('panel.companies.excel.import') }} type="button">Import Excel</button>
                    </div>
                </div>
            </div>
            <div class="card-body">
                <table id="companies" class="display compact" style="width: 100%;">
                    <thead>
                        <tr>
                            <th>Name</th>
                            <th>Phone</th>
                            <th>Email</th>
                            <th>Status</th>
                            <th>Industry</th>
                            <th>Job Title</th>
                            <th>Job Salary</th>
                            <th>Action</th>
                            <th>Job Description</th>
                            <th>Hr Name</th>
                            <th>Hr Email</th>
                            <th>Website</th>
                            <th>Created At</th>
                        </tr>
                    </thead>
                    <tbody></tbody>
                    <tfoot>
                        <tr>
                            <th>Name</th>
                            <th>Phone</th>
                            <th>Email</th>
                            <th>Status</th>
                            <th>Industry</th>
                            <th>Job Title</th>
                            <th>Job Salary</th>
                            <th>Action</th>
                            <th>Job Description</th>
                            <th>Hr Name</th>
                            <th>Hr Email</th>
                            <th>Website</th>
                            <th>Created At</th>
                        </tr>
                    </tfoot>
                </table>
            </div>
        </div>
    </div>
@endsection

@push('extra-scripts')
    <script>
        $(document).ready(function() {
            if (typeof companyCols == 'undefined') {
                var companyCols = [{
                        data: 'name',
                        name: 'name'
                    },
                    {
                        data: 'phone',
                        name: 'phone'
                    },
                    {
                        data: 'email',
                        name: 'email',
                    },
                    {
                        data: 'status',
                        name: 'status',
                    },
                    {
                        data: 'industry',
                        name: 'industry'
                    },
                    {
                        data: 'job_title',
                        name: 'job_title'
                    },
                    {
                        data: 'job_salary',
                        name: 'job_salary',
                    },
                    {
                        data: 'action',
                        name: 'action',
                        orderable: false,
                        searchable: false
                    },
                    {
                        data: 'job_description',
                        name: 'job_description'
                    },
                    {
                        data: 'hr_name',
                        name: 'hr_name'
                    },
                    {
                        data: 'hr_email',
                        name: 'hr_email',
                    },
                    {
                        data: 'website',
                        name: 'website'
                    },
                    {
                        data: 'created_at',
                        name: 'created_at'
                    }
                ];
            }
            filterTable("{!! route('panel.companies.index') !!}", '#companies', null, null, true, companyCols);
        });
    </script>
@endpush
