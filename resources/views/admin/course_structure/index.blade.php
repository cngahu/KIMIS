
@extends('admin.admin_dashboard')

@section('admin')

    <style>
        .stage-box {
            border: 1px solid #dee2e6;
            border-radius: 6px;
            padding: 8px 10px;
            margin-bottom: 6px;
            background: #f8f9fa;
            display: flex;
            justify-content: space-between;
            align-items: center;
        }

        .stage-box strong {
            font-size: 14px;
        }

        .stage-actions button {
            margin-left: 4px;
        }

        .structure-container {
            min-height: 300px;
            border: 2px dashed #ced4da;
            border-radius: 6px;
            padding: 10px;
            background: #ffffff;
        }

        .structure-placeholder {
            color: #999;
            font-style: italic;
            text-align: center;
            margin-top: 40px;
        }
    </style>

    <div class="container-fluid">

        {{-- Header --}}
        <h5 class="mb-3">
            Course Structure –
            <span class="text-primary">{{ $course->course_name }}</span>
        </h5>

        {{-- Success Message --}}
        @if(session('success'))
            <div class="alert alert-success">
                {{ session('success') }}
            </div>
        @endif

        <form method="POST" action="{{ route('course_structure.store', $course) }}">
            @csrf

            <div class="row">

                {{-- LEFT: AVAILABLE STAGES --}}
                <div class="col-md-5">
                    <h6 class="mb-2">Available Stages</h6>

                    @foreach($stages as $stage)
                        <div class="stage-box">
                        <span>
                            <strong>{{ $stage->code }}</strong>
                            – {{ $stage->name }}
                        </span>

                            <button type="button"
                                    class="btn btn-sm btn-outline-primary add-stage"
                                    data-id="{{ $stage->id }}"
                                    data-label="{{ $stage->code }} – {{ $stage->name }}">
                                Add →
                            </button>
                        </div>
                    @endforeach
                </div>

                {{-- RIGHT: COURSE STRUCTURE --}}
                <div class="col-md-7">
                    <h6 class="mb-2">Course Structure (Top → Bottom)</h6>

                    <ul id="structureList" class="list-group structure-container">

                        @forelse($structure as $row)
                            <li class="list-group-item d-flex justify-content-between align-items-center">

                                @if($row->stage)
                                    <span>
                                    <strong>{{ $row->stage->code }}</strong>
                                    – {{ $row->stage->name }}
                                </span>
                                @else
                                    <span class="text-danger">
                                    [Missing stage – please remove]
                                </span>
                                @endif

                                <div class="stage-actions">
                                    <button type="button" class="btn btn-sm btn-outline-secondary move-up">↑</button>
                                    <button type="button" class="btn btn-sm btn-outline-secondary move-down">↓</button>
                                    <button type="button" class="btn btn-sm btn-outline-danger remove-stage">✕</button>
                                </div>

                                <input type="hidden"
                                       name="stage_ids[]"
                                       value="{{ $row->course_stage_id }}">
                            </li>
                        @empty
                            <li class="structure-placeholder">
                                No stages added yet.
                            </li>
                        @endforelse

                    </ul>
                </div>

            </div>

            {{-- Actions --}}
            <div class="mt-3">
                <button class="btn btn-primary">
                    Save Structure
                </button>

                <a href="{{ route('course_structure.home') }}"
                   class="btn btn-secondary ms-2">
                    Back
                </a>
            </div>

        </form>

    </div>

    {{-- SIMPLE, READABLE JS --}}
    <script>
        const structureList = document.getElementById('structureList');

        // Add stage to structure
        document.querySelectorAll('.add-stage').forEach(button => {
            button.addEventListener('click', () => {
                const id = button.dataset.id;
                const label = button.dataset.label;

                // Prevent duplicates
                if (structureList.querySelector(`input[value="${id}"]`)) {
                    alert('This stage is already in the structure.');
                    return;
                }

                removePlaceholder();

                const li = document.createElement('li');
                li.className = 'list-group-item d-flex justify-content-between align-items-center';

                li.innerHTML = `
                <span><strong>${label}</strong></span>
                <div class="stage-actions">
                    <button type="button" class="btn btn-sm btn-outline-secondary move-up">↑</button>
                    <button type="button" class="btn btn-sm btn-outline-secondary move-down">↓</button>
                    <button type="button" class="btn btn-sm btn-outline-danger remove-stage">✕</button>
                </div>
                <input type="hidden" name="stage_ids[]" value="${id}">
            `;

                structureList.appendChild(li);
            });
        });

        // Handle remove & reorder
        structureList.addEventListener('click', function (e) {
            const li = e.target.closest('li');

            if (!li) return;

            if (e.target.classList.contains('remove-stage')) {
                li.remove();
                checkEmpty();
            }

            if (e.target.classList.contains('move-up') && li.previousElementSibling) {
                structureList.insertBefore(li, li.previousElementSibling);
            }

            if (e.target.classList.contains('move-down') && li.nextElementSibling) {
                structureList.insertBefore(li.nextElementSibling, li);
            }
        });

        function checkEmpty() {
            if (structureList.children.length === 0) {
                structureList.innerHTML =
                    `<li class="structure-placeholder">No stages added yet.</li>`;
            }
        }

        function removePlaceholder() {
            const placeholder = structureList.querySelector('.structure-placeholder');
            if (placeholder) placeholder.remove();
        }
    </script>

@endsection
