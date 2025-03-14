<?php
namespace App\Http\Controllers;

use App\Models\Arrondissement;
use App\Models\Commune;
use App\Models\Departement;
use App\Models\File;
use App\Models\Individuelle;
use App\Models\Module;
use App\Models\Projet;
use App\Models\Region;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Redirect;
use RealRashid\SweetAlert\Facades\Alert;

class IndividuelleController extends Controller
{
    public function __construct()
    {
        // examples:
        $this->middleware('auth');
        $this->middleware(['role:super-admin|admin|Demandeur|DIOF|ADIOF']);
        /* $this->middleware("permission:user-view", ["only" => ["index"]]); */
        $this->middleware("permission:individuelle-view", ["only" => ["index"]]);
        /* $this->middleware(['permission:arrive-show']); */
        // or with specific guard
        /* $this->middleware(['role_or_permission:super-admin']); */
    }
    public function index()
    {
        /* $individuelles = Individuelle::skip(0)->take(1000)->get(); */
        //skip permet de sauter des lignes, par exemple skip(2) permet de parcourrir la BD en sautant ligne par 2
        //take joue le même role que limit
        $total_count = Individuelle::get();
        $total_count = number_format($total_count->count(), 0, ',', ' ');

        $individuelles = Individuelle::limit(500)
            ->latest()
            ->get();

        $count_demandeur = number_format($individuelles?->count(), 0, ',', ' ');

        if ($count_demandeur < "1") {
            $title = 'Aucune demande individuelle';
        } elseif ($count_demandeur == "1") {
            $title = $count_demandeur . ' demande individuelle sur un total de ' . $total_count;
        } else {
            $title = 'Liste des ' . $count_demandeur . ' dernières demandes individuelles sur un total de ' . $total_count;
        }

        $departements = Departement::orderBy("created_at", "DESC")->get();
        $modules      = Module::orderBy("created_at", "desc")->get();

        /* $today = date('Y-m-d');
        $annee = date('Y');
        $annee_lettre = 'Diagramme à barres, année: ' . date('Y');
        $count_today = Individuelle::where("created_at", "LIKE",  "{$today}%")->count();

        $janvier = DB::table('individuelles')->whereMonth("created_at", "01")->where("created_at", "LIKE", "{$annee}%")->where('deleted_at', null)->count();
        $fevrier = DB::table('individuelles')->whereMonth("created_at", "02")->where("created_at", "LIKE", "{$annee}%")->where('deleted_at', null)->count();
        $mars = DB::table('individuelles')->whereMonth("created_at", "03")->where("created_at", "LIKE", "{$annee}%")->where('deleted_at', null)->count();
        $avril = DB::table('individuelles')->whereMonth("created_at", "04")->where("created_at", "LIKE", "{$annee}%")->where('deleted_at', null)->count();
        $mai = DB::table('individuelles')->whereMonth("created_at", "05")->where("created_at", "LIKE", "{$annee}%")->where('deleted_at', null)->count();
        $juin = DB::table('individuelles')->whereMonth("created_at", "06")->where("created_at", "LIKE", "{$annee}%")->where('deleted_at', null)->count();
        $juillet = DB::table('individuelles')->whereMonth("created_at", "07")->where("created_at", "LIKE", "{$annee}%")->where('deleted_at', null)->count();
        $aout = DB::table('individuelles')->whereMonth("created_at", "08")->where("created_at", "LIKE", "{$annee}%")->where('deleted_at', null)->count();
        $septembre = DB::table('individuelles')->whereMonth("created_at", "09")->where("created_at", "LIKE", "{$annee}%")->where('deleted_at', null)->count();
        $octobre = DB::table('individuelles')->whereMonth("created_at", "10")->where("created_at", "LIKE", "{$annee}%")->where('deleted_at', null)->count();
        $novembre = DB::table('individuelles')->whereMonth("created_at", "11")->where("created_at", "LIKE", "{$annee}%")->where('deleted_at', null)->count();
        $decembre = DB::table('individuelles')->whereMonth("created_at", "12")->where("created_at", "LIKE", "{$annee}%")->where('deleted_at', null)->count();

        $masculin = Individuelle::join('users', 'users.id', 'individuelles.users_id')
        ->select('individuelles.*')
        ->where('users.civilite', "M.")
        ->count();

        $feminin = Individuelle::join('users', 'users.id', 'individuelles.users_id')
        ->select('individuelles.*')
        ->where('users.civilite', "Mme")
        ->count();

        $attente = Individuelle::where('statut', 'Attente')
        ->count();

        $nouvelle = Individuelle::where('statut', 'Nouvelle')
        ->count();

        $retenue = Individuelle::where('statut', 'Retenue')
        ->count();

        $terminer = Individuelle::where('statut', "Terminée")
        ->count();

        $rejeter = Individuelle::where('statut', 'Rejetée')
        ->count();

        $pourcentage_hommes = ($masculin / $individuelles->count()) * 100;
        $pourcentage_femmes = ($feminin / $individuelles->count()) * 100;

        return view("individuelles.index", compact("pourcentage_femmes",
        "pourcentage_hommes", 'Rejetée', "Terminée", "retenue", "Nouvelle",
        'Attente', "individuelles", "modules", "departements", "count_today",
        'janvier', 'fevrier', 'mars', 'avril', 'mai', 'juin', 'juillet', 'aout',
        'septembre', 'octobre', 'novembre', 'decembre', 'annee', 'annee_lettre',
        'masculin', 'feminin'));*/

        return view(
            "individuelles.index",
            compact('individuelles', 'departements', 'modules', 'title')
        );
    }

    public function create()
    {
        //
    }

