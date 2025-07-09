<?php



namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\User;
use Illuminate\Support\Facades\Hash;


class AuthController extends Controller
{
    // Afficher le formulaire de connexion
    public function showLoginForm()
    {
        return view('auth.login');
    }

    // Traiter la connexion
    public function login(Request $request)
    {
        $credentials = $request->validate([
            'email' => 'required|email',
            'password' => 'required',
        ]);

// Dans la méthode login()
if (Auth::attempt($credentials)) {
    $request->session()->regenerate();

    // Redirection selon le rôle
    $user = Auth::user();
    if ($user->role === 'admin') {
        return redirect()->intended('/admin');
    } elseif ($user->role === 'caissier') {
        return redirect()->intended('/caissier');
    } else {
        return redirect()->intended('/serveur');
    }
}

return back()->withErrors([
    'email' => 'Identifiants incorrects.',
]);
    }

    // Déconnexion
    public function logout(Request $request)
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        return redirect('/');
    }
     // Afficher le formulaire d'inscription (réservé à l'admin)
    public function showRegisterForm()
    {
        // if (!Auth::check() || Auth::user()->role !== 'admin') {
        //     abort(403, 'Accès réservé à l\'administrateur');
        // }
        
        return view('auth.register');
    }

    // Traiter l'inscription
    public function register(Request $request)
    {
        // if (!Auth::check() || Auth::user()->role !== 'admin') {
        //     abort(403, 'Accès réservé à l\'administrateur');
        // }

        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|min:8|confirmed',
            'role' => 'required|in:serveur,caissier'
        ]);

        User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'role' => $request->role,
            'is_active' => true
        ]);

        return redirect()->route('admin.users')->with('success', 'Utilisateur créé avec succès');
    }


 }