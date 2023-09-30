@extends('layout.switcher')
@section('switcher')
    <section class="content">
        <div class="card card-primary">
            <div class="card-header">
                <h3 class="card-title">
                    Company Log
                </h3>
            </div>
            <div class="card-body">
                <div class="list-group">
                    @forelse ($companyLogs as $index => $companyLog)
                        <div href="#" class="list-group-item list-group-item-action flex-column align-items-start">
                            <div class="d-flex w-100 justify-content-between">
                                <h5 class="mb-1">
                                    {{ \App\Interfaces\CompanyStatusesInterface::getDetails($companyLog->status)['title'] }}
                                </h5>
                                <small>{{ $companyLog->created_at }}</small>
                            </div>
                        </div>
                        @if (count($companyLogs) > $index+1)
                            <i class="fas fa-chevron-up text-center py-3"></i>
                        @endif

                    @empty
                        <div class="text-center">There's no log for this company</div>
                    @endforelse
                </div>
            </div>
        </div>
    </section>
@endsection
