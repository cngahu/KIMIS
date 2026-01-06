<li>
    <a href="javascript:;" class="has-arrow">
        <div class="parent-icon"><i class='bx bx-book-reader'></i></div>
        <div class="menu-title">Accounts</div>
    </a>
    <ul>
        <li>
            <a href="{{ route('accounts.dashboard') }}">
                <i class="bx bx-radio-circle"></i> Dashboard

            </a>
        </li>

        <li>
            <a href="{{ route('accounts.invoices') }}">
                <i class="bx bx-radio-circle"></i> Invoices

            </a>
        </li>

        <li>
            <a href="{{ route('reports.daily.collections') }}">
                <i class="bx bx-radio-circle"></i> Daily Collections Report

            </a>
        </li>
        <li>
            <a href="{{ route('reports.outstanding') }}">
                <i class="bx bx-radio-circle"></i>Outstanding Payments

            </a>
        </li>


    </ul>
</li>
