<div class="sidebar pinned" id="sidebar">
    <div class="sidebar-header d-flex align-items-center"> <!-- Flexbox untuk menyusun elemen -->
        <img id="sidebarLogo" src="{{ asset('icons/dark/factory-insight-dark.png') }}" alt="Factory Insight" class="app-logo mx-3" width="150px"/> <!-- Ganti span dengan gambar -->
        <i class="fas fa-thumbtack pin-icon" id="pinIcon" style="font-size: 24px; cursor: pointer; margin-left: 10px;"></i> <!-- Ukuran ikon pin -->
        <i class="fas fa-thumbtack unpin-icon" id="unpinIcon" style="display: none; font-size: 24px; cursor: pointer; margin-left: 10px;"></i> <!-- Ukuran ikon unpin -->
    </div>
    <ul class="nav flex-column">
        <li class="nav-item">
            <a class="nav-link dropdown-toggle-custom fw-bold" href="#masterDataSubmenu">
                <img src="{{ asset('icons/dark/master-data-dark.png') }}" alt="Master Data" class="menu-icon">
                <b class="menu-text">Master Data</b>
                <i class="fas fa-chevron-right float-end chevron-icon"></i>
            </a>
            <ul class="collapse list-unstyled" id="masterDataSubmenu">
                <li>
                    <a class="nav-link" href="{{ route('models.index') }}">
                        <img src="{{ asset('icons/dark/model-dark.png') }}" alt="Models" class="menu-icon">
                        <span class="menu-text">Models</span>
                    </a>
                </li>
                <li>
                    <a class="nav-link" href="{{ route('parts.index') }}">
                        <img src="{{ asset('icons/dark/part-dark.png') }}" alt="Parts" class="menu-icon">
                        <span class="menu-text">Parts</span>
                    </a>
                </li>
            </ul>
        </li>
    </ul>
</div>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        var sidebar = document.getElementById('sidebar');
        var pinIcon = document.getElementById('pinIcon');
        var unpinIcon = document.getElementById('unpinIcon');
        var sidebarLogo = document.getElementById('sidebarLogo'); // Ambil elemen logo
        var dropdownToggle = document.querySelector('.nav-link.dropdown-toggle-custom');
        var submenu = document.querySelector('#masterDataSubmenu');
        var chevronIcon = dropdownToggle.querySelector('.chevron-icon');
        var currentUrl = window.location.href;

        // Tambahkan kelas active pada submenu yang sesuai dengan URL saat ini
        var submenuLinks = submenu.querySelectorAll('.nav-link');
        submenuLinks.forEach(function(link) {
            if (link.href === currentUrl) {
                link.classList.add('active');
                submenu.classList.add('show');
                submenu.style.maxHeight = submenu.scrollHeight + "px";
                chevronIcon.classList.remove('fa-chevron-right');
                chevronIcon.classList.add('fa-chevron-down');
            }
        });

        dropdownToggle.addEventListener('click', function(event) {
            event.preventDefault();
            if (submenu.classList.contains('show')) {
                submenu.classList.remove('show');
                submenu.style.maxHeight = null;
                chevronIcon.classList.remove('fa-chevron-down');
                chevronIcon.classList.add('fa-chevron-right');
            } else {
                submenu.classList.add('show');
                submenu.style.maxHeight = submenu.scrollHeight + "px";
                chevronIcon.classList.remove('fa-chevron-right');
                chevronIcon.classList.add('fa-chevron-down');
            }
        });

        pinIcon.addEventListener('click', function() {
            sidebar.classList.add('pinned');
            sidebarLogo.style.display = 'block'; // Tampilkan logo
            pinIcon.style.display = 'none';
            unpinIcon.style.display = 'inline';
        });

        unpinIcon.addEventListener('click', function() {
            sidebar.classList.remove('pinned');
            sidebarLogo.style.display = 'none'; // Sembunyikan logo
            pinIcon.style.display = 'inline';
            unpinIcon.style.display = 'none';
        });

        // Fungsi untuk memeriksa ukuran layar dan mengatur sidebar
        function checkScreenSize() {
            if (window.innerWidth <= 768) { // Ukuran layar untuk mobile
                sidebar.classList.remove('pinned');
                sidebarLogo.style.display = 'none'; // Sembunyikan logo
                pinIcon.style.display = 'inline';
                unpinIcon.style.display = 'none';
            } else {
                sidebarLogo.style.display = 'block'; // Tampilkan logo jika tidak mobile
            }
        }

        // Panggil fungsi saat halaman dimuat
        checkScreenSize();

        // Tambahkan event listener untuk memeriksa perubahan ukuran layar
        window.addEventListener('resize', checkScreenSize);
    });
</script>
