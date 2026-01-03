@extends('admin.admin_dashboard')

@section('admin')

    <h4 class="fw-bold mb-3">
        Revenue Overview – {{ $training->course->course_name }}
    </h4>

    <div class="row g-3 mb-3">

        <div class="col-md-3">
            <div class="card radius-10">
                <div class="card-body text-center">
                    <div class="kpi-value">{{ $stats['total_applications'] }}</div>
                    <div class="kpi-label">Applications</div>
                </div>
            </div>
        </div>

        <div class="col-md-3">
            <div class="card radius-10">
                <div class="card-body text-center">
                    <div class="kpi-value">{{ $stats['total_participants'] }}</div>
                    <div class="kpi-label">Participants</div>
                </div>
            </div>
        </div>

        <div class="col-md-3">
            <div class="card radius-10 bg-success text-white">
                <div class="card-body text-center">
                    <div class="kpi-value">
                        KSh {{ number_format($stats['paid_amount'], 2) }}
                    </div>
                    <div class="kpi-label text-white">Paid</div>
                </div>
            </div>
        </div>

        <div class="col-md-3">
            <div class="card radius-10 bg-warning text-dark">
                <div class="card-body text-center">
                    <div class="kpi-value">
                        KSh {{ number_format($stats['unpaid_amount'], 2) }}
                    </div>
                    <div class="kpi-label">Pending</div>
                </div>
            </div>
        </div>

    </div>

@endsection
