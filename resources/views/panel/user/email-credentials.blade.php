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
                            <label for="first_name">Mailer</label>
                            <input type="text" class="form-control" name="mailer" id="mailer" required
                                value="{{ $emailCredentials['mailer'] ?? '' }}" placeholder="smtp">
                        </div>
                        <div class="form-group col-4">
                            <label for="last_name">Host</label>
                            <input type="text" class="form-control" name="host" id="host" required
                                value="{{ $emailCredentials['host'] ?? '' }}" placeholder="smtp.gmail.com">
                        </div>
                        <div class="form-group col-4">
                            <label for="location">Port</label>
                            <input type="number" class="form-control" name="port" id="port" required
                                value="{{ $emailCredentials['port'] ?? '' }}" placeholder="587">
                        </div>
                    </div>
                    <div class="row">
                        <div class="form-group col-4">
                            <label for="email">Username</label>
                            <input type="email" class="form-control" name="username" id="username" required
                                value="{{ $emailCredentials['username'] ?? '' }}" placeholder="your_email@gmail.com">
                        </div>
                        <div class="form-group col-4">
                            <label for="phone">Password</label>
                            <input type="text" class="form-control" name="password" id="password" required
                                value="{{ $emailCredentials['password'] ?? '' }}" placeholder="PaSsWoRd">
                            <small class="text-success"><i class="fas fa-passport"></i> Encrypted Password</small>
                        </div>
                        <div class="form-group col-4">
                            <label for="job_title">Encryption</label>
                            <input type="text" class="form-control" name="encryption" id="encryption" required
                                value="{{ $emailCredentials['encryption'] ?? '' }}" placeholder="tls">
                        </div>
                    </div>
                    <div class="row">
                        <div class="form-group col-4">
                            <label for="email">From Address</label>
                            <input type="email" class="form-control" name="from_address" id="from_address" required
                                value="{{ $emailCredentials['from_address'] ?? '' }}" placeholder="your_email@gmail.com">
                        </div>
                        <div class="form-group col-4">
                            <label for="phone">From Name</label>
                            <input type="text" class="form-control" name="from_name" id="from_name" required
                                value="{{ $emailCredentials['from_name'] ?? '' }}" placeholder="Your Cool Name">
                        </div>
                    </div>
                    <div class="edit-status mt-2"></div>
                    <button type="submit" class="btn btn-primary">Save</button>
                </form>
            </div>
        </div>
    </div>
@endsection

@push('extra-scripts')
    <script></script>
@endpush
