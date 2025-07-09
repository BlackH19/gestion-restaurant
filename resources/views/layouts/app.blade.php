<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Gestion Restaurant - @yield('title')</title>

    <link rel="icon" type="image/x-icon" href="{{ asset('favicon.ico') }}">

    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">

    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">

    <!-- Google Fonts -->
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap" rel="stylesheet">

    <!-- Styles personnalisés -->
    <style>
        :root {
            --primary-color: #2563eb;
            --primary-dark: #1d4ed8;
            --secondary-color: #64748b;
            --success-color: #059669;
            --danger-color: #dc2626;
            --warning-color: #d97706;
            --sidebar-bg: #1e293b;
            --sidebar-hover: #334155;
            --card-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.1), 0 2px 4px -1px rgba(0, 0, 0, 0.06);
            --transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
        }

        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: 'Inter', sans-serif;
            background: linear-gradient(135deg, #f8fafc 0%, #e2e8f0 100%);
            min-height: 100vh;
            color: #334155;
        }

        /* Navigation principale */
        .navbar-custom {
            background: linear-gradient(135deg, var(--sidebar-bg) 0%, #0f172a 100%);
            backdrop-filter: blur(10px);
            border-bottom: 1px solid rgba(255, 255, 255, 0.1);
            box-shadow: 0 4px 20px rgba(0, 0, 0, 0.1);
            padding: 0.75rem 0;
        }

        .navbar-brand {
            font-weight: 700;
            font-size: 1.5rem;
            color: #ffffff !important;
            text-decoration: none;
            transition: var(--transition);
        }

        .navbar-brand:hover {
            transform: translateY(-1px);
            color: #60a5fa !important;
        }

        .navbar-brand i {
            background: linear-gradient(45deg, #60a5fa, #3b82f6);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            margin-right: 0.5rem;
        }

        .navbar-nav .nav-link {
            color: rgba(255, 255, 255, 0.8) !important;
            font-weight: 500;
            padding: 0.5rem 1rem !important;
            border-radius: 0.5rem;
            margin: 0 0.25rem;
            transition: var(--transition);
        }

        .navbar-nav .nav-link:hover {
            color: #ffffff !important;
            background: rgba(255, 255, 255, 0.1);
            transform: translateY(-1px);
        }

        .navbar-nav .nav-link.active {
            color: #ffffff !important;
            background: var(--primary-color);
        }

        /* Sidebar moderne */
        .sidebar {
            position: fixed;
            top: 0;
            left: 0;
            height: 100vh;
            width: 280px;
            background: var(--sidebar-bg);
            padding-top: 20px;
            z-index: 1000;
            transition: var(--transition);
            border-right: 1px solid rgba(255, 255, 255, 0.1);
        }

        .sidebar-header {
            padding: 1.5rem;
            border-bottom: 1px solid rgba(255, 255, 255, 0.1);
            margin-bottom: 1rem;
        }

        .sidebar-menu {
            padding: 0 1rem;
        }

        .sidebar-item {
            display: block;
            color: rgba(255, 255, 255, 0.8);
            text-decoration: none;
            padding: 0.875rem 1rem;
            margin-bottom: 0.5rem;
            border-radius: 0.75rem;
            transition: var(--transition);
            font-weight: 500;
            position: relative;
        }

        .sidebar-item:hover {
            color: #ffffff;
            background: var(--sidebar-hover);
            transform: translateX(4px);
        }

        .sidebar-item.active {
            color: #ffffff;
            background: linear-gradient(135deg, var(--primary-color), var(--primary-dark));
            box-shadow: 0 4px 12px rgba(37, 99, 235, 0.3);
        }

        .sidebar-item i {
            width: 20px;
            margin-right: 0.75rem;
            text-align: center;
        }

        /* Contenu principal */
        .main-content {
            margin-left: 280px;
            padding: 2rem;
            min-height: 100vh;
            transition: var(--transition);
        }

        /* Responsive Sidebar */
        @media (max-width: 991.98px) {
            .sidebar {
                transform: translateX(-100%);
                transition: var(--transition);
                box-shadow: 0 0 0 100vw rgba(30, 41, 59, 0.5);
            }

            .sidebar.show {
                transform: translateX(0);
            }

            .main-content,
            .footer {
                margin-left: 0 !important;
            }
        }

        /* Cards modernes */
        .card {
            border: none;
            border-radius: 1rem;
            box-shadow: var(--card-shadow);
            background: rgba(255, 255, 255, 0.9);
            backdrop-filter: blur(10px);
            transition: var(--transition);
        }

        .card:hover {
            transform: translateY(-2px);
            box-shadow: 0 10px 25px -5px rgba(0, 0, 0, 0.1), 0 10px 10px -5px rgba(0, 0, 0, 0.04);
        }

        .card-header {
            background: linear-gradient(135deg, #f8fafc 0%, #e2e8f0 100%);
            border-bottom: 1px solid rgba(0, 0, 0, 0.05);
            border-radius: 1rem 1rem 0 0 !important;
            padding: 1.25rem 1.5rem;
            font-weight: 600;
        }

        /* Boutons modernes */
        .btn {
            font-weight: 500;
            border-radius: 0.75rem;
            padding: 0.625rem 1.25rem;
            transition: var(--transition);
            border: none;
        }

        .btn-primary {
            background: linear-gradient(135deg, var(--primary-color), var(--primary-dark));
            box-shadow: 0 4px 12px rgba(37, 99, 235, 0.3);
        }

        .btn-primary:hover {
            transform: translateY(-1px);
            box-shadow: 0 6px 16px rgba(37, 99, 235, 0.4);
        }

        .btn-success {
            background: linear-gradient(135deg, #059669, #047857);
            box-shadow: 0 4px 12px rgba(5, 150, 105, 0.3);
        }

        .btn-danger {
            background: linear-gradient(135deg, #dc2626, #b91c1c);
            box-shadow: 0 4px 12px rgba(220, 38, 38, 0.3);
        }

        /* Alerts modernes */
        .alert {
            border: none;
            border-radius: 0.75rem;
            font-weight: 500;
            box-shadow: var(--card-shadow);
        }

        .alert-success {
            background: linear-gradient(135deg, #d1fae5, #a7f3d0);
            color: #065f46;
            border-left: 4px solid #059669;
        }

        .alert-danger {
            background: linear-gradient(135deg, #fee2e2, #fecaca);
            color: #991b1b;
            border-left: 4px solid #dc2626;
        }

        /* Dropdown moderne */
        .dropdown-menu {
            background: #fff !important;
            color: #1e293b !important;
        }

        .dropdown-menu .dropdown-item {
            color: #1e293b !important;
        }

        .dropdown-menu .dropdown-item:hover {
            background: var(--primary-color) !important;
            color: #fff !important;
        }

        .dropdown-menu .dropdown-divider {
            border-top: 1px solid #e2e8f0;
        }

        /* Footer moderne */
        .footer {
            background: var(--sidebar-bg);
            margin-left: 280px;
            padding: 1.5rem 2rem;
            border-top: 1px solid rgba(255, 255, 255, 0.1);
        }

        /* Responsive */
        @media (max-width: 991.98px) {
            .sidebar {
                transform: translateX(-100%);
            }

            .sidebar.show {
                transform: translateX(0);
            }

            .main-content {
                margin-left: 0;
                padding: 1rem;
            }

            .footer {
                margin-left: 0;
            }
        }

        /* Animations */
        @keyframes slideInDown {
            from {
                transform: translateY(-100%);
                opacity: 0;
            }

            to {
                transform: translateY(0);
                opacity: 1;
            }
        }

        .alert {
            animation: slideInDown 0.5s ease-out;
        }

        /* Scrollbar personnalisée */
        ::-webkit-scrollbar {
            width: 6px;
        }

        ::-webkit-scrollbar-track {
            background: #f1f5f9;
        }

        ::-webkit-scrollbar-thumb {
            background: var(--primary-color);
            border-radius: 3px;
        }

        ::-webkit-scrollbar-thumb:hover {
            background: var(--primary-dark);
        }
    </style>

    @stack('styles')
</head>

<body>
    <!-- Barre de navigation -->
    <!-- <nav class="navbar navbar-expand-lg navbar-dark navbar-custom fixed-top">
        <div class="container-fluid">
            <a class="navbar-brand" href="{{ url('/') }}">
                <i class="fas fa-utensils"></i>Gestion Restaurant
            </a>
            
            <button class="navbar-toggler border-0" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" onclick="toggleSidebar()">
                <span class="navbar-toggler-icon"></span>
            </button>
            
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav me-auto">
                    @auth
                    <li class="nav-item">
                        <a class="nav-link" href="{{ route('commandes.index') }}">
                            <i class="fas fa-list-alt me-2"></i>Commandes
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="{{ route('plats.index') }}">
                            <i class="fas fa-utensils me-2"></i>Plats
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="{{ route('mouvements-caisse.index') }}">
                            <i class="fas fa-cash-register me-2"></i>Caisse
                        </a>
                    </li>
                    @if(auth()->user()->hasRole('admin'))
                    <li class="nav-item">
                        <a class="nav-link" href="{{ route('admin.users') }}">
                            <i class="fas fa-users-cog me-2"></i>Utilisateurs
                        </a>
                    </li>
                    @endif
                    @endauth
                </ul>
                
                <ul class="navbar-nav ms-auto">
                    @auth
                    <li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle d-flex align-items-center" href="#" id="navbarDropdown" role="button" data-bs-toggle="dropdown">
                            <div class="bg-primary rounded-circle d-flex align-items-center justify-content-center me-2" style="width: 32px; height: 32px;">
                                <i class="fas fa-user text-white"></i>
                            </div>
                            {{ auth()->user()->name }}
              
                        </a>
                        <ul class="dropdown-menu dropdown-menu-end">
                            <li><a class="dropdown-item" href="#"><i class="fas fa-user me-2"></i>Profil</a></li>
                            <li><a class="dropdown-item" href="#"><i class="fas fa-cog me-2"></i>Paramètres</a></li>
                            <li><hr class="dropdown-divider"></li>
                            <li>
                                <form action="{{ route('logout') }}" method="POST" class="d-inline">
                                    @csrf
                                    <button type="submit" class="dropdown-item">
                                        <i class="fas fa-sign-out-alt me-2"></i>Déconnexion
                                    </button>
                                </form>
                            </li>
                        </ul>
                    </li>
                    @else
                    <li class="nav-item">
                        <a class="nav-link" href="{{ route('login') }}">
                            <i class="fas fa-sign-in-alt me-2"></i>Connexion
                        </a>
                    </li>
                    @endauth
                </ul>
            </div>
        </div>
    </nav> -->

    <!-- Bouton pour mobile -->
    <button class="btn btn-primary d-lg-none" id="sidebarToggle" style="position:fixed;top:20px;left:20px;z-index:1100;"
        onclick="toggleSidebar()">
        <i class="fas fa-bars"></i>
    </button>
    <!-- Sidebar -->
    @auth
        <aside class="sidebar d-flex flex-column justify-content-between" id="sidebar">
            <div>
                <div class="sidebar-header d-flex flex-column justify-content-center align-items-center">
                    <img src="{{ asset('images/logo.jpg') }}" alt="Logo"
                        style="height: 100px; width: 100px; object-fit: contain;">
                    <span style="color: #fff; font-size: 1.3rem; font-weight: bold; margin-top: 10px; letter-spacing: 1px;">
                        Gestion Restaurant
                    </span>
                </div>
                <nav class="sidebar-menu">
                    @if(auth()->user()->isAdmin())
                        <a href="{{ route('admin.dashboard') }}"
                            class="sidebar-item {{ request()->routeIs('admin.dashboard') ? 'active' : '' }}">
                            <i class="fas fa-home"></i>Dashboard Admin
                        </a>
                    @elseif(auth()->user()->isServeur())
                        <a href="{{ route('serveur.dashboard') }}"
                            class="sidebar-item {{ request()->routeIs('serveur.dashboard') ? 'active' : '' }}">
                            <i class="fas fa-home"></i>Dashboard Serveur
                        </a>
                    @else
                        <a href="{{ route('caissier.dashboard') }}"
                            class="sidebar-item {{ request()->routeIs('caissier.dashboard') ? 'active' : '' }}">
                            <i class="fas fa-home"></i>Dashboard Caissier
                        </a>
                    @endif
                    <a href="{{ route('commandes.index') }}"
                        class="sidebar-item {{ request()->routeIs('commandes.*') ? 'active' : '' }}">
                        <i class="fas fa-list-alt"></i>Commandes
                    </a>
                    <a href="{{ route('plats.index') }}"
                        class="sidebar-item {{ request()->routeIs('plats.*') ? 'active' : '' }}">
                        <i class="fas fa-utensils"></i>Plats
                    </a>
                    @if(auth()->user()->isCaissier() || auth()->user()->isAdmin())
                    <a href="{{ route('mouvements-caisse.index') }}"
                        class="sidebar-item {{ request()->routeIs('mouvements-caisse.*') ? 'active' : '' }}">
                        <i class="fas fa-cash-register"></i>Gestion Caisse
                    </a>
                    @endif
                    @if(auth()->user()->isAdmin())
                        <a href="{{ route('admin.users') }}"
                            class="sidebar-item {{ request()->routeIs('admin.users') ? 'active' : '' }}">
                            <i class="fas fa-users-cog"></i>Utilisateurs
                        </a>
                    @endif
                </nav>
            </div>
            <div>
                <!-- Menu utilisateur en bas -->
                <div class="dropdown w-100 mb-2 px-3">
                    <a class="d-flex align-items-center text-white text-decoration-none dropdown-toggle" href="#"
                        id="sidebarUserDropdown" data-bs-toggle="dropdown" aria-expanded="false">
                        <div class="bg-primary rounded-circle d-flex align-items-center justify-content-center me-2"
                            style="width: 38px; height: 38px;">
                            <i class="fas fa-user text-white"></i>
                        </div>
                        <span>{{ auth()->user()->name }}</span>
                    </a>
                    <ul class="dropdown-menu dropdown-menu-dark shadow" aria-labelledby="sidebarUserDropdown">
                        <li>
                            <a class="dropdown-item" href="#">
                                <i class="fas fa-user me-2"></i>Profil
                            </a>
                        </li>
                        <li>
                            <a class="dropdown-item" href="#">
                                <i class="fas fa-cog me-2"></i>Paramètres
                            </a>
                        </li>
                        <li>
                            <hr class="dropdown-divider">
                        </li>
                        <li>
                            <form action="{{ route('logout') }}" method="POST" class="d-inline">
                                @csrf
                                <button type="submit" class="dropdown-item">
                                    <i class="fas fa-sign-out-alt me-2"></i>Déconnexion
                                </button>
                            </form>
                        </li>
                    </ul>
                </div>
                <!-- Bouton de déconnexion en bas (optionnel si déjà dans le menu) -->
                <!--
            <form action="{{ route('logout') }}" method="POST" class="w-100 px-3 mb-3">
                @csrf
                <button type="submit" class="btn btn-danger w-100">
                    <i class="fas fa-sign-out-alt me-2"></i>Déconnexion
                </button>
            </form>
            -->
            </div>
        </aside>
    @endauth

    <!-- Contenu principal -->
    <main class="main-content">
        <!-- Messages flash -->
        @if(session('success'))
            <div class="alert alert-success alert-dismissible fade show" role="alert">
                <i class="fas fa-check-circle me-2"></i>
                {{ session('success') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        @endif

        @if(session('error'))
            <div class="alert alert-danger alert-dismissible fade show" role="alert">
                <i class="fas fa-exclamation-circle me-2"></i>
                {{ session('error') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        @endif

        @if(session('warning'))
            <div class="alert alert-warning alert-dismissible fade show" role="alert">
                <i class="fas fa-exclamation-triangle me-2"></i>
                {{ session('warning') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        @endif

        <!-- Contenu spécifique à la page -->
        @yield('content')
    </main>

    <!-- Footer -->
    <footer class="footer text-white-50">
        <div class="d-flex justify-content-between align-items-center">
            <p class="mb-0">
                &copy; {{ date('Y') }} Gestion Restaurant - Tous droits réservés
            </p>
            <div>
                <small>Version 1.0</small>
            </div>
        </div>
    </footer>

    <!-- Bootstrap JS Bundle with Popper -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>

    <!-- Scripts personnalisés -->
    <script>
        // Fonction pour gérer la sidebar responsive
        function toggleSidebar() {
            const sidebar = document.getElementById('sidebar');
            if (sidebar) {
                sidebar.classList.toggle('show');
            }
        }

        // Activer les tooltips et autres fonctionnalités
        document.addEventListener('DOMContentLoaded', function () {
            // Tooltips
            var tooltipTriggerList = [].slice.call(document.querySelectorAll('[data-bs-toggle="tooltip"]'));
            var tooltipList = tooltipTriggerList.map(function (tooltipTriggerEl) {
                return new bootstrap.Tooltip(tooltipTriggerEl);
            });

            // Auto-hide des messages flash après 5 secondes
            setTimeout(function () {
                var alerts = document.querySelectorAll('.alert');
                alerts.forEach(function (alert) {
                    var bsAlert = new bootstrap.Alert(alert);
                    bsAlert.close();
                });
            }, 5000);

            // Fermer la sidebar sur mobile quand on clique sur un lien
            const sidebarLinks = document.querySelectorAll('.sidebar-item');
            sidebarLinks.forEach(function (link) {
                link.addEventListener('click', function () {
                    if (window.innerWidth < 992) {
                        document.getElementById('sidebar').classList.remove('show');
                    }
                });
            });

            // Smooth scrolling pour les ancres
            document.querySelectorAll('a[href^="#"]').forEach(anchor => {
                anchor.addEventListener('click', function (e) {
                    e.preventDefault();
                    const target = document.querySelector(this.getAttribute('href'));
                    if (target) {
                        target.scrollIntoView({
                            behavior: 'smooth',
                            block: 'start'
                        });
                    }
                });
            });
        });

        // Gestion du thème sombre (optionnel)
        function toggleDarkMode() {
            document.body.classList.toggle('dark-mode');
            localStorage.setItem('darkMode', document.body.classList.contains('dark-mode'));
        }

        // Charger le thème sauvegardé
        if (localStorage.getItem('darkMode') === 'true') {
            document.body.classList.add('dark-mode');
        }
    </script>

    @stack('scripts')
</body>

</html>