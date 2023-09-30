@extends('layout.switcher')
@section('switcher')
    <div class="user-page">
        <div class="card">
            <div class="card-header">
                <h5><i class="fas fa-fingerprint"></i> Email Credentials</h5>
            </div>
            <div class="card-body">
                <form method="POST" action="{{ route('panel.user.email-credentials.update') }}" id="editForm"
                    enctype="multipart/form-data">
                    @csrf
                    {{ method_field('POST') }}
                    <div class="row">
                        <div class="form-group col-4">
                            <label for="mailer">Mailer</label>
                            <input type="text" class="form-control" name="mailer" id="mailer" required
                                value="{{ $emailCredentials['mailer'] ?? '' }}" placeholder="smtp">
                        </div>
                        <div class="form-group col-4">
                            <label for="host">Host</label>
                            <input type="text" class="form-control" name="host" id="host" required
                                value="{{ $emailCredentials['host'] ?? '' }}" placeholder="smtp.gmail.com">
                        </div>
                        <div class="form-group col-4">
                            <label for="port">Port</label>
                            <input type="number" class="form-control" name="port" id="port" required
                                value="{{ $emailCredentials['port'] ?? '' }}" placeholder="587">
                        </div>
                    </div>
                    <div class="row">
                        <div class="form-group col-4">
                            <label for="username">Username</label>
                            <input type="email" class="form-control" name="username" id="username" required
                                value="{{ $emailCredentials['username'] ?? '' }}" placeholder="your_email@gmail.com">
                        </div>
                        <div class="form-group col-4">
                            <label for="password">Password</label>
                            <input type="password" class="form-control" name="password" id="password" required
                                value="{{ $emailCredentials['password'] ?? '' }}" placeholder="PaSsWoRd">
                            <small class="text-success"><i class="fas fa-passport"></i> Encrypted Password</small>
                        </div>
                        <div class="form-group col-4">
                            <label for="encryption">Encryption</label>
                            <input type="text" class="form-control" name="encryption" id="encryption" required
                                value="{{ $emailCredentials['encryption'] ?? '' }}" placeholder="tls">
                        </div>
                    </div>
                    <div class="row">
                        <div class="form-group col-4">
                            <label for="from_address">From Address</label>
                            <input type="email" class="form-control" name="from_address" id="from_address" required
                                value="{{ $emailCredentials['from_address'] ?? '' }}" placeholder="your_email@gmail.com">
                        </div>
                        <div class="form-group col-4">
                            <label for="from_name">From Name</label>
                            <input type="text" class="form-control" name="from_name" id="from_name" required
                                value="{{ $emailCredentials['from_name'] ?? '' }}" placeholder="Your Cool Name">
                        </div>
                    </div>
                    <div class="edit-status mt-2"></div>
                    <div>
                        <button type="submit" class="btn btn-sm btn-primary"><i class="fas fa-save"></i> Save</button>
                    </div>
                </form>
                <form method="POST" class="mt-2" id="testMailForm"
                    action="{{ route('panel.user.email-credentials.test') }}">
                    @csrf
                    {{ method_field('POST') }}
                    <button type="submit" class="btn btn-sm btn-danger"><i class="fas fa-vial"></i> Send Test Mail</button>
                </form>
            </div>
        </div>
    </div>
@endsection

@push('extra-scripts')
    <script>
        $(document).on("submit", "#testMailForm", function(e) {
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
                    $(".edit-status").html(
                        `<h6 class="text-muted"><i class="fas fa-circle-notch fa-spin"></i> Sending test mail, Please wait...</h6>`
                    );
                    formBtn.prop("disabled", true);
                },
                success: function(data) {
                    $(".edit-status").html(
                        `<h6 class="text-success"><i class="fas fa-check-circle"></i> ${data.message}</h6>`
                    );
                    formBtn.prop("disabled", false);
                },
                error: function(data) {
                    $(".edit-status").html(
                        `<h6 class="text-danger"><i class="fas fa-exclamation-triangle"></i> ` +
                        (data.responseJSON.message ?? "Something went wrong") +
                        `</h6>`
                    );
                    formBtn.prop("disabled", false);
                },
            });
        });
    </script>
@endpush
