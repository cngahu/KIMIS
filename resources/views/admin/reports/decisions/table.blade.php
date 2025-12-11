<table id="rejectedTable" class="table table-bordered table-striped">
    <thead class="table-dark">
    <tr>
        <th>Reference</th>
        <th>Name</th>
        <th>Course</th>
        <th>Reviewer</th>
        <th>Reason</th>
        <th>Rejected On</th>
    </tr>
    </thead>

    <tbody>
    @forelse($data as $app)
        <tr>
            <td>{{ $app->reference }}</td>
            <td>{{ $app->full_name }}</td>
            <td>{{ $app->course->course_name }}</td>
            <td>{{ optional($app->reviewer)->name ?? '—' }}</td>
            <td>{{ $app->reviewer_comments ?? 'No comments' }}</td>
            <td>{{ $app->updated_at->format('d M Y H:i') }}</td>
        </tr>
    @empty
        <tr>
            <td colspan="6" class="text-center text-muted">No rejected applications found.</td>
        </tr>
    @endforelse
    </tbody>
</table>

<script>
    $('#rejectedTable').DataTable({
        pageLength: 25,
        order: [[5, 'desc']]
    });
</script>
