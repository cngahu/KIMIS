{{--<table class="table table-bordered table-striped">--}}
{{--    <thead class="table-dark">--}}
{{--    <tr>--}}
{{--        <th>Reference</th>--}}
{{--        <th>Applicant</th>--}}
{{--        <th>Course</th>--}}
{{--        <th>Status</th>--}}
{{--        <th>Submitted</th>--}}
{{--    </tr>--}}
{{--    </thead>--}}
{{--    <tbody>--}}
{{--    @forelse($data as $app)--}}
{{--        <tr>--}}
{{--            <td>{{ $app->reference }}</td>--}}
{{--            <td>{{ $app->full_name }}</td>--}}
{{--            <td>{{ $app->course->course_name }}</td>--}}
{{--            <td>{{ ucfirst($app->status) }}</td>--}}
{{--            <td>{{ $app->created_at->format('d M Y') }}</td>--}}
{{--        </tr>--}}
{{--    @empty--}}
{{--        <tr>--}}
{{--            <td colspan="5" class="text-center text-muted">--}}
{{--                No records found.--}}
{{--            </td>--}}
{{--        </tr>--}}
{{--    @endforelse--}}
{{--    </tbody>--}}
{{--</table>--}}
<table class="table table-bordered table-striped table-sm">
    <thead class="table-dark">
    <tr>
        <th>#</th>
        <th>Reference</th>
        <th>Name</th>
        <th>ID No</th>
        <th>Phone</th>
        <th>Email</th>
        <th>Course</th>
        <th>Financier</th>
        <th>Status</th>
        <th>Payment</th>
        <th>Home County</th>
        <th>Current County</th>
        <th>Subcounty</th>
        <th>Applied On</th>
    </tr>
    </thead>

    <tbody>
    @forelse ($data as $index => $app)
        <tr>
            <td>{{ $index + 1 }}</td>
            <td>{{ $app->reference }}</td>
            <td>{{ $app->full_name }}</td>
            <td>{{ $app->id_number }}</td>
            <td>{{ $app->phone }}</td>
            <td>{{ $app->email }}</td>
            <td>{{ optional($app->course)->course_name }}</td>
            <td>{{ ucfirst($app->financier) }}</td>
            <td>{{ ucfirst($app->status) }}</td>
            <td>
                <span class="badge bg-{{ $app->payment_status == 'paid' ? 'success':'warning' }}">
                    {{ ucfirst($app->payment_status) }}
                </span>
            </td>
            <td>{{ optional($app->homeCounty)->name }}</td>
            <td>{{ optional($app->currentCounty)->name }}</td>
            <td>{{ optional($app->currentSubcounty)->name }}</td>
            <td>{{ $app->created_at->format('d M Y') }}</td>
        </tr>
    @empty
        <tr>
            <td colspan="14" class="text-center text-muted">No records found.</td>
        </tr>
    @endforelse
    </tbody>
</table>

@if ($data->count() >= 2000)
    <p class="text-danger small">
        Showing first 2,000 records only. Apply filters or download PDF for the full dataset.
    </p>
@endif