    /* public function store(IndividuelleStoreRequest $request): RedirectResponse */
    public function store(Request $request)
    {
        $this->validate($request, [
            'telephone_secondaire'   => ['required', 'string', 'min:9', 'max:12'],
            'adresse'                => ['required', 'string', 'max:255'],
            'departement'            => ['required', 'string', 'max:255'],
            'module'                 => ['required', 'string', 'max:255'],
            'niveau_etude'           => ['required', 'string', 'max:255'],
            'diplome_academique'     => ['required', 'string', 'max:255'],
            'diplome_professionnel'  => ['required', 'string', 'max:255'],
            'projet_poste_formation' => ['required', 'string', 'max:255'],
            'projetprofessionnel'    => ['required', 'string', 'max:2000'],
        ]);

        $user = Auth::user();

        $individuelle_total = Individuelle::where('users_id', $user->id)
            ->where('projets_id', null)
            ->count();

        if ($individuelle_total >= 3) {
            Alert::warning('Avertissement !', 'Vous avez atteint la limite autorisée de demandes.');
            return redirect()->back();
        } else {

            $date_depot = date('Y-m-d');

            $anneeEnCours = date('Y');
            $an           = date('y');

            /* $numero_individuelle = Individuelle::join('users', 'users.id', 'individuelles.users_id')
                ->select('individuelles.*')
                ->where('date_depot', "LIKE", "{$anneeEnCours}%")
                ->get()->last();

            if (isset($numero_individuelle)) {
                $numero_individuelle = Individuelle::join('users', 'users.id', 'individuelles.users_id')
                    ->select('individuelles.*')
                    ->get()->last()->numero;
                $numero_individuelle = ++$numero_individuelle;
            } else {
                $numero_individuelle = $an . "0001";
                $numero_individuelle = 'I' . $numero_individuelle;
            }

            $longueur = strlen($numero_individuelle);

            if ($longueur <= 1) {
                $numero_individuelle = strtolower("00000" . $numero_individuelle);
            } elseif ($longueur >= 2 && $longueur < 3) {
                $numero_individuelle = strtolower("0000" . $numero_individuelle);
            } elseif ($longueur >= 3 && $longueur < 4) {
                $numero_individuelle = strtolower("000" . $numero_individuelle);
            } elseif ($longueur >= 4 && $longueur < 5) {
                $numero_individuelle = strtolower("00" . $numero_individuelle);
            } elseif ($longueur >= 5 && $longueur < 6) {
                $numero_individuelle = strtolower("0" . $numero_individuelle);
            } else {
                $numero_individuelle = strtolower($numero_individuelle);
            }

            $numero_individuelle = strtoupper($numero_individuelle); */

            // Récupérer le dernier numéro existant
            $numero_individuelle = Individuelle::join('users', 'users.id', 'individuelles.users_id')
                ->where('date_depot', 'LIKE', "{$anneeEnCours}%")
                ->orderBy('individuelles.id', 'desc')
                ->value('numero');

            if ($numero_individuelle) {
                $numero_individuelle = ++$numero_individuelle; // Incrémenter le dernier numéro
            } else {
                $numero_individuelle = 'I' . $anneeEnCours . "0001"; // Nouveau numéro
            }

// Vérifier l'unicité du numéro
            while (Individuelle::where('numero', $numero_individuelle)->exists()) {
// Si le numéro existe déjà, incrémenter encore plus (ajouter 1 à la partie numérique)
                $numero_individuelle = 'I' . str_pad((int) substr($numero_individuelle, 1) + 1, 6, '0', STR_PAD_LEFT);
            }

// Normalisation avec des zéros à gauche (6 chiffres minimum après le préfixe)
            $numero_individuelle = strtoupper($numero_individuelle);

            $departement = Departement::where('nom', $request->input("departement"))->first();

            $regionid = $departement->region->id;

            $module_find = DB::table('modules')->where('name', $request->input("module"))->first();

            $demandeur_ind = Individuelle::where('users_id', $user->id)->get();

            if (isset($module_find)) {
                foreach ($demandeur_ind as $key => $value) {
                    if ($value->module->name == $module_find->name) {
                        Alert::warning('Attention !', 'Le module ' . $value->module->name . ' a déjà été sélectionné.');
                        return redirect()->back();
                    }
                }
                $individuelle = new Individuelle([
                    'date_depot'                       => $date_depot,
                    'numero'                           => $numero_individuelle,
                    'adresse'                          => $request->input('adresse'),
                    'telephone'                        => $request->input('telephone_secondaire'),
                    'niveau_etude'                     => $request->input('niveau_etude'),
                    'diplome_academique'               => $request->input('diplome_academique'),
                    'autre_diplome_academique'         => $request->input('autre_diplome_academique'),
                    'option_diplome_academique'        => $request->input('option_diplome_academique'),
                    'etablissement_academique'         => $request->input('etablissement_academique'),
                    'diplome_professionnel'            => $request->input('diplome_professionnel'),
                    'autre_diplome_professionnel'      => $request->input('autre_diplome_professionnel'),
                    'specialite_diplome_professionnel' => $request->input('specialite_diplome_professionnel'),
                    'etablissement_professionnel'      => $request->input('etablissement_professionnel'),
                    'projet_poste_formation'           => $request->input('projet_poste_formation'),
                    'projetprofessionnel'              => $request->input('projetprofessionnel'),
                    'qualification'                    => $request->input('qualification'),
                    'experience'                       => $request->input('experience'),
                    "departements_id"                  => $departement->id,
                    "regions_id"                       => $regionid,
                    "modules_id"                       => $module_find->id,
                    /* 'autre_module'                      =>  $request->input('autre_module'), */
                    'statut'                           => 'Nouvelle',
                    'users_id'                         => $user->id,
                ]);
            } else {
                $module = new Module([
                    'name' => $request->input('module'),
                ]);

                $module->save();

                $individuelle = new Individuelle([
                    'date_depot'                       => $date_depot,
                    'numero'                           => $numero_individuelle,
                    'adresse'                          => $request->input('adresse'),
                    'telephone'                        => $request->input('telephone_secondaire'),
                    'niveau_etude'                     => $request->input('niveau_etude'),
                    'diplome_academique'               => $request->input('diplome_academique'),
                    'autre_diplome_academique'         => $request->input('autre_diplome_academique'),
                    'option_diplome_academique'        => $request->input('option_diplome_academique'),
                    'etablissement_academique'         => $request->input('etablissement_academique'),
                    'diplome_professionnel'            => $request->input('diplome_professionnel'),
                    'autre_diplome_professionnel'      => $request->input('autre_diplome_professionnel'),
                    'specialite_diplome_professionnel' => $request->input('specialite_diplome_professionnel'),
                    'etablissement_professionnel'      => $request->input('etablissement_professionnel'),
                    'projet_poste_formation'           => $request->input('projet_poste_formation'),
                    'projetprofessionnel'              => $request->input('projetprofessionnel'),
                    'qualification'                    => $request->input('qualification'),
                    'experience'                       => $request->input('experience'),
                    "departements_id"                  => $departement->id,
                    "regions_id"                       => $regionid,
                    "modules_id"                       => $module->id,
                    /* 'autre_module'                      =>  $request->input('autre_module'), */
                    'statut'                           => 'Nouvelle',
                    'users_id'                         => $user->id,
                ]);
            }
        }

        $individuelle->save();

        Alert::success("Succès !", "L'enregistrement a été effectué avec succès.");

        return Redirect::back();
    }
    public function individuellesStore(Request $request)
    {
        $this->validate($request, [
            'telephone_secondaire'   => ['required', 'string', 'min:9', 'max:12'],
            'adresse'                => ['required', 'string', 'max:255'],
            'departement'            => ['required', 'string', 'max:255'],
            'module'                 => ['required', 'string', 'max:255'],
            'niveau_etude'           => ['required', 'string', 'max:255'],
            'diplome_academique'     => ['required', 'string', 'max:255'],
            'diplome_professionnel'  => ['required', 'string', 'max:255'],
            'projet_poste_formation' => ['required', 'string', 'max:255'],
        ]);

        $user   = Auth::user();
        $projet = Projet::findOrFail($request?->idprojet);

        $individuelle = Individuelle::where('users_id', $user->id)
            ->where('projets_id', $request?->idprojet)
            ->count();

        if ($projet->statut == 'fermer') {
            Alert::warning('Avertissement !', 'La période de dépôt est terminée.');
            return redirect()->back();
        } elseif ($individuelle >= 3) {
            Alert::warning('Avertissement !', 'Vous avez atteint la limite autorisée de demandes.');
            return redirect()->back();
        } else {

            $date_depot = date('Y-m-d');

            $anneeEnCours = date('Y');
            $an           = date('y');

            /* $numero_individuelle = Individuelle::join('users', 'users.id', 'individuelles.users_id')
                ->select('individuelles.*')
                ->where('date_depot', "LIKE", "{$anneeEnCours}%")
                ->get()->last();

            if (isset($numero_individuelle)) {
                $numero_individuelle = Individuelle::join('users', 'users.id', 'individuelles.users_id')
                    ->select('individuelles.*')
                    ->get()->last()->numero;
                $numero_individuelle = ++$numero_individuelle;
            } else {
                $numero_individuelle = $an . "0001";
                $numero_individuelle = 'I' . $numero_individuelle;
            }

            $longueur = strlen($numero_individuelle);

            if ($longueur <= 1) {
                $numero_individuelle = strtolower("00000" . $numero_individuelle);
            } elseif ($longueur >= 2 && $longueur < 3) {
                $numero_individuelle = strtolower("0000" . $numero_individuelle);
            } elseif ($longueur >= 3 && $longueur < 4) {
                $numero_individuelle = strtolower("000" . $numero_individuelle);
            } elseif ($longueur >= 4 && $longueur < 5) {
                $numero_individuelle = strtolower("00" . $numero_individuelle);
            } elseif ($longueur >= 5 && $longueur < 6) {
                $numero_individuelle = strtolower("0" . $numero_individuelle);
            } else {
                $numero_individuelle = strtolower($numero_individuelle);
            }

            $numero_individuelle = strtoupper($numero_individuelle); */

            // Récupérer le dernier numéro existant
            $numero_individuelle = Individuelle::join('users', 'users.id', 'individuelles.users_id')
                ->where('date_depot', 'LIKE', "{$anneeEnCours}%")
                ->orderBy('individuelles.id', 'desc')
                ->value('numero');

            if ($numero_individuelle) {
                $numero_individuelle = ++$numero_individuelle; // Incrémenter le dernier numéro
            } else {
                $numero_individuelle = 'I' . $anneeEnCours . "0001"; // Nouveau numéro
            }

// Vérifier l'unicité du numéro
            while (Individuelle::where('numero', $numero_individuelle)->exists()) {
// Si le numéro existe déjà, incrémenter encore plus (ajouter 1 à la partie numérique)
                $numero_individuelle = 'I' . str_pad((int) substr($numero_individuelle, 1) + 1, 6, '0', STR_PAD_LEFT);
            }

// Normalisation avec des zéros à gauche (6 chiffres minimum après le préfixe)
            $numero_individuelle = strtoupper($numero_individuelle);

            if (! empty($request->input("departement")) && $projet?->type_localite == 'Commune') {
                $commune          = Commune::where('nom', $request->input("departement"))->first();
                $communeid        = $commune?->id;
                $arrondissement   = $commune?->arrondissement;
                $arrondissementid = $commune?->arrondissement?->id;
                $departement      = $commune?->arrondissement?->departement;
                $departementid    = $commune?->arrondissement?->departement?->id;
                $regionid         = $commune?->arrondissement?->departement?->region?->id;
            } elseif (! empty($request->input("departement")) && $projet?->type_localite == 'Arrondissement') {
                $communeid        = null;
                $arrondissement   = Arrondissement::where('nom', $request->input("departement"))->first();
                $arrondissementid = $arrondissement?->id;
                $departement      = $arrondissement?->departement;
                $departementid    = $arrondissement?->departement?->id;
                $regionid         = $arrondissement?->departement?->region?->id;
            } elseif (! empty($request->input("departement")) && $projet?->type_localite == 'Departement') {
                $communeid        = null;
                $arrondissementid = null;
                $departement      = Departement::where('nom', $request->input("departement"))->first();
                $departementid    = $departement?->id;
                $regionid         = $departement?->region?->id;
            } elseif (! empty($request->input("departement")) && $projet?->type_localite == 'Region') {
                $communeid        = null;
                $arrondissementid = null;
                $departement      = Departement::where('nom', $request->input("departement"))->first();
                $departementid    = $departement?->id;
                $regionid         = $departement?->region?->id;
            } else {
                $departement = Departement::where('nom', $request->input("departement"))->first();
                $regionid    = $departement?->region?->id;
            }

            $module_find = DB::table('modules')->where('name', $request->input("module"))->first();

            $demandeur_ind = Individuelle::where('users_id', $user->id)->get();

            if (isset($module_find)) {
                foreach ($demandeur_ind as $key => $value) {
                    if ($value->module->name == $module_find->name) {
                        Alert::warning('Attention !', 'Le module ' . $value->module->name . ' a déjà été sélectionné.');
                        return redirect()->back();
                    }
                }
                $individuelle = new Individuelle([
                    'date_depot'                       => $date_depot,
                    'numero'                           => $numero_individuelle,
                    'adresse'                          => $request->input('adresse'),
                    'telephone'                        => $request->input('telephone_secondaire'),
                    'niveau_etude'                     => $request->input('niveau_etude'),
                    'diplome_academique'               => $request->input('diplome_academique'),
                    'autre_diplome_academique'         => $request->input('autre_diplome_academique'),
                    'option_diplome_academique'        => $request->input('option_diplome_academique'),
                    'etablissement_academique'         => $request->input('etablissement_academique'),
                    'diplome_professionnel'            => $request->input('diplome_professionnel'),
                    'autre_diplome_professionnel'      => $request->input('autre_diplome_professionnel'),
                    'specialite_diplome_professionnel' => $request->input('specialite_diplome_professionnel'),
                    'etablissement_professionnel'      => $request->input('etablissement_professionnel'),
                    'projet_poste_formation'           => $request->input('projet_poste_formation'),
                    'projetprofessionnel'              => $request->input('projetprofessionnel'),
                    'qualification'                    => $request->input('qualification'),
                    'experience'                       => $request->input('experience'),
                    "departements_id"                  => $departementid,
                    "regions_id"                       => $regionid,
                    "communes_id"                      => $communeid,
                    "arrondissements_id"               => $arrondissementid,
                    "modules_id"                       => $module_find->id,
                    "projets_id"                       => $request?->idprojet,
                    'autre_module'                     => $request->input('module'),
                    'statut'                           => 'Nouvelle',
                    'users_id'                         => $user->id,
                ]);
            } else {
                $module = new Module([
                    'name' => $request->input('module'),
                ]);

                $module->save();

                $individuelle = new Individuelle([
                    'date_depot'                       => $date_depot,
                    'numero'                           => $numero_individuelle,
                    'adresse'                          => $request->input('adresse'),
                    'telephone'                        => $request->input('telephone_secondaire'),
                    'niveau_etude'                     => $request->input('niveau_etude'),
                    'diplome_academique'               => $request->input('diplome_academique'),
                    'autre_diplome_academique'         => $request->input('autre_diplome_academique'),
                    'option_diplome_academique'        => $request->input('option_diplome_academique'),
                    'etablissement_academique'         => $request->input('etablissement_academique'),
                    'diplome_professionnel'            => $request->input('diplome_professionnel'),
                    'autre_diplome_professionnel'      => $request->input('autre_diplome_professionnel'),
                    'specialite_diplome_professionnel' => $request->input('specialite_diplome_professionnel'),
                    'etablissement_professionnel'      => $request->input('etablissement_professionnel'),
                    'projet_poste_formation'           => $request->input('projet_poste_formation'),
                    'projetprofessionnel'              => $request->input('projetprofessionnel'),
                    'qualification'                    => $request->input('qualification'),
                    'experience'                       => $request->input('experience'),
                    "departements_id"                  => $departementid,
                    "regions_id"                       => $regionid,
                    "communes_id"                      => $communeid,
                    "arrondissements_id"               => $arrondissementid,
                    "modules_id"                       => $module->id,
                    "projets_id"                       => $request?->idprojet,
                    'autre_module'                     => $request->input('module'),
                    'statut'                           => 'Nouvelle',
                    'users_id'                         => $user->id,
                ]);
            }
        }

        $individuelle->save();

        Alert::success("Succès !", "L'enregistrement a été effectué avec succès.");

        return Redirect::back();
    }

