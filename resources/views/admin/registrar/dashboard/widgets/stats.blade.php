<div class="col-md-3">
    <div class="card card-analytic border-start border-primary border-3">
        <div class="card-body">
            <h6>Total Applications</h6>
            <h3>{{ $total }}</h3>
        </div>
    </div>
</div>

<div class="col-md-3">
    <div class="card card-analytic border-start border-warning border-3">
        <div class="card-body">
            <h6>Awaiting Assignment</h6>
            <h3>{{ $awaiting }}</h3>
        </div>
    </div>
</div>

<div class="col-md-3">
    <div class="card card-analytic border-start border-info border-3">
        <div class="card-body">
            <h6>Under Review</h6>
            <h3>{{ $underReview }}</h3>
        </div>
    </div>
</div>

<div class="col-md-3">
    <div class="card card-analytic border-start border-success border-3">
        <div class="card-body">
            <h6>Approved</h6>
            <h3>{{ $approved }}</h3>
        </div>
    </div>
</div>

<div class="col-md-3 mt-3">
    <div class="card card-analytic border-start border-danger border-3">
        <div class="card-body">
            <h6>Rejected</h6>
            <h3>{{ $rejected }}</h3>
        </div>
    </div>
</div>

<div class="col-md-5 mt-3">
    <div class="card card-analytic">
        <div class="card-body">
            <h6>Average Processing Time</h6>
            <h3>{{ number_format($avgProcessing,1) }} hrs</h3>
        </div>
    </div>
</div>

<div class="col-md-4 mt-3">
    <div class="card card-analytic">
        <div class="card-body">
            <h6>Best Officer</h6>
            <h4>
                @if($bestOfficer)
                    {{ $bestOfficer->surname }} {{ $bestOfficer->firstname }}
                @else
                    N/A
                @endif
            </h4>
            <p class="text-muted">{{ $bestReviewer->speed ?? 'N/A' }} hrs avg</p>
        </div>
    </div>
</div>
