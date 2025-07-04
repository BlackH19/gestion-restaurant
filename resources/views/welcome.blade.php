<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Restaurant - Accueil</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css">
    <style>
        :root {
            --primary-color: #3b82f6;
            --primary-dark: #2563eb;
            --success-color: #10b981;
        }
        
        body {
            font-family: 'Inter', sans-serif;
            background: linear-gradient(135deg, #f8fafc 0%, #e2e8f0 100%);
            min-height: 100vh;
            display: flex;
            flex-direction: column;
        }
        
        .hero-section {
            background: linear-gradient(rgba(0, 0, 0, 0.7), rgba(0, 0, 0, 0.7)), url('https://images.unsplash.com/photo-1517248135467-4c7edcad34c4?ixlib=rb-1.2.1&auto=format&fit=crop&w=1350&q=80');
            background-size: cover;
            background-position: center;
            color: white;
            padding: 8rem 0;
            text-align: center;
        }
        
        .btn-primary {
            background: linear-gradient(135deg, var(--primary-color), var(--primary-dark));
            border: none;
            padding: 0.75rem 2rem;
            font-weight: 500;
            border-radius: 50px;
            transition: all 0.3s;
        }
        
        .btn-primary:hover {
            transform: translateY(-3px);
            box-shadow: 0 10px 20px rgba(0, 0, 0, 0.1);
        }
        
        .btn-outline-light {
            border-radius: 50px;
            padding: 0.75rem 2rem;
            font-weight: 500;
            transition: all 0.3s;
        }
        
        .feature-icon {
            font-size: 2.5rem;
            color: var(--primary-color);
            margin-bottom: 1rem;
        }
        
        footer {
            background: #1e293b;
            color: white;
            padding: 2rem 0;
            margin-top: auto;
        }
    </style>
</head>
<body>
    <!-- Navigation -->
    <nav class="navbar navbar-expand-lg navbar-dark bg-dark">
        <div class="container">
            <a class="navbar-brand" href="#">
                <i class="fas fa-utensils me-2"></i>Restaurant Gourmet
            </a>
            <div class="ms-auto">
                <a href="{{ route('login') }}" class="btn btn-outline-light me-2">Connexion</a>
                <a href="{{ route('register') }}" class="btn btn-primary">Inscription</a>
            </div>
        </div>
    </nav>

    <!-- Hero Section -->
    <section class="hero-section">
        <div class="container">
            <h1 class="display-4 fw-bold mb-4">Bienvenue au Restaurant Gourmet</h1>
            <p class="lead mb-5">Découvrez une expérience culinaire exceptionnelle</p>
            <div class="d-flex justify-content-center gap-3">
                <a href="{{ route('login') }}" class="btn btn-primary btn-lg">
                    <i class="fas fa-sign-in-alt me-2"></i>Se connecter
                </a>
                <a href="{{ route('register') }}" class="btn btn-outline-light btn-lg">
                    <i class="fas fa-user-plus me-2"></i>S'inscrire
                </a>
            </div>
        </div>
    </section>

    <!-- Features Section -->
    <section class="py-5">
        <div class="container">
            <div class="row text-center">
                <div class="col-md-4 mb-4">
                    <div class="feature-icon">
                        <i class="fas fa-utensils"></i>
                    </div>
                    <h3>Cuisine raffinée</h3>
                    <p>Des plats préparés avec des ingrédients frais et de saison.</p>
                </div>
                <div class="col-md-4 mb-4">
                    <div class="feature-icon">
                        <i class="fas fa-wine-glass-alt"></i>
                    </div>
                    <h3>Carte des vins</h3>
                    <p>Une sélection exceptionnelle de vins pour accompagner vos plats.</p>
                </div>
                <div class="col-md-4 mb-4">
                    <div class="feature-icon">
                        <i class="fas fa-concierge-bell"></i>
                    </div>
                    <h3>Service premium</h3>
                    <p>Un service attentionné pour une expérience mémorable.</p>
                </div>
            </div>
        </div>
    </section>

    <!-- Footer -->
    <footer class="text-center">
        <div class="container">
            <div class="d-flex justify-content-center gap-4 mb-3">
                <a href="#" class="text-white"><i class="fab fa-facebook-f"></i></a>
                <a href="#" class="text-white"><i class="fab fa-instagram"></i></a>
                <a href="#" class="text-white"><i class="fab fa-twitter"></i></a>
            </div>
            <p class="mb-0">&copy; {{ date('Y') }} Restaurant Gourmet. Tous droits réservés.</p>
        </div>
    </footer>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>