@extends('layout.switcher')
@section('switcher')
    <div class="apply-page">
        <div class="container-fluid">
            <div class="row">
                <div class="col-md-3">
                    <div class="card">
                        <div class="card-header">
                            <h3 class="card-title">Types</h3>
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
                    <form method="POST" action="" id="emailForm">
                        <div class="card card-primary card-outline">
                            <div class="card-body">
                                <div class="form-group">
                                    <input class="form-control" name="to_address[]" placeholder="To:" required>
                                </div>
                                <div class="form-group">
                                    <input class="form-control" name="subject" placeholder="Subject:" required>
                                </div>
                                <div class="form-group">
                                    <textarea id="emailMessageContent" class="form-control"></textarea>
                                </div>
                                <div class="form-group">
                                    <div class="">
                                        <label for="file-input" class="btn btn-sm btn-secondary attachments-input-label">
                                            <i class="fas fa-file-upload"></i> Add Attachments
                                        </label>
                                        <input type="file" id="file-input" accept=".pdf, .doc, .docx" multiple
                                            name="attachments">
                                    </div>
                                    <div class="text-primary font-12">Max. 5MB | .pdf, .doc, .docx</div>
                                    <hr />
                                    <div class="list-attachments">
                                        <small class="mx-2 mb-2">
                                            Attachments
                                        </small>
                                        <ul>
                                            @if (isset($userInfo) && $userInfo->resume)
                                                <li>
                                                    <a href="#" data-file-url="{{ $userInfo->resume }}" class="text-primary view-file">
                                                        <b><i class="fas fa-paperclip"></i> Resume: </b>
                                                        {{ $userInfo->resume_file_name }}
                                                    </a>
                                                </li>
                                            @endif
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
                                        <button type="button" id="sendMail" class="btn btn-sm btn-primary">
                                            <i class="far fa-envelope"></i>
                                            Preview
                                        </button>
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
    </script>
@endpush