    public function addIndividuelle(Request $request)
    {
        $this->validate($request, [
            'civilite'                  => ['required', 'string'],
            'date_depot'                => ['required', 'date', 'min:10', 'max:10', 'date_format:Y-m-d'],
            'cin'                       => ['required', 'string', 'min:13', 'max:15', 'unique:' . User::class],
            'email'                     => ['required', 'string', 'lowercase', 'email', 'max:255', 'unique:' . User::class],
            'firstname'                 => ['required', 'string', 'max:50'],
            'lastname'                  => ['required', 'string', 'max:25'],
            'telephone'                 => ['required', 'string', 'min:9', 'max:12'],
            'telephone_secondaire'      => ['required', 'string', 'min:9', 'max:12'],
            'date_naissance'            => ['required', 'date', 'min:10', 'max:10', 'date_format:Y-m-d'],
            'lieu_naissance'            => ['required', 'string'],
            'adresse'                   => ['required', 'string', 'max:255'],
            'departement'               => ['required', 'string', 'max:255'],
            'module'                    => ['required', 'string', 'max:255'],
            'situation_professionnelle' => ['required', 'string', 'max:255'],
            'situation_familiale'       => ['required', 'string', 'max:255'],
            'niveau_etude'              => ['required', 'string', 'max:255'],
            'diplome_academique'        => ['required', 'string', 'max:255'],
            'diplome_professionnel'     => ['required', 'string', 'max:255'],
            'projet_poste_formation'    => ['required', 'string', 'max:255'],
        ]);

        $cin = $request->input('cin');
        $cin = str_replace(' ', '', $cin);

        /* $rand = rand(0, 999);
        $letter1 = chr(rand(65, 90));
        $letter2 = chr(rand(65, 90));
        $random = $letter1.''.$rand . '' . $letter2;
        $longueur = strlen($random);

        if ($longueur == 1) {
        $numero_individuelle   =   strtoupper("0000" . $random);
        } elseif ($longueur >= 2 && $longueur < 3) {
        $numero_individuelle   =   strtoupper("000" . $random);
        } elseif ($longueur >= 3 && $longueur < 4) {
        $numero_individuelle   =   strtoupper("00" . $random);
        } elseif ($longueur >= 4 && $longueur < 5) {
        $numero_individuelle   =   strtoupper("0" . $random);
        } else {
        $numero_individuelle   =   strtoupper($random);
        } */

        /* $annee = date('y');
        $numero_individuelle = Individuelle::get()->last();
        if (isset($numero_individuelle)) {
        $numero_individuelle = Individuelle::get()->last()->numero;
        $numero_individuelle = ++$numero_individuelle;
        $longueur = strlen($numero_individuelle);
        if ($longueur <= 1) {
        $numero_individuelle   =   strtolower("0000" . $numero_individuelle);
        } elseif ($longueur >= 2 && $longueur < 3) {
        $numero_individuelle   =   strtolower("000" . $numero_individuelle);
        } elseif ($longueur >= 3 && $longueur < 4) {
        $numero_individuelle   =   strtolower("00" . $numero_individuelle);
        } elseif ($longueur >= 4 && $longueur < 5) {
        $numero_individuelle   =   strtolower("0" . $numero_individuelle);
        } else {
        $numero_individuelle   =   strtolower($numero_individuelle);
        }
        } else {
        $numero_individuelle = "00001";
        $numero_individuelle = 'I' . $annee . $numero_individuelle;
        } */

        $date_depot = date('Y-m-d H:i:s', strtotime($request->input('date_depot')));

        $anneeEnCours = date('Y');
        $an           = date('y');

        /* $numero_individuelle = Individuelle::join('users', 'users.id', 'individuelles.users_id')
            ->select('individuelles.*')
            ->where('date_depot', "LIKE", "{$anneeEnCours}%")
            ->get()->last();

        if (isset($numero_individuelle)) {
            $numero_individuelle = Individuelle::join('users', 'users.id', 'individuelles.users_id')
                ->select('individuelles.*')
                ->get()->last()->numero;
            $numero_individuelle = ++$numero_individuelle;
        } else {
            $numero_individuelle = $an . "0001";
            $numero_individuelle = 'I' . $numero_individuelle;
        }

        $longueur = strlen($numero_individuelle);

        if ($longueur <= 1) {
            $numero_individuelle = strtolower("00000" . $numero_individuelle);
        } elseif ($longueur >= 2 && $longueur < 3) {
            $numero_individuelle = strtolower("0000" . $numero_individuelle);
        } elseif ($longueur >= 3 && $longueur < 4) {
            $numero_individuelle = strtolower("000" . $numero_individuelle);
        } elseif ($longueur >= 4 && $longueur < 5) {
            $numero_individuelle = strtolower("00" . $numero_individuelle);
        } elseif ($longueur >= 5 && $longueur < 6) {
            $numero_individuelle = strtolower("0" . $numero_individuelle);
        } else {
            $numero_individuelle = strtolower($numero_individuelle);
        }

        $numero_individuelle = strtoupper($numero_individuelle); */
        // Récupérer le dernier numéro existant
        $numero_individuelle = Individuelle::join('users', 'users.id', 'individuelles.users_id')
            ->where('date_depot', 'LIKE', "{$anneeEnCours}%")
            ->orderBy('individuelles.id', 'desc')
            ->value('numero');

        if ($numero_individuelle) {
            $numero_individuelle = ++$numero_individuelle; // Incrémenter le dernier numéro
        } else {
            $numero_individuelle = 'I' . $anneeEnCours . "0001"; // Nouveau numéro
        }

// Vérifier l'unicité du numéro
        while (Individuelle::where('numero', $numero_individuelle)->exists()) {
// Si le numéro existe déjà, incrémenter encore plus (ajouter 1 à la partie numérique)
            $numero_individuelle = 'I' . str_pad((int) substr($numero_individuelle, 1) + 1, 6, '0', STR_PAD_LEFT);
        }

// Normalisation avec des zéros à gauche (6 chiffres minimum après le préfixe)
        $numero_individuelle = strtoupper($numero_individuelle);

        $departement = Departement::where('nom', $request->input("departement"))->first();
        $regionid    = $departement->region->id;

        $module_find = DB::table('modules')->where('name', $request->input("module"))->first();

        $user = User::create([
            'civilite'                  => $request->input('civilite'),
            'cin'                       => $cin,
            'firstname'                 => $request->input('firstname'),
            'name'                      => $request->input('lastname'),
            'date_naissance'            => $request->input('date_naissance'),
            'lieu_naissance'            => $request->input('lieu_naissance'),
            'email'                     => $request->input('email'),
            'telephone'                 => $request->input('telephone'),
            'telephone_secondaire'      => $request->input('telephone_secondaire'),
            'situation_familiale'       => $request->input('situation_familiale'),
            'situation_professionnelle' => $request->input('situation_professionnelle'),
            'adresse'                   => $request->input('adresse'),
            'password'                  => Hash::make($request->email),
        ]);

        $user->save();

        $user->update([
            'username' => $request->input('lastname') . '' . $user->id,
        ]);

        $user->save();

        $user->assignRole('Demandeur');

        if (isset($module_find)) {
            $individuelle = new Individuelle([
                'date_depot'                       => $date_depot,
                'numero'                           => $numero_individuelle,
                'telephone'                        => $request->input('telephone_secondaire'),
                'niveau_etude'                     => $request->input('niveau_etude'),
                'diplome_academique'               => $request->input('diplome_academique'),
                'autre_diplome_academique'         => $request->input('autre_diplome_academique'),
                'option_diplome_academique'        => $request->input('option_diplome_academique'),
                'etablissement_academique'         => $request->input('etablissement_academique'),
                'diplome_professionnel'            => $request->input('diplome_professionnel'),
                'autre_diplome_professionnel'      => $request->input('autre_diplome_professionnel'),
                'specialite_diplome_professionnel' => $request->input('specialite_diplome_professionnel'),
                'etablissement_professionnel'      => $request->input('etablissement_professionnel'),
                'projet_poste_formation'           => $request->input('projet_poste_formation'),
                'projetprofessionnel'              => $request->input('projetprofessionnel'),
                'qualification'                    => $request->input('qualification'),
                'experience'                       => $request->input('experience'),
                'adresse'                          => $request->input('adresse'),
                "departements_id"                  => $departement->id,
                "regions_id"                       => $regionid,
                "modules_id"                       => $module_find->id,
                /* 'autre_module'                      =>  $request->input('autre_module'), */
                'statut'                           => 'Nouvelle',
                'users_id'                         => $user->id,
            ]);
        } else {
            $module = new Module([
                'name' => $request->input('module'),
            ]);

            $module->save();

            $individuelle = new Individuelle([
                'date_depot'                       => $date_depot,
                'numero'                           => $numero_individuelle,
                'niveau_etude'                     => $request->input('niveau_etude'),
                'telephone'                        => $request->input('telephone_secondaire'),
                'diplome_academique'               => $request->input('diplome_academique'),
                'autre_diplome_academique'         => $request->input('autre_diplome_academique'),
                'option_diplome_academique'        => $request->input('option_diplome_academique'),
                'etablissement_academique'         => $request->input('etablissement_academique'),
                'diplome_professionnel'            => $request->input('diplome_professionnel'),
                'autre_diplome_professionnel'      => $request->input('autre_diplome_professionnel'),
                'specialite_diplome_professionnel' => $request->input('specialite_diplome_professionnel'),
                'etablissement_professionnel'      => $request->input('etablissement_professionnel'),
                'projet_poste_formation'           => $request->input('projet_poste_formation'),
                'projetprofessionnel'              => $request->input('projetprofessionnel'),
                'qualification'                    => $request->input('qualification'),
                'experience'                       => $request->input('experience'),
                'adresse'                          => $request->input('adresse'),
                "departements_id"                  => $departement->id,
                "regions_id"                       => $regionid,
                "modules_id"                       => $module->id,
                /* 'autre_module'                      =>  $request->input('autre_module'), */
                'statut'                           => 'Nouvelle',
                'users_id'                         => $user->id,
            ]);
        }

        $individuelle->save();

        $files = File::where('users_id', null)->distinct()->get();

        foreach ($files as $key => $file) {
            $file = File::create([
                'legende'  => $file->legende,
                'sigle'    => $file->sigle,
                'users_id' => $user->id,
            ]);
        }

        Alert::success("Succès !", "L'enregistrement a été effectué avec succès.");

        return redirect()->back();
    }

