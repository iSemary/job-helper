@extends('layout.switcher')
@section('switcher')
    <div class="generator-page cover-letter">
        <div class="row">
            <div class="col-8">
                <div>
                    <h5 for="">Generated Cover Letter</h5>
                    <textarea name="generated_cover_letter" id="coverLetterContent"></textarea>
                </div>
                <br />
                <div>
                    <h5 for="">GPT Prompt Text</h5>
                    <textarea name="prompt" class="form-control" placeholder="Enter job GPT prompt text" cols="30" rows="10"></textarea>
                </div>
            </div>
            <div class="col-4">
                <div>
                    <button class="btn btn-sm btn-danger" type="button">Clear</button>
                    <button class="btn btn-sm btn-success" type="button">Download</button>
                </div>
                <div class="my-2">
                    <button class="btn btn-sm btn-primary w-100" type="button" data-toggle="collapse"
                        data-target="#collapseFileName" aria-expanded="false" aria-controls="collapseFileName">
                        File Name <i class="fas fa-sort-down"></i>
                    </button>
                    <div class="collapse" id="collapseFileName">
                        <div class="card card-body p-2">
                            <input name="file_name" class="form-control font-12" placeholder="Enter file name"
                                value="COVER_LETTER_FOR_" />
                        </div>
                    </div>
                </div>
                <div class="my-2">
                    <button class="btn btn-sm btn-primary w-100" type="button" data-toggle="collapse"
                        data-target="#collapseCompanyName" aria-expanded="false" aria-controls="collapseCompanyName">
                        Company Name <i class="fas fa-sort-down"></i>
                    </button>
                    <div class="collapse" id="collapseCompanyName">
                        <div class="card card-body p-2">
                            <input name="company_name" class="form-control font-12" placeholder="Enter company name"
                                value="" />
                        </div>
                    </div>
                </div>
                <div class="my-2">
                    <button class="btn btn-sm btn-primary w-100" type="button" data-toggle="collapse"
                        data-target="#collapseJobTitle" aria-expanded="false" aria-controls="collapseJobTitle">
                        Job Title <i class="fas fa-sort-down"></i>
                    </button>
                    <div class="collapse" id="collapseJobTitle">
                        <div class="card card-body p-2">
                            <input name="job_title" class="form-control" placeholder="Enter job title" />
                        </div>
                    </div>
                </div>
                <div class="my-2">
                    <button class="btn btn-sm btn-primary w-100" type="button" data-toggle="collapse"
                        data-target="#collapseJobDescription" aria-expanded="false" aria-controls="collapseJobDescription">
                        Job Description <i class="fas fa-sort-down"></i>
                    </button>
                    <div class="collapse" id="collapseJobDescription">
                        <div class="card card-body p-2">
                            <textarea name="job_description" class="form-control" placeholder="Enter job description content" id=""
                                cols="30" rows="10"></textarea>
                        </div>
                    </div>
                </div>
                <div class="my-2">
                    <button class="btn btn-sm btn-warning w-100" type="button" data-toggle="collapse"
                        data-target="#collapseJobTitle" aria-expanded="false" aria-controls="collapseJobTitle">
                        <i class="fas fa-save"></i> Save Cover Letter
                    </button>
                </div>
                <hr>
                <div class="my-2">
                    <h5 class="text-dark"><i class="fas fa-info-circle"></i> Cover Letter Status</h5>
                    <ul class="form-status">
                        <li class="text-success"><i class="fas fa-check-circle"></i> Your Info</li>
                        <li class="text-warning"><i class="fas fa-exclamation-triangle"></i> Job Title</li>
                        <li class="text-warning"><i class="fas fa-exclamation-triangle"></i> File Name</li>
                        <li class="text-success"><i class="fas fa-check-circle"></i> Job Description</li>
                    </ul>
                </div>
            </div>
        </div>
    </div>
@endsection

@push('extra-scripts')
    <script>
        CKEDITOR.replace('coverLetterContent', {
            toolbar: [{
                    name: 'clipboard',
                    items: ['Cut', 'Copy', 'Paste', 'Undo', 'Redo']
                },
                {
                    name: 'basicstyles',
                    items: ['Bold', 'Italic', 'Underline', 'Strike', 'RemoveFormat']
                },
                {
                    name: 'paragraph',
                    items: ['NumberedList', 'BulletedList', '-', 'Blockquote']
                },
                {
                    name: 'styles',
                    items: ['Styles', 'Format']
                },
                {
                    name: 'insert',
                    items: ['Image', 'Link', 'Table', 'HorizontalRule']
                },
                {
                    name: 'tools',
                    items: ['Maximize']
                }
            ]
        });
    </script>
@endpush
