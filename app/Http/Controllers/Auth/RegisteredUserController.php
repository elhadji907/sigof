<?php
namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\File;
use App\Models\User;
use App\Providers\RouteServiceProvider;
use Illuminate\Auth\Events\Registered;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rule;
use Illuminate\View\View;
use RealRashid\SweetAlert\Facades\Alert;

class RegisteredUserController extends Controller
{
    /**
     * Display the registration view.
     */
    public function create(): View
    {
        /*  return view('auth.register'); */
        return view('user.register-page');
    }

    /**
     * Handle an incoming registration request.
     *
     * @throws \Illuminate\Validation\ValidationException
     */
    public function store(Request $request): RedirectResponse
    {
        // Vérification incluant les utilisateurs soft deleted
        $request->validate([
            'username'        => [
                'required',
                'string',
                'min:3',
                'max:10',
                Rule::unique('users')->whereNull('deleted_at'), // Ignore les utilisateurs supprimés
            ],
            'email'           => [
                'required',
                'string',
                'email',
                'max:255',
                Rule::unique('users')->whereNull('deleted_at'), // Ignore les utilisateurs supprimés
            ],
            'votre_telephone' => ['required', 'string', 'min:12', 'max:12'],
            'termes'          => ['required', 'accepted'], // 'accepted' est plus approprié pour un champ de type checkbox
            /* 'password' => ['required', 'confirmed', Rules\Password::defaults()], */
            'password'        => 'required|string|min:8|confirmed',
        ]);

        // Vérifier si l'utilisateur existe mais est supprimé
        $user = User::withTrashed()->where('email', $request->email)->first();

        if ($user) {
            // Restaurer l'utilisateur supprimé
            $user->restore();

            // Mettre à jour le mot de passe (optionnel)
            $user->password = Hash::make($request->password);
            $user->save();

            Alert::success('Bonjour ' . $user->username . ', Heureux de vous retrouver !', 'Votre compte restauré avec succès');

            return redirect(RouteServiceProvider::LOGIN);

            /* return response()->json(['message' => 'Compte restauré avec succès !'], 200); */
        }

        $user = User::create([
            'username'  => substr(str_replace(' ', '', $request->username), 0, 10),
            'email'     => $request->email,
            'telephone' => $request->votre_telephone,
            'password'  => Hash::make($request->password),
        ]);

        $files = File::where('users_id', null)->distinct()->get();

        foreach ($files as $key => $file) {
            $file = File::create([
                'legende'  => $file->legende,
                'sigle'    => $file->sigle,
                'users_id' => $user->id,
            ]);
        }

        $user->assignRole($request->input('role'));

        event(new Registered($user));

        // Afficher une alerte de succès pour la création de compte
        /*  Alert::success(
            'Bienvenue ' . $user->username . ' !',
            "Votre inscription a été réussie.
            Pour activer votre compte, veuillez vérifier votre boîte e-mail et suivre les instructions.
            Si vous ne trouvez pas l'e-mail, pensez à vérifier votre dossier spam."
        ); */

        alert()->html('<i>Bienvenue </i> <a href="#">' . $user->username . '</a> !', "Votre inscription a été effectuée avec <b>succès</b>, <br>
        Pour activer votre compte, veuillez vérifier votre <a href='#'>boîte e-mail</a> et suivre les instructions. <br>
        Si vous ne trouvez pas l'e-mail, pensez à vérifier votre dossier spam.", 'success');

        return redirect(RouteServiceProvider::LOGIN);
    }
}