    public function edit($id)
    {
        $individuelle = Individuelle::findOrFail($id);
        $departements = Departement::orderBy("created_at", "desc")->get();
        $modules      = Module::orderBy("created_at", "desc")->get();
        $projets      = Projet::orderBy("created_at", "desc")->get();

        foreach (Auth::user()->roles as $role) {
            if (! empty($role?->name) && ($role?->name != 'super-admin')
                && ($role?->name != 'Employe') && ($role?->name != 'admin')
                && ($role?->name != 'DIOF') && ($role?->name != 'DEC')) {
                $this->authorize('update', $individuelle);
            }
        }

        if ($individuelle->projet && $individuelle->projet->statut != 'ouvert') {
            Alert::warning('Avertissement !', 'La modification a échoué.');
            return redirect()->back();
        } elseif ($individuelle->statut != 'Nouvelle' && ! empty($role?->name) && ($role?->name === 'Demandeur')) {
            Alert::warning('Attention ! ', 'action impossible demande déjà traitée.');
            return redirect()->back();
        } else {
            return view("individuelles.update",
                compact("individuelle",
                    "departements",
                    "modules",
                    "projets")
            );
        }
    }
    public function update(Request $request, $id)
    {
        $individuelle = Individuelle::findOrFail($id);
        $user_id      = $individuelle?->users_id;

        foreach (Auth::user()->roles as $role) {
            if (! empty($role?->name) && ($role?->name != 'super-admin')
                && ($role?->name != 'Employe') && ($role?->name != 'admin')
                && ($role?->name != 'DIOF') && ($role?->name != 'DEC')) {
                $this->authorize('update', $individuelle);
            }
        }
        $this->validate($request, [
            'date_depot'             => ['nullable', 'date_format:d/m/Y'],
            'telephone_secondaire'   => ['required', 'string', 'min:9', 'max:12'],
            'adresse'                => ['required', 'string', 'max:255'],
            'departement'            => ['required', 'string', 'max:255'],
            'module'                 => ['required', 'string', 'max:255'],
            'niveau_etude'           => ['required', 'string', 'max:255'],
            'diplome_academique'     => ['required', 'string', 'max:255'],
            'diplome_professionnel'  => ['required', 'string', 'max:255'],
            'projet_poste_formation' => ['required', 'string', 'max:255'],
            'projetprofessionnel'    => ['required', 'string', 'max:2000'],
        ], [
            'date_depot.required'             => 'La date de dépôt est obligatoire.',
            'telephone_secondaire.required'   => 'Le téléphone secondaire est obligatoire.',
            'adresse.required'                => 'L\'adresse est obligatoire.',
            'departement.required'            => 'Le département est obligatoire.',
            'module.required'                 => 'Le module est obligatoire.',
            'niveau_etude.required'           => 'Le niveau d\'étude est obligatoire.',
            'diplome_academique.required'     => 'Le diplôme académique est obligatoire.',
            'diplome_professionnel.required'  => 'Le diplôme professionnel est obligatoire.',
            'projet_poste_formation.required' => 'Le projet poste de formation est obligatoire.',
            'projetprofessionnel.required'    => 'Le projet professionnel est obligatoire.',
        ]);

        if (! empty($request->input('date_depot'))) {
            $dateString = $request->input('date_depot');
            $date_depot = Carbon::createFromFormat('d/m/Y', $dateString);
        } else {
            $date_depot = null;
        }

        $projet = Projet::where('sigle', $request->input("projet"))->first();

        if (! empty($request->input("departement")) && $projet?->type_localite == 'Commune') {
            $commune          = Commune::where('nom', $request->input("departement"))->first();
            $communeid        = $commune?->id;
            $arrondissement   = $commune?->arrondissement;
            $arrondissementid = $commune?->arrondissement?->id;
            $departement      = $commune?->arrondissement?->departement;
            $departementid    = $commune?->arrondissement?->departement?->id;
            $regionid         = $commune?->arrondissement?->departement?->region?->id;
        } elseif (! empty($request->input("departement")) && $projet?->type_localite == 'Arrondissement') {
            $communeid        = null;
            $arrondissement   = Arrondissement::where('nom', $request->input("departement"))->first();
            $arrondissementid = $arrondissement?->id;
            $departement      = $arrondissement?->departement;
            $departementid    = $arrondissement?->departement?->id;
            $regionid         = $arrondissement?->departement?->region?->id;
        } elseif (! empty($request->input("departement")) && $projet?->type_localite == 'Departement') {
            $communeid        = null;
            $arrondissementid = null;
            $departement      = Departement::where('nom', $request->input("departement"))->first();
            $departementid    = $departement?->id;
            $regionid         = $departement?->region?->id;
        } elseif (! empty($request->input("departement")) && $projet?->type_localite == 'Region') {
            $communeid        = null;
            $arrondissementid = null;
            $departement      = Departement::where('nom', $request->input("departement"))->first();
            $departementid    = $departement->id;
            $regionid         = $departement?->region?->id;
        } else {
            $departement      = Departement::where('nom', $request->input("departement"))->first();
            $departementid    = $departement->id;
            $regionid         = $departement?->region?->id;
            $communeid        = null;
            $arrondissementid = null;
        }

        $user = Auth::user();

        $module_find = DB::table('modules')->where('name', $request->input("module"))->first();

        $demandeur_ind = Individuelle::where('users_id', $user->id)->get();

        if (! empty($projet)) {
            $projetid = $projet?->id;
        } else {
            $projetid = null;
        }

        if (isset($module_find)) {
            if (isset($individuelle->module) && ($individuelle->module->name == $module_find->name)) {
                $individuelle->update([
                    'date_depot'                       => $date_depot,
                    'niveau_etude'                     => $request->input('niveau_etude'),
                    'telephone'                        => $request->input('telephone_secondaire'),
                    'diplome_academique'               => $request->input('diplome_academique'),
                    'autre_diplome_academique'         => $request->input('autre_diplome_academique'),
                    'option_diplome_academique'        => $request->input('option_diplome_academique'),
                    'etablissement_academique'         => $request->input('etablissement_academique'),
                    'diplome_professionnel'            => $request->input('diplome_professionnel'),
                    'autre_diplome_professionnel'      => $request->input('autre_diplome_professionnel'),
                    'specialite_diplome_professionnel' => $request->input('specialite_diplome_professionnel'),
                    'etablissement_professionnel'      => $request->input('etablissement_professionnel'),
                    'projet_poste_formation'           => $request->input('projet_poste_formation'),
                    'projetprofessionnel'              => $request->input('projetprofessionnel'),
                    'qualification'                    => $request->input('qualification'),
                    'adresse'                          => $request->input('adresse'),
                    'experience'                       => $request->input('experience'),
                    "departements_id"                  => $departementid,
                    "regions_id"                       => $regionid,
                    "communes_id"                      => $communeid,
                    "arrondissements_id"               => $arrondissementid,
                    "projets_id"                       => $projetid,
                    'users_id'                         => $user_id,
                ]);
            } elseif (isset($module_find)) {
                foreach ($demandeur_ind as $value) {
                    if ($value->module->name == $module_find->name) {
                        Alert::warning('Attention !', 'Le module ' . $value->module->name . ' a déjà été sélectionné.');
                        return redirect()->back();
                    }
                }
                $individuelle->update([
                    'date_depot'                       => $date_depot,
                    'niveau_etude'                     => $request->input('niveau_etude'),
                    'telephone'                        => $request->input('telephone_secondaire'),
                    'diplome_academique'               => $request->input('diplome_academique'),
                    'autre_diplome_academique'         => $request->input('autre_diplome_academique'),
                    'option_diplome_academique'        => $request->input('option_diplome_academique'),
                    'etablissement_academique'         => $request->input('etablissement_academique'),
                    'diplome_professionnel'            => $request->input('diplome_professionnel'),
                    'autre_diplome_professionnel'      => $request->input('autre_diplome_professionnel'),
                    'specialite_diplome_professionnel' => $request->input('specialite_diplome_professionnel'),
                    'etablissement_professionnel'      => $request->input('etablissement_professionnel'),
                    'projet_poste_formation'           => $request->input('projet_poste_formation'),
                    'projetprofessionnel'              => $request->input('projetprofessionnel'),
                    'qualification'                    => $request->input('qualification'),
                    'adresse'                          => $request->input('adresse'),
                    'experience'                       => $request->input('experience'),
                    "departements_id"                  => $departementid,
                    "regions_id"                       => $regionid,
                    "communes_id"                      => $communeid,
                    "arrondissements_id"               => $arrondissementid,
                    "projets_id"                       => $projetid,
                    "modules_id"                       => $module_find->id,
                    /* 'autre_module'                      =>  $request->input('autre_module'), */
                    'users_id'                         => $user_id,
                ]);
            } else {

                $module = new Module([
                    'name' => $request->input('module'),
                ]);

                $module->save();

                $individuelle->update([
                    'date_depot'                       => $date_depot,
                    'niveau_etude'                     => $request->input('niveau_etude'),
                    'telephone'                        => $request->input('telephone_secondaire'),
                    'diplome_academique'               => $request->input('diplome_academique'),
                    'autre_diplome_academique'         => $request->input('autre_diplome_academique'),
                    'option_diplome_academique'        => $request->input('option_diplome_academique'),
                    'etablissement_academique'         => $request->input('etablissement_academique'),
                    'diplome_professionnel'            => $request->input('diplome_professionnel'),
                    'autre_diplome_professionnel'      => $request->input('autre_diplome_professionnel'),
                    'specialite_diplome_professionnel' => $request->input('specialite_diplome_professionnel'),
                    'etablissement_professionnel'      => $request->input('etablissement_professionnel'),
                    'projet_poste_formation'           => $request->input('projet_poste_formation'),
                    'projetprofessionnel'              => $request->input('projetprofessionnel'),
                    'qualification'                    => $request->input('qualification'),
                    'adresse'                          => $request->input('adresse'),
                    'experience'                       => $request->input('experience'),
                    "departements_id"                  => $departementid,
                    "regions_id"                       => $regionid,
                    "communes_id"                      => $communeid,
                    "arrondissements_id"               => $arrondissementid,
                    "projets_id"                       => $projetid,
                    "modules_id"                       => $module->id,
                    /* 'autre_module'                      =>  $request->input('autre_module'), */
                    'users_id'                         => $user_id,
                ]);
            }

            $individuelle->save();
        } else {

            $module = new Module([
                'name' => $request->input('module'),
            ]);

            $module->save();

            $individuelle->update([
                'date_depot'                       => $date_depot,
                'niveau_etude'                     => $request->input('niveau_etude'),
                'telephone'                        => $request->input('telephone_secondaire'),
                'diplome_academique'               => $request->input('diplome_academique'),
                'autre_diplome_academique'         => $request->input('autre_diplome_academique'),
                'option_diplome_academique'        => $request->input('option_diplome_academique'),
                'etablissement_academique'         => $request->input('etablissement_academique'),
                'diplome_professionnel'            => $request->input('diplome_professionnel'),
                'autre_diplome_professionnel'      => $request->input('autre_diplome_professionnel'),
                'specialite_diplome_professionnel' => $request->input('specialite_diplome_professionnel'),
                'etablissement_professionnel'      => $request->input('etablissement_professionnel'),
                'projet_poste_formation'           => $request->input('projet_poste_formation'),
                'projetprofessionnel'              => $request->input('projetprofessionnel'),
                'qualification'                    => $request->input('qualification'),
                'adresse'                          => $request->input('adresse'),
                'experience'                       => $request->input('experience'),
                "departements_id"                  => $departementid,
                "regions_id"                       => $regionid,
                "communes_id"                      => $communeid,
                "arrondissements_id"               => $arrondissementid,
                "projets_id"                       => $projetid,
                "modules_id"                       => $module->id,
                /* 'autre_module'                      =>  $request->input('autre_module'), */
                'users_id'                         => $user_id,
            ]);

            $individuelle->save();
        }

        Alert::success('Succès !', 'La demande a été modifiée avec succès.');

        return Redirect::back();
    }

