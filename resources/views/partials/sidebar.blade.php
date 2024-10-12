<div class="sidebar pinned" id="sidebar">
    <div class="sidebar-header d-flex align-items-center">
        <img id="sidebarLargeLogo" src="{{ asset('icons/dark/factory-insight-dark.png') }}" alt="Factory Insight"
            class="app-logo mx-5" style="width: 176px; height: 28.86px; margin-left: 10px;" />
        <img id="sidebarSmallLogo" src="{{ asset('icons/dark/factory-insight-minimize.png') }}"
            alt="Factory Insight Minimized" style="width: 30px; margin-left: 40px; display: none;">
        <img src="{{ asset('icons/dark/pin-dark.png') }}" alt="Pin Sidebar" id="pinIcon" class="pin-icon"
            style="width: 24px; cursor: pointer; margin-left: 10px;">
        <img src="{{ asset('icons/dark/pin-dark-slash.png') }}" alt="Unpin Sidebar" id="unpinIcon" class="unpin-icon"
            style="width: 24px; cursor: pointer; margin-left: 10px; display: none;">
    </div>
    <ul class="nav flex-column mt-4">
        <li class="nav-item">
            <a class="nav-link dropdown-toggle-custom" href="#dashboardSubmenu">
                <img src="{{ asset('icons/dark/dashboard-dark.png') }}" alt="Dashboard" width="18" height="18"
                    class="menu-icon">
                <span class="menu-text" style="font-size: 19px; font-weight: 500; color: white;">Dashboard</span>
                <i class="fas fa-chevron-right float-end chevron-icon"></i>
            </a>
            <ul class="collapse list-unstyled" id="dashboardSubmenu" style="padding-left: 20px;">
                <li>
                    <a class="nav-link" href="#">
                        <span class="menu-text">Overview</span>
                    </a>
                </li>
                <li>
                    <a class="nav-link" href="#">
                        <span class="menu-text">Statistics</span>
                    </a>
                </li>
            </ul>
        </li>

        <li class="nav-item">
            <a class="nav-link dropdown-toggle-custom" href="#masterDataSubmenu">
                <img src="{{ asset('icons/dark/master-data-dark.png') }}" alt="Master Data" width="18" height="18"
                    class="menu-icon">
                <span class="menu-text" style="font-size: 19px; font-weight: 500; color: white;">Master Data</span>
                <i class="fas fa-chevron-right float-end chevron-icon"></i>
            </a>
            <ul class="collapse list-unstyled" id="masterDataSubmenu" style="padding-left: 20px; border-radius: 5px;">
                <li>
                    <a class="nav-link" href="#">
                        <img src="{{ asset('icons/dark/access-level-dark.png') }}" alt="Access Level" class="menu-icon">
                        <span class="menu-text" style="color: white;">Access Level</span>
                    </a>
                </li>
                <li>
                    <a class="nav-link" href="#">
                        <img src="{{ asset('icons/dark/user-dark.png') }}" alt="Users" class="menu-icon">
                        <span class="menu-text" style="color: white;">Users</span>
                    </a>
                </li>
                <li>
                    <a class="nav-link" href="#">
                        <img src="{{ asset('icons/dark/machine-dark.png') }}" alt="Machines" class="menu-icon">
                        <span class="menu-text" style="color: white;">Machines</span>
                    </a>
                </li>
                <li>
                    <a class="nav-link" href="{{ route('models.index') }}">
                        <img src="{{ asset('icons/dark/model-dark.png') }}" alt="Models" class="menu-icon">
                        <span class="menu-text" style="color: white;">Models</span>
                    </a>
                </li>
                <li>
                    <a class="nav-link" href="{{ route('parts.index') }}">
                        <img src="{{ asset('icons/dark/part-dark.png') }}" alt="Parts" class="menu-icon">
                        <span class="menu-text" style="color: white;">Parts</span>
                    </a>
                </li>
                <li>
                    <a class="nav-link" href="#">
                        <img src="{{ asset('icons/dark/dies-dark.png') }}" alt="Dies" class="menu-icon">
                        <span class="menu-text" style="color: white;">Dies</span>
                    </a>
                </li>
                <li>
                    <a class="nav-link" href="#">
                        <img src="{{ asset('icons/dark/cart-dark.png') }}" alt="Carts" class="menu-icon">
                        <span class="menu-text" style="color: white;">Carts</span>
                    </a>
                </li>
                <li>
                    <a class="nav-link" href="#">
                        <img src="{{ asset('icons/dark/reject-reason-dark.png') }}" alt="Reject Reason"
                            class="menu-icon">
                        <span class="menu-text" style="color: white;">Reject Reason</span>
                    </a>
                </li>
            </ul>
        </li>

        <!-- Menu Information -->
        <li class="nav-item">
            <a class="nav-link dropdown-toggle-custom" href="#informationSubmenu">
                <img src="{{ asset('icons/dark/information-dark.png') }}" alt="Information" width="18" height="18"
                    class="menu-icon">
                <span class="menu-text" style="font-size: 19px; font-weight: 500; color: white;">Information</span>
                <i class="fas fa-chevron-right float-end chevron-icon"></i>
            </a>
            <ul class="collapse list-unstyled" id="informationSubmenu" style="padding-left: 20px;">
                <li>
                    <a class="nav-link" href="#">
                        <span class="menu-text">Info 1</span>
                    </a>
                </li>
                <li>
                    <a class="nav-link" href="#">
                        <span class="menu-text">Info 2</span>
                    </a>
                </li>
            </ul>
        </li>

        <!-- Menu Transaction -->
        <li class="nav-item">
            <a class="nav-link dropdown-toggle-custom" href="#transactionSubmenu">
                <img src="{{ asset('icons/dark/transaction-dark.png') }}" alt="Transaction" width="18" height="18"
                    class="menu-icon">
                <span class="menu-text" style="font-size: 19px; font-weight: 500; color: white;">Transaction</span>
                <i class="fas fa-chevron-right float-end chevron-icon"></i>
            </a>
            <ul class="collapse list-unstyled" id="transactionSubmenu" style="padding-left: 20px;">
                <li>
                    <a class="nav-link" href="#">
                        <span class="menu-text">Transaction 1</span>
                    </a>
                </li>
                <li>
                    <a class="nav-link" href="#">
                        <span class="menu-text">Transaction 2</span>
                    </a>
                </li>
            </ul>
        </li>

        <!-- Menu Reports -->
        <li class="nav-item">
            <a class="nav-link" href="#">
                <img src="{{ asset('icons/dark/report-dark.png') }}" alt="Reports" width="18" height="18"
                    class="menu-icon">
                <span class="menu-text" style="font-size: 19px; font-weight: 500; color: white;">Reports</span>
            </a>
        </li>
    </ul>
