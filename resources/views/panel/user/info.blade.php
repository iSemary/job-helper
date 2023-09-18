@extends('layout.switcher')
@section('switcher')
    <div class="user-page">
        <div class="card">
            <div class="card-header">
                <h5><i class="fas fa-user-cog"></i> Your Information</h5>
            </div>
            <div class="card-body">
                <form method="POST" action="{{ route('panel.user.profile.update') }}" id="editForm"
                    enctype="multipart/form-data">
                    @csrf
                    {{ method_field('POST') }}
                    <div class="row">
                        <div class="form-group col-4">
                            <label for="first_name"><i class="fas fa-user"></i> First Name</label>
                            <input type="text" class="form-control" name="first_name" id="first_name"
                                value="{{ $userInfo['first_name'] ?? '' }}" placeholder="Enter first name">
                        </div>
                        <div class="form-group col-4">
                            <label for="last_name"><i class="fas fa-user"></i> Last Name</label>
                            <input type="text" class="form-control" name="last_name" id="last_name"
                                value="{{ $userInfo['last_name'] ?? '' }}" placeholder="Enter last name">
                        </div>
                        <div class="form-group col-4">
                            <label for="location"><i class="fas fa-map-marker-alt"></i> Location</label>
                            <input type="text" class="form-control" name="location" id="location"
                                value="{{ $userInfo['location'] ?? '' }}" placeholder="Enter location">
                        </div>
                    </div>
                    <div class="row">
                        <div class="form-group col-4">
                            <label for="email"><i class="fas fa-envelope"></i> Email</label>
                            <input type="email" class="form-control" name="email" id="email"
                                value="{{ $userInfo['email'] ?? '' }}" placeholder="Enter email">
                        </div>
                        <div class="form-group col-4">
                            <label for="phone"><i class="fas fa-phone"></i> Phone</label>
                            <input type="tel" class="form-control" name="phone" id="phone"
                                value="{{ $userInfo['phone'] ?? '' }}" placeholder="Enter phone number">
                        </div>
                        <div class="form-group col-4">
                            <label for="job_title"><i class="fas fa-briefcase"></i> Job Title</label>
                            <input type="text" class="form-control" name="job_title" id="job_title"
                                value="{{ $userInfo['job_title'] ?? '' }}" placeholder="Enter job title">
                        </div>
                    </div>
                    <div class="row">
                        <div class="form-group col-6">
                            <label for="total_experience_years"><i class="fas fa-clock"></i> Total Experience
                                (years)</label>
                            <select class="form-control" name="total_experience_years" id="total_experience_years">
                                <?php
                                for ($i = 0; $i <= 55; $i++) {
                                    echo '<option ' . (isset($userInfo['total_experience_years']) && $userInfo['total_experience_years'] == $i ? 'selected' : '') . ">$i</option>";
                                }
                                ?>
                            </select>
                        </div>
                        <div class="form-group col-6">
                            <label for="resumeFile">Resume / CV</label>
                            <input type="file" name="resume" accept=".pdf,.doc,.docx" id="resumeFile">
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="looking_for_relocation"><i class="fas fa-map-marker-alt"></i> Looking for
                            Relocation</label>
                        <div class="custom-control custom-switch">
                            <input type="checkbox" class="custom-control-input" name="looking_for_relocation"
                                {{ isset($userInfo['looking_for_relocation']) && $userInfo['looking_for_relocation'] == 1 ? 'checked' : '' }}
                                id="looking_for_relocation">
                            <label class="custom-control-label" for="looking_for_relocation"></label>
                        </div>
                    </div>
                    <div class="edit-status mt-2"></div>
                    <button type="submit" class="btn btn-primary">Save</button>
                </form>
            </div>
            <div class="card-footer">
                <h5 class="text-center">Resume/CV Viewer</h5>
                <hr>
                <div class="resume-viewer" id="resumeViewer" data-url="{{ $userInfo['resume']??'' }}">
                </div>
            </div>
        </div>
    </div>
@endsection

@push('extra-scripts')
    <script>
        $(document).ready(function(e) {
            let resumeURL = $("#resumeViewer").attr("data-url");
            if (resumeURL) {
                loadPDF(resumeURL, "resumeViewer")
            }
        })
    </script>
@endpush