    public function show($id)
    {
        $individuelle = Individuelle::findOrFail($id);

        foreach (Auth::user()->roles as $role) {
            if (! empty($role?->name) && ($role?->name != 'super-admin')
                && ($role?->name != 'Employe') && ($role?->name != 'admin')
                && ($role?->name != 'DIOF') && ($role?->name != 'DEC')) {
                $this->authorize('view', $individuelle);
            }
        }

        $files = File::where('users_id', $individuelle->user->id)
            ->whereNotNull('file') // Utilisation de whereNotNull pour plus de clarté
            ->distinct()
            ->get();

        return view("individuelles.show", compact("individuelle", "files"));
    }

    public function rejeterIndividuelle(Request $request)
    {
        $request->validate([
            'motif' => 'required',
            'string',
        ]);

        $individuelle         = Individuelle::findOrFail($request->input('id'));
        $individuelle->numero = $request->input('motif');
        $individuelle->save();

        Alert::success('Opération réussie!', 'La région a été modifiée avec succès.');
        return redirect()->route('modal');
    }
    public function destroy($id)
    {
        $individuelle = Individuelle::find($id);

        foreach (Auth::user()->roles as $role) {
            if (! empty($role?->name) && ($role?->name != 'super-admin')
                && ($role?->name != 'Employe') && ($role?->name != 'admin')
                && ($role?->name != 'DIOF') && ($role?->name != 'DEC')) {
                $this->authorize('delete', $individuelle);
            }
        }

        foreach (Auth::user()->roles as $key => $role) {
        }
        if ($individuelle->statut != 'Nouvelle' && ! empty($role?->name) && ($role?->name != 'super-admin')) {
            Alert::warning('Attention ! ', 'action impossible demande déjà traitée.');
            return redirect()->back();
        } else {
            $individuelle->update([
                'numero' => $individuelle->numero . '/' . $id,
            ]);

            $individuelle->save();

            $individuelle->delete();

            Alert::success('Succès !', 'La demande a été supprimée avec succès.');

            return redirect()->back();
        }
    }
    public function validationsRejetMessage(Request $request)
    {
        $individuelle = Individuelle::findOrFail($request?->input('id'));
        return view("individuelles.validationsrejetmessage", compact('individuelle'));
    }

