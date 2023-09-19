@extends('layout.switcher')
@section('switcher')
    <section class="content">
        <div class="card card-primary">
            <div class="card-header">
                <h3 class="card-title">
                    Import companies dataset form excel sheet
                </h3>
            </div>
            <form action="{{ route('panel.companies.excel.store') }}" id="createForm" method="POST"
                enctype="multipart/form-data">
                @csrf
                {{ method_field('POST') }}
                <div class="card-body">
                    <div class="row align-items-center">
                        <div class="form-group col-6">
                            <label for="importFile">Excel File <span class="text-danger">*</span></label>
                            <input type="file" id="importFile" class="form-control" name="excel_file"
                                accept=".xlsx, .xls, .csv" required>
                            <small class="text-primary">Max: 30Mb | .xlsx, .xls, .csv</small>
                        </div>
                        <div class="form-group col-6 text-right">
                            <button type="submit" class="btn btn-success">
                                Import
                            </button>
                        </div>
                    </div>
                    <div class="create-status"></div>
                </div>
                <hr>
                <div>
                    <h5 class="text-center font-weight-bold">Sheet Columns Sample</h5>
                    <table class="sample-table table text-center">
                        <thead>
                            <th>Name</th>
                            <th>Phone</th>
                            <th>Email</th>
                            <th>Industry</th>
                            <th>Job Title</th>
                            <th>Job Description</th>
                            <th>Job Salary</th>
                            <th>Hr Name</th>
                            <th>Hr Email</th>
                            <th>Website</th>
                        </thead>
                        <tbody>
                            <td>Required</td>
                            <td>Required</td>
                            <td>Not Required</td>
                            <td>Not Required</td>
                            <td>Not Required</td>
                            <td>Not Required</td>
                            <td>Not Required</td>
                            <td>Not Required</td>
                            <td>Not Required</td>
                            <td>Not Required</td>
                        </tbody>
                    </table>
                </div>
            </form>
        </div>
    </section>
@endsection
