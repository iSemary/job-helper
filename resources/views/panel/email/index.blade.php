@extends('layout.switcher')
@section('switcher')
    <div class="apply-page">
        <div class="container-fluid">
            <div class="row">
                <div class="col-md-3">
                    <div class="card">
                        <div class="card-header text-center">
                            <h3 class="card-title">Email Status</h3>
                        </div>
                        <div class="card-body p-0">
                            <div class="mx-2">
                                <ul class="form-status">
                                    <li class="text-{{ isset($emailCredentials) ? 'success' : 'warning' }}"
                                        id="emailCredentialsStatus">
                                        <i
                                            class="fas fa-{{ isset($emailCredentials) ? 'check-circle' : 'exclamation-triangle' }}"></i>
                                        Email Credentials
                                    </li>
                                    <li class="text-{{ isset($userInfo) && $userInfo->resume ? 'success' : 'warning' }}"
                                        id="resumeStatus">
                                        <i
                                            class="fas fa-{{ isset($userInfo) && $userInfo->resume ? 'check-circle' : 'exclamation-triangle' }}"></i>
                                        Resume
                                    </li>
                                    <li class="text-warning" id="coverLetterStatus">
                                        <i class="fas fa-exclamation-triangle"></i>
                                        Cover Letter
                                    </li>
                                    <li class="text-warning" id="emailMessageStatus">
                                        <i class="fas fa-exclamation-triangle"></i>
                                        Email Message
                                    </li>
                                </ul>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="col-md-9">
                    <form method="POST" action="{{ route('panel.email.send') }}" id="emailForm"
                        enctype="multipart/form-data">
                        @csrf
                        {{ method_field('POST') }}
                        <div class="card card-primary card-outline">
                            <div class="card-body">
                                @if (isset($companies))
                                    <div class="row">
                                        <div class="form-group col-6 company-selector mb-2">
                                            <select name="company_id" class="form-control" id="companySelector">
                                                <option value="">Select Company</option>
                                                @foreach ($companies as $company)
                                                    <option value="{{ $company->id }}"
                                                        data-route-url="{{ route('panel.companies.show', $company->id) }}">
                                                        {{ $company->name }}
                                                    </option>
                                                @endforeach
                                            </select>
                                        </div>
                                        <div class="form-group col-6 cover-letter-selector mb-2">
                                            <select name="cover_letter_id" class="form-control" id="coverLetterSelector">
                                                <option value="">Select Cover Letter</option>
                                            </select>
                                        </div>
                                    </div>
                                @else
                                    <input type="hidden" id="companyId" name="company_id" value="">
                                @endif
                                <input type="hidden" id="coverLetterId" name="cover_letter_id" value="">
                                <input type="hidden" id="emailMessageId" name="email_message_id" value="">
                                <div class="form-group">
                                    <input class="form-control" name="to_address" id="toAddressInput" type="email"
                                        placeholder="To:" required>
                                </div>
                                <div class="form-group">
                                    <input class="form-control" name="subject" id="subjectInput" placeholder="Subject:"
                                        required>
                                </div>
                                <div class="form-group">
                                    <textarea id="emailMessageContent" name="message" class="form-control"></textarea>
                                </div>
                                <div class="form-group">
                                    <div class="">
                                        <label for="file-input" class="btn btn-sm btn-secondary attachments-input-label">
                                            <i class="fas fa-file-upload"></i> Add Attachments
                                        </label>
                                        <input type="file" id="file-input" accept=".pdf, .doc, .docx" name="attachments"
                                            multiple>
                                    </div>
                                    <div class="text-primary font-12">Max. 5MB | .pdf, .doc, .docx</div>
                                    <hr />
                                    <div class="list-attachments">
                                        <small class="mx-2 mb-2">
                                            Attachments
                                        </small>
                                        <ul id="attachmentsList">
                                            @if (isset($userInfo) && $userInfo->resume)
                                                <li class="resume-attachment">
                                                    <a href="#" data-file-url="{{ $userInfo->resume }}"
                                                        class="text-primary view-file">
                                                        <b><i class="fas fa-paperclip"></i> Resume: </b>
                                                        {{ $userInfo->resume_file_name }}
                                                    </a>
                                                </li>
                                            @endif
                                            <li class="cover-letter-attachment"></li>

                                        </ul>
                                    </div>
                                </div>
                            </div>
                            <div class="card-footer">
                                <div class="row">
                                    <div class="col-6">
                                        <div class="email-status"></div>
                                    </div>
                                    <div class="col-6 text-right">
                                        <button type="submit" id="previewMail" class="btn btn-sm btn-success">
                                            <i class="far fa-envelope"></i>
                                            Send
                                        </button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
            <hr>
            <div class="preview-email" id="previewEmail">

            </div>
        </div>
    </div>