    public function demandesIndividuelle(Request $request)
    {
        $departements  = Departement::orderBy("created_at", "desc")->get();
        $modules       = Module::orderBy("created_at", "desc")->get();
        $user          = Auth::user();
        $individuelles = Individuelle::where('users_id', $user->id)
            ->where('numero', '!=', null)
            ->where('projets_id', null)
            ->orderBy("created_at", "desc")
            ->get();
        $individuelle_total = $individuelles->count();
        if ($individuelle_total == 0) {
            return view(
                "individuelles.show-individuelle-aucune",
                compact(
                    "individuelle_total",
                    "departements",
                    "individuelles",
                    "modules"
                )
            );
        } else {
            return view(
                "individuelles.show-individuelle",
                compact(
                    "individuelle_total",
                    "departements",
                    "individuelles",
                    "modules"
                )
            );
        }
    }
    public function rapports(Request $request)
    {
        $title = 'rapports demandes individuelles';
        return view('individuelles.rapports', compact(
            'title'
        ));
    }
    public function generateRapport(Request $request)
    {

        $this->validate($request, [
            'from_date' => 'required|date',
            'to_date'   => 'required|date',
        ]);

        $now = Carbon::now()->format('H:i:s');

        $from_date = date_format(date_create($request->from_date), 'd/m/Y');

        $to_date = date_format(date_create($request->to_date), 'd/m/Y');

        $individuelles = Individuelle::whereBetween(DB::raw('DATE(created_at)'), [$request->from_date, $request->to_date])->get();

        $count = $individuelles->count();

        if ($from_date == $to_date) {
            if (isset($count) && $count < "1") {
                $title = 'aucune demande individuelle reçue le ' . $from_date;
            } elseif (isset($count) && $count == "1") {
                $title = $count . ' demande individuelle reçue le ' . $from_date;
            } else {
                $title = $count . ' demandes individuelles reçues le ' . $from_date;
            }
        } else {
            if (isset($count) && $count < "1") {
                $title = 'aucune demande individuelle reçue entre le ' . $from_date . ' et le ' . $to_date;
            } elseif (isset($count) && $count == "1") {
                $title = $count . ' demande individuelle reçue entre le ' . $from_date . ' et le ' . $to_date;
            } else {
                $title = $count . ' demandes individuelles reçues entre le ' . $from_date . ' et le ' . $to_date;
            }
        }

        return view('individuelles.rapports', compact(
            'individuelles',
            'from_date',
            'to_date',
            'title'
        ));
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
            Alert::warning('Attention', 'Veuillez renseigner au moins un champ pour effectuer une recherche.');
            return redirect()->back();
        }

        $individuelles = Individuelle::join('users', 'users.id', 'individuelles.users_id')
            ->select('individuelles.*')
            ->where('users.firstname', 'LIKE', "%{$request?->firstname}%")
            ->where('users.name', 'LIKE', "%{$request?->name}%")
            ->where('users.cin', 'LIKE', "%{$request?->cin}%")
            ->where('users.telephone', 'LIKE', "%{$request?->telephone}%")
            ->where('users.email', 'LIKE', "%{$request?->email}%")
            ->distinct()
            ->get();

        $count = $individuelles?->count();

        if (isset($count) && $count < "1") {
            $title = 'aucune demande trouvée';
        } elseif (isset($count) && $count == "1") {
            $title = $count . ' demande trouvée';
        } else {
            $title = $count . ' demandes trouvées';
        }

