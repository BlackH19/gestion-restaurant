<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\ForgotPasswordController;
use App\Http\Controllers\ResetPasswordController;
use App\Http\Controllers\CommandeController;
use App\Http\Controllers\PlatController;
use App\Http\Controllers\MouvementCaisseController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\CaissierController;
use App\Http\Controllers\ServeurController;




// Page d'accueil publique
Route::get('/', function () {
    return view('welcome');
});

// Authentification
Route::get('/login', [AuthController::class, 'showLoginForm'])->name('login');
Route::post('/login', [AuthController::class, 'login']);
Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

// Routes protégées
Route::middleware(['auth'])->group(function () {
    // Admin
    Route::middleware(['check.role:admin'])->prefix('admin')->group(function () {
        Route::get('/', function () {
            return view('admin.dashboard');
        })->name('admin.dashboard');
    });

    // Caissier
    Route::middleware(['check.role:caissier'])->prefix('caissier')->group(function () {
        Route::get('/', function () {
            return view('caissier.dashboard');
        })->name('caissier.dashboard');
    });

    // Serveur
    Route::middleware(['check.role:serveur'])->prefix('serveur')->group(function () {
        Route::get('/', function () {
            return view('serveur.dashboard');
        })->name('serveur.dashboard');
    });
});

// ...

// Réinitialisation du mot de passe

// Inscription (protégée, admin seulement)

Route::get('/register', [AuthController::class, 'showRegisterForm'])->name('register');
Route::post('/register', [AuthController::class, 'register']);


Route::middleware(['auth', 'check.role:admin'])->prefix('admin')->group(function () {
    Route::resource('users', UserController::class);
    Route::get('/users', [UserController::class, 'index'])->name('admin.users');
    Route::get('/users/create', [UserController::class, 'create'])->name('admin.users.create');
    Route::post('/users', [UserController::class, 'store'])->name('admin.users.store');
    Route::get('users/index', [UserController::class, 'index'])->name('admin.users.index');
    Route::get('/users/{user}/edit', [UserController::class, 'edit'])->name('admin.users.edit');
    Route::put('/users/{user}', [UserController::class, 'update'])->name('admin.users.update');
    Route::delete('/users/{user}', [UserController::class, 'destroy'])->name('admin.users.destroy');
});

// Mot de passe oublié
Route::get('password/reset', [ForgotPasswordController::class, 'showLinkRequestForm'])->name('password.request');
Route::post('password/email', [ForgotPasswordController::class, 'sendResetLinkEmail'])->name('password.email');
Route::get('password/reset/{token}', [ResetPasswordController::class, 'showResetForm'])->name('password.reset');
Route::post('password/reset', [ResetPasswordController::class, 'reset'])->name('password.update');




// Routes pour Commandes (protégées par auth et rôle serveur/admin)
Route::middleware(['auth', 'check.role:serveur,admin'])->group(function () {
    Route::get('/commandes', [CommandeController::class, 'index'])->name('commandes.index');
    Route::get('/commandes/create', [CommandeController::class, 'create'])->name('commandes.create');
    Route::post('/commandes', [CommandeController::class, 'store'])->name('commandes.store');
    Route::get('/commandes/{commande}', [CommandeController::class, 'show'])->name('commandes.show');
    Route::get('/commandes/{commande}/edit', [CommandeController::class, 'edit'])->name('commandes.edit');
    Route::post('/commandes/{commande}/valider', [CommandeController::class, 'valider'])->name('commandes.valider');
    Route::post('/commandes/{commande}/annuler', [CommandeController::class, 'annuler'])->name('commandes.annuler');
    Route::put('/commandes/{commande}', [CommandeController::class, 'update'])->name('commandes.update');
    Route::post('/commandes/{commande}/calculer-total', [CommandeController::class, 'calculerTotal'])->name('commandes.calculer-total');
    Route::get('/serveur/commande/create', [CommandeController::class, 'create'])
        ->name('serveur.commande.create');
    Route::get('/commande/service', [CommandeController::class, 'service'])->name('serveur.commande.service');
});


