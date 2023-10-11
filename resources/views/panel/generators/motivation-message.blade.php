@extends('layout.switcher')
@section('switcher')
    <div class="generator-page">
        <div class="row">
            <div class="col-8">
                <div>
                    <h5 for="">Generated Message</h5>
                    <textarea name="generated_message" id="messageContent"></textarea>
                </div>
                <br />
                <div>
                    <h5 for="">GPT Prompt Text</h5>
                    <textarea name="prompt" id="prompt" class="form-control" placeholder="Enter job GPT prompt text" cols="30"
                        rows="10">Draft a motivational email message in "html format" and just send the email message body only, using the following variables to send to a prospective employer when applying for the [Job Title] position at [Company Name], and job description [Job Description].
                        Your email should convey your enthusiasm for the role, showcase your relevant skills, and explain why you are the ideal candidate for the job.
                        
                        Ensure that your email maintains a professional and engaging tone to leave a lasting impression on the employer.</textarea>
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
                        <button class="btn btn-sm btn-danger col-6" id="clearInputs" type="button">Clear</button>
                        <button class="btn btn-sm btn-purple col-6" id="generateMessage" type="button"><i
                                class="fas fa-magic"></i> Generate</button>
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
                    <button class="btn btn-sm btn-warning w-100" type="button" id="saveMessage" disabled>
                        <i class="fas fa-save"></i> Save Message
                    </button>
                </div>
                <h6 class="message-status"></h6>
                <hr>
                <div class="my-2">
                    <h5 class="text-dark">Message Status</h5>
                    <ul class="form-status">
                        <li class="text-{{ $userInfo ? 'success' : 'warning' }}"><i
                                class="fas fa-{{ $userInfo ? 'check-circle' : 'exclamation-triangle' }}"></i> Your Info
                        </li>
                        <li class="text-warning" id="companyNameStatus"><i class="fas fa-exclamation-triangle"></i>
                            Company Name</li>
                        <li class="text-warning" id="jobTitleStatus"><i class="fas fa-exclamation-triangle"></i> Job
                            Title
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
        // CKeditor message Content
        var messageContent = CKEDITOR.replace('messageContent', {
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
        // Check Status of companyName, jobTitle, jobDescription
        $(document).on("change keyup paste", "#jobDescription, #jobTitle, #companyName", function(e) {
            let statusSpan = "#" + $(this).attr('id') + "Status";
            if ($(this).val() == "") {
                switchWarningStatus(statusSpan);
            } else {
                switchSuccessStatus(statusSpan);
            }
        });
        // Clear Inputs 
        $(document).on("click", "#clearInputs", function(e) {
            messageContent.setData('');
            $("#companySelector").val("");
            $("#jobDescription, #jobTitle, #companyName, #MessageContent").val("");
            switchWarningStatus("#jobDescriptionStatus, #jobTitleStatus, #companyNameStatus");
        });

        // Save Message 
        $(document).on("click", "#saveMessage", function(e) {
            let companyId = $("#companySelector").val();
            let prompt = $("#prompt").val();
            let fileContent = messageContent.getData();
            let type = `{{ $type }}`;
            $.ajax({
                url: `{{ route('panel.generator.message.save') }}`,
                method: "POST",
                data: {
                    company_id: companyId,
                    prompt: prompt,
                    content: fileContent,
                    type: type,
                    _token: csrfToken,
                },
                dataType: "json",
                beforeSend: function() {
                    waitingLoad();
                    $(".message-status").html(
                        `<h6 class="text-muted"><i class="fas fa-circle-notch fa-spin"></i> Saving your message...<h6/>`
                    );
                },
                success: function(response) {
                    normalLoad();
                    $(".message-status").html(
                        `<h6 class="text-success"><i class="fas fa-check-circle"></i> Message saved successfully.</h6>`
                    );
                },
                error: function(data) {
                    errorLoad();
                    console.log(data);
                }
            });
        });

        // Listen message Changes 
        messageContent.on('change', function() {
            if (messageContent.getData() == '') {
                $("#saveMessage").prop("disabled", true);
            } else {
                $("#saveMessage").prop("disabled", false);
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
                    }
                },
            });
        });
        // Generate button listener
        $(document).on("click", "#generateMessage", function(e) {
            generateMessage(
                $("#companySelector").val(),
                $("#companyName").val(),
                $("#jobTitle").val(),
                $("#jobDescription").val(),
                $("#prompt").val(),
            );
        });

        // Generate message
        function generateMessage(companyId, companyName, jobTitle, jobDescription, prompt) {
            $("#generateMessage").prop("disabled", true);
            $.ajax({
                url: `{{ route('panel.generator.generate') }}`,
                method: "POST",
                data: {
                    company_id: companyId,
                    company_name: companyName,
                    job_title: jobTitle,
                    job_description: jobDescription,
                    prompt: prompt,
                    _token: csrfToken,
                },
                dataType: "json",
                beforeSend: function() {
                    waitingLoad();
                    messageContent.setData("Waiting for GPT to get a response, please wait...");
                },
                success: function(response) {
                    normalLoad();
                    $("#generateMessage").prop("disabled", false);
                    messageContent.setData(response.data.data.response);
                },
                error: function(data) {
                    errorLoad();
                    $("#generateMessage").prop("disabled", false);
                }
            });
        }
    </script>
@endpush
