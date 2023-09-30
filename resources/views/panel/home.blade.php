@extends('layout.switcher')
@section('switcher')
    <div class="row text-white">
        <div class="col-lg-3 col-6">
            <div class="small-box bg-info">
                <div class="inner text-center pt-2">
                    <h3>{{ $companies }}</h3>
                    <p>Companies</p>
                </div>
            </div>
        </div>
        <div class="col-lg-3 col-6">
            <div class="small-box bg-success">
                <div class="inner text-center pt-2">
                    <h3>{{ $emailsSent }}</h3>
                    <p>Emails Sent</p>
                </div>
            </div>
        </div>
        <div class="col-lg-3 col-6">
            <div class="small-box bg-warning">
                <div class="inner text-center pt-2">
                    <h3>{{ $coverLetters }}</h3>
                    <p>Cover Letters</p>
                </div>
            </div>
        </div>
        <div class="col-lg-3 col-6">
            <div class="small-box bg-danger">
                <div class="inner text-center pt-2">
                    <h3>{{ $remindersSent }}</h3>
                    <p>Reminders Sent</p>
                </div>
            </div>
        </div>
    </div>
@endsection
