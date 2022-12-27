<!--********************************** Sidebar start ***********************************-->
<div class="deznav">
    <div class="deznav-scroll">
        <ul class="metismenu" id="menu">
            <li>
                <a href="{{ route('user.dashboard') }}" class="" aria-expanded="false">
                    <i class="bi bi-grid"></i>
                    <span class="nav-text">Dashboard</span>
                </a>
            </li>
            <li>
                <a href="{{ route('user.kyc.index') }}" class="" aria-expanded="false">
                    <i class="bi bi-file-earmark-check"></i>
                    <span class="nav-text">My KYC</span>
                </a>
            </li>
            <li>
                <a href="{{ route('user.packages.index') }}" class="" aria-expanded="false">
                    <i class="bi bi-stack"></i>
                    <span class="nav-text">Buy Package</span>
                </a>
            </li>
            <li>
                <a href="{{ route('user.packages.active') }}" class="" aria-expanded="false">
                    <i class="bi bi-box"></i>
                    <span class="nav-text">Active Package</span>
                </a>
            </li>
            <li>
                <a href="{{ route('user.genealogy') }}" class="" aria-expanded="false">
                    <i class="bi bi-diagram-3-fill"></i>
                    <span class="nav-text">My Genealogy</span>
                </a>
            </li>
            <li>
                <a href="{{ route('user.transactions.index') }}" class="" aria-expanded="false">
                    <i class="bi bi-currency-exchange"></i>
                    <span class="nav-text">Transaction</span>
                </a>
            </li>
            <li>
                <a href="{{ route('user.earnings.index') }}" class="" aria-expanded="false">
                    <i class="bi bi-cash"></i>
                    <span class="nav-text">My Earnings</span>
                </a>
            </li>

            @include('navigation-menu')
        </ul>

    </div>
</div>
<!--********************************** Sidebar end ***********************************-->