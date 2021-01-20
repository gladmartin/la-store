<ul class="nav nav-tabs mb-3">
    <li class="nav-item">
    <a class="nav-link {{ request('show', 'all') == 'all' ? 'active' : '' }}" href="?show=all">Semua orderan</a>
    </li>
    <li class="nav-item">
        <a class="nav-link {{ request('show') == 'pending' ? 'active' : '' }}" href="?show=pending">Menuggu dikonfirmasi</a>
    </li>
    <li class="nav-item">
        <a class="nav-link {{ request('show') == 'delivery' ? 'active' : '' }}" href="?show=delivery">Sedang dikirim</a>
    </li>
    <li class="nav-item">
        <a class="nav-link {{ request('show') == 'close' ? 'active' : '' }}" href="?show=close">Orderan selesai</a>
    </li>
</ul>
