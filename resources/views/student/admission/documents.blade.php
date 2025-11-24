

@extends('admin.admin_dashboard')

@section('admin')
    <div class="page-content">


        <p class="text-muted">Please upload all required admission documents.</p>

        <div class="alert alert-info">
            Admission Status: <strong>{{ ucfirst($admission->status) }}</strong>
        </div>
        <h4 class="mb-3 fw-bold">Admission Document Upload</h4>
        <form method="POST" action="{{ route('student.admission.documents.upload') }}" enctype="multipart/form-data">
            @csrf

            @foreach($docTypes as $doc)
                <div class="card p-3 mb-3">

                    <label class="fw-bold">
                        {{ $doc->name }}
                        @if($doc->is_mandatory)
                            <span class="text-danger">*</span>
                        @endif
                    </label>

                    <p class="text-muted small">{{ $doc->description }}</p>

                    <input type="file"
                           class="form-control"
                           name="documents[{{ $doc->id }}]"
                           accept="{{ $doc->file_types }}">

                    @if(isset($uploaded[$doc->id]))
                        <p class="mt-2">
                            <a href="{{ asset('storage/'.$uploaded[$doc->id]->file_path) }}"
                               class="btn btn-sm btn-outline-primary"
                               target="_blank">
                                View Uploaded File
                            </a>
                        </p>
                    @endif
                </div>
            @endforeach

            <button class="btn btn-primary">Submit Documents</button>
        </form>
    </div>
@endsection