@endsection

@push('extra-scripts')
    <script>
        // CKeditor Email; Content
        var emailContent = CKEDITOR.replace('emailMessageContent', {
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


        emailContent.on('change', function() {
            if (emailContent.getData() == '') {
                $("#sendMail, #previewMail").prop("disabled", true);
                switchWarningStatus("#emailMessageStatus")
            } else {
                $("#sendMail, #previewMail").prop("disabled", false);
                switchSuccessStatus("#emailMessageStatus")
            }
        });



        // change cover letter
        $(document).on("change", "#coverLetterSelector", function(e) {
            let coverLetterId = $(this).val();
            if (coverLetterId == "") {
                clearCoverLetterAttachment();
                switchWarningStatus("#coverLetterStatus");
                return false;
            }

            let coverLetter = [];
            coverLetter.file_path = $("#coverLetterSelector option:selected").attr("data-file-path");
            coverLetter.file_name = $("#coverLetterSelector option:selected").attr("data-file-name");
            coverLetter.original_file_name = $("#coverLetterSelector option:selected").html();

            appendCoverLetterAttachment(coverLetter);

        });
        // fetch company details AJAX call
        $(document).on("change", "#companySelector", function(e) {
            let companyId = $(this).val();
            if (companyId == "") {
                clearCoverLetterAttachment();
                switchWarningStatus("#coverLetterStatus");
                return false;
            }
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
                        $("#companyId").val(data.company.id);
                        if (data.company.hr_email) {
                            $("#toAddressInput").val(data.company.hr_email);
                        } else {
                            if (data.company.email) {
                                $("#toAddressInput").val(data.company.email);
                            }
                        }

                        if (data.company.motivation_message) {
                            emailContent.setData(data.company.motivation_message.content);
                            $("#emailMessageId").val(data.company.motivation_message.id)
                        }

                        if (data.company.job_title) {
                            $("#subjectInput").val("Apply to " + data.company.job_title);
                        }

                        if (data.company.cover_letters && data.company.cover_letters[0]) {
                            $("#coverLetterId").val(data.company.cover_letters[0].id);
                            switchSuccessStatus("#coverLetterStatus");
                            appendCoverLetterAttachment(data.company.cover_letters[0]);

                            $('#coverLetterSelector option:not(:first-child)').remove();

                            $.map(data.company.cover_letters, function(coverLetter, index) {
                                $('#coverLetterSelector').append(
                                    `<option ${index == 0 ? "selected" : ""}
                                    data-file-path="${coverLetter.file_path}"
                                    data-file-name="${coverLetter.file_name}"
                                    value="${coverLetter.id}">#${coverLetter.id} ${coverLetter.original_file_name}</option>`
                                );
                            });

                        } else {
                            switchWarningStatus("#coverLetterStatus");
                            $('#coverLetterSelector option:not(:first-child)').remove();
                            clearCoverLetterAttachment();
                        }


                    } else {
                        $("#companyId, #coverLetterId, #emailMessageId").val("");
                    }
                },
            });
        });

        function appendCoverLetterAttachment(coverLetter) {
            $(".cover-letter-attachment").html(
                `<a href="#" data-file-url="${coverLetter.file_path}" class="text-primary view-file"><b><i class="fas fa-paperclip"></i> Cover Letter: </b>${coverLetter.original_file_name}</a>`
            );
        }

        function clearCoverLetterAttachment() {
            $(".cover-letter-attachment").html("");
        }

        $(document).on("submit", "#emailForm", function(e) {
            e.preventDefault();
            let formBtn = $(this).find(":submit");
            let formData = new FormData(this);
            let formID = "#" + $(this).attr("id");
            let formUrl = $(this).attr("action");

            $.ajax({
                type: "POST",
                dataType: "json",
                url: formUrl,
                data: formData,
                cache: false,
                contentType: false,
                processData: false,
                beforeSend: function() {
                    waitingLoad();
                    $(".email-status").html(
                        `<h6 class="text-muted"><i class="fas fa-circle-notch fa-spin"></i> Updating, please wait...</h6>`
                    );
                    formBtn.prop("disabled", true);
                },
                success: function(data) {
                    normalLoad();
                    $(".email-status").html(
                        `<h6 class="text-success"><i class="fas fa-check-circle"></i> ${data.message}</h6>`
                    );
                    formBtn.prop("disabled", false);
                },
                error: function(xhr) {
                    errorLoad();
                    $(".email-status").html("");
                    formBtn.prop("disabled", false);
                    $(".email-status").html(
                        `<h6 class="text-danger" style="max-width:70vw;"><i class="fas fa-exclamation-triangle"></i> ` +
                        JSON.stringify(xhr) + `</h6>`
                    );
                },
            });
        });
    </script>
@endpush
