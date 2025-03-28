<?php
namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Validation\Rule;
use Illuminate\View\View;
use Intervention\Image\Facades\Image;
use RealRashid\SweetAlert\Facades\Alert;

class ProfileOperateurController extends Controller
{

    /**
     * Display the user's profile show.
     */
    public function profilePage(Request $request): View
    {
        foreach (Auth::user()->roles as $role) {
            if ($role->name == 'Operateur') {
                return view('profile.profile-operateur-page', [
                    'user' => $request->user(),
                ]);
            } else {
                return view('profile.profile-page', [
                    'user' => $request->user(),
                ]);
            }
        }
        return view('profile.profile-page', [
            'user' => $request->user(),
        ]);
    }

    /**
     * Display the user's lin.
     */
    public function loginPage(Request $request): View
    {
        return view('user.login-page');
    }
    /**
     * Display the user's register.
     */
    public function registerPage(Request $request): View
    {
        return view('user.register-page');
    }

    /**
     * Display the user's profile form.
     */
    public function edit(Request $request): View
    {
        return view('profile.edit', [
            'user' => $request->user(),
        ]);
    }

    /**
     * Update the user's profile information.
     */
    /* public function update(ProfileOperateurUpdateRequest $request, $id): RedirectResponse
    {
        $request->user()->fill($request->validated());

        if ($request->user()->isDirty('email')) {
            $request->user()->email_verified_at = null;
        } */
    public function update(Request $request, $id)
    {

        $user = User::findOrFail($id);

        $this->validate($request, [
            'cin'                  => [
                'required',
                'string',
                'min:16',
                'max:17',
                Rule::unique(User::class)->ignore($id ?? null)->whereNull('deleted_at'),
            ],
            'username'             => [
                'required',
                'string',
                'min:3',
                'max:25',
                Rule::unique('users')->ignore($id ?? null)->whereNull('deleted_at'),
            ],
            'operateur'            => [
                'required',
                'string',
                'min:3',
                'max:25',
                Rule::unique('users')->ignore($id ?? null)->whereNull('deleted_at'),
            ],
            'image'                => ['sometimes', 'image', 'mimes:jpeg,png,jpg,gif,svg', 'max:1024'],
            'civilite'             => ['required', 'string', 'max:8'],
            'firstname'            => ['required', 'string', 'max:150'],
            'name'                 => ['required', 'string', 'max:25'],
            'categorie'            => ['required', 'string'],
            'rccm'                 => ['required', 'string'],
            'ninea'                => [
                'required',
                'string',
                'max:20',
                Rule::unique(User::class)->ignore($id ?? null)->whereNull('deleted_at'),
            ],
            'email'                => [
                'nullable',
                'string',
                'lowercase',
                'email',
                'max:255',
                Rule::unique(User::class)->ignore($id ?? null)->whereNull('deleted_at'),
            ],
            'email_responsable'    => [
                'nullable',
                'string',
                'lowercase',
                'email',
                'max:255',
                Rule::unique(User::class)->ignore($id ?? null)->whereNull('deleted_at'),
            ],
            'telephone'            => ['required', 'string', 'size:12'],
            'telephone_parent'     => ['required', 'string', 'size:12'],
            'adresse'              => ['required', 'string', 'max:255'],
            'fonction_responsable' => ['required', 'string', 'max:250'],
            'twitter'              => ['nullable', 'string', 'max:255'],
            'facebook'             => ['nullable', 'string', 'max:255'],
            'instagram'            => ['nullable', 'string', 'max:255'],
            'linkedin'             => ['nullable', 'string', 'max:255'],
            'web'                  => ['nullable', 'string', 'max:255'],
            'fixe'                 => ['nullable', 'string', 'max:255'],
            'statut'               => ['nullable', 'string', 'max:255'],
        ]);

        $cin = $request->input('cin') ?? null;

        $user->update([
            'cin'                  => $cin,
            'username'             => $request->input('username'),
            'operateur'            => $request->input('operateur'),
            'civilite'             => $request->input('civilite'),
            'firstname'            => $request->input('firstname'),
            'name'                 => $request->input('name'),
            'categorie'            => $request->input('categorie'),
            'rccm'                 => $request->input('rccm'),
            'ninea'                => $request->input('ninea'),
            'email_responsable'    => $request->input('email_responsable'),
            'telephone'            => $request->input('telephone'),
            'telephone_parent'     => $request->input('telephone_parent'),
            'adresse'              => $request->input('adresse'),
            'fonction_responsable' => $request->input('fonction_responsable'),
            'twitter'              => $request->input('twitter'),
            'facebook'             => $request->input('facebook'),
            'instagram'            => $request->input('instagram'),
            'linkedin'             => $request->input('linkedin'),
            'web'                  => $request->input('web'),
            'fixe'                 => $request->input('fixe'),
            'statut'               => $request->input('statut'),
        ]);

        if (request('image')) {
            Storage::disk('public')->delete($user->image);
            $imagePath       = request('image')->store('avatars', 'public');
            $file            = $request->file('image');
            $filenameWithExt = $file->getClientOriginalName();
            $filename        = pathinfo($filenameWithExt, PATHINFO_FILENAME);
            // Remove unwanted characters
            $filename = preg_replace("/[^A-Za-z0-9 ]/", '', $filename);
            $filename = preg_replace("/\s+/", '-', $filename);
            // Get the original image extension
            $extension = $file->getClientOriginalExtension();

            // Create unique file name
            $fileNameToStore = 'avatars/' . $filename . '' . time() . '.' . $extension;

            /* dd($fileNameToStore); */

            $image = Image::make(public_path("/storage/{$imagePath}"))->fit(800, 800);

            $image->save();

            $request->user()->update([
                'image' => $imagePath,
            ]);
        }

        $request->user()->save();

        Alert::success('Succès ! ', 'Votre profil a été modifié avec succès');

        /* return Redirect::route('profile.edit')->with('status', 'profile-updated'); */
        /* return Redirect::route('profil')->with('status', 'Votre profil a été modifié avec succès'); */
        return back(); // Redirige vers la page précédente
    }

    /**
     * Delete the user's account.
     */
    public function destroy(Request $request): RedirectResponse
    {
        $request->validateWithBag('userDeletion', [
            'password' => ['required', 'current_password'],
        ]);

        $user = $request->user();

        Auth::logout();

        $user->delete();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return Redirect::to('/');
    }
}