</div>


<script>
    document.addEventListener('DOMContentLoaded', function () {
        var sidebar = document.getElementById('sidebar');
        var pinIcon = document.getElementById('pinIcon');
        var unpinIcon = document.getElementById('unpinIcon');
        var sidebarLargeLogo = document.getElementById('sidebarLargeLogo');
        var sidebarSmallLogo = document.getElementById('sidebarSmallLogo');
        var currentUrl = window.location.href;

        // Dropdown Master Data
        var masterDataDropdownToggle = document.querySelector('.nav-link.dropdown-toggle-custom[href="#masterDataSubmenu"]');
        var masterDataSubmenu = document.querySelector('#masterDataSubmenu');
        var masterDataChevronIcon = masterDataDropdownToggle?.querySelector('.chevron-icon');

        // Add active class to the appropriate submenu item for Master Data
        if (masterDataSubmenu) {
            var masterDataLinks = masterDataSubmenu.querySelectorAll('.nav-link');
            let hasActiveLink = false; // Flag to check if any link is active

            masterDataLinks.forEach(function (link) {
                if (link.href === currentUrl) {
                    link.classList.add('active');
                    hasActiveLink = true; // Set the flag if an active link is found
                    masterDataSubmenu.classList.add('show');
                    masterDataSubmenu.style.maxHeight = masterDataSubmenu.scrollHeight + "px";
                    masterDataChevronIcon?.classList.remove('fa-chevron-right');
                    masterDataChevronIcon?.classList.add('fa-chevron-down');
                }
            });

            // Add .active-main-menu class to the main menu if any submenu item is active
            if (hasActiveLink) {
                masterDataDropdownToggle.classList.add('active-main-menu');
            }
        }

        masterDataDropdownToggle?.addEventListener('click', function (event) {
            event.preventDefault();
            toggleSubmenu(masterDataSubmenu, masterDataChevronIcon);

            // Toggle the main menu class when clicked
            if (masterDataDropdownToggle.classList.contains('active-main-menu')) {
                masterDataDropdownToggle.classList.remove('active-main-menu');
            } else {
                masterDataDropdownToggle.classList.add('active-main-menu');
            }
        });

        // Dropdown Dashboard
        var dashboardDropdownToggle = document.querySelector('.nav-link.dropdown-toggle-custom[href="#dashboardSubmenu"]');
        var dashboardSubmenu = document.querySelector('#dashboardSubmenu');
        var dashboardChevronIcon = dashboardDropdownToggle?.querySelector('.chevron-icon');

        dashboardDropdownToggle?.addEventListener('click', function (event) {
            event.preventDefault();
            toggleSubmenu(dashboardSubmenu, dashboardChevronIcon);
        });

        // Dropdown Information
        var informationDropdownToggle = document.querySelector('.nav-link.dropdown-toggle-custom[href="#informationSubmenu"]');
        var informationSubmenu = document.querySelector('#informationSubmenu');
        var informationChevronIcon = informationDropdownToggle?.querySelector('.chevron-icon');

        informationDropdownToggle?.addEventListener('click', function (event) {
            event.preventDefault();
            toggleSubmenu(informationSubmenu, informationChevronIcon);
        });

        // Dropdown Transaction
        var transactionDropdownToggle = document.querySelector('.nav-link.dropdown-toggle-custom[href="#transactionSubmenu"]');
        var transactionSubmenu = document.querySelector('#transactionSubmenu');
        var transactionChevronIcon = transactionDropdownToggle?.querySelector('.chevron-icon');

        transactionDropdownToggle?.addEventListener('click', function (event) {
            event.preventDefault();
            toggleSubmenu(transactionSubmenu, transactionChevronIcon);
        });

        // Function to toggle submenu
        function toggleSubmenu(submenu, chevronIcon) {
            if (submenu) {
                submenu.classList.toggle('show');
                chevronIcon?.classList.toggle('fa-chevron-right');
                chevronIcon?.classList.toggle('fa-chevron-down');
                submenu.style.maxHeight = submenu.classList.contains('show') ? submenu.scrollHeight + "px" : null;
            }
        }

        // Function to handle pin/unpin sidebar
        function toggleSidebarPin() {
            if (sidebar.classList.contains('pinned')) {
                sidebar.classList.remove('pinned');
                sidebarLargeLogo.style.display = 'none';
                sidebarSmallLogo.style.display = 'block';
                pinIcon.style.display = 'inline';
                unpinIcon.style.display = 'none';
                localStorage.setItem('sidebarPinned', 'false'); // Simpan status
            } else {
                sidebar.classList.add('pinned');
                sidebarLargeLogo.style.display = 'block';
                sidebarSmallLogo.style.display = 'none';
                pinIcon.style.display = 'none';
                unpinIcon.style.display = 'inline';
                localStorage.setItem('sidebarPinned', 'true'); // Simpan status
            }
        }

        // Add event listeners for pin/unpin icons
        pinIcon?.addEventListener('click', toggleSidebarPin);
        unpinIcon?.addEventListener('click', toggleSidebarPin);

        // Function to check screen size and set sidebar
        function checkScreenSize() {
            if (window.innerWidth <= 768) {
                sidebar.classList.remove('pinned');
                sidebarLargeLogo.style.display = 'none';
                sidebarSmallLogo.style.display = 'block';
                pinIcon.style.display = 'inline';
                unpinIcon.style.display = 'none';
            } else {
                if (sidebar.classList.contains('pinned')) {
                    sidebarLargeLogo.style.display = 'block';
                    sidebarSmallLogo.style.display = 'none';
                    pinIcon.style.display = 'none';
                    unpinIcon.style.display = 'inline';
                } else {
                    sidebarLargeLogo.style.display = 'none';
                    sidebarSmallLogo.style.display = 'block';
                    pinIcon.style.display = 'inline';
                    unpinIcon.style.display = 'none';
                }
            }
        }

        // Memeriksa status sidebar saat halaman dimuat
        function initializeSidebar() {
            var isPinned = localStorage.getItem('sidebarPinned');
            if (isPinned === 'true') {
                sidebar.classList.add('pinned');
                sidebarLargeLogo.style.display = 'block';
                sidebarSmallLogo.style.display = 'none';
                pinIcon.style.display = 'none';
                unpinIcon.style.display = 'inline';
            } else {
                sidebar.classList.remove('pinned');
                sidebarLargeLogo.style.display = 'none';
                sidebarSmallLogo.style.display = 'block';
                pinIcon.style.display = 'inline';
                unpinIcon.style.display = 'none';
            }
        }

        // Inisialisasi sidebar
        initializeSidebar();
        checkScreenSize();
        window.addEventListener('resize', checkScreenSize);
    });

</script>