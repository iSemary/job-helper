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
                <div class="company-selector mb-2">
                    <select name="company_id" class="form-control" id="companySelector">
                        <option value="">Select Company</option>
                        @foreach ($companies as $company)
                            <option value="{{ $company->id }}"
                                data-route-url="{{ route('panel.companies.show', $company->id) }}">{{ $company->name }}
                            </option>
                        @endforeach
                    </select>
                </div>
                <hr>
                <div>
                    <div class="row w-100 mx-0 px-0">
                        <button class="btn btn-sm btn-danger col-2" id="clearInputs" type="button">Clear</button>
                        <button class="btn btn-sm btn-success col-4" disabled id="downloadFile"
                            type="button">Download</button>
                        <button class="btn btn-sm btn-purple col-6" id="generateCoverLetter" type="button"><i
                                class="fas fa-magic"></i> Generate</button>
                    </div>
                </div>
                <div class="my-2">
                    <button class="btn btn-sm btn-outline-info w-100" type="button" data-toggle="collapse"
                        data-target="#collapseFileName" aria-expanded="false" aria-controls="collapseFileName">
                        File Name <i class="fas fa-sort-down"></i>
                    </button>
                    <div class="collapse" id="collapseFileName">
                        <div class="card card-body p-2">
                            <input name="file_name" class="form-control font-12" id="fileName"
                                placeholder="Enter file name" value="COVER_LETTER_FOR_" />
                        </div>
                    </div>
                </div>
                <div class="my-2">
                    <button class="btn btn-sm btn-outline-info w-100" type="button" data-toggle="collapse"
                        data-target="#collapseCompanyName" aria-expanded="false" aria-controls="collapseCompanyName">
                        Company Name <i class="fas fa-sort-down"></i>
                    </button>
                    <div class="collapse" id="collapseCompanyName">
                        <div class="card card-body p-2">
                            <input name="company_name" class="form-control font-12" id="companyName"
                                placeholder="Enter company name" value="" />
                        </div>
                    </div>
                </div>
                <div class="my-2">
                    <button class="btn btn-sm btn-outline-info w-100" type="button" data-toggle="collapse"
                        data-target="#collapseJobTitle" aria-expanded="false" aria-controls="collapseJobTitle">
                        Job Title <i class="fas fa-sort-down"></i>
                    </button>
                    <div class="collapse" id="collapseJobTitle">
                        <div class="card card-body p-2">
                            <input name="job_title" class="form-control" id="jobTitle" placeholder="Enter job title" />
                        </div>
                    </div>
                </div>
                <div class="my-2">
                    <button class="btn btn-sm btn-outline-info w-100" type="button" data-toggle="collapse"
                        data-target="#collapseJobDescription" aria-expanded="false" aria-controls="collapseJobDescription">
                        Job Description <i class="fas fa-sort-down"></i>
                    </button>
                    <div class="collapse" id="collapseJobDescription">
                        <div class="card card-body p-2">
                            <textarea name="job_description" class="form-control" placeholder="Enter job description content" id="jobDescription"
                                cols="30" rows="10"></textarea>
                        </div>
                    </div>
                </div>
                <div class="my-2">
                    <button class="btn btn-sm btn-warning w-100" type="button" id="saveLetter" disabled>
                        <i class="fas fa-save"></i> Save Cover Letter
                    </button>
                </div>
                <hr>
                <div class="my-2">
                    <h5 class="text-dark"><i class="fas fa-info-circle"></i> Cover Letter Status</h5>
                    <ul class="form-status">
                        <li class="text-{{ $userInfo ? 'success' : 'warning' }}"><i
                                class="fas fa-{{ $userInfo ? 'check-circle' : 'exclamation-triangle' }}"></i> Your Info
                        </li>
                        <li class="text-warning" id="companyNameStatus"><i class="fas fa-exclamation-triangle"></i>
                            Company Name</li>
                        <li class="text-warning" id="jobTitleStatus"><i class="fas fa-exclamation-triangle"></i> Job
                            Title
                        </li>
                        <li class="text-warning" id="fileNameStatus"><i class="fas fa-exclamation-triangle"></i> File
                            Name
                        </li>
                        <li class="text-warning" id="jobDescriptionStatus"><i class="fas fa-exclamation-triangle"></i>
                            Job Description</li>
                    </ul>
                </div>
            </div>
        </div>
    </div>