// Routes pour Plats (protégées par auth et rôle approprié)
Route::middleware(['auth', 'check.role:admin,serveur'])->group(function () {
    Route::get('/plats', [PlatController::class, 'index'])->name('plats.index');
    Route::get('/plats/create', [PlatController::class, 'create'])->name('plats.create');
    Route::post('/plats', [PlatController::class, 'store'])->name('plats.store');
    Route::get('/plats/{plat}', [PlatController::class, 'show'])->name('plats.show');
    Route::get('/plats/{plat}/edit', [PlatController::class, 'edit'])->name('plats.edit');
    Route::put('/plats/{plat}', [PlatController::class, 'update'])->name('plats.update');
    Route::delete('/plats/{plat}', [PlatController::class, 'destroy'])->name('plats.destroy');
});







// Routes pour MouvementCaisse (protégées par auth et rôle caissier/admin)
Route::middleware(['auth', 'check.role:caissier,admin'])->group(function () {
    Route::get('/mouvements-caisse', [MouvementCaisseController::class, 'index'])->name('mouvements-caisse.index');
    Route::get('/mouvements-caisse/create', [MouvementCaisseController::class, 'create'])->name('mouvements-caisse.create');
    Route::post('/mouvements-caisse', [MouvementCaisseController::class, 'store'])->name('mouvements-caisse.store');
    Route::get('/mouvements-caisse/{mouvement}', [MouvementCaisseController::class, 'show'])->name('mouvements-caisse.show');
    Route::get('/mouvements-caisse/{mouvement}/edit', [MouvementCaisseController::class, 'edit'])->name('mouvements-caisse.edit');
    Route::put('/mouvements-caisse/{mouvement}', [MouvementCaisseController::class, 'update'])->name('mouvements-caisse.update');
    Route::delete('/mouvements-caisse/{mouvement}', [MouvementCaisseController::class, 'destroy'])->name('mouvements-caisse.destroy');
    Route::resource('mouvements', MouvementCaisseController::class);


    // Route pour le solde actuel
    Route::get('/caisse/solde', [MouvementCaisseController::class, 'solde'])->name('caisse.solde');
    Route::get('/caisse/entree', [MouvementCaisseController::class, 'createEntree'])->name('caisse.entree');
    Route::post('/caisse/entree', [MouvementCaisseController::class, 'storeEntree'])->name('caisse.storeEntree');
    Route::get('/caisse/sortie', [MouvementCaisseController::class, 'createSortie'])->name('caisse.sortie');
    Route::post('/caisse/sortie', [MouvementCaisseController::class, 'storeSortie'])->name('caisse.storeSortie');
    Route::get('/caisse/solde-actuel', [MouvementCaisseController::class, 'getSoldeActuel'])->name('caisse.solde-actuel');
    Route::get('/caisse/entrees-du-jour', [MouvementCaisseController::class, 'entreesDuJour'])->name('caisse.entrees-du-jour');
    Route::get('/caisse/sorties-du-jour', [MouvementCaisseController::class, 'sortiesDuJour'])->name('caisse.sorties-du-jour');
});



// Routes admin (accès complet)
Route::middleware(['auth', 'check.role:admin'])->prefix('admin')->group(function () {
    Route::get('/', [AdminController::class, 'dashboard'])->name('admin.dashboard');
    // ... autres routes admin
});

// Routes partagées (admin + autres rôles)
Route::middleware(['auth', 'check.role:admin,caissier,serveur'])->group(function () {
    Route::get('/commandes', [CommandeController::class, 'index'])->name('commandes.index');
    Route::get('/plats', [PlatController::class, 'index'])->name('plats.index');
    Route::get('/mouvements-caisse', [MouvementCaisseController::class, 'index'])->name('mouvements-caisse.index');
});

// Routes spécifiques caissier
Route::middleware(['auth', 'check.role:admin,caissier'])->group(function () {
    Route::get('/caissier', [CaissierController::class, 'dashboard'])->name('caissier.dashboard');
    // ... autres routes caissier
});

// Routes spécifiques serveur
Route::middleware(['auth', 'check.role:admin,serveur'])->group(function () {
    Route::get('/serveur', [ServeurController::class, 'dashboard'])->name('serveur.dashboard');
    // ... autres routes serveur
});
Route::middleware(['auth', 'check.role:admin'])->prefix('admin')->name('admin.users')->group(function () {
    Route::resource('admin.users', UserController::class);
});
