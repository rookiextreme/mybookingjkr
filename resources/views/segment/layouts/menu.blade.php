<ul class="navigation navigation-main" id="main-menu-navigation" data-menu="menu-navigation">
    <li class=" navigation-header"><span data-i18n="Apps &amp; Pages">Admin</span><i data-feather="more-horizontal"></i>
    </li>
    <li class=" nav-item"><a class="d-flex align-items-center" href="app-kanban.html"><i data-feather="grid"></i><span class="menu-title text-truncate" data-i18n="Kanban">Paparan Muka</span></a>
    </li>
    @role('Admin')
    <li class=" nav-item"><a class="d-flex align-items-center" href="#"><i data-feather="calendar"></i><span class="menu-title text-truncate" data-i18n="Invoice">Tetapan Bilik</span></a>
        <ul class="menu-content">
            <li><a class="d-flex align-items-center" href="{{ Request::root() }}/admin/bilik"><i data-feather="circle"></i><span class="menu-item text-truncate" data-i18n="Edit">Bilik</span></a>
            </li>
        </ul>
    </li>
    <li class=" nav-item"><a class="d-flex align-items-center" href="#"><i data-feather="settings"></i><span class="menu-title text-truncate" data-i18n="Invoice">Tetapan Biasa</span></a>
        <ul class="menu-content">
            <li><a class="d-flex align-items-center" href="{{ Request::root() }}/admin/tetapan/lokasi"><i data-feather="circle"></i><span class="menu-item text-truncate" data-i18n="List">Lokasi</span></a>
            </li>
            <li><a class="d-flex align-items-center" href="{{ Request::root() }}/admin/tetapan/bangunan"><i data-feather="circle"></i><span class="menu-item text-truncate" data-i18n="Preview">Bangunan</span></a>
            </li>
            <li><a class="d-flex align-items-center" href="{{ Request::root() }}/admin/tetapan/fasiliti"><i data-feather="circle"></i><span class="menu-item text-truncate" data-i18n="List">Fasiliti/Kemudahan</span></a>
            </li>
        </ul>
    </li>
    @endrole

    <li class=" navigation-header"><span data-i18n="Apps &amp; Pages">Pengguna</span><i data-feather="more-horizontal"></i>
    </li>
    <li class=" nav-item"><a class="d-flex align-items-center" href="#"><i data-feather="book-open"></i><span class="menu-title text-truncate" data-i18n="Invoice"> Tempahan</span></a>
        <ul class="menu-content">
            <li><a class="d-flex align-items-center" href="{{ Request::root() }}/pengguna/tempahan/bilik"><i data-feather="circle"></i><span class="menu-item text-truncate" data-i18n="List">Bilik</span></a>
            </li>
            <li><a class="d-flex align-items-center" href="app-invoice-preview.html"><i data-feather="circle"></i><span class="menu-item text-truncate" data-i18n="Preview">Laporan</span></a>
            </li>
        </ul>
    </li>
    <li class=" nav-item"><a class="d-flex align-items-center" href="#"><i data-feather="user"></i><span class="menu-title text-truncate" data-i18n="Invoice">Profil</span></a>
        <ul class="menu-content">
            <li><a class="d-flex align-items-center" href="app-invoice-list.html"><i data-feather="circle"></i><span class="menu-item text-truncate" data-i18n="List">Profile Pengguna</span></a>
            </li>
            <li><a class="d-flex align-items-center" href="app-invoice-preview.html"><i data-feather="circle"></i><span class="menu-item text-truncate" data-i18n="Preview">Carian Maklumat</span></a>
            </li>
        </ul>
    </li>
</ul>
