@extends('layout.switcher')
@section('switcher')
    <section class="content">
        <div class="card card-primary">
            <div class="card-header">
                <h3 class="card-title">
                    {{ isset($company) ? "Edit company [{$company->name}]" : 'Create new company record' }}
                </h3>
            </div>
            <form
                action="{{ isset($company) ? route('panel.companies.update', $company->id) : route('panel.companies.store') }}"
                id="{{ isset($company) ? 'editForm' : 'createForm' }}" method="POST">
                @csrf
                {{ method_field(isset($company) ? 'PUT' : 'POST') }}
                <div class="card-body">
                    <div class="row">
                        <div class="form-group col-md-4">
                            <label for="companyName">Name <span class="text-danger">*</span></label>
                            <input type="text" id="companyName" class="form-control" value="{{ $company->name ?? '' }}"
                                name="name" placeholder="Company name" required>
                        </div>
                        <div class="form-group col-md-4">
                            <label for="companyEmail">Email <span class="text-danger">*</span></label>
                            <input type="email" id="companyEmail" class="form-control" value="{{ $company->email ?? '' }}"
                                name="email" placeholder="Company email" required>
                        </div>
                        <div class="form-group col-md-4">
                            <label for="companyPhone">Phone</label>
                            <input type="text" id="companyPhone" class="form-control" value="{{ $company->phone ?? '' }}"
                                name="phone" placeholder="Company phone">
                        </div>
                    </div>
                    <div class="row">
                        <div class="form-group col-md-6">
                            <label for="companyHrName">Hr name</label>
                            <input type="text" id="companyHrName" class="form-control"
                                value="{{ $company->hr_name ?? '' }}" name="hr_name" placeholder="Company hr name">
                        </div>
                        <div class="form-group col-md-6">
                            <label for="companyHrEmail">Hr email</label>
                            <input type="email" id="companyHrEmail" class="form-control"
                                value="{{ $company->hr_email ?? '' }}" name="hr_email" placeholder="Company hr email">
                        </div>
                    </div>
                    <div class="row">
                        <div class="form-group col-md-4">
                            <label for="companyIndustry">Industry</label>
                            <input type="text" id="companyIndustry" class="form-control"
                                value="{{ $company->industry ?? '' }}" name="industry" placeholder="Company industry">
                        </div>
                        <div class="form-group col-md-4">
                            <label for="companyWebsite">Website</label>
                            <input type="url" id="companyWebsite" class="form-control"
                                value="{{ $company->website ?? '' }}" name="website" placeholder="Company website">
                        </div>
                        <div class="form-group col-md-4">
                            <label for="companyExpectedSalary">Job Expected salary</label>
                            <input type="number" id="companyExpectedSalary" class="form-control"
                                value="{{ $company->job_salary ?? '' }}" name="job_salary"
                                placeholder="Job expected salary">
                        </div>
                    </div>
                    <div class="row">
                        <div class="form-group col-md-4">
                            <label for="companyJobTitle">Job Title</label>
                            <input type="text" id="companyJobTitle" class="form-control"
                                value="{{ $company->job_title ?? '' }}" name="job_title" placeholder="Company job title">
                        </div>
                        <div class="form-group col-md-8">
                            <label for="companyJobDescription">Job Description</label>
                            <textarea name="job_description" placeholder="Company job description" class="form-control" id="companyJobDescription"
                                cols="30" rows="10">{{ $company->job_description ?? '' }}</textarea>
                        </div>
                    </div>
                    <div class="{{ isset($company) ? 'edit' : 'create' }}-status"></div>
                </div>
                <div class="card-footer">
                    <button type="submit" class="btn btn-{{ isset($company) ? 'primary' : 'success' }}">
                        {{ isset($company) ? 'Update' : 'Create' }}
                    </button>
                </div>
            </form>
        </div>
    </section>
@endsection
