<?php

namespace App\Http\Controllers;

use App\Http\Requests\AuthenticateFormRequest;
use App\Http\Requests\ProcessRegistractionFormValidate;
use App\Http\Requests\UpdateUserInfoForm;
use App\Http\Requests\UpdateUserPassword;
use App\Http\Requests\UpdateUserPicture;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;

use Intervention\Image\ImageManager;
use Intervention\Image\Drivers\Gd\Driver;

class AccountController extends Controller
{
    // Login
    public function login()
    {
        return view('jobs_portail.front.auth.login');
    }

    public function authenticate(AuthenticateFormRequest $request)
    {
        $credentials = $request->validated();

        if (Auth::attempt($credentials)) {

            session()->flash('success', 'Connexion réussie. Bienvenue !');

            $request->session()->regenerate();
            return response()->json([
                'status' => true,
                'redirect' => route('account.profile')
            ]);

        } else {
            return response()->json([
                'status' => false,
                'type' => 'auth_error',
                'message' => 'Les identifiants fournis sont incorrects.'
            ]);
        }

    }

    // Sign
    public function sign()
    {
        return view('jobs_portail.front.auth.sign');
    }

    // Register User
    public function processRegistraction(ProcessRegistractionFormValidate $request)
    {

        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
        ]);

        session()->flash('success', 'Inscription réussie. Votre compte a été créé avec succès.');

        return response()->json([
            'status' => true,
            'message' => 'Vous etes inscrit',
            'errors' => []
        ]);

    }

    // Profil
    public function profile()
    {

        $id = Auth::user()->id;
        $user = User::where('id', $id)->first();

        return view('jobs_portail.front.profile.index', [
            'user' => $user,
        ]);
    }

    public function update(UpdateUserInfoForm $request)
    {
        $user = auth()->user();

        $user->update($request->validated());

        return response()->json([
            'status' => true,
            'data' => auth()->user(),
            'message' => 'Informations mises à jour avec succès'
        ]);

    }

    public function updatePassword(UpdateUserPassword $request)
    {
        $user = auth()->user();

        // Vérifier ancien mot de passe si ca correspond au mot de passe de la personne connecté
        if (!Hash::check($request->current_password, $user->password)) {
            return response()->json([
                'status' => false,
                'type' => 'auth_error',
                'message' => 'Le mot de passe actuel est incorrect.'
            ]);
        }

        // Vérifier nouveau doit etre different de l'ancien
        if (Hash::check($request->new_password, $user->password)) {
            return response()->json([
                'status' => false,
                'type' => 'auth_error',
                'message' => 'Le nouveau mot de passe doit être différent de l\'ancien.'
            ]);
        }

        // Update Password
        $user->update([
            'password' => Hash::make($request->new_password)
        ]);

        return response()->json([
            'status' => true,
            'message' => 'Mot de passe modifié avec succès.'
        ]);

    }

    public function pictureProfile(UpdateUserPicture $request)
    {
        $user = auth()->user();

        $imageName = $user->id . '-' . time() . '.' . $request->file('image')->extension();
        $path = $request->file('image')->storeAs('profile_avatar', $imageName, 'public');

        // supprimer ancienne image
        if ($user->avatar) {
            Storage::disk('public')->delete('profile_avatar/' . $user->avatar);
            Storage::disk('public')->delete('profile_avatar/thumb/' . $user->avatar);
        }


        // create new manager instance with desired driver
        $manager = new ImageManager(new Driver());
        $imagePath = storage_path('app/public/profile_avatar/' . $imageName);

        $image = $manager->read($imagePath);

        $thumbPath = storage_path('app/public/profile_avatar/thumb/' . $imageName);

        $image->cover(150, 150)
            ->toPng()
            ->save($thumbPath);

        // UPDATE 
        $user->update(['avatar' => $imageName]);

        return response()->json([
            'status' => true,
            'image' => asset('storage/profile_avatar/thumb/' . $imageName),
            'message' => 'Image mise à jour.'
        ]);

    }

    // Login
    public function logout(Request $request)
    {
        Auth::logout();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect()
            ->route('auth.login')
            ->with('success', 'Vous êtes déconnecté avec succès.');
    }

}
