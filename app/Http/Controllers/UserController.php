<?php
namespace App\Http\Controllers;

use App\Http\Requests\StoreUserRequest;
use App\Models\Arrive;
use App\Models\Collective;
use App\Models\Depart;
use App\Models\Departement;
use App\Models\Direction;
use App\Models\Employee;
use App\Models\Fonction;
use App\Models\Formation;
use App\Models\Individuelle;
use App\Models\Ingenieur;
use App\Models\Interne;
use App\Models\Listecollective;
use App\Models\Module;
use App\Models\Operateur;
use App\Models\Region;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Storage;
use Illuminate\Validation\Rule;
use Illuminate\Validation\Rules;
use Intervention\Image\Facades\Image;
use RealRashid\SweetAlert\Facades\Alert;
use Spatie\Permission\Models\Role;

class UserController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
        $this->middleware(['role:super-admin|admin|DIOF|DEC|DPP']);
        $this->middleware("permission:user-view", ["only" => ["index"]]);
        $this->middleware("permission:user-create", ["only" => ["create", "store"]]);
        $this->middleware("permission:user-update", ["only" => ["update", "edit"]]);
        $this->middleware("permission:user-show", ["only" => ["show"]]);
        $this->middleware("permission:user-delete", ["only" => ["destroy"]]);
        $this->middleware("permission:give-role-permissions", ["only" => ["givePermissionsToRole"]]);
    }

    public function homePage()
    {
        $total_user = User::count();
        /* $email_verified_at = DB::table(table: 'users')->where('email_verified_at', '!=', null)->count(); */

        $email_verified_at = User::whereNotNull('email_verified_at')->count();
        $email_verified_at = ($email_verified_at / $total_user) * 100;
        $email_verified_at = number_format($email_verified_at, 2, ',', ' ');

        $total_arrive  = Arrive::where('type', null)->count();
        $total_depart  = Depart::count();
        $total_interne = Interne::count();

        $formations = Formation::where('statut', "Démarrée")
            ->orderBy('created_at', 'desc')
            ->get();

        $count_formations = Formation::where('statut', "Démarrée")->count();

        $total_courrier = $total_arrive + $total_depart + $total_interne;

        /*     if ($total_courrier != 0) {
            $pourcentage_arrive  = ($total_arrive / $total_courrier) * 100;
            $pourcentage_depart  = ($total_depart / $total_courrier) * 100;
            $pourcentage_interne = ($total_interne / $total_courrier) * 100;
        } else {
            $pourcentage_arrive  = 0;
            $pourcentage_depart  = 0;
            $pourcentage_interne = 0;
        } */
        $pourcentage_arrive  = $total_courrier != 0 ? ($total_arrive / $total_courrier) * 100 : 0;
        $pourcentage_depart  = $total_courrier != 0 ? ($total_depart / $total_courrier) * 100 : 0;
        $pourcentage_interne = $total_courrier != 0 ? ($total_interne / $total_courrier) * 100 : 0;

        $total_individuelle = Individuelle::count();
        $roles              = Role::orderBy('created_at', 'desc')->get();
        /* return view("home-page", compact("total_user", 'roles', 'total_arrive', 'total_depart', 'total_individuelle')); */

        /* $individuelles = Individuelle::skip(0)->take(1000)->get(); */
        $individuelles = Individuelle::get();

        $collectives = Collective::get();

        $listecollectives = Listecollective::get();

        $departements = Departement::orderBy("created_at", "desc")->get();

        $modules = Module::orderBy("created_at", "desc")->get();

        $today = date('Y-m-d');

        $annee = date('Y');

        $annee_lettre = 'Diagramme à barres, année: ' . date('Y');

        $count_today_individuelle = Individuelle::where("created_at", "LIKE", "{$today}%")->count();

        $count_today_collective = Collective::where("created_at", "LIKE", "{$today}%")->count();

        $count_today = $count_today_individuelle + $count_today_collective;

        $counts = DB::table('individuelles')
            ->selectRaw('MONTH(created_at) as month, count(*) as count')
            ->whereYear('created_at', $annee)
            ->whereNull('deleted_at')
            ->groupBy(DB::raw('MONTH(created_at)'))
            ->pluck('count', 'month');

        // Initialiser les variables avec 0 au cas où il manque un mois
        $janvier   = $counts->get(1, 0);
        $fevrier   = $counts->get(2, 0);
        $mars      = $counts->get(3, 0);
        $avril     = $counts->get(4, 0);
        $mai       = $counts->get(5, 0);
        $juin      = $counts->get(6, 0);
        $juillet   = $counts->get(7, 0);
        $aout      = $counts->get(8, 0);
        $septembre = $counts->get(9, 0);
        $octobre   = $counts->get(10, 0);
        $novembre  = $counts->get(11, 0);
        $decembre  = $counts->get(12, 0);

        $masculin = Individuelle::join('users', 'users.id', 'individuelles.users_id')
            ->select('individuelles.*')
            ->where('users.civilite', "M.")
            ->count();

        $feminin = Individuelle::join('users', 'users.id', 'individuelles.users_id')
            ->select('individuelles.*')
            ->where('users.civilite', "Mme")
            ->count();

        $statuts = Individuelle::selectRaw('statut, count(*) as count')
            ->whereIn('statut', ['Attente', 'Nouvelle', 'Retenue', 'Terminée', 'Rejetée'])
            ->groupBy('statut')
            ->pluck('count', 'statut');

        $attente  = $statuts['Attente'] ?? 0;
        $nouvelle = $statuts['Nouvelle'] ?? 0;
        $retenue  = $statuts['Retenue'] ?? 0;
        $terminer = $statuts['Terminée'] ?? 0;
        $rejeter  = $statuts['Rejetée'] ?? 0;

        $pourcentage_hommes = $individuelles->count() > 0
        ? ($masculin / $individuelles->count()) * 100
        : 0;

        $pourcentage_femmes = $individuelles->count() > 0
        ? ($feminin / $individuelles->count()) * 100
        : 0;

        $feminin_collective = Listecollective::where('civilite', "Mme")
            ->count();

        $masculin_collective = Listecollective::where('civilite', "M.")
            ->count();

        $pourcentage_femmes_collective = $listecollectives->count() > 0
        ? ($feminin_collective / $listecollectives->count()) * 100
        : 0;

        $pourcentage_hommes_collective = $listecollectives->count() > 0
        ? ($masculin_collective / $listecollectives->count()) * 100
        : 0;

        $count_demandes = ($individuelles ? $individuelles->count() : 0) +
            ($listecollectives ? $listecollectives->count() : 0);

        return view(
            "home-page",
            compact(
                "total_user",
                'roles',
                'total_arrive',
                'total_depart',
                'total_individuelle',
                "pourcentage_femmes",
                "pourcentage_femmes_collective",
                "pourcentage_hommes_collective",
                "pourcentage_hommes",
                "count_demandes",
                'rejeter',
                "terminer",
                "retenue",
                "nouvelle",
                'attente',
                "individuelles",
                "collectives",
                "modules",
                "departements",
                "count_today",
                'janvier',
                'fevrier',
                'mars',
                'avril',
                'mai',
                'juin',
                'juillet',
                'aout',
                'septembre',
                'octobre',
                'novembre',
                'decembre',
                'annee',
                'annee_lettre',
                'masculin',
                'feminin',
                'email_verified_at',
                'total_interne',
                'pourcentage_arrive',
                'pourcentage_depart',
                'pourcentage_interne',
                'count_formations',
                'formations'
            )
        );
    }

    public function create()
    {
        $roles = Role::pluck('name', 'name')->all();

        return view("user.create", compact("roles"));
    }

    public function index()
    {
        /* $total_count = User::get();
        $total_count = number_format($total_count->count(), 0, ',', ' ');

        $roles = Role::pluck('name', 'name')->all();

        $user_liste = User::take(100)
            ->latest()
            ->get();

        $count_demandeur = number_format($user_liste?->count(), 0, ',', ' ');

        if ($count_demandeur < "1") {
            $title = 'Aucun utilisateur';
        } elseif ($count_demandeur == "1") {
            $title = $count_demandeur . ' utilisateur sur un total de ' . $total_count;
        } else {
            $title = 'Liste des ' . $count_demandeur . ' derniers utilisateurs sur un total de ' . $total_count;
        }

        return view("user.index", compact("user_liste", "title", "roles")); */
        // Nombre total d'utilisateurs (sans charger toute la table)
        $count_raw   = User::count();
        $total_count = number_format($count_raw, 0, ',', ' ');

// Récupération de la liste des rôles sous forme de tableau clé-valeur
        $roles = Role::pluck('name', 'name')->all();

// Récupération des 100 derniers utilisateurs
        $user_liste          = User::latest()->limit(100)->get();
        $count_demandeur_raw = $user_liste->count();
        $count_demandeur     = number_format($count_demandeur_raw, 0, ',', ' ');

// Définition du titre avec des comparaisons correctes
        if ($count_demandeur_raw < 1) {
            $title = 'Aucun utilisateur';
        } elseif ($count_demandeur_raw == 1) {
            $title = '1 utilisateur sur un total de ' . $total_count;
        } else {
            $title = 'Liste des ' . $count_demandeur . ' derniers utilisateurs sur un total de ' . $total_count;
        }

// Retour de la vue avec les données optimisées
        return view("user.index", compact("user_liste", "title", "roles"));

    }

    public function store(StoreUserRequest $request): RedirectResponse
    {
        if ($request->password) {
            $password = Hash::make($request->password);
        } else {
            $password = Hash::make($request->email);
        }
        $user = User::create([
            'username'  => substr(str_replace(' ', '', $request->username), 0, 10),
            'firstname' => format_proper_name($request->firstname),
            'name'      => remove_accents_uppercase($request->name),
            'email'     => $request->email,
            'telephone' => $request->telephone,
            'adresse'   => $request->adresse,
            'password'  => $password,
        ]);

        if (request('image')) {
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

            //dd($fileNameToStore);

            $image = Image::make(public_path("/storage/{$imagePath}"))->fit(800, 800);

            $image->save();

            $user->update([
                'image' => $imagePath,
            ]);
        }

        $user->syncRoles($request->roles);

        /* $user = User::create($request->all()); */

        /*  $status = "Enregistrement effectué avec succès";
        return redirect()->back()->with("status", $status); */

        Alert::success('Effectué !', 'Utilisateur enregistré');
        return redirect()->back();
    }

    public function edit($id)
    {
        $roles = Role::pluck('name', 'name')->all();

        $user = User::findOrFail($id);

        $userRoles = $user->roles->pluck('name', 'name')->all();

        return view("user.update", compact('user', 'roles', 'userRoles'));
    }

    public function update(Request $request, $id)
    {
        $user = User::findOrFail($id);

        // Vérifie si l'utilisateur connecté a le rôle 'super-admin' ou 'admin'
        if (! Auth::user()->hasRole(['super-admin', 'admin'])) {
            $this->authorize('update', $user);
        }

        if ($request->input('employe') == "1") {
            $this->validate($request, [
                /* "matricule"           => ['nullable', 'string', 'min:8', 'max:8',Rule::unique(Employee::class)], */
                "matricule" => ['nullable', 'string', 'min:8', 'max:8', "unique:employees,matricule,Null,{$user?->employee?->id},deleted_at,NULL"],
                /* 'cin'                 => ['required', 'string', 'min:13', 'max:15',Rule::unique(User::class)], */
                'direction' => ['required', 'string'],
            ]);

            Employee::create([
                'users_id'      => $user?->id,
                /* 'cin'           => $request?->input('employe'), */
                'matricule'     => $request?->input('matricule'),
                'directions_id' => $request?->input('direction'),
            ]);
            Alert::success('Effectuée ! ', 'employé ajouté');

            /* $user->assignRole('Employe'); */

            return Redirect::back();

        } elseif ($request->input('ingenieur') == "1") {
            $this->validate($request, [
                "initiale" => ['required', 'string', 'min:2', 'max:5', "unique:ingenieurs,initiale,Null,{$user?->ingenieur?->id},deleted_at,NULL"],
                'fonction' => ['required', 'string'],
            ]);

            $ingenieur = Ingenieur::create([
                "users_id"  => $user?->id,
                "name"      => $user?->firstname . ' ' . $user?->name,
                "initiale"  => $request->input("initiale"),
                "fonction"  => $request->input("fonction"),
                "email"     => $user?->email,
                "telephone" => $user?->telephone,
            ]);

            $ingenieur->save();

            Alert::success('Effectuée ! ', 'ingénieur ajouté');

            /* $user->assignRole('Ingenieur'); */

            return Redirect::back();

        } else {

            $this->validate($request, [
                'civilite'       => ['nullable', 'string', 'max:10'],
                'username'       => ["required", "string", "max:25", Rule::unique(User::class)->ignore($id)],
                'cin'            => [
                    'required',
                    'string',
                    'min:16',
                    'max:17',
                    Rule::unique(User::class)->ignore($id ?? null)->whereNull('deleted_at'),
                ],
                'firstname'      => ['required', 'string', 'max:150'],
                'name'           => ['required', 'string', 'max:50'],
                'date_naissance' => ['nullable', 'date_format:d/m/Y'],
                'lieu_naissance' => ['string', 'nullable'],
                'image'          => ['image', 'nullable', 'mimes:jpeg,png,jpg,gif,svg', 'max:2048'],
                'telephone'      => ['required', 'string', 'max:12', 'min:9'],
                'adresse'        => ['required', 'string', 'max:255'],
                'roles.*'        => ['string', 'max:255', 'nullable', 'max:255'],
                "email"          => ["lowercase", 'email', "max:255", Rule::unique(User::class)->ignore($id)],
            ]);

            if (! empty($request->date_naissance)) {
                $dateString     = $request->input('date_naissance');
                $date_naissance = Carbon::createFromFormat('d/m/Y', $dateString);

            } else {
                $date_naissance = null;
            }

            if (request('image')) {
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

                //dd($fileNameToStore);

                $image = Image::make(public_path("/storage/{$imagePath}"))->fit(800, 800);

                $image->save();

                $user->update([
                    'image' => $imagePath,
                ]);
            }

            $user->update([
                'civilite'                  => $request->civilite,
                'username'                  => substr(str_replace(' ', '', $request->username), 0, 10),
                'cin'                       => $request->cin,
                'firstname'                 => format_proper_name($request->firstname),
                'name'                      => remove_accents_uppercase($request->name),
                'date_naissance'            => $date_naissance,
                'lieu_naissance'            => remove_accents_uppercase($request->lieu_naissance),
                'situation_familiale'       => $request->situation_familiale,
                'situation_professionnelle' => $request->situation_professionnelle,
                'email'                     => $request->email,
                'telephone'                 => $request->telephone,
                'adresse'                   => $request->adresse,
                'twitter'                   => $request->twitter,
                'facebook'                  => $request->facebook,
                'instagram'                 => $request->instagram,
                'linkedin'                  => $request->linkedin,
                'updated_by'                => Auth::user()->id,
            ]);

            $user->syncRoles($request->roles);

            Alert::success('Succès !', 'Les modifications ont été enregistrées avec succès.');

            /* return Redirect::route('user.index'); */
            return Redirect::back();
        }
    }

    public function show($id)
    {
        $user = User::findOrFail($id);

        // Vérifie si l'utilisateur connecté a le rôle 'super-admin' ou 'admin'
        if (! Auth::user()->hasRole(['super-admin', 'admin'])) {
            $this->authorize('update', $user);
        }

        /* if ($user->created_by == null || $user->updated_by == null) {
            $user_create_name = $user?->civilite . ' ' . $user?->firstname . ' ' . $user?->name;
            $user_update_name = $user?->civilite . ' ' . $user?->firstname . ' ' . $user?->name;
        } else {
            $user_created_id = $user->created_by;
            $user_updated_id = $user->updated_by;

            $user_create = User::findOrFail($user_created_id);
            $user_update = User::findOrFail($user_updated_id);

            $user_create_name = $user_create->firstname . ' ' . $user_create->firstname;
            $user_update_name = $user_update->firstname . ' ' . $user_update->firstname;
        } */

        function getUserName(?User $user): string
        {
            return $user ? trim("{$user->civilite} {$user->firstname} {$user->name}") : 'Utilisateur inconnu';
        }

        $user_create = User::find($user->created_by);
        $user_update = User::find($user->updated_by);

        $user_create_name = getUserName($user_create ?? $user);
        $user_update_name = getUserName($user_update ?? $user);

        /*   $roles      = Role::pluck('name', 'name')->all();
        $userRoles  = $user->roles->pluck('name', 'name')->all();
        $directions = Direction::orderBy('created_at', 'desc')->get();
        $fonctions  = Fonction::orderBy('created_at', 'desc')->get(); */

        $roles      = Role::pluck('name')->toArray();
        $userRoles  = $user->roles->pluck('name')->toArray();
        $directions = Direction::latest()->get();
        $fonctions  = Fonction::latest()->get();

        return view("user.show", compact("user", "user_create_name", "user_update_name", "roles", "userRoles", "directions", "fonctions"));
    }

    /* public function destroy($userId)
    {
        $user = User::findOrFail($userId);

        foreach (Auth::user()->roles as $key => $role) {
            if (strpos($role?->name, 'super-admin') !== false || strpos($role?->name, 'admin') !== false) {
            } else {
                $this->authorize('delete', $user);
            }
        }

        if (! empty($user->image)) {
            Storage::disk('public')->delete($user->image);
            $user->update([
                'image' => null,
            ]);
        }

        $user->roles()->detach();

        $user->delete();

        Alert::success('Succès !', $user->firstname . ' ' . $user->name . ' a été supprimé(e).');

        return redirect()->back();
    } */

    public function destroy($userId)
    {
        $user = User::findOrFail($userId);

        // Vérifier si l'utilisateur connecté est un admin ou super-admin
        $userRoles = collect(Auth::user()->roles)->pluck('name');
        if (! $userRoles->contains(fn($role) => str_contains($role, 'super-admin') || str_contains($role, 'admin'))) {
            $this->authorize('delete', $user);
        }

        DB::transaction(function () use ($user) {
            // Suppression de l'image si elle existe
            if (! empty($user->image)) {
                Storage::disk('public')->delete($user->image);
                $user->update(['image' => null]);
            }

            // Détacher les rôles et supprimer l'utilisateur
            $user->roles()->detach();
            $user->delete();
        });

        // Message de succès
        Alert::success('Succès !', "{$user->firstname} {$user->name} a été supprimé(e).");

        return redirect()->back();
    }

    public function rapports(Request $request)
    {
        $title = 'Générer rapport utilisateurs';
        $roles = Role::pluck('name', 'name')->all();
        return view('user.rapports', compact(
            'title',
            'roles'
        ));
    }
    public function generateRapport(Request $request)
    {
        if ($request->cin_value == "1") {
            $this->validate($request, [
                'cin' => 'required|string|min:10|max:15',
            ]);

            $users = User::where('cin', 'LIKE', "%{$request->cin}%")
                ->distinct()
                ->get();

            $count = $users->count();

            if (isset($count) && $count <= "1") {
                $user = 'utilisateur';
            } else {
                $user = 'utilisateurs';
            }

            $title = $count . ' ' . $user . ' avec le cin ' . $request->cin;
        } elseif ($request->date_value == "1") {
            $this->validate($request, [
                'from_date' => 'required|date',
                'to_date'   => 'required|date',
            ]);

            $now = Carbon::now()->format('H:i:s');

            $from_date = date_format(date_create($request->from_date), 'd/m/Y');

            $to_date = date_format(date_create($request->to_date), 'd/m/Y');

            $users = User::whereBetween(DB::raw('DATE(date_naissance)'), [$request->from_date, $request->to_date])->get();

            $count = $users->count();

            if ($from_date == $to_date) {
                if (isset($count) && $count < "1") {
                    $title = 'aucune utilisateur né le ' . $from_date;
                } elseif (isset($count) && $count == "1") {
                    $title = $count . ' utilisateur né ' . $from_date;
                } else {
                    $title = $count . ' utilisateurs nés ' . $from_date;
                }
            } else {
                if (isset($count) && $count < "1") {
                    $title = 'aucune utilisateur né entre le ' . $from_date . ' au ' . $to_date;
                } elseif (isset($count) && $count == "1") {
                    $title = $count . ' utilisateur né entre le ' . $from_date . ' au ' . $to_date;
                } else {
                    $title = $count . ' utilisateurs nés entre le ' . $from_date . ' au ' . $to_date;
                }
            }
        } elseif ($request->telephone_value == "1") {
            $this->validate($request, [
                'telephone' => 'required|string|min:9|max:9',
            ]);

            $users = User::where('telephone', 'LIKE', "%{$request->telephone}%")
                ->orwhere('fixe', 'LIKE', "%{$request->telephone}%")
                ->distinct()
                ->get();

            $count = $users->count();

            if (isset($count) && $count <= "1") {
                $user = 'utilisateur';
            } else {
                $user = 'utilisateurs';
            }

            $title = $count . ' ' . $user . ' avec le téléphone ' . $request->telephone;
        } elseif ($request->date_value == "1") {
            $this->validate($request, [
                'from_date' => 'required|date',
                'to_date'   => 'required|date',
            ]);

            $now = Carbon::now()->format('H:i:s');

            $from_date = date_format(date_create($request->from_date), 'd/m/Y');

            $to_date = date_format(date_create($request->to_date), 'd/m/Y');

            $users = User::whereBetween(DB::raw('DATE(date_naissance)'), [$request->from_date, $request->to_date])->get();

            $count = $users->count();

            if ($from_date == $to_date) {
                if (isset($count) && $count < "1") {
                    $title = 'aucune utilisateur né le ' . $from_date;
                } elseif (isset($count) && $count == "1") {
                    $title = $count . ' utilisateur né ' . $from_date;
                } else {
                    $title = $count . ' utilisateurs nés ' . $from_date;
                }
            } else {
                if (isset($count) && $count < "1") {
                    $title = 'aucune utilisateur né entre le ' . $from_date . ' au ' . $to_date;
                } elseif (isset($count) && $count == "1") {
                    $title = $count . ' utilisateur né entre le ' . $from_date . ' au ' . $to_date;
                } else {
                    $title = $count . ' utilisateurs nés entre le ' . $from_date . ' au ' . $to_date;
                }
            }
        } elseif ($request->email_value == "1") {
            $this->validate($request, [
                'email' => 'required|email',
            ]);

            $users = User::where('email', 'LIKE', "%{$request->email}%")
                ->distinct()
                ->get();

            $count = $users->count();

            if (isset($count) && $count <= "1") {
                $user = 'utilisateur';
            } else {
                $user = 'utilisateurs';
            }

            $title = $count . ' ' . $user . ' avec le mail ' . $request->email;
        } elseif ($request->verify_value == "1") {

            $users = User::where('email_verified_at', '!=', null)
                ->distinct()
                ->get();

            $count = $users->count();

            if (isset($count) && $count <= "1") {
                $user = 'utilisateur avec un compte valide ';
            } else {
                $user = 'utilisateurs avec des comptes valides ';
            }

            $title = $count . ' ' . $user . ' ' . $request->email;
        } elseif ($request->role_value == "1") {
            $this->validate($request, [
                'role' => 'required|string',
            ]);

            $role = $request->role;

            $users = User::whereHas(
                'roles',
                function ($q) use ($role) {
                    $q->where('name', $role);
                }
            )->get();

            /* dd($users);

            $admins = User::whereHas('roles', function($q) use ($role){$q->whereIn('role.name', $role);})->get();

            dd($admins); */

            $count = $users->count();

            if (isset($count) && $count <= "1") {
                $user = 'utilisateur';
            } else {
                $user = 'utilisateurs';
            }

            $title = $count . ' ' . $user . ' avec le role ' . $role;
        } else {
            $this->validate($request, [
                'region' => 'required|string',
                'module' => 'required|string',
                'statut' => 'required|string',
            ]);

            $region = Region::findOrFail($request->region);

            $operateurs = Operateur::join('operateurmodules', 'operateurs.id', 'operateurmodules.operateurs_id')
                ->select('operateurs.*')
                ->where('statut_agrement', 'LIKE', "%{$request->statut}%")
                ->where('regions_id', "{$request->region}")
                ->where('operateurmodules.module', 'LIKE', "%{$request->module}%")
                ->distinct()
                ->get();

            $count = $operateurs->count();

            if (isset($count) && $count <= "1") {
                $operateur = 'opérateur';
                if (isset($request->statut) && $request->statut == "agréer") {
                    $statut = 'agréé';
                } else {
                    $statut = $request->statut;
                }
            } else {
                $operateur = 'opérateurs';
                if (isset($request->statut) && $request->statut == "agréer") {
                    $statut = 'agréés';
                } else {
                    $statut = $request->statut;
                }
            }
            $title = $count . ' ' . $operateur . ' ' . $statut . ' dans la région de  ' . $region->nom . ' en ' . $request->module;
        }

        $roles = Role::pluck('name', 'name')->all();

        return view('user.rapports', compact(
            'users',
            'roles',
            'title'
        ));
    }

    public function reports(Request $request)
    {
        $total_count = User::get();
        $total_count = number_format($total_count->count(), 0, ',', ' ');

        $roles = Role::pluck('name', 'name')->all();

        $user_liste = User::take(100)
            ->latest()
            ->get();

        $count_demandeur = number_format($user_liste?->count(), 0, ',', ' ');

        if ($count_demandeur < "1") {
            $title = 'Aucun utilisateur';
        } elseif ($count_demandeur == "1") {
            $title = $count_demandeur . ' utilisateur sur un total de ' . $total_count;
        } else {
            $title = 'Liste des ' . $count_demandeur . ' derniers utilisateurs sur un total de ' . $total_count;
        }

        return view("user.index", compact("user_liste", "title", "roles"));
    }

    public function generateReport(Request $request)
    {
        $this->validate($request, [
            'cin'       => 'nullable|string',
            'name'      => 'nullable|string',
            'firstname' => 'nullable|string',
            'telephone' => 'nullable|string',
            'email'     => 'nullable|email',
        ]);

        if ($request?->cin == null && $request->firstname == null && $request->telephone == null && $request->name == null && $request->email == null) {
            Alert::warning('Recherche impossible', 'Veuillez remplir au moins un champ avant de continuer.');
            return redirect()->back();
        }

        $user_liste = User::where('firstname', 'LIKE', "%{$request?->firstname}%")
            ->where('name', 'LIKE', "%{$request?->name}%")
            ->where('cin', 'LIKE', "%{$request?->cin}%")
            ->where('telephone', 'LIKE', "%{$request?->telephone}%")
            ->where('email', 'LIKE', "%{$request?->email}%")
            ->distinct()
            ->get();

        $count = $user_liste?->count();

        if (isset($count) && $count < "1") {
            $title = 'aucun utilisateur trouvée';
        } elseif (isset($count) && $count == "1") {
            $title = $count . ' utilisateur trouvée';
        } else {
            $title = $count . ' utilisateurs trouvées';
        }

        $roles        = Role::pluck('name', 'name')->all();
        $departements = Departement::orderBy("created_at", "DESC")->get();
        /* $modules = Module::orderBy("created_at", "desc")->get(); */

        return view('user.index', compact(
            'user_liste',
            'departements',
            'roles',
            'title'
        ));
    }

    public function resetuserPassword(Request $request, $id)
    {

        $request->validate([
            'password' => ['required', 'confirmed', Rules\Password::defaults()],
        ]);

        $user = User::findOrFail($id);

        $user->update([
            'password' => Hash::make($request->password),
        ]);

        Alert::success('Succès !', 'Votre mot de passe a été réinitialisé avec succès.');

        return Redirect::back();

    }

    public function backup(Request $request)
    {

        Artisan::call('database:backup');

        Alert::success('Sauvegarde réussie !', 'Waw.');

        return Redirect::back();
    }

    public function ingenieurformations(Request $request)
    {
        $user = Auth::user();

        /* $nouvelle_formations = Formation::join('individuelles', 'formations.id', 'individuelles.formations_id')
            ->select('formations.*')
            ->where('individuelles.users_id', $user->id)
            ->where('formations.statut', 'Nouvelle')->get(); */

        return view("profile.formations", compact("user"));
    }

    public function actifs()
    {
        $total_count = User::whereNotNull('email_verified_at')->count();
        $total_count = number_format($total_count, 0, ',', ' ');

        $roles = Role::pluck('name', 'name')->all();

        $user_liste = User::whereNotNull('email_verified_at')
            ->latest()
            ->take(100)
            ->get();

        $count_demandeur = number_format($user_liste->count(), 0, ',', ' ');

        if ($count_demandeur < 1) {
            $title = 'Aucun utilisateur vérifié';
        } elseif ($count_demandeur == 1) {
            $title = "$count_demandeur utilisateur vérifié sur un total de $total_count";
        } else {
            $title = "Liste des $count_demandeur derniers utilisateurs vérifiés sur un total de $total_count";
        }

        return view("user.actifs", compact("user_liste", "title", "roles"));
    }

    public function inactifs()
    {
        $total_count = User::whereNull('email_verified_at')->count();
        $total_count = number_format($total_count, 0, ',', ' ');

        $roles = Role::pluck('name', 'name')->all();

        $user_liste = User::whereNull('email_verified_at')
            ->latest()
            ->take(100)
            ->get();

        $count_demandeur = number_format($user_liste->count(), 0, ',', ' ');

        if ($count_demandeur < 1) {
            $title = 'Aucun utilisateur non vérifié';
        } elseif ($count_demandeur == 1) {
            $title = "$count_demandeur utilisateur non vérifié sur un total de $total_count";
        } else {
            $title = "Liste des $count_demandeur derniers utilisateurs non vérifiés sur un total de $total_count";
        }

        return view("user.inactifs", compact("user_liste", "title", "roles"));
    }

    public function corbeille()
    {
        $total_count = User::onlyTrashed()->count();
        $total_count = number_format($total_count, 0, ',', ' ');

        $roles = Role::pluck('name', 'name')->all();

        $user_liste = User::onlyTrashed()
            ->latest()
            ->take(100)
            ->get();

        $count_demandeur = number_format($user_liste->count(), 0, ',', ' ');

        if ($count_demandeur < 1) {
            $title = 'Aucun utilisateur supprimé';
        } elseif ($count_demandeur == 1) {
            $title = "$count_demandeur utilisateur supprimé sur un total de $total_count";
        } else {
            $title = "Liste des $count_demandeur derniers utilisateurs supprimés sur un total de $total_count";
        }

        return view("user.corbeille", compact("user_liste", "title", "roles"));

    }

    public function restored()
    {
        $total_count = User::whereNotNull('restored_at')->count();
        $total_count = number_format($total_count, 0, ',', ' ');

        $roles = Role::pluck('name', 'name')->all();

        $user_liste = User::whereNotNull('restored_at')
            ->latest()
            ->take(100)
            ->get();

        $count_demandeur = number_format($user_liste->count(), 0, ',', ' ');

        if ($count_demandeur < 1) {
            $title = 'Aucun utilisateur restauré';
        } elseif ($count_demandeur == 1) {
            $title = "$count_demandeur utilisateur restauré sur un total de $total_count";
        } else {
            $title = "Liste des $count_demandeur derniers utilisateurs restaurés sur un total de $total_count";
        }

        return view("user.restored", compact("user_liste", "title", "roles"));
    }

    public function errors()
    {
        return view('errors.500');
    }

    public function showOnlineUsers()
    {
        $users = User::online()->get();
        return view('user.online', compact('users'));
    }
}
