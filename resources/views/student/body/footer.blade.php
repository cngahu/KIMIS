{{-- resources/views/student/body/footer.blade.php --}}

<footer class="student-footer text-center py-3 mt-auto shadow-sm" style="background: #f8f9fa; border-top: 1px solid #ddd;">
    <div class="container">
        <p class="mb-0 text-muted">
            &copy; {{ date('Y') }} Kenya Institute of High. All rights reserved.
        </p>
    </div>

    <style>
        .student-footer p {
            font-size: 0.9rem;
        }

        @media (max-width: 575px) {
            .student-footer {
                font-size: 0.8rem;
                padding: 1rem 0;
            }
        }
    </style>
</footer>