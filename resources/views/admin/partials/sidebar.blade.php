<nav id="sidebar" class="sidebar js-sidebar">
    <div class="sidebar-content js-simplebar">
        <a class="sidebar-brand" href="{{ route('admin.dashboard') }}>
            <span class="align-middle">RescueFood</span>
        </a>
        <ul class="sidebar-nav">
            <li class="sidebar-item {{ Route::currentRouteName() == 'admin.dashboard' ? 'active' : '' }}">
                <a class="sidebar-link" href="{{ route('admin.dashboard') }}">
                    <i class="align-middle" data-feather="home"></i> <span class="align-middle">Tableau de bord</span>
                </a>
            </li>
            <li class="sidebar-item {{ Route::currentRouteName() == 'admin.users.index' ? 'active' : '' }}">
                <a class="sidebar-link" href="{{ route('admin.users.index') }}">
                    <i class="align-middle" data-feather="user"></i> <span class="align-middle">Utilisateurs</span>
                </a>
            </li>
            <li class="sidebar-item ">
                <a class="sidebar-link" href="{{ route('admin.users.index') }}">
                    <i class="align-middle" data-feather="box"></i> <span class="align-middle">Inventaires</span>
                </a>
            </li>
            <li class="sidebar-item ">
                <a class="sidebar-link" href="{{ route('admin.dons.index') }}">
                    <i class="align-middle" data-feather="gift"></i> <span class="align-middle">Dons</span>
                </a>
            </li>
            <li class="sidebar-item {{ Route::currentRouteName() == 'admin.demandes.index' ? 'active' : '' }}">
                <a class="sidebar-link" href="{{ route('admin.demandes.index') }}">
                    <i class="align-middle" data-feather="clipboard"></i> <span class="align-middle">Demandes</span>
                </a>
            </li>
            <li class="sidebar-item ">
                <a class="sidebar-link" href="{{ route('admin.produits.index') }}">
                    <i class="align-middle" data-feather="shopping-cart"></i> <span class="align-middle">Produits</span>
                </a>
            </li>
            <li class="sidebar-item {{ Route::currentRouteName() == 'admin.certifications.index' ? 'active' : '' }}">
                <a class="sidebar-link" href="{{ route('admin.certifications.index') }}">
                    <i class="align-middle" data-feather="award"></i> <span class="align-middle">Certifications</span>
                </a>
            </li>
            <li class="sidebar-item ">
                <a class="sidebar-link" href="{{ route('admin.users.index') }}">
                    <i class="align-middle" data-feather="edit"></i> <span class="align-middle">Publications</span>
                </a>
            </li>
            <li class="sidebar-item {{ Route::currentRouteName() == 'admin.feedbacks.index' ? 'active' : '' }}">
                <a class="sidebar-link" href="{{ route('admin.feedbacks.index') }}">
                    <i class="align-middle" data-feather="message-circle"></i> <span class="align-middle">Commentaires</span>
                </a>
            </li>
            <li class="sidebar-item {{ Route::currentRouteName() == 'admin.reservations.index' ? 'active' : '' }}">
                <a class="sidebar-link" href="{{ route('admin.reservations.index') }}">
                    <i class="align-middle" data-feather="calendar"></i> <span class="align-middle">Reservations</span>
                </a>
            </li>
            <li class="sidebar-item ">
                 <a class="sidebar-link" href="{{ route('admin.recommendations.index') }}">
                    <i class="align-middle" data-feather="map-pin"></i> <span class="align-middle">Recommandations</span>
                </a>
            </li>
            <li class="sidebar-item ">
                <a class="sidebar-link" href="{{ route('admin.events.index') }}">
                    <i class="align-middle" data-feather="settings"></i> <span class="align-middle">Événements</span>
                </a>
            </li>



        </ul>
    </div>
</nav>
