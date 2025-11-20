<table class="table table-bordered table-striped">
    <thead class="table-dark">
    <tr>
        <th>Reference</th>
        <th>Applicant</th>
        <th>Course</th>
        <th>Status</th>
        <th>Submitted</th>
    </tr>
    </thead>
    <tbody>
    @forelse($data as $app)
        <tr>
            <td>{{ $app->reference }}</td>
            <td>{{ $app->full_name }}</td>
            <td>{{ $app->course->course_name }}</td>
            <td>{{ ucfirst($app->status) }}</td>
            <td>{{ $app->created_at->format('d M Y') }}</td>
        </tr>
    @empty
        <tr>
            <td colspan="5" class="text-center text-muted">
                No records found.
            </td>
        </tr>
    @endforelse
    </tbody>
</table>
