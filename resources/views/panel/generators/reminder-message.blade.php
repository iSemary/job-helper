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
                        rows="10">Generate a reminder email message in HTML format and ONLY write the body of the email, Based on the email I sent and didn’t get any response, and very interested in getting feedback, Applied email content : [Apply Mail]</textarea>
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
                        data-target="#collapseApplyMail" aria-expanded="false" aria-controls="collapseApplyMail">
                        Apply Mail <i class="fas fa-sort-down"></i>
                    </button>
                    <div class="collapse" id="collapseApplyMail">
                        <div class="card card-body p-2">
                            <textarea name="apply_mail" class="form-control" placeholder="Enter applied mail content" id="applyMail" cols="30"
                                rows="10"></textarea>
                        </div>
                    </div>
                </div>
                <div class="my-2">
                    <button class="btn btn-sm btn-outline-info w-100" type="button" data-toggle="collapse"
                        data-target="#collapseReminderSubject" aria-expanded="false"
                        aria-controls="collapseReminderSubject">
                        Reminder Subject <i class="fas fa-sort-down"></i>
                    </button>
                    <div class="collapse" id="collapseReminderSubject">
                        <div class="card card-body p-2">
                            <input name="subject" class="form-control font-12" id="reminderSubject"
                                placeholder="Enter reminder email subject" value="" />
                        </div>
                    </div>
                </div>
                <div class="my-2">
                    <button class="btn btn-sm btn-outline-info w-100" type="button" data-toggle="collapse"
                        data-target="#collapseReminderEmail" aria-expanded="false" aria-controls="collapseReminderEmail">
                        To Address <i class="fas fa-sort-down"></i>
                    </button>
                    <div class="collapse" id="collapseReminderEmail">
                        <div class="card card-body p-2">
                            <input name="to_address" class="form-control font-12" id="reminderEmail"
                                placeholder="Enter reminder email to address" value="" />
                        </div>
                    </div>
                </div>
                <div class="my-2">
                    <div class="row">
                        <div class="col-6 pe-0">
                            <button class="btn btn-sm btn-primary w-100" type="button" id="sendReminder" disabled>
                                <i class="fas fa-paper-plane"></i> Send Reminder
                            </button>
                        </div>
                        <div class="col-6 ps-0">
                            <button class="btn btn-sm btn-warning w-100" type="button" id="saveMessage" disabled>
                                <i class="fas fa-save"></i> Save Message
                            </button>
                        </div>
                    </div>
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
                        <li class="text-warning" id="applyMailStatus"><i class="fas fa-exclamation-triangle"></i>
                            Apply Mail</li>
                    </ul>
                </div>
            </div>
        </div>
    </div>
@endsection

@push('extra-scripts')
    <script>
        let type = `{{ $type }}`;
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
        $(document).on("change keyup paste", "#applyMail, #companyName", function(e) {
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
            $("#applyMail, #companyName, #MessageContent").val("");
            switchWarningStatus("#applyMailStatus, #companyNameStatus");
        });

        // Save Message 
        $(document).on("click", "#saveMessage", function(e) {
            let companyId = $("#companySelector").val();
            let prompt = $("#prompt").val();
            let fileContent = messageContent.getData();
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

        // Save Message 
        $(document).on("click", "#sendReminder", function(e) {
            let btn = $(this);
            let companyId = $("#companySelector").val();
            let reminderSubject = $("#reminderSubject").val();
            let reminderEmail = $("#reminderEmail").val();
            let fileContent = messageContent.getData();
            $.ajax({
                url: `{{ route('panel.email.sendReminder') }}`,
                method: "POST",
                data: {
                    company_id: companyId,
                    to_address: reminderEmail,
                    subject: reminderSubject,
                    message: fileContent,
                    _token: csrfToken,
                },
                dataType: "json",
                beforeSend: function() {
                    btn.prop("disabled", true);
                    waitingLoad();
                    $(".message-status").html(
                        `<h6 class="text-muted"><i class="fas fa-circle-notch fa-spin"></i> Sending your reminder email...<h6/>`
                    );
                },
                success: function(response) {
                    btn.prop("disabled", false);
                    normalLoad();
                    $(".message-status").html(
                        `<h6 class="text-success"><i class="fas fa-check-circle"></i> Reminder sent successfully.</h6>`
                    );
                },
                error: function(data) {
                    btn.prop("disabled", false);
                    errorLoad();
                    console.log(data);
                }
            });
        });
        // Listen message Changes 
        messageContent.on('change', function() {
            if (messageContent.getData() == '') {
                $("#saveMessage, #sendReminder").prop("disabled", true);
            } else {
                $("#saveMessage, #sendReminder").prop("disabled", false);
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
                beforeSend: function() {
                    waitingLoad();
                },
                success: function(data) {
                    normalLoad();
                    if (data.company) {
                        if (data.company.name) {
                            $("#companyName").val(data.company.name);
                            switchSuccessStatus("#companyNameStatus");
                        } else {
                            switchWarningStatus("#companyNameStatus");
                        }

                        if (data.company.hr_email) {
                            $("#reminderEmail").val(data.company.hr_email);
                        } else {
                            if (data.company.email) {
                                $("#reminderEmail").val(data.company.email);
                            }
                        }

                        if (data.company.job_title) {
                            $("#reminderSubject").val("Reminder to apply to " + data.company.job_title);
                        }

                        if (data.company.motivation_message) {
                            $("#applyMail").val(data.company.motivation_message.content);
                            switchSuccessStatus("#applyMailStatus");
                        } else {
                            switchWarningStatus("#applyMailStatus");
                        }
                    }
                },
                error: function() {
                    errorLoad();
                }
            });
        });
        // Generate button listener
        $(document).on("click", "#generateMessage", function(e) {
            generateMessage(
                $("#companySelector").val(),
                $("#companyName").val(),
                $("#applyMail").val(),
                $("#prompt").val(),
            );
        });

        // Generate message
        function generateMessage(companyId, companyName, applyMail, prompt) {
            $("#generateMessage").prop("disabled", true);
            $.ajax({
                url: `{{ route('panel.generator.generate') }}`,
                method: "POST",
                data: {
                    company_id: companyId,
                    company_name: companyName,
                    apply_mail: applyMail,
                    type: type,
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