        $departements = Departement::orderBy("created_at", "DESC")->get();
        /* $modules = Module::orderBy("created_at", "desc")->get(); */
        return view('individuelles.index', compact(
            'individuelles',
            'departements',
            'title'
        ));
    }

    public function showIndividuelleProjet(Request $request)
    {
        $projet = Projet::findOrFail($request->idprojet);

        $this->validate($request, [
            'telephone_secondaire'   => ['required', 'string', 'min:9', 'max:12'],
            'adresse'                => ['required', 'string', 'max:255'],
            'departement'            => ['required', 'string', 'max:255'],
            'module'                 => ['required', 'string', 'max:255'],
            'niveau_etude'           => ['required', 'string', 'max:255'],
            'diplome_academique'     => ['required', 'string', 'max:255'],
            'diplome_professionnel'  => ['required', 'string', 'max:255'],
            'projet_poste_formation' => ['required', 'string'],
            'projetprofessionnel'    => ['required', 'string', 'max:2000'],
        ]);

        $user = Auth::user();

        $individuelle_total = Individuelle::where('users_id', $user->id)->where('projets_id', $projet->id)
            ->count();

        if ($individuelle_total >= 3) {
            Alert::warning('Avertissement !', 'Vous avez atteint la limite autorisée de demandes.');
            return redirect()->back();
        } else {

            $date_depot = date('Y-m-d');

            $anneeEnCours = date('Y');
            $an           = date('y');

            /* $numero_individuelle = Individuelle::join('users', 'users.id', 'individuelles.users_id')
                ->select('individuelles.*')
                ->where('date_depot', "LIKE", "{$anneeEnCours}%")
                ->get()->last();

            if (isset($numero_individuelle)) {
                $numero_individuelle = Individuelle::join('users', 'users.id', 'individuelles.users_id')
                    ->select('individuelles.*')
                    ->get()->last()->numero;
                $numero_individuelle = ++$numero_individuelle;
            } else {
                $numero_individuelle = $an . "0001";
                $numero_individuelle = 'I' . $numero_individuelle;
            }

            $longueur = strlen($numero_individuelle);

            if ($longueur <= 1) {
                $numero_individuelle = strtolower("00000" . $numero_individuelle);
            } elseif ($longueur >= 2 && $longueur < 3) {
                $numero_individuelle = strtolower("0000" . $numero_individuelle);
            } elseif ($longueur >= 3 && $longueur < 4) {
                $numero_individuelle = strtolower("000" . $numero_individuelle);
            } elseif ($longueur >= 4 && $longueur < 5) {
                $numero_individuelle = strtolower("00" . $numero_individuelle);
            } elseif ($longueur >= 5 && $longueur < 6) {
                $numero_individuelle = strtolower("0" . $numero_individuelle);
            } else {
                $numero_individuelle = strtolower($numero_individuelle);
            }

            $numero_individuelle = strtoupper($numero_individuelle); */
            // Récupérer le dernier numéro existant
            $numero_individuelle = Individuelle::join('users', 'users.id', 'individuelles.users_id')
                ->where('date_depot', 'LIKE', "{$anneeEnCours}%")
                ->orderBy('individuelles.id', 'desc')
                ->value('numero');

            if ($numero_individuelle) {
                $numero_individuelle = ++$numero_individuelle; // Incrémenter le dernier numéro
            } else {
                $numero_individuelle = 'I' . $anneeEnCours . "0001"; // Nouveau numéro
            }

// Vérifier l'unicité du numéro
            while (Individuelle::where('numero', $numero_individuelle)->exists()) {
// Si le numéro existe déjà, incrémenter encore plus (ajouter 1 à la partie numérique)
                $numero_individuelle = 'I' . str_pad((int) substr($numero_individuelle, 1) + 1, 6, '0', STR_PAD_LEFT);
            }

// Normalisation avec des zéros à gauche (6 chiffres minimum après le préfixe)
            $numero_individuelle = strtoupper($numero_individuelle);

            if (! empty($request->input("departement")) && $projet?->type_localite == 'Commune') {
                $commune          = Commune::where('nom', $request->input("departement"))->first();
                $communeid        = $commune?->id;
                $arrondissement   = $commune?->arrondissement;
                $arrondissementid = $commune?->arrondissement?->id;
                $departement      = $commune?->arrondissement?->departement;
                $departementid    = $commune?->arrondissement?->departement?->id;
                $regionid         = $commune?->arrondissement?->departement?->region?->id;
            } elseif (! empty($request->input("departement")) && $projet?->type_localite == 'Arrondissement') {
                $communeid        = null;
                $arrondissement   = Arrondissement::where('nom', $request->input("departement"))->first();
                $arrondissementid = $arrondissement?->id;
                $departement      = $arrondissement?->departement;
                $departementid    = $arrondissement?->departement?->id;
                $regionid         = $arrondissement?->departement?->region?->id;
            } elseif (! empty($request->input("departement")) && $projet?->type_localite == 'Departement') {
                $communeid        = null;
                $arrondissementid = null;
                $departement      = Departement::where('nom', $request->input("departement"))->first();
                $departementid    = $departement?->id;
                $regionid         = $departement?->region?->id;
            } elseif (! empty($request->input("departement")) && $projet?->type_localite == 'Region') {
                $communeid        = null;
                $arrondissementid = null;
                $departement      = Departement::where('nom', $request->input("departement"))->first();
                $departementid    = $departement?->id;
                $regionid         = $departement?->region?->id;
            } else {
                $departement = Departement::where('nom', $request->input("departement"))->first();
                $regionid    = $departement?->region?->id;
            }

            $module_find = DB::table('modules')->where('name', $request->input("module"))->first();

            $demandeur_ind = Individuelle::where('users_id', $user->id)->where('projets_id', $projet->id)->get();

            if (isset($module_find)) {
                foreach ($demandeur_ind as $key => $value) {
                    if ($value->module->name == $module_find->name) {
                        Alert::warning('Attention !Le module ' . $value->module->name, 'a déjà été sélectionné');
                        return redirect()->back();
                    }
                }
                $individuelle = new Individuelle([
                    'date_depot'                       => $date_depot,
                    'numero'                           => $numero_individuelle,
                    'adresse'                          => $request->input('adresse'),
                    'telephone'                        => $request->input('telephone_secondaire'),
                    'niveau_etude'                     => $request->input('niveau_etude'),
                    'diplome_academique'               => $request->input('diplome_academique'),
                    'autre_diplome_academique'         => $request->input('autre_diplome_academique'),
                    'option_diplome_academique'        => $request->input('option_diplome_academique'),
                    'etablissement_academique'         => $request->input('etablissement_academique'),
                    'diplome_professionnel'            => $request->input('diplome_professionnel'),
                    'autre_diplome_professionnel'      => $request->input('autre_diplome_professionnel'),
                    'specialite_diplome_professionnel' => $request->input('specialite_diplome_professionnel'),
                    'etablissement_professionnel'      => $request->input('etablissement_professionnel'),
                    'projet_poste_formation'           => $request->input('projet_poste_formation'),
                    'projetprofessionnel'              => $request->input('projetprofessionnel'),
                    'qualification'                    => $request->input('qualification'),
                    'experience'                       => $request->input('experience'),
                    'autre_module'                     => $request->input('module'),
                    "communes_id"                      => $communeid,
                    "arrondissements_id"               => $arrondissementid,
                    "departements_id"                  => $departementid,
                    "regions_id"                       => $regionid,
                    "modules_id"                       => $module_find->id,
                    /* 'autre_module'                      =>  $request->input('autre_module'), */
                    'statut'                           => 'Nouvelle',
                    'users_id'                         => $user->id,
                    'projets_id'                       => $projet->id,
                ]);
            } else {
                $module = new Module([
                    'name' => $request->input('module'),
                ]);

                $module->save();

                $individuelle = new Individuelle([
                    'date_depot'                       => $date_depot,
                    'numero'                           => $numero_individuelle,
                    'adresse'                          => $request->input('adresse'),
                    'telephone'                        => $request->input('telephone_secondaire'),
                    'niveau_etude'                     => $request->input('niveau_etude'),
                    'diplome_academique'               => $request->input('diplome_academique'),
                    'autre_diplome_academique'         => $request->input('autre_diplome_academique'),
                    'option_diplome_academique'        => $request->input('option_diplome_academique'),
                    'etablissement_academique'         => $request->input('etablissement_academique'),
                    'diplome_professionnel'            => $request->input('diplome_professionnel'),
                    'autre_diplome_professionnel'      => $request->input('autre_diplome_professionnel'),
                    'specialite_diplome_professionnel' => $request->input('specialite_diplome_professionnel'),
                    'etablissement_professionnel'      => $request->input('etablissement_professionnel'),
                    'projet_poste_formation'           => $request->input('projet_poste_formation'),
                    'projetprofessionnel'              => $request->input('projetprofessionnel'),
                    'qualification'                    => $request->input('qualification'),
                    'experience'                       => $request->input('experience'),
                    'autre_module'                     => $request->input('module'),
                    "communes_id"                      => $communeid,
                    "arrondissements_id"               => $arrondissementid,
                    "departements_id"                  => $departementid,
                    "regions_id"                       => $regionid,
                    "modules_id"                       => $module->id,
                    /* 'autre_module'                      =>  $request->input('autre_module'), */
                    'statut'                           => 'Nouvelle',
                    'users_id'                         => $user->id,
                    'projets_id'                       => $projet->id,
                ]);
            }
        }

        $individuelle->save();

        Alert::success("Succès !", "L'enregistrement a été effectué avec succès.");

        return Redirect::back();
    }

    public function showMasculin()
    {
        $individuelles = Individuelle::join('users', 'users.id', 'individuelles.users_id')
            ->select('individuelles.*')
            ->where('users.civilite', 'M.')
            ->limit(500)
            ->latest()
            ->get();

        $total_count = Individuelle::get();
        $total_count = number_format($total_count->count(), 0, ',', ' ');

        $count_demandeur = number_format($individuelles?->count(), 0, ',', ' ');

        if ($count_demandeur < "1") {
            $title = 'Aucune demande individuelle masculine';
        } elseif ($count_demandeur == "1") {
            $title = $count_demandeur . ' demande individuelle masculine sur un total de ' . $total_count;
        } else {
            $title = 'Liste des ' . $count_demandeur . ' dernières demandes individuelles masculines sur un total de ' . $total_count;
        }

        $departements = Departement::orderBy("created_at", "DESC")->get();
        $modules      = Module::orderBy("created_at", "desc")->get();

        return view(
            "individuelles.masculin",
            compact('individuelles', 'departements', 'modules', 'title')
        );
    }

    public function showFeminin()
    {
        $individuelles = Individuelle::join('users', 'users.id', 'individuelles.users_id')
            ->select('individuelles.*')
            ->where('users.civilite', 'Mme')
            ->limit(500)
            ->latest()
            ->get();

        $total_count = Individuelle::get();
        $total_count = number_format($total_count->count(), 0, ',', ' ');

        $count_demandeur = number_format($individuelles?->count(), 0, ',', ' ');

        if ($count_demandeur < "1") {
            $title = 'Aucune demande individuelle féminine';
        } elseif ($count_demandeur == "1") {
            $title = $count_demandeur . ' demande individuelle féminine sur un total de ' . $total_count;
        } else {
            $title = 'Liste des ' . $count_demandeur . ' dernières demandes individuelles féminines sur un total de ' . $total_count;
        }

        $departements = Departement::orderBy("created_at", "DESC")->get();
        $modules      = Module::orderBy("created_at", "desc")->get();

        return view(
            "individuelles.feminin",
            compact('individuelles', 'departements', 'modules', 'title')
        );
    }

    public function mesformations(Request $request)
    {
        $user = Auth::user();

        $individuelles = $user->individuelles->where('formations_id', '!=', null);

        $formation_count = $individuelles->count();

        return view("individuelles.show-formation", compact("formation_count", "individuelles"));
    }

    public function nouvellesformations(Request $request)
    {
        $user = Auth::user();

        /* $nouvelle_formations = Formation::join('individuelles', 'formations.id', 'individuelles.formations_id')
            ->select('formations.*')
            ->where('individuelles.users_id', $user->id)
            ->where('formations.statut', 'Nouvelle')->get(); */

        $nouvelle_formations = Auth::user()->individuelles()
            ->join('formations', 'formations.id', '=', 'individuelles.formations_id')
            ->where('formations.statut', 'Nouvelle')
            ->select('individuelles.*')
            ->get();

        return view("individuelles.nouvelle_formations", compact("nouvelle_formations"));
    }

    public function demandesdg(Request $request)
    {

        $total_count = Individuelle::get();
        $total_count = number_format($total_count->count(), 0, ',', ' ');

        $dakar   = Region::where('nom', 'Dakar')->first();
        $thies   = Region::orwhere('nom', 'THIES')->first();
        $dakarid = $dakar->id;
        $thiesid = $thies->id;

        $individuelles = Individuelle::where('regions_id', $dakarid)->orwhere('regions_id', $thiesid)->limit(500)
            ->latest()
            ->get();

        $count_demandeur = number_format($individuelles?->count(), 0, ',', ' ');

        if ($count_demandeur < "1") {
            $title = 'aucune demande individuelle';
        } elseif ($count_demandeur == "1") {
            $title = $count_demandeur . ' demande individuelle trouvée ';
        } else {
            $title = $count_demandeur . ' demandes trouvées';
        }

        $departements = Departement::orderBy("created_at", "DESC")->get();
        $modules      = Module::orderBy("created_at", "desc")->get();
        return view(
            "individuelles.index",
            compact('individuelles', 'departements', 'modules', 'title')
        );
    }

    public function demandeszig(Request $request)
    {

        $total_count = Individuelle::get();
        $total_count = number_format($total_count->count(), 0, ',', ' ');

        $ziguinchor   = Region::where('nom', 'ZIGUINCHOR')->first();
        $kolda        = Region::orwhere('nom', 'KOLDA')->first();
        $sedhiou      = Region::orwhere('nom', 'SEDHIOU')->first();
        $ziguinchorid = $ziguinchor->id;
        $koldaid      = $kolda->id;
        $sedhiouid    = $sedhiou->id;

        $individuelles = Individuelle::where('regions_id', $ziguinchorid)
        /* ->orwhere('regions_id', $koldaid)
        ->orwhere('regions_id', $sedhiouid) */
            ->limit(500)
            ->latest()
            ->get();

        $count_demandeur = number_format($individuelles?->count(), 0, ',', ' ');

        if ($count_demandeur < "1") {
            $title = 'aucune demande individuelle';
        } elseif ($count_demandeur == "1") {
            $title = $count_demandeur . ' demande individuelle trouvée ';
        } else {
            $title = $count_demandeur . ' demandes trouvées';
        }

        $departements = Departement::orderBy("created_at", "DESC")->get();
        $modules      = Module::orderBy("created_at", "desc")->get();
        return view(
            "individuelles.index",
            compact('individuelles', 'departements', 'modules', 'title')
        );
    }

    public function demandeskd(Request $request)
    {

        $total_count = Individuelle::get();
        $total_count = number_format($total_count->count(), 0, ',', ' ');

        $ziguinchor   = Region::where('nom', 'ZIGUINCHOR')->first();
        $kolda        = Region::orwhere('nom', 'KOLDA')->first();
        $sedhiou      = Region::orwhere('nom', 'SEDHIOU')->first();
        $ziguinchorid = $ziguinchor->id;
        $koldaid      = $kolda->id;
        $sedhiouid    = $sedhiou->id;

        $individuelles = Individuelle::orwhere('regions_id', $koldaid)
            ->orwhere('regions_id', $sedhiouid)
            ->limit(500)
            ->latest()
            ->get();

        $count_demandeur = number_format($individuelles?->count(), 0, ',', ' ');

        if ($count_demandeur < "1") {
            $title = 'aucune demande individuelle';
        } elseif ($count_demandeur == "1") {
            $title = $count_demandeur . ' demande individuelle trouvée ';
        } else {
            $title = $count_demandeur . ' demandes trouvées';
        }

        $departements = Departement::orderBy("created_at", "DESC")->get();
        $modules      = Module::orderBy("created_at", "desc")->get();
        return view(
            "individuelles.index",
            compact('individuelles', 'departements', 'modules', 'title')
        );
    }

    public function demandeskl(Request $request)
    {

        $total_count = Individuelle::get();
        $total_count = number_format($total_count->count(), 0, ',', ' ');

        $kaolack  = Region::orwhere('nom', 'KAOLACK')->first();
        $kaffrine = Region::orwhere('nom', 'KAFFRINE')->first();
        $fatick   = Region::where('nom', 'FATICK')->first();

        $kaolackid  = $kaolack->id;
        $kaffrineid = $kaffrine->id;
        $fatickid   = $fatick->id;

        $individuelles = Individuelle::orwhere('regions_id', $kaolackid)
            ->orwhere('regions_id', $kaffrineid)
            ->orwhere('regions_id', $fatickid)
            ->limit(500)
            ->latest()
            ->get();

        $count_demandeur = number_format($individuelles?->count(), 0, ',', ' ');

        if ($count_demandeur < "1") {
            $title = 'aucune demande individuelle';
        } elseif ($count_demandeur == "1") {
            $title = $count_demandeur . ' demande individuelle trouvée ';
        } else {
            $title = $count_demandeur . ' demandes trouvées';
        }

        $departements = Departement::orderBy("created_at", "DESC")->get();
        $modules      = Module::orderBy("created_at", "desc")->get();
        return view(
            "individuelles.index",
            compact('individuelles', 'departements', 'modules', 'title')
        );
    }

    public function demandessl(Request $request)
    {
        $total_count = Individuelle::get();
        $total_count = number_format($total_count->count(), 0, ',', ' ');

        $saintlouis = Region::orwhere('nom', 'SAINT LOUIS')->first();
        $louga      = Region::orwhere('nom', 'LOUGA')->first();

        $saintlouisid = $saintlouis->id;
        $lougaid      = $louga->id;

        $individuelles = Individuelle::orwhere('regions_id', $saintlouisid)
            ->orwhere('regions_id', $lougaid)
            ->limit(500)
            ->latest()
            ->get();

        $count_demandeur = number_format($individuelles?->count(), 0, ',', ' ');

        if ($count_demandeur < "1") {
            $title = 'aucune demande individuelle';
        } elseif ($count_demandeur == "1") {
            $title = $count_demandeur . ' demande individuelle trouvée ';
        } else {
            $title = $count_demandeur . ' demandes trouvées';
        }

        $departements = Departement::orderBy("created_at", "DESC")->get();
        $modules      = Module::orderBy("created_at", "desc")->get();
        return view(
            "individuelles.index",
            compact('individuelles', 'departements', 'modules', 'title')
        );
    }

    public function demandeskg(Request $request)
    {
        $total_count = Individuelle::get();
        $total_count = number_format($total_count->count(), 0, ',', ' ');

        $kedougou    = Region::orwhere('nom', 'KEDOUGOU')->first();
        $tambacounda = Region::orwhere('nom', 'TAMBACOUNDA')->first();

        $kedougouid    = $kedougou->id;
        $tambacoundaid = $tambacounda->id;

        $individuelles = Individuelle::orwhere('regions_id', $kedougouid)
            ->orwhere('regions_id', $tambacoundaid)
            ->limit(500)
            ->latest()
            ->get();

        $count_demandeur = number_format($individuelles?->count(), 0, ',', ' ');

        if ($count_demandeur < "1") {
            $title = 'aucune demande individuelle';
        } elseif ($count_demandeur == "1") {
            $title = $count_demandeur . ' demande individuelle trouvée ';
        } else {
            $title = $count_demandeur . ' demandes trouvées';
        }

        $departements = Departement::orderBy("created_at", "DESC")->get();
        $modules      = Module::orderBy("created_at", "desc")->get();
        return view(
            "individuelles.index",
            compact('individuelles', 'departements', 'modules', 'title')
        );
    }

    public function demandesmt(Request $request)
    {
        $total_count = Individuelle::get();
        $total_count = number_format($total_count->count(), 0, ',', ' ');

        $matam = Region::orwhere('nom', 'MATAM')->first();

        $matamid = $matam->id;

        $individuelles = Individuelle::orwhere('regions_id', $matamid)
            ->limit(500)
            ->latest()
            ->get();

        $count_demandeur = number_format($individuelles?->count(), 0, ',', ' ');

        if ($count_demandeur < "1") {
            $title = 'aucune demande individuelle';
        } elseif ($count_demandeur == "1") {
            $title = $count_demandeur . ' demande individuelle trouvée ';
        } else {
            $title = $count_demandeur . ' demandes trouvées';
        }

        $departements = Departement::orderBy("created_at", "DESC")->get();
        $modules      = Module::orderBy("created_at", "desc")->get();
        return view(
            "individuelles.index",
            compact('individuelles', 'departements', 'modules', 'title')
        );
    }

    public function demandesdl(Request $request)
    {
        $total_count = Individuelle::get();
        $total_count = number_format($total_count->count(), 0, ',', ' ');

        $diourbel = Region::orwhere('nom', 'DIOURBEL')->first();

        $diourbelid = $diourbel->id;

        $individuelles = Individuelle::orwhere('regions_id', $diourbelid)
            ->limit(500)
            ->latest()
            ->get();

        $count_demandeur = number_format($individuelles?->count(), 0, ',', ' ');

        if ($count_demandeur < "1") {
            $title = 'aucune demande individuelle';
        } elseif ($count_demandeur == "1") {
            $title = $count_demandeur . ' demande individuelle trouvée ';
        } else {
            $title = $count_demandeur . ' demandes trouvées';
        }

        $departements = Departement::orderBy("created_at", "DESC")->get();
        $modules      = Module::orderBy("created_at", "desc")->get();
        return view(
            "individuelles.index",
            compact('individuelles', 'departements', 'modules', 'title')
        );
    }

    public function confirmer(Request $request, $id)
    {
        $individuelle = Individuelle::findOrFail($id);

        $individuelle->update([
            'confirmation'      => 'confirmer',
            'motif_declinaison' => null,
        ]);

        Alert::success('Félicitations !', 'Merci pour votre confiance');

        return redirect()->back();
    }
    public function decliner(Request $request, $id)
    {
        $this->validate($request, [
            'motif' => "required|string",
        ]);

        $individuelle = Individuelle::findOrFail($id);

        $individuelle->update([
            'confirmation'      => 'décliner',
            'motif_declinaison' => $request->motif,
        ]);

        Alert::success('Dommage !', 'Nous espérons vous retrouver bientôt');

        return redirect()->back();

    }
}