@endsection

@push('extra-scripts')
    <script>
        // CKeditor Cover Letter Content
        var coverLetterContent = CKEDITOR.replace('coverLetterContent', {
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
                    name: 'insert',
                    items: ['Link', 'HorizontalRule']
                },
                {
                    name: 'tools',
                    items: ['Maximize']
                },

                {
                    name: 'styles',
                    items: ['Styles', 'Format']
                },
            ]
        });
        // Check Status of fileName, companyName, jobTitle, jobDescription
        $(document).on("change keyup paste", "#fileName, #jobDescription, #jobTitle, #companyName", function(e) {
            let statusSpan = "#" + $(this).attr('id') + "Status";
            if ($(this).val() == "") {
                switchWarningStatus(statusSpan);
            } else {
                switchSuccessStatus(statusSpan);
            }
        });
        // Clear Inputs 
        $(document).on("click", "#clearInputs", function(e) {
            coverLetterContent.setData('');
            $("#companySelector").val("");
            $("#fileName, #jobDescription, #jobTitle, #companyName, #coverLetterContent").val("");
            switchWarningStatus("#fileNameStatus, #jobDescriptionStatus, #jobTitleStatus, #companyNameStatus");
        });

        // Download File 
        $(document).on("click", "#downloadFile", function(e) {
            let fileName = $("#fileName").val() + ".pdf";
            let companyId = $("#companySelector").val();
            let fileContent = coverLetterContent.getData()
            $.ajax({
                url: `{{ route('panel.generator.cover-letter.download') }}`,
                method: "POST",
                data: {
                    company_id: companyId,
                    file_name: fileName,
                    file_content: fileContent,
                    _token: csrfToken,
                },
                dataType: "json",
                success: function(response) {
                    if (response.file_url) {
                        var downloadLink = document.createElement('a');
                        downloadLink.href = response
                            .file_url;
                        downloadLink.download = fileName;
                        downloadLink.style.display = 'none';
                        document.body.appendChild(downloadLink);
                        downloadLink.click();
                        document.body.removeChild(downloadLink);
                    } else {
                        // Handle errors here
                        alert("File generation failed.");
                    }
                },
                error: function(data) {
                    console.log(data);
                }
            });
        });

        // Listen Cover Letter Changes 
        coverLetterContent.on('change', function() {
            if (coverLetterContent.getData() == '') {
                $("#downloadFile, #saveLetter").prop("disabled", true);
            } else {
                $("#downloadFile, #saveLetter").prop("disabled", false);
            }
        });

        // fetch company details AJAX call
        $(document).on("change", "#companySelector", function(e) {
            let companyId = $(this).val();
            if (companyId == "") return false;
            // fetch company details route
            let routeUrl = $("#companySelector option:selected").attr("data-route-url");
            $.ajax({
                type: "GET",
                dataType: "json",
                url: routeUrl,
                data: {
                    company_id: companyId
                },
                cache: false,
                contentType: false,
                processData: false,
                beforeSend: function() {},
                success: function(data) {
                    if (data.company) {
                        if (data.company.name) {
                            $("#companyName").val(data.company.name);
                            switchSuccessStatus("#companyNameStatus");
                        } else {
                            switchWarningStatus("#companyNameStatus");
                        }
                        if (data.company.job_title) {
                            $("#jobTitle").val(data.company.job_title);
                            switchSuccessStatus("#jobTitleStatus");
                        } else {
                            switchWarningStatus("#jobTitleStatus");
                        }
                        if (data.company.job_description) {
                            $("#jobDescription").val(data.company.job_description);
                            switchSuccessStatus("#jobDescriptionStatus");
                        } else {
                            switchWarningStatus("#jobDescriptionStatus");
                        }
                        if (data.company.name) {
                            let fileCompanyName = (data.company.name).replaceAll(" ", "_")
                                .toUpperCase();
                            $("#fileName").val("COVER_LETTER_FOR_" + fileCompanyName);
                            switchSuccessStatus("#fileNameStatus");
                        } else {
                            switchWarningStatus("#fileNameStatus");
                        }

                    }
                },
            });
        });

        // Generate cover letter
        function generateCoverLetter(companyId, companyName, jobTitle, jobDescription, fileName) {


        }
    </script>
@endpush
