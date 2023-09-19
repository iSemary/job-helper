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
                            <ul class="nav nav-pills flex-column">
                                <li class="nav-item">
                                    <a href="#" class="nav-link">
                                        <i class="far fa-envelope"></i> Sent
                                    </a>
                                </li>
                                <li class="nav-item">
                                    <a href="#" class="nav-link">
                                        <i class="far fa-file-alt"></i> Schedule
                                    </a>
                                </li>
                                <li class="nav-item">
                                    <a href="#" class="nav-link">
                                        <i class="far fa-file-alt"></i> Drafts
                                    </a>
                                </li>
                            </ul>
                            <hr>
                            <div class="mx-2">
                                <ul class="form-status">
                                    <li class="text-warning" id="jobTitleStatus"><i class="fas fa-exclamation-triangle"></i>
                                        Email Credentials</li>

                                    <li class="text-warning" id="jobTitleStatus"><i class="fas fa-exclamation-triangle"></i>
                                        Resume</li>
                                    <li class="text-warning" id="companyNameStatus"><i
                                            class="fas fa-exclamation-triangle"></i> Cover Letter</li>
                                    <li class="text-warning" id="companyNameStatus"><i
                                            class="fas fa-exclamation-triangle"></i> Email Message</li>
                                </ul>
                            </div>
                            <hr>
                            <small class="mx-2 mb-2">
                                Total Attachments: <span>1</span>
                            </small>
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
                                            <i class="fas fa-paperclip"></i> Add Attachments
                                        </label>
                                        <input type="file" id="file-input" accept=".pdf, .doc, .docx" multiple
                                            name="attachments">
                                    </div>
                                    <div class="text-primary font-12">Max. 5MB | .pdf, .doc, .docx</div>
                                </div>
                            </div>
                            <div class="card-footer">
                                <div class="row">
                                    <div class="col-6">
                                        <div class="email-status"></div>
                                    </div>
                                    <div class="col-6 text-right">
                                        <button type="button" class="btn btn-primary">
                                            <i class="far fa-envelope"></i>
                                            Preview</button>
                                        <button type="submit" class="btn btn-success"><i class="far fa-envelope"></i>
                                            Send</button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection

@push('extra-scripts')
    <script>
        // CKeditor Cover Letter Content
        var coverLetterContent = CKEDITOR.replace('emailMessageContent', {
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
    </script>
@endpush
