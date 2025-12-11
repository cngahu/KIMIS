<table id="applicationsTable" class="table table-striped table-hover">
    <thead>
    <tr>
        <th>Reference</th>
        <th>Applicant</th>
        <th>Course</th>
        <th>Financier</th>
        <th>Status</th>
        <th>Phone</th>
        <th>Email</th>
        <th>Applied On</th>
    </tr>
    </thead>

    <tbody>
    @foreach($data as $app)
        <tr>
            <td><strong>{{ $app->reference }}</strong></td>
            <td>{{ $app->full_name }}</td>
            <td>{{ $app->course->course_name }}</td>
            <td>{{ ucfirst($app->financier) }}</td>
            <td>
                <span class="badge
                    @if($app->status=='approved') bg-success
                    @elseif($app->status=='rejected') bg-danger
                    @elseif($app->status=='under_review') bg-info
                    @else bg-secondary @endif">
                    {{ ucfirst($app->status) }}
                </span>
            </td>
            <td>{{ $app->phone }}</td>
            <td>{{ $app->email }}</td>
            <td>{{ $app->created_at->format('d M Y') }}</td>
        </tr>
    @endforeach
    </tbody>
</table>
