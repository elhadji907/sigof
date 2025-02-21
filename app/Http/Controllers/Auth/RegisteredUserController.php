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
use Illuminate\Validation\Rules;
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
        $request->validate([
            'username' => ['required', 'string', 'min:3', 'max:25', 'unique:' . User::class],
            'email'    => ['required', 'string', 'lowercase', 'email', 'max:255', 'unique:' . User::class],
            'termes'    => ['required', 'accepted'], // 'accepted' est plus approprié pour un champ de type checkbox
            'password' => ['required', 'confirmed', Rules\Password::defaults()],
        ]);

        $user = User::create([
            'username' => $request->username,
            'email'    => $request->email,
            'password' => Hash::make($request->password),
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

        alert()->html('<i>Félicitations </i> <a href="#">' . $user->username . '</a>', "Votre inscription a été effectuée avec <b>succès</b>, <br>
        Pour activer votre compte, veuillez vérifier votre <a href='#'>boîte e-mail</a> et suivre les instructions. <br>
        Si vous ne trouvez pas l'e-mail, pensez à vérifier votre dossier spam.", 'success');

        return redirect(RouteServiceProvider::LOGIN);
    }
}
