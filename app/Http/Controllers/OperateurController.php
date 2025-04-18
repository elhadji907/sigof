<?php
namespace App\Http\Controllers;

use App\Models\Arrive;
use App\Models\Commissionagrement;
use App\Models\Departement;
use App\Models\File;
use App\Models\Operateur;
use App\Models\Operateureference;
use App\Models\Operateurequipement;
use App\Models\Operateurformateur;
use App\Models\Operateurlocalite;
use App\Models\Operateurmodule;
use App\Models\Region;
use App\Models\User;
use App\Models\Validationoperateur;
use Carbon\Carbon;
use Dompdf\Dompdf;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;
use Illuminate\Validation\Rule;
use Intervention\Image\Facades\Image;
use RealRashid\SweetAlert\Facades\Alert;

class OperateurController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
        $this->middleware(['role:super-admin|admin|Operateur|DIOF|ADIOF|DEC|ADEC|Demandeur|Employe']);
        $this->middleware("permission:operateur-view", ["only" => ["index"]]);
    }
    public function index()
    {
        /* $operateurs        = Operateur::orderBy('created_at', 'desc')->get();
        $departements      = Departement::orderBy("created_at", "desc")->get();
        $operateur_agreer  = Operateur::where('statut_agrement', 'agréer')->count();
        $operateur_rejeter = Operateur::where('statut_agrement', 'Rejetée')->count();
        $operateur_nouveau = Operateur::where('statut_agrement', 'nouveau')->count();
        $operateur_expirer = Operateur::where('statut_agrement', 'expirer')->count();
        $operateur_total   = Operateur::where('statut_agrement', 'agréer')->orwhere('statut_agrement', 'Rejetée')->orwhere('statut_agrement', 'nouveau')->count();

        if (isset($operateur_total) && $operateur_total > '0') {
            $pourcentage_agreer  = ((($operateur_agreer) / ($operateur_total)) * 100);
            $pourcentage_rejeter = ((($operateur_rejeter) / ($operateur_total)) * 100);
            $pourcentage_nouveau = ((($operateur_nouveau) / ($operateur_total)) * 100);
            $pourcentage_expirer = ((($operateur_expirer) / ($operateur_total)) * 100);
        } else {
            $pourcentage_agreer  = "0";
            $pourcentage_rejeter = "0";
            $pourcentage_nouveau = "0";
            $pourcentage_expirer = "0";
        }

        $total_count = Operateur::get();
        $total_count = number_format($total_count->count(), 0, ',', ' ');

        $operateur_liste = Operateur::take(50)
            ->latest()
            ->get();

        $count_operateur = number_format($operateur_liste?->count(), 0, ',', ' ');

        if ($count_operateur < "1") {
            $title = 'Aucun opérateur';
        } elseif ($count_operateur == "1") {
            $title = $count_operateur . ' opérateur sur un total de ' . $total_count;
        } else {
            $title = 'Liste des ' . $count_operateur . ' derniers opérateurs sur un total de ' . $total_count;
        }

        return view(
            "operateurs.index",
            compact(
                "operateurs",
                "departements",
                "operateur_agreer",
                "operateur_rejeter",
                "pourcentage_agreer",
                "pourcentage_rejeter",
                "operateur_nouveau",
                "operateur_expirer",
                "title",
                "pourcentage_nouveau",
                "pourcentage_expirer"
            )
        ); */

        $operateurs   = Operateur::latest()->get();
        $departements = Departement::latest()->get();

        $statuts = ['agréer', 'Rejetée', 'nouveau', 'expirer'];

        $counts = Operateur::whereIn('statut_agrement', $statuts)
            ->selectRaw("statut_agrement, COUNT(*) as count")
            ->groupBy('statut_agrement')
            ->pluck('count', 'statut_agrement');

        $operateur_agreer  = $counts['agréer'] ?? 0;
        $operateur_rejeter = $counts['Rejetée'] ?? 0;
        $operateur_nouveau = $counts['nouveau'] ?? 0;
        $operateur_expirer = $counts['expirer'] ?? 0;
        $operateur_total   = $operateur_agreer + $operateur_rejeter + $operateur_nouveau;

        $pourcentage_agreer  = $operateur_total ? ($operateur_agreer / $operateur_total) * 100 : 0;
        $pourcentage_rejeter = $operateur_total ? ($operateur_rejeter / $operateur_total) * 100 : 0;
        $pourcentage_nouveau = $operateur_total ? ($operateur_nouveau / $operateur_total) * 100 : 0;
        $pourcentage_expirer = $operateur_total ? ($operateur_expirer / $operateur_total) * 100 : 0;

        $total_count     = number_format(Operateur::count(), 0, ',', ' ');
        $operateur_liste = Operateur::latest()->take(50)->get();
        $count_operateur = number_format($operateur_liste->count(), 0, ',', ' ');

        $title = match ($count_operateur) {
            "0" => 'Aucun opérateur',
            "1" => "$count_operateur opérateur sur un total de $total_count",
            default => "Liste des $count_operateur derniers opérateurs sur un total de $total_count",
        };

        return view("operateurs.index",
            compact(
                "operateurs",
                "departements",
                "operateur_agreer",
                "operateur_rejeter",
                "pourcentage_agreer",
                "pourcentage_rejeter",
                "operateur_nouveau",
                "operateur_expirer",
                "title",
                "pourcentage_nouveau",
                "pourcentage_expirer"
            ));

    }
    
    public function create()
    {
        $departements = Departement::get();
        return view('operateurs.create', compact('departements'));
    }

    public function agrement()
    {
        /*  $operateurs      = Operateur::query()->orderBy('created_at', 'desc')->orderByDesc('created_at')->get();
        $departements    = Departement::orderBy("created_at", "desc")->get();
        $operateurs      = Operateur::orderBy('created_at', 'desc')->get();
        $operateur_new   = Operateur::where('type_demande', 'Nouvelle')->count();
        $operateur_renew = Operateur::where('type_demande', 'Renouvellement')->count();
        $operateur_total = Operateur::where('type_demande', 'Nouvelle')->orwhere('type_demande', 'Renouvellement')->count();

        if (isset($operateur_total) && $operateur_total > '0') {
            $pourcentage_new   = ((($operateur_new) / ($operateur_total)) * 100);
            $pourcentage_renew = ((($operateur_renew) / ($operateur_total)) * 100);
        } else {
            $pourcentage_new   = "0";
            $pourcentage_renew = "0";
        } */

        $operateurs   = Operateur::latest()->get();
        $departements = Departement::latest()->get();

        $type_demandes = ['Nouvelle', 'Renouvellement'];
        $counts        = Operateur::whereIn('type_demande', $type_demandes)
            ->selectRaw("type_demande, COUNT(*) as count")
            ->groupBy('type_demande')
            ->pluck('count', 'type_demande');

        $operateur_new   = $counts['Nouvelle'] ?? 0;
        $operateur_renew = $counts['Renouvellement'] ?? 0;
        $operateur_total = $operateur_new + $operateur_renew;

        $pourcentage_new   = $operateur_total ? ($operateur_new / $operateur_total) * 100 : 0;
        $pourcentage_renew = $operateur_total ? ($operateur_renew / $operateur_total) * 100 : 0;

        return view("operateurs.agrements.index", compact("operateurs", "departements", "operateur_new", "operateur_renew", "pourcentage_new", "pourcentage_renew"));
    }

    //cette fonction permet de valider l'agrement des operateurs
    public function agrements($id)
    {
        /*  $operateur          = Operateur::findOrFail($id);
        $operateurs         = Operateur::get();
        $operateureferences = Operateureference::get();
        foreach (Auth::user()->roles as $key => $role) {
            if (! empty($role?->name) && ($role?->name != 'super-admin') && ($role?->name != 'Employe') && ($role?->name != 'admin') && ($role?->name != 'DIOF') && ($role?->name != 'DEC')) {
                $this->authorize('view', $operateur);
            }
        } */

        $operateur          = Operateur::findOrFail($id);
        $operateurs         = Operateur::all();
        $operateureferences = Operateureference::all();

        $excludedRoles = ['super-admin', 'Employe', 'admin', 'DIOF', 'DEC'];
        foreach (Auth::user()->roles as $role) {
            if (! empty($role?->name) && ! in_array($role->name, $excludedRoles)) {
                $this->authorize('view', $operateur);
            }
        }
        return view("operateurs.agrement",
            compact("operateurs",
                "operateur",
                "operateureferences"));
    }

    public function store(Request $request)
    {
        $this->validate($request, [
            /* "categorie"             =>      "required|string", */
            /* "statut"                =>      "required|string", */
            "departement"  => "required|string",
            "quitus"       => ['image', 'required', 'mimes:jpeg,png,jpg,gif,svg', 'max:1024'],
            "date_quitus"  => "required|date_format:d/m/Y",
            "type_demande" => "required|string",
        ]);

        /*  $user = Auth::user();

        $operateur_total = Operateur::where('users_id', $user->id)->count();
        $departement     = Departement::where('nom', $request->input("departement"))->first();

        if ($operateur_total >= 1) {
            Alert::warning('Attention ! ', 'Vous avez atteint le nombre de demandes autoriées');
            return redirect()->back();
        } else {

            $anneeEnCours = date('Y');
            $an           = date('y');

            $numCourrier = Arrive::join('courriers', 'courriers.id', 'arrives.courriers_id')
                ->select('arrives.*')
                ->where('courriers.annee', $anneeEnCours)
                ->get()->last();

            if (! empty($numCourrier)) {
                $numCourrier = Arrive::join('courriers', 'courriers.id', 'arrives.courriers_id')
                    ->select('arrives.*')
                    ->get()->last()->numero_arrive;

                $numCourrier = ++$numCourrier;
            } else {
                $numCourrier = $an . "0001";
                $longueur    = strlen($numCourrier);

                if ($longueur <= 1) {
                    $numCourrier = strtolower("00000" . $numCourrier);
                } elseif ($longueur >= 2 && $longueur < 3) {
                    $numCourrier = strtolower("0000" . $numCourrier);
                } elseif ($longueur >= 3 && $longueur < 4) {
                    $numCourrier = strtolower("000" . $numCourrier);
                } elseif ($longueur >= 4 && $longueur < 5) {
                    $numCourrier = strtolower("00" . $numCourrier);
                } elseif ($longueur >= 5 && $longueur < 6) {
                    $numCourrier = strtolower("0" . $numCourrier);
                } else {
                    $numCourrier = strtolower($numCourrier);
                }
            }

            $courrier = new Courrier([
                'date_recep'      => date('Y-m-d'),
                'date_cores'      => date('Y-m-d'),
                'numero_courrier' => $numCourrier,
                'annee'           => date('Y'),
                'objet'           => $request->input("type_demande") . ' agrément opérateur',
                'expediteur'      => Auth::user()?->username,
                'type'            => 'operateur',
                "user_create_id"  => Auth::user()->id,
                "user_update_id"  => Auth::user()->id,
                'users_id'        => Auth::user()->id,
            ]);

            $courrier->save();

            $arrive = new Arrive([
                'numero_arrive' => $numCourrier,
                'objet'         => $request->input("type_demande") . ' agrément opérateur',
                'expediteur'    => Auth::user()->username,
                "type"          => 'operateur',
                'courriers_id'  => $courrier->id,
            ]);

            $arrive->save();

            if (! empty($request->input('date_quitus'))) {
                $date_quitus = $request->input('date_quitus');
            } else {
                $date_quitus = null;
            }

            $operateur = Operateur::create([
                "numero_agrement" => $numCourrier . '/ONFP/DG/DEC/' . date('Y'),
                "type_demande"    => $request->input("type_demande"),
                "debut_quitus"    => $date_quitus,
                "annee_agrement"  => date('Y-m-d'),
                "statut_agrement" => 'nouveau',
                "departements_id" => $departement?->id,
                "regions_id"      => $departement?->region?->id,
                "users_id"        => $user->id,
                'courriers_id'    => $courrier->id,
            ]);

            $operateur->save();

            if (request('quitus')) {
                $quitusPath = request('quitus')->store('quitus', 'public');
                $quitus     = Image::make(public_path("/storage/{$quitusPath}"));

                $quitus->save();

                $operateur->update([
                    'quitus' => $quitusPath,
                ]);
            }

            Alert::success("Félicitations ! ", "demande ajoutée avec succès");

            return redirect()->back();
        } */

        $user = Auth::user();

        $operateur_total = Operateur::where('users_id', $user->id)->count();
        $departement     = Departement::where('nom', $request->input("departement"))->first();

        if ($operateur_total >= 1) {
            Alert::warning('Attention ! ', 'Vous avez atteint le nombre de demandes autorisées');
            return redirect()->back();
        }

        /* $anneeEnCours = date('Y');
        $an           = date('y');

        $numCourrier = Arrive::join('courriers', 'courriers.id', 'arrives.courriers_id')
            ->where('courriers.annee', $anneeEnCours)
            ->latest('arrives.id')
            ->value('numero_arrive');

        $numCourrier = $numCourrier ? ++$numCourrier : $an . "0001";
        $numCourrier = str_pad($numCourrier, 5, "0", STR_PAD_LEFT); */

        /* $courrier = Courrier::create([
            'date_recep'      => date('Y-m-d'),
            'date_cores'      => date('Y-m-d'),
            'numero_courrier' => $numCourrier,
            'annee'           => $anneeEnCours,
            'objet'           => $request->input("type_demande") . ' agrément opérateur',
            'expediteur'      => $user->username,
            'type'            => 'operateur',
            'user_create_id'  => $user->id,
            'user_update_id'  => $user->id,
            'users_id'        => $user->id,
        ]); */

        /* $arrive = Arrive::create([
            'numero_arrive' => $numCourrier,
            'objet'         => $request->input("type_demande") . ' agrément opérateur',
            'expediteur'    => $user->username,
            'type'          => 'operateur',
            'courriers_id'  => $courrier->id,
        ]); */

        $dateString  = $request->input('date_quitus');
        $date_quitus = ! empty($dateString) ? Carbon::createFromFormat('d/m/Y', $dateString) : null;

        $anneeEnCours = date('Y');
        $an           = date('y');

        $operateur = Operateur::create([
            'numero_agrement' => "/ONFP/DG/DEC/$anneeEnCours",
            'type_demande'    => $request->input("type_demande"),
            'debut_quitus'    => $date_quitus,
            'annee_agrement'  => date('Y-m-d'),
            'statut_agrement' => 'nouveau',
            'departements_id' => $departement?->id,
            'regions_id'      => $departement?->region?->id,
            'users_id'        => $user->id,
            /* 'courriers_id'    => $courrier->id, */
        ]);

        if ($request->hasFile('quitus')) {
            $quitusPath = $request->file('quitus')->store('quitus', 'public');
            Image::make(public_path("/storage/{$quitusPath}"))->save();
            $operateur->update(['quitus' => $quitusPath]);
        }

        Alert::success("Succès ! ", "Demande ajoutée avec succès");
        return redirect()->back();

    }
    public function addOperateur(Request $request)
    {
        $this->validate($request, [
            'operateur'            => ["required", "string", Rule::unique('users')->where(function ($query) {
                return $query->whereNull('deleted_at');
            })],
            'email'                => ["required", "email", Rule::unique('users')->where(function ($query) {
                return $query->whereNull('deleted_at');
            })],
            'username'             => ["required", "string", Rule::unique('users')->where(function ($query) {
                return $query->whereNull('deleted_at');
            })],
            'fixe'                 => ["required", "string", "min:9", "max:12", Rule::unique('users')->where(function ($query) {
                return $query->whereNull('deleted_at');
            })],
            'telephone'            => ["required", "string", "min:9", "max:12", Rule::unique('users')->where(function ($query) {
                return $query->whereNull('deleted_at');
            })],
            'bp'                   => ['nullable', 'string'],
            'categorie'            => ['required', 'string'],
            'adresse'              => ['required', 'string', 'max:255'],
            'rccm'                 => ['nullable', 'string'],
            'ninea'                => ["nullable", "string", Rule::unique('users')->where(function ($query) {
                return $query->whereNull('deleted_at');
            })],
            'web'                  => ['nullable', 'string', 'max:255'],
            'civilite'             => ['required', 'string', 'max:8'],
            'prenom'               => ['required', 'string', 'max:150'],
            'email_responsable'    => ["nullable", "email", Rule::unique('users')->where(function ($query) {
                return $query->whereNull('deleted_at');
            })],
            "numero_agrement"      => ["nullable", "string", Rule::unique('operateurs')->where(function ($query) {
                return $query->whereNull('deleted_at');
            })],
            "statut"               => "required|string",
            "autre_statut"         => "nullable|string",
            "departement"          => "required|string",
            "quitus"               => ['image', 'sometimes', 'mimes:jpeg,png,jpg,gif,svg', 'max:1024'],
            "date_quitus"          => "nullable|date_format:d/m/Y",
            "type_demande"         => "required|string",
            "arrete_creation"      => "nullable|string",
            "file_arrete_creation" => ['file', 'sometimes', 'mimes:jpeg,png,jpg,gif,svg,pdf', 'max:1024'],
            "demande_signe"        => "nullable|string",
            "formulaire_signe"     => "nullable|string",
        ]);

        /* $courrier = new Courrier([
            'date_recep'      => date('Y-m-d'),
            'date_cores'      => date('Y-m-d'),
            'numero_courrier' => $request->input("numero_arrive"),
            'annee'           => date('Y'),
            'objet'           => $request->input("operateur"),
            'expediteur'      => $request->input("username"),
            'type'            => 'operateur',
            "user_create_id"  => Auth::user()->id,
            "user_update_id"  => Auth::user()->id,
            'users_id'        => Auth::user()->id,
        ]);

        $courrier->save();

        $arrive = new Arrive([
            'numero_arrive' => $request->input("numero_arrive"),
            'type'          => 'operateur',
            'courriers_id'  => $courrier->id,
        ]);

        $arrive->save(); */

        /* $user = new User([
            'civilite'             => $request->input("civilite"),
            'firstname'            => $request->input("prenom"),
            'name'                 => $request->input("nom"),
            'operateur'            => $request->input("operateur"),
            'username'             => $request->input("username"),
            'email'                => $request->input('email'),
            "fixe"                 => $request->input("fixe"),
            "telephone"            => $request->input("telephone"),
            "adresse"              => $request->input("adresse"),
            'password'             => Hash::make($request->input('email')),
            'created_by'           => Auth::user()->id,
            'updated_by'           => Auth::user()->id,
            "categorie"            => $request->input("categorie"),
            "email_responsable"    => $request->input("email_responsable"),
            "fonction_responsable" => $request->input("fonction_responsable"),
            "telephone_parent"     => $request->input("telephone_parent"),
            "rccm"                 => $request->input("rccm"), // choisir ninea ou rccm
            "ninea"                => $request->input("ninea"), // enregistrer le numero de la valeur choisi (ninea ou rccm)
            "bp"                   => $request->input("bp"),
            "statut"               => $request->input("statut"),
            "autre_statut"         => $request->input("autre_statut"),
            "quitusfiscal"         => $request->input("quitusfiscal"),
            "cvsigne"              => $request->input("cvsigne"),
            "web"                  => $request->input("web"),

        ]);

        $user->save();

        $departement = Departement::where('nom', $request->input("departement"))->first();

        if (! empty($request->input('date_quitus'))) {
            $date_quitus = $request->input('date_quitus');
        } else {
            $date_quitus = null;
        }

        $operateur = Operateur::create([
            "numero_dossier"   => $request->input("numero_dossier"),
            'numero_arrive'    => $request->input("numero_arrive"),
            "numero_agrement"  => $request->input("numero_agrement"),
            "type_demande"     => $request->input("type_demande"),
            "debut_quitus"     => $date_quitus,
            "annee_agrement"   => date('Y-m-d'),
            "statut_agrement"  => 'nouveau',
            "departements_id"  => $departement?->id,
            "regions_id"       => $departement?->region?->id,
            "users_id"         => $user->id,
            // 'courriers_id'     => $courrier->id,
            "arrete_creation"  => $request->input("arrete_creation"),
            "demande_signe"    => $request->input("demande_signe"),
            "formulaire_signe" => $request->input("formulaire_signe"),
            "quitusfiscal"     => $request->input("quitusfiscal"),
            "cvsigne"          => $request->input("cvsigne"),
        ]);

        $operateur->save();

        $user->assignRole('Operateur');

        if (request('quitus')) {
            $quitusPath = request('quitus')->store('quitus', 'public');
            $quitus     = Image::make(public_path("/storage/{$quitusPath}"));

            $quitus->save();

            $operateur->update([
                'quitus' => $quitusPath,
            ]);
        }

        if (request('file_arrete_creation')) {

            $file_arrete_creation = request('file_arrete_creation')->store('uploads', 'public');

            $file            = $request->file('file_arrete_creation');
            $filenameWithExt = $file->getClientOriginalName();
            $filename        = pathinfo($filenameWithExt, PATHINFO_FILENAME);
            $filename = preg_replace("/[^A-Za-z0-9 ]/", '', $filename);
            $filename = preg_replace("/\s+/", '-', $filename);

            $operateur->update([
                'file_arrete_creation' => $file_arrete_creation,
            ]);
        }

        Alert::success("Félicitations !", "opérateur ajouté avec succès");

        return redirect()->back(); */

        $user = User::create([
            'civilite'             => $request->input("civilite"),
            'firstname'            => $request->input("prenom"),
            'name'                 => $request->input("nom"),
            'operateur'            => $request->input("operateur"),
            'username'             => $request->input("username"),
            'email'                => $request->input('email'),
            'fixe'                 => $request->input("fixe"),
            'telephone'            => $request->input("telephone"),
            'adresse'              => $request->input("adresse"),
            'password'             => Hash::make($request->input('email')),
            'created_by'           => Auth::id(),
            'updated_by'           => Auth::id(),
            'categorie'            => $request->input("categorie"),
            'email_responsable'    => $request->input("email_responsable"),
            'fonction_responsable' => $request->input("fonction_responsable"),
            'telephone_parent'     => $request->input("telephone_parent"),
            'rccm'                 => $request->input("rccm"),
            'ninea'                => $request->input("ninea"),
            'bp'                   => $request->input("bp"),
            'statut'               => $request->input("statut"),
            'autre_statut'         => $request->input("autre_statut"),
            'quitusfiscal'         => $request->input("quitusfiscal"),
            'cvsigne'              => $request->input("cvsigne"),
            'web'                  => $request->input("web"),
        ]);

        $departement = Departement::where('nom', $request->input("departement"))->first();

        $dateString  = $request->input('date_quitus');
        $date_quitus = ! empty($dateString) ? Carbon::createFromFormat('d/m/Y', $dateString) : null;

        $numero_agrement = $request->input("numero_agrement") ?: $request->input("numero_arrive") . '/ONFP/DG/DEC/' . date('Y');

        $operateur = Operateur::create([
            "numero_dossier"   => $request->input("numero_dossier"),
            'numero_arrive'    => $request->input("numero_arrive"),
            "numero_agrement"  => $numero_agrement,
            "type_demande"     => $request->input("type_demande"),
            "debut_quitus"     => $date_quitus,
            "annee_agrement"   => now()->format('Y-m-d'),
            "statut_agrement"  => 'nouveau',
            "departements_id"  => $departement?->id,
            "regions_id"       => $departement?->region?->id,
            "users_id"         => $user->id,
            "arrete_creation"  => $request->input("arrete_creation"),
            "demande_signe"    => $request->input("demande_signe"),
            "formulaire_signe" => $request->input("formulaire_signe"),
            "quitusfiscal"     => $request->input("quitusfiscal"),
            "cvsigne"          => $request->input("cvsigne"),
        ]);

        $user->assignRole('Operateur');

        // Gestion des fichiers
        if ($request->hasFile('quitus')) {
            $quitusPath = $request->file('quitus')->store('quitus', 'public');
            $operateur->update(['quitus' => $quitusPath]);
        }

        if ($request->hasFile('file_arrete_creation')) {
            $file_arrete_creation = $request->file('file_arrete_creation')->store('uploads', 'public');
            $operateur->update(['file_arrete_creation' => $file_arrete_creation]);
        }

        Alert::success("Félicitations !", "Opérateur ajouté avec succès");

        return redirect()->back();

    }
    public function renewOperateur(Request $request)
    {
        $user = Auth::user();
        foreach ($user->operateurs as $key => $operateur) {
        }
        $this->validate($request, [
            "quitus"      => ['image', 'required', 'mimes:jpeg,png,jpg,gif,svg', 'max:1024'],
            "date_quitus" => ['required', 'date_format:d/m/Y'],
        ]);

        foreach (Auth::user()->roles as $key => $role) {
            if (! empty($role?->name) && ($role?->name != 'super-admin') && ($role?->name != 'Employe') && ($role?->name != 'admin') && ($role?->name != 'DIOF') && ($role?->name != 'DEC')) {
                $this->authorize('view', $operateur);
            }
        }

        /* $anneeEnCours = date('Y');
        $an           = date('y');

        $numCourrier = Arrive::join('courriers', 'courriers.id', 'arrives.courriers_id')
            ->select('arrives.*')
            ->where('courriers.annee', $anneeEnCours)
            ->get()->last();

        if (! empty($numCourrier)) {
            $numCourrier = Arrive::join('courriers', 'courriers.id', 'arrives.courriers_id')
                ->select('arrives.*')
                ->get()->last()->numero_arrive;

            $numCourrier = ++$numCourrier;
        } else {
            $numCourrier = $an . "0001";
            $longueur    = strlen($numCourrier);

            if ($longueur <= 1) {
                $numCourrier = strtolower("00000" . $numCourrier);
            } elseif ($longueur >= 2 && $longueur < 3) {
                $numCourrier = strtolower("0000" . $numCourrier);
            } elseif ($longueur >= 3 && $longueur < 4) {
                $numCourrier = strtolower("000" . $numCourrier);
            } elseif ($longueur >= 4 && $longueur < 5) {
                $numCourrier = strtolower("00" . $numCourrier);
            } elseif ($longueur >= 5 && $longueur < 6) {
                $numCourrier = strtolower("0" . $numCourrier);
            } else {
                $numCourrier = strtolower($numCourrier);
            }
        }

        $courrier = new Courrier([
            'date_recep'      => date('Y-m-d'),
            'date_cores'      => date('Y-m-d'),
            'numero_courrier' => $numCourrier,
            'annee'           => date('Y'),
            'objet'           => Auth::user()->operateur,
            'expediteur'      => Auth::user()->username,
            'type'            => 'operateur',
            "user_create_id"  => Auth::user()->id,
            "user_update_id"  => Auth::user()->id,
            'users_id'        => Auth::user()->id,
        ]);

        $courrier->save();

        $arrive = new Arrive([
            'numero_arrive' => $numCourrier,
            'objet'         => $request->input("type_demande") . ' agrément opérateur',
            'expediteur'    => Auth::user()->username,
            "type"          => 'operateur',
            'courriers_id'  => $courrier->id,
        ]);

        $arrive->save(); */

        /* if (! empty($request->input('date_quitus'))) {
            $date_quitus = $request->input('date_quitus');
        } else {
            $date_quitus = null;
        }

        $op = Operateur::create([
            "numero_agrement" => $numCourrier . '/ONFP/DG/DEC/' . date('Y'),
            "categorie"       => $operateur?->categorie,
            "statut"          => $operateur?->statut,
            "statut_agrement" => 'nouveau',
            "autre_statut"    => $operateur?->autre_statut,
            "type_demande"    => 'Renouvellement',
            "annee_agrement"  => date('Y-m-d'),
            "rccm"            => $operateur?->registre_commerce, // choisir ninea ou rccm
            "ninea"           => $operateur?->ninea, // enregistrer le numero de la valeur choisi (ninea ou rccm)
            // "quitus"               =>       $request->input("quitus"),
            "debut_quitus"    => $date_quitus,
            "departements_id" => $operateur?->departements_id,
            "regions_id"      => $operateur?->departement?->region?->id,
            "users_id"        => $operateur?->users_id,
        ]);

        $op->save();

        if (request('quitus')) {
            $quitusPath = request('quitus')->store('quitus', 'public');
            $quitus     = Image::make(public_path("/storage/{$quitusPath}"));

            $quitus->save();

            $op->update([
                'quitus' => $quitusPath,
            ]);
        }

        foreach ($operateur->operateurmodules as $key => $operateurmodule) {
            $module = new Operateurmodule([
                "module"               => $operateurmodule?->module,
                "domaine"              => $operateurmodule?->domaine,
                "categorie"            => $operateurmodule?->categorie,
                'niveau_qualification' => $operateurmodule?->niveau_qualification,
                'statut'               => $operateurmodule?->statut,
                'operateurs_id'        => $op->id,
            ]);

            $module->save();
        }

        foreach ($operateur->operateureferences as $key => $operateureference) {
            $reference = Operateureference::create([
                "organisme"     => $operateureference?->organisme,
                "contact"       => $operateureference?->contact,
                "periode"       => $operateureference?->periode,
                "description"   => $operateureference?->description,
                "operateurs_id" => $op->id,
            ]);

            $reference->save();
        }

        foreach ($operateur->operateurformateurs as $key => $operateurformateur) {
            $formateur = Operateurformateur::create([
                "name"                   => $operateurformateur?->name,
                "domaine"                => $operateurformateur?->domaine,
                "nbre_annees_experience" => $operateurformateur?->nbre_annees_experience,
                "references"             => $operateurformateur?->references,
                "operateurs_id"          => $op->id,
            ]);

            $formateur->save();
        }

        foreach ($operateur->operateurequipements as $key => $operateurequipement) {
            $equipement = Operateurequipement::create([
                "designation"   => $operateurequipement?->designation,
                "quantite"      => $operateurequipement?->quantite,
                "etat"          => $operateurequipement?->etat,
                "type"          => $operateurequipement?->type,
                "operateurs_id" => $op->id,
            ]);

            $equipement->save();
        }

        foreach ($operateur->operateurlocalites as $key => $operateurlocalite) {
            $localite = Operateurlocalite::create([
                "name"          => $operateurlocalite?->name,
                "region"        => $operateurlocalite?->region,
                "operateurs_id" => $op->id,
            ]);

            $localite->save();
        }

        Alert::success("Succès !", "Renouvellement effectué avec succès");

        return redirect()->back(); */

        $dateString  = $request->input('date_quitus');
        $date_quitus = ! empty($dateString) ? Carbon::createFromFormat('d/m/Y', $dateString) : null;

        $op = Operateur::create([
            "numero_agrement" => '/ONFP/DG/DEC/' . date('Y'),
            "categorie"       => $operateur?->categorie,
            "statut"          => $operateur?->statut,
            "statut_agrement" => 'nouveau',
            "autre_statut"    => $operateur?->autre_statut,
            "type_demande"    => 'Renouvellement',
            "annee_agrement"  => now()->format('Y-m-d'),
            "rccm"            => $operateur?->registre_commerce,
            "ninea"           => $operateur?->ninea,
            "debut_quitus"    => $date_quitus,
            "departements_id" => $operateur?->departements_id,
            "regions_id"      => $operateur?->departement?->region?->id,
            "users_id"        => $operateur?->users_id,
        ]);

// Gestion du fichier quitus
        if ($request->hasFile('quitus')) {
            $quitusPath = $request->file('quitus')->store('quitus', 'public');
            $op->update(['quitus' => $quitusPath]);
        }

// Clonage des modules de l'opérateur
        foreach ($operateur->operateurmodules as $operateurmodule) {
            Operateurmodule::create([
                "module"               => $operateurmodule->module,
                "domaine"              => $operateurmodule->domaine,
                "categorie"            => $operateurmodule->categorie,
                "niveau_qualification" => $operateurmodule->niveau_qualification,
                "statut"               => $operateurmodule->statut,
                "operateurs_id"        => $op->id,
            ]);
        }

// Clonage des références
        foreach ($operateur->operateureferences as $operateureference) {
            Operateureference::create([
                "organisme"     => $operateureference->organisme,
                "contact"       => $operateureference->contact,
                "periode"       => $operateureference->periode,
                "description"   => $operateureference->description,
                "operateurs_id" => $op->id,
            ]);
        }

// Clonage des formateurs
        foreach ($operateur->operateurformateurs as $operateurformateur) {
            Operateurformateur::create([
                "name"                   => $operateurformateur->name,
                "domaine"                => $operateurformateur->domaine,
                "nbre_annees_experience" => $operateurformateur->nbre_annees_experience,
                "references"             => $operateurformateur->references,
                "operateurs_id"          => $op->id,
            ]);
        }

// Clonage des équipements
        foreach ($operateur->operateurequipements as $operateurequipement) {
            Operateurequipement::create([
                "designation"   => $operateurequipement->designation,
                "quantite"      => $operateurequipement->quantite,
                "etat"          => $operateurequipement->etat,
                "type"          => $operateurequipement->type,
                "operateurs_id" => $op->id,
            ]);
        }

// Clonage des localités
        foreach ($operateur->operateurlocalites as $operateurlocalite) {
            Operateurlocalite::create([
                "name"          => $operateurlocalite->name,
                "region"        => $operateurlocalite->region,
                "operateurs_id" => $op->id,
            ]);
        }

        Alert::success("Succès !", "Votre renouvellement a été pris en compte");

        return redirect()->back();

    }

    public function update(Request $request, $id)
    {
        $operateur = Operateur::findOrFail($id);
        $user      = $operateur->user;

        $this->validate($request, [
            "numero_dossier"       => ['nullable', 'string', Rule::unique(Operateur::class)->ignore($id)->whereNull('deleted_at')],
            "numero_arrive"        => ['nullable', 'string', Rule::unique(Operateur::class)->ignore($id)->whereNull('deleted_at')],
            "numero_agrement"      => ['nullable', 'string', Rule::unique(Operateur::class)->ignore($id)->whereNull('deleted_at')],
            "operateur"            => ['required', 'string', Rule::unique(User::class)->ignore($user->id)->whereNull('deleted_at')],
            "username"             => ['required', 'string', Rule::unique(User::class)->ignore($user->id)->whereNull('deleted_at')],
            "email"                => ['required', 'string', Rule::unique(User::class)->ignore($user->id)->whereNull('deleted_at')],
            "fixe"                 => ['required', 'string', Rule::unique(User::class)->ignore($user->id)->whereNull('deleted_at')],
            "telephone"            => ['required', 'string', Rule::unique(User::class)->ignore($user->id)->whereNull('deleted_at')],
            "categorie"            => ['required', 'string'],
            "statut"               => ['required', 'string'],
            "departement"          => ['required', 'string'],
            "adresse"              => ['required', 'string'],
            "ninea"                => ['nullable', 'string'],
            "registre_commerce"    => ['nullable', 'string'],
            "quitus"               => ['sometimes', 'image', 'mimes:jpeg,png,jpg,gif,svg', 'max:1024'],
            "date_quitus"          => ['nullable', 'date_format:d/m/Y'],
            "type_demande"         => ['required', 'string'],
            "arrete_creation"      => ['nullable', 'string'],
            "file_arrete_creation" => ['file', 'sometimes', 'mimes:jpeg,png,jpg,gif,svg,pdf', 'max:1024'],
            "demande_signe"        => ['nullable', 'string'],
            "formulaire_signe"     => ['nullable', 'string'],
            "web"                  => ['nullable', 'string'],
        ]);

        $departement = Departement::where('nom', $request->input("departement"))->firstOrFail();

        foreach (Auth::user()->roles as $key => $role) {
            if (! empty($role?->name) && ($role?->name != 'super-admin') && ($role?->name != 'Employe') && ($role?->name != 'admin') && ($role?->name != 'DIOF') && ($role?->name != 'DEC')) {
                $this->authorize('update', $operateur);
            }
            if (! empty($role?->name) && ($operateur->statut_agrement != 'nouveau') && ($role?->name != 'super-admin') && ($role?->name != 'Employe') && ($role?->name != 'admin') && ($role?->name != 'DIOF') && ($role?->name != 'DEC')) {
                Alert::warning('Attention ! ', 'action impossible');
                return redirect()->back();
            }
        }

        $arrive = Arrive::where('numero_arrive', $request->input("numero_arrive"))->first();

        /* if (! empty($arrive)) {

            $arrive->update([
                'numero_arrive' => $request->input("numero_arrive"),
            ]);

            $arrive->save();

            $courrier = $arrive->courrier;

            $courrier->update([
                'numero_courrier' => $request->input("numero_arrive"),
            ]);

            $courrier->save();
        } else { */

        /* $anneeEnCours = date('Y');
            $an = date('y');

            $numCourrier = Arrive::join('courriers', 'courriers.id', 'arrives.courriers_id')
            ->select('arrives.*')
            ->where('courriers.annee', $anneeEnCours)
            ->get()->last();

            if (isset($numCourrier)) {
            $numCourrier = Arrive::join('courriers', 'courriers.id', 'arrives.courriers_id')
            ->select('arrives.*')
            ->get()->last()->numero;

            $numCourrier = ++$numCourrier;
            } else {
            $numCourrier = $an . "0001";
            $longueur = strlen($numCourrier);

            if ($longueur <= 1) {
            $numCourrier   =   strtolower("00000" . $numCourrier);
            } elseif ($longueur >= 2 && $longueur < 3) {
            $numCourrier   =   strtolower("0000" . $numCourrier);
            } elseif ($longueur >= 3 && $longueur < 4) {
            $numCourrier   =   strtolower("000" . $numCourrier);
            } elseif ($longueur >= 4 && $longueur < 5) {
            $numCourrier   =   strtolower("00" . $numCourrier);
            } elseif ($longueur >= 5 && $longueur < 6) {
            $numCourrier   =   strtolower("0" . $numCourrier);
            } else {
            $numCourrier   =   strtolower($numCourrier);
            }
            } */

        /* $courrier = new Courrier([
                'date_recep'      => date('Y-m-d'),
                'date_cores'      => date('Y-m-d'),
                'numero_courrier' => $request->input("numero_arrive"),
                'annee'           => date('Y'),
                'objet'           => $request->input("operateur"),
                'expediteur'      => $request->input("username"),
                'type'            => 'operateur',
                "user_create_id"  => Auth::user()->id,
                "user_update_id"  => Auth::user()->id,
                'users_id'        => Auth::user()->id,
            ]);

            $courrier->save();

            $arrive = new Arrive([
                'numero_arrive' => $request->input("numero_arrive"),
                'type'          => 'operateur',
                'courriers_id'  => $courrier->id,
            ]);

            $arrive->save();
        } */

        /* $user->update([
            'civilite'             => $request->input("civilite"),
            'firstname'            => $request->input("prenom"),
            'name'                 => $request->input("nom"),
            'operateur'            => $request->input("operateur"),
            'username'             => $request->input("username"),
            'email'                => $request->input('email'),
            "fixe"                 => $request->input("fixe"),
            "telephone"            => $request->input("telephone"),
            "adresse"              => $request->input("adresse"),
            "categorie"            => $request->input("categorie"),
            "email_responsable"    => $request->input("email_responsable"),
            "fonction_responsable" => $request->input("fonction_responsable"),
            "telephone_parent"     => $request->input("telephone_parent"),
            "rccm"                 => $request->input("registre_commerce"), // choisir ninea ou rccm
            "ninea"                => $request->input("ninea"), // enregistrer le numero de la valeur choisi (ninea ou rccm)
            "bp"                   => $request->input("bp"),
            "statut"               => $request->input("statut"),
            "autre_statut"         => $request->input("autre_statut"),
            "web"                  => $request->input("web"),
            'updated_by'           => Auth::user()->id,
        ]);

        $user->save();

        if (! empty($request->input('date_quitus'))) {
            $date_quitus = $request->input('date_quitus');
        } else {
            $date_quitus = null;
        }

        $operateur->update([
            'numero_arrive'    => $request->input("numero_arrive"),
            "numero_dossier"   => $request->input("numero_dossier"),
            "numero_agrement"  => $request->input("numero_agrement"),
            "type_demande"     => $request->input("type_demande"),
            "debut_quitus"     => $date_quitus,
            "departements_id"  => $departement?->id,
            "regions_id"       => $departement?->region?->id,
            "users_id"         => $user->id,
            //'courriers_id'     => $courrier->id,
            "arrete_creation"  => $request->input("arrete_creation"),
            "demande_signe"    => $request->input("demande_signe"),
            "formulaire_signe" => $request->input("formulaire_signe"),
            "quitusfiscal"     => $request->input("quitusfiscal"),
            "cvsigne"          => $request->input("cvsigne"),
        ]);

        $operateur->save();

        if (request('quitus')) {
            if (! empty($operateur->quitus)) {
                Storage::disk('public')->delete($operateur->quitus);
            }
            $quitusPath = request('quitus')->store('quitus', 'public');
            $quitus     = Image::make(public_path("/storage/{$quitusPath}"));

            $quitus->save();

            $operateur->update([
                'quitus' => $quitusPath,
            ]);
        }

        if (request('file_arrete_creation')) {
            $file_arrete_creation = request('file_arrete_creation')->store('uploads', 'public');
            $quitus               = Image::make(public_path("/storage/{$file_arrete_creation}"));

            $quitus->save();

            $operateur->update([
                'file_arrete_creation' => $file_arrete_creation,
            ]);
        }

        Alert::success("Effectuée ! ", 'demande modifiée avec succès');

        return redirect()->back(); */

        $user->update([
            'civilite'             => $request->input("civilite"),
            'firstname'            => $request->input("prenom"),
            'name'                 => $request->input("nom"),
            'operateur'            => $request->input("operateur"),
            'username'             => $request->input("username"),
            'email'                => $request->input('email'),
            "fixe"                 => $request->input("fixe"),
            "telephone"            => $request->input("telephone"),
            "adresse"              => $request->input("adresse"),
            "categorie"            => $request->input("categorie"),
            "email_responsable"    => $request->input("email_responsable"),
            "fonction_responsable" => $request->input("fonction_responsable"),
            "telephone_parent"     => $request->input("telephone_parent"),
            "rccm"                 => $request->input("registre_commerce"),
            "ninea"                => $request->input("ninea"),
            "bp"                   => $request->input("bp"),
            "statut"               => $request->input("statut"),
            "autre_statut"         => $request->input("autre_statut"),
            "web"                  => $request->input("web"),
            'updated_by'           => Auth::id(),
        ]);

        $dateString  = $request->input('date_quitus');
        $date_quitus = ! empty($dateString) ? Carbon::createFromFormat('d/m/Y', $dateString) : null;

        $operateur->update([
            'numero_arrive'    => $request->input("numero_arrive"),
            "numero_dossier"   => $request->input("numero_dossier"),
            "numero_agrement"  => $request->input("numero_agrement"),
            "type_demande"     => $request->input("type_demande"),
            "debut_quitus"     => $date_quitus,
            "departements_id"  => $departement?->id,
            "regions_id"       => $departement?->region?->id,
            "users_id"         => $user->id,
            "arrete_creation"  => $request->input("arrete_creation"),
            "demande_signe"    => $request->input("demande_signe"),
            "formulaire_signe" => $request->input("formulaire_signe"),
            "quitusfiscal"     => $request->input("quitusfiscal"),
            "cvsigne"          => $request->input("cvsigne"),
        ]);

        // Gestion des fichiers
        if ($request->hasFile('quitus')) {
            Storage::disk('public')->delete($operateur->quitus);
            $quitusPath = $request->file('quitus')->store('quitus', 'public');
            $operateur->update(['quitus' => $quitusPath]);
        }

        if ($request->hasFile('file_arrete_creation')) {
            $filePath = $request->file('file_arrete_creation')->store('uploads', 'public');
            $operateur->update(['file_arrete_creation' => $filePath]);
        }

        Alert::success("Succès !", 'Demande modifiée avec succès');
        return redirect()->back();

    }

    public function updated(Request $request, $id)
    {
        $operateur   = Operateur::findOrFail($id);
        $user        = $operateur->user;
        $departement = Departement::where('nom', $request->input("departement"))->firstOrFail();
        $this->validate($request, [
            "departement"  => ['required', 'string'],
            "quitus"       => ['sometimes', 'image', 'mimes:jpeg,png,jpg,gif,svg', 'max:1024'],
            "date_quitus"  => ['nullable', 'date_format:d/m/Y'],
            "type_demande" => ['required', 'string'],
            'email'        => [
                'nullable',
                'string',
                'lowercase',
                'email',
                'max:255',
                Rule::unique(User::class)->ignore($id ?? null)->whereNull('deleted_at'),
            ],
        ]);

/*         foreach (Auth::user()->roles as $key => $role) {
            if (! empty($role?->name) && ($role?->name != 'super-admin') && ($role?->name != 'Employe') && ($role?->name != 'admin') && ($role?->name != 'DIOF') && ($role?->name != 'DEC')) {
                $this->authorize('update', $operateur);
            }
            if (! empty($role?->name) && ($operateur->statut_agrement != 'nouveau') && ($role?->name != 'super-admin') && ($role?->name != 'Employe') && ($role?->name != 'admin') && ($role?->name != 'DIOF') && ($role?->name != 'DEC')) {
                Alert::warning('Attention ! ', 'action impossible');
                return redirect()->back();
            }
        } */

        $rolesValid       = ['super-admin', 'Employe', 'admin', 'DIOF', 'DEC'];
        $rolesUtilisateur = Auth::user()->roles->pluck('name');

// Vérifier si l'utilisateur possède un des rôles valides
        $roleValide = $rolesUtilisateur->intersect($rolesValid)->isNotEmpty();

        if (! $roleValide) {
            // Vérifier le statut de l'opérateur et autoriser l'action si nécessaire
            if ($operateur->statut_agrement !== 'nouveau') {
                Alert::warning('Attention !', 'Action impossible');
                return redirect()->back();
            }

            // Si l'utilisateur n'a pas de rôle valide, on l'autorise à effectuer la mise à jour
            $this->authorize('update', $operateur);
        }

        /*  if (! empty($request->input('date_quitus'))) {
            $date_quitus = $request->input('date_quitus');
        } else {
            $date_quitus = null;
        } */

        $dateString  = $request->input('date_quitus');
        $date_quitus = ! empty($dateString) ? Carbon::createFromFormat('d/m/Y', $dateString) : null;

        $operateur->update([
            "type_demande"    => $request->input("type_demande"),
            "debut_quitus"    => $date_quitus,
            "departements_id" => $departement?->id,
            "regions_id"      => $departement?->region?->id,
            "users_id"        => $user->id,
        ]);

        $operateur->save();

        if (request('quitus')) {
            if (! empty($operateur->quitus)) {
                Storage::disk('public')->delete($operateur->quitus);
            }
            $quitusPath = request('quitus')->store('quitus', 'public');
            $quitus     = Image::make(public_path("/storage/{$quitusPath}"));

            $quitus->save();

            $operateur->update([
                'quitus' => $quitusPath,
            ]);
        }

        Alert::success("Succès ! ", 'demande modifiée avec succès');

        return redirect()->back();
    }
    public function edit($id)
    {
        $operateur    = Operateur::findOrFail($id);
        $departements = Departement::orderBy("created_at", "desc")->get();
        foreach (Auth::user()->roles as $key => $role) {
            if (! empty($role?->name) && ($role?->name != 'super-admin') && ($role?->name != 'Employe') && ($role?->name != 'admin') && ($role?->name != 'DIOF') && ($role?->name != 'DEC')) {
                $this->authorize('view', $operateur);
            }
        }
        return view("operateurs.update", compact("operateur", "departements"));
    }

    public function show($id)
    {
        $operateur          = Operateur::findOrFail($id);
        $operateurs         = Operateur::get();
        $operateureferences = Operateureference::get();
        $user               = $operateur->user;

        foreach (Auth::user()->roles as $key => $role) {
            if (! empty($role?->name) && ($role?->name != 'super-admin') && ($role?->name != 'Employe') && ($role?->name != 'admin') && ($role?->name != 'DIOF') && ($role?->name != 'DEC')) {
                $this->authorize('view', $operateur);
            }
        }

        return view("operateurs.show", compact("operateur", "operateureferences", "operateurs"));
    }

    public function showAgrement($id)
    {
        $operateur          = Operateur::findOrFail($id);
        $operateurs         = Operateur::get();
        $operateureferences = Operateureference::get();
        return view("operateurs.agrements.show", compact("operateur", "operateureferences", "operateurs"));
    }

    public function destroy($id)
    {
        /* $operateur = Operateur::findOrFail($id);
        if (! empty($operateur->quitus)) {
            Storage::disk('public')->delete($operateur->quitus);
        }
        if ($operateur->statut_agrement != 'nouveau') {
            Alert::warning('Attention ! ', 'action impossible');
            return redirect()->back();
        }
        foreach (Auth::user()->roles as $key => $role) {
            if (! empty($role?->name) && ($role?->name != 'super-admin') && ($role?->name != 'Employe') && ($role?->name != 'admin') && ($role?->name != 'DIOF') && ($role?->name != 'DEC')) {
                $this->authorize('delete', $operateur);
            }
        }
        $operateur->delete();
        Alert::success("Succès !" . $operateur?->user?->username, 'a été supprimé');
        return redirect()->back(); */
        $operateur = Operateur::findOrFail($id);

// Delete quitus file if it exists
        if ($operateur->quitus) {
            Storage::disk('public')->delete($operateur->quitus);
        }

// Check if the operator's status is 'nouveau'
        if ($operateur->statut_agrement !== 'nouveau') {
            Alert::warning('Attention !', 'Action impossible');
            return redirect()->back();
        }

// Check if the user has the correct roles to delete the operator
        $validRoles   = ['super-admin', 'Employe', 'admin', 'DIOF', 'DEC'];
        $hasValidRole = Auth::user()->roles->pluck('name')->intersect($validRoles)->isNotEmpty();

// If the user doesn't have a valid role, check if they are authorized to delete
        if (! $hasValidRole) {
            $this->authorize('delete', $operateur);
        }

// Delete the operator and show success alert
        $operateur->delete();
        Alert::success('Succès ! ', $operateur->user->username . ' a été supprimé');

// Redirect back
        return redirect()->back();

    }

    /* public function fetch(Request $request)
    {
        if ($request->get('query')) {
            $query = $request->get('query');
            $data  = DB::table('modules')
                ->where('name', 'LIKE', "%{$query}%")
                ->distinct()
                ->get();
            $output = '<ul class="dropdown-menu" style="display:block; position:relative;width:100%;">';
            foreach ($data as $row) {
                $output .= '
                <li><a class="dropdown-item" href="#">' . $row->name . '</a></li>
                ';
            }
            $output .= '</ul>';
            echo $output;
        }
    } */
    public function fetch(Request $request)
    {
        if ($request->get('query')) {
            $query = $request->get('query');
            $data  = DB::table('modules')
                ->whereNull('deleted_at') // Exclure les enregistrements supprimés
                ->where('name', 'LIKE', "%{$query}%")
                ->distinct()
                ->get();

            $output = '<ul class="dropdown-menu" style="display:block; position:relative;width:100%;">';
            foreach ($data as $row) {
                $output .= '
            <li><a class="dropdown-item" href="#">' . $row->name . '</a></li>
            ';
            }
            $output .= '</ul>';
            echo $output;
        }
    }

    /* public function fetchModuleOperateur(Request $request)
    {
        if ($request->get('query')) {
            $query = $request->get('query');
            $data  = DB::table('operateurmodules')
                ->where('module', 'LIKE', "%{$query}%")
                ->get()
                ->unique('module');
            $output = '<ul class="dropdown-menu" style="display:block; position:relative;width:100%;">';
            foreach ($data as $row) {
                $output .= '
                <li><a class="dropdown-item" href="#">' . $row->module . '</a></li>
                ';
            }
            $output .= '</ul>';
            echo $output;
        }
    } */

    public function fetchModuleOperateur(Request $request)
    {
        if ($request->get('query')) {
            $query = $request->get('query');
            $data  = DB::table('operateurmodules')
                ->whereNull('deleted_at') // Exclure les enregistrements supprimés
                ->where('module', 'LIKE', "%{$query}%")
                ->distinct() // Applique l'unicité au niveau SQL
                ->get();

            $output = '<ul class="dropdown-menu" style="display:block; position:relative;width:100%;">';
            foreach ($data as $row) {
                $output .= '<li><a class="dropdown-item" href="#">' . $row->module . '</a></li>';
            }
            $output .= '</ul>';
            echo $output;
        }
    }

/*     public function fetchOperateurModule(Request $request)
    {
        if ($request->get('query')) {
            $query = $request->get('query');
            $data  = DB::table('operateurmodules')
                ->where('module', 'LIKE', "%{$query}%")
                ->get()
                ->unique('module');
            $output = '<ul class="dropdown-menu" style="display:block; position:relative;width:100%;">';
            foreach ($data as $row) {
                $output .= '
                <li><a class="dropdown-item" href="#">' . $row->module . '</a></li>
                ';
            }
            $output .= '</ul>';
            echo $output;
        }
    } */

    public function fetchOperateurModule(Request $request)
    {
        if ($request->get('query')) {
            $query = $request->get('query');
            $data  = DB::table('operateurmodules')
                ->whereNull('deleted_at') // Exclure les enregistrements supprimés
                ->where('module', 'LIKE', "%{$query}%")
                ->distinct() // Optimisation : Filtrage de l'unicité au niveau SQL
                ->get();

            $output = '<ul class="dropdown-menu" style="display:block; position:relative;width:100%;">';
            foreach ($data as $row) {
                $output .= '<li><a class="dropdown-item" href="#">' . $row->module . '</a></li>';
            }
            $output .= '</ul>';
            echo $output;
        }
    }

    public function showReference($id)
    {
        $operateur          = Operateur::findOrFail($id);
        $operateureferences = Operateureference::get();

        return view('operateureferences.show', compact('operateur', 'operateureferences'));
    }
    public function showEquipement($id)
    {
        $operateur            = Operateur::findOrFail($id);
        $operateurequipements = Operateurequipement::get();

        return view('operateurequipements.show', compact('operateur', 'operateurequipements'));
    }
    public function showFormateur($id)
    {
        $operateur           = Operateur::findOrFail($id);
        $operateurformateurs = Operateurformateur::get();

        return view('operateurformateurs.show', compact('operateur', 'operateurformateurs'));
    }
    public function showLocalite($id)
    {
        $operateur          = Operateur::findOrFail($id);
        $operateurlocalites = Operateurlocalite::get();
        $regions            = Region::get();

        return view('operateurlocalites.show', compact('operateur', 'operateurlocalites', 'regions'));
    }

    /* Validation automatique */
    public function validateOperateur($id)
    {
        $operateur = Operateur::findOrFail($id);

        $moduleoperateur_count = $operateur->operateurmodules->count();

        if ($moduleoperateur_count > 0) {
            if ($operateur->statut_agrement == 'nouveau' || $operateur->statut_agrement == 'non retenu') {
                $operateur->update([
                    'statut_agrement' => 'Retenu',
                ]);

                $operateur->save();

                Alert::success("Effectué !", "l'opérateur " . $operateur?->user?->username . ' a été retenu');

                return redirect()->back();
            } else {
                Alert::warning("Imopssible ", "Car l'opérateur " . $operateur?->user?->username . ' a déjà été validé');

                return redirect()->back();
            }
        } else {
            Alert::warning('Désolez ! ', 'assurez-vous d\'avoir ajouté au moins un module');
            return redirect()->back();
        }

        /* Cette partie consistait à faire une validation automatique */

        /* $count_agreer = $operateur->operateurmodules->where('statut', 'agréer')->count();
    $count_rejeter = $operateur->operateurmodules->where('statut', 'Rejetée')->count();
    $count_nouveau = $operateur->operateurmodules->where('statut', 'nouveau')->count();

    if ($count_agreer > 0) {
    $operateur->update([
    'statut_agrement'    => 'agréer',
    'motif'              => null,
    'date',"max:10", "min:10", "date_format:Y-m-d"               =>  date('Y-m-d'),
    ]);
    Alert::success("Effectué !", "l'opérateur " . $operateur?->user?->username . ' a été agréé');
    } elseif ($count_nouveau > 0) {
    Alert::warning('Désolez ! ', 'il reste des module à traiter');
    return redirect()->back();
    } elseif ($count_rejeter > 0) {
    $operateur->update([
    'statut_agrement'    => 'Rejetée',
    'motif'              => 'Rejetée',
    'date',"max:10", "min:10", "date_format:Y-m-d"               =>  date('Y-m-d'),
    ]);
    Alert::warning("Dommage !", "l'opérateur " . $operateur?->user?->username . " n'a pas été agréé");
    } else {
    Alert::warning('Désolez ! ', 'action impossible');
    return redirect()->back();
    }

    $operateur->save();

    return redirect()->back(); */
    }
    public function nonRetenu(Request $request, $id)
    {
        $this->validate($request, [
            "motif" => "required|string",
        ]);

        $operateur = Operateur::findOrFail($id);

        if ($operateur->statut_agrement == 'Nouveau' || $operateur->statut_agrement == 'Retenue') {
            $operateur->update([
                'statut_agrement' => 'non retenu',
                'motif'           => $request->input('motif'),
            ]);

            $operateur->save();

            $validationoperateur = new Validationoperateur([
                'action'        => "non retenu",
                'motif'         => $request->input('motif'),
                'validated_id'  => Auth::user()->id,
                'session'       => $operateur?->session_agrement,
                'operateurs_id' => $operateur->id,

            ]);

            $validationoperateur->save();

            Alert::success('Effectué !', $operateur?->user?->username . " n'a pas été retenu");

            return redirect()->back();
        } else {
            Alert::warning("Imopssible ", "Car l'opérateur " . $operateur?->user?->username . ' a déjà été validé');

            return redirect()->back();
        }
    }

    public function agreerOperateur($id)
    {
        $operateur             = Operateur::findOrFail($id);
        $moduleoperateur_count = $operateur->operateurmodules->count();

        $count_nouveau = $operateur->operateurmodules->where('statut', 'nouveau')->count();

        if ($count_nouveau > 0) {
            Alert::warning('Désolez ! ', 'il reste de(s) module(s) à traiter');
            return redirect()->back();
        } elseif ($moduleoperateur_count <= '0') {
            Alert::warning('Désolez ! ', 'aucun module disponible pour cet opérateur');
            return redirect()->back();
        } else {
            $operateur->update([
                'statut_agrement' => 'agréer',
                'motif'           => null,
                'date', "max:10", "min:10", "date_format:Y-m-d" => date('Y-m-d'),
            ]);

            $operateur->save();

            $validateoperateur = new Validationoperateur([
                'validated_id'  => Auth::user()->id,
                'action'        => 'agréer',
                'session'       => $operateur?->session_agrement,
                'operateurs_id' => $operateur?->id,

            ]);

            $validateoperateur->save();

            Alert::success("Effectué !", "l'opérateur " . $operateur?->user?->username . ' a été agréé');
            return redirect()->back();
        }
    }

    public function agreerAllModuleOperateur($id)
    {
        $operateur = Operateur::findOrFail($id);

        foreach ($operateur->operateurmodules as $key => $operateurmodule) {

            $operateurmodule->update([
                'statut'   => 'agréer',
                'users_id' => Auth::user()->id,
            ]);

            $operateurmodule->save();

            Alert::success('Effectué !', 'Tous les modules ont été agréés');
        }

        return redirect()->back();

        /* $moduleoperateur_count = $operateur->operateurmodules->count();

    $count_nouveau = $operateur->operateurmodules->where('statut', 'nouveau')->count();

    if ($count_nouveau > 0) {
    Alert::warning('Désolez ! ', 'il reste de(s) module(s) à traiter');
    return redirect()->back();
    } elseif ($moduleoperateur_count <= '0') {
    Alert::warning('Désolez ! ', 'aucun module disponible pour cet opérateur');
    return redirect()->back();
    } else {
    $operateur->update([
    'statut_agrement'    => 'agréer',
    'motif'              => null,
    'date',"max:10", "min:10", "date_format:Y-m-d"               =>  date('Y-m-d'),
    ]);

    $operateur->save();

    $validateoperateur = new Validationoperateur([
    'validated_id'       =>       Auth::user()->id,
    'action'             =>      'agréer',
    'session'            =>      $operateur?->session_agrement,
    'operateurs_id'      =>      $operateur?->id

    ]);

    $validateoperateur->save();

    Alert::success("Effectué !", "l'opérateur " . $operateur?->user?->username . ' a été agréé');
    return redirect()->back();
    } */
    }

    public function retirerOperateur($id)
    {
        $operateur = Operateur::findOrFail($id);
        if ($operateur->statut_agrement != 'nouveau') {
            Alert::warning('Attention ! ', 'action impossible opérateur déjà traité');
            return redirect()->back();
        }
        $operateur->update([
            'statut_agrement'        => 'Retiré',
            'commissionagrements_id' => null,
        ]);

        $operateur->save();

        $validateoperateur = new Validationoperateur([
            'validated_id'  => Auth::user()->id,
            'action'        => 'Retiré',
            'session'       => $operateur?->session_agrement,
            'operateurs_id' => $operateur?->id,

        ]);

        $validateoperateur->save();

        Alert::success("Effectué !", "l'opérateur a été retiré");

        return redirect()->back();
    }
    public function devenirOperateur()
    {
        /* $user            = Auth::user();
        $operateur       = Operateur::where('users_id', $user->id)->orderBy("created_at", "desc")->get();
        $operateurs      = Operateur::get();
        $operateur_total = $operateur->count();
        $departements    = Departement::orderBy("created_at", "desc")->get();

        if ($operateur_total >= 1) {
            foreach ($user?->operateurs as $operateur_module) {
            }

            $operateur_module_count = Operateurmodule::where('operateurs_id', $operateur_module?->id)->count();

            if ($operateur_module_count > 0) {
                $module_count = "valide";
            } else {
                $module_count = "invalide";
            }

            $operateur_reference_count = Operateureference::where('operateurs_id', $operateur_module?->id)->count();

            if ($operateur_reference_count > 0) {
                $reference_count = "valide";
            } else {
                $reference_count = "invalide";
            }

            $operateur_equipement_count = Operateurequipement::where('operateurs_id', $operateur_module?->id)->count();

            if ($operateur_equipement_count > 0) {
                $equipement_count = "valide";
            } else {
                $equipement_count = "invalide";
            }

            $operateur_formateur_count = Operateurformateur::where('operateurs_id', $operateur_module?->id)->count();

            if ($operateur_formateur_count > 0) {
                $formateur_count = "valide";
            } else {
                $formateur_count = "invalide";
            }

            $operateur_localite_count = Operateurlocalite::where('operateurs_id', $operateur_module?->id)->count();

            if ($operateur_localite_count > 0) {
                $localite_count = "valide";
            } else {
                $localite_count = "invalide";
            }

            if (
                $operateur_module_count > 0
                && $operateur_reference_count > 0
                && $operateur_equipement_count > 0
                && $operateur_formateur_count > 0
                && $operateur_localite_count >= 0
            ) {
                $statut_demande = "valide";
            } else {
                $statut_demande = "invalide";
            }

            return view(
                "operateurs.show-operateur",
                compact(
                    "operateur_total",
                    "departements",
                    "operateur",
                    "operateurs",
                    "statut_demande",
                    "module_count",
                    "reference_count",
                    "equipement_count",
                    "formateur_count",
                    "localite_count",
                )
            );
        } else {
            return view(
                "operateurs.show-operateur-aucun",
                compact(
                    "operateur_total",
                    "departements",
                    "operateur",
                    "operateurs"
                    "user"
                )
            );
        } */

        $user = Auth::user();

        // Récupérer l'opérateur lié à l'utilisateur
        $operateur    = Operateur::where('users_id', $user->id)->orderBy("created_at", "desc")->first();
        $operateurA   = Operateur::where('users_id', $user->id)->orderBy("created_at", "desc")->get();
        $operateurs   = Operateur::all();
        $departements = Departement::orderBy("created_at", "desc")->get();

        $operateur_total = $operateurs->count();

        // Récupérer les fichiers associés à l'utilisateur
        $files = File::where('users_id', $user->id)
            ->whereNotNull('file')
            ->distinct()
            ->get();

        /* $user_files = File::where('users_id', $user->id)
            ->whereNull('file')
            ->distinct()
            ->get(); */

        $user_files = File::where('users_id', $user?->id)
            ->whereNull('file')
            ->whereNotIn('sigle', ['CIN', 'DAC', 'DP', 'CR', 'AD', 'Bulletins'])
            ->distinct()
            ->get();

        if ($operateur_total >= 1 && $operateur) {
            // Récupérer les counts des relations de l'opérateur
            $module_count     = Operateurmodule::where('operateurs_id', $operateur->id)->exists() ? "valide" : "invalide";
            $reference_count  = Operateureference::where('operateurs_id', $operateur->id)->exists() ? "valide" : "invalide";
            $equipement_count = Operateurequipement::where('operateurs_id', $operateur->id)->exists() ? "valide" : "invalide";
            $formateur_count  = Operateurformateur::where('operateurs_id', $operateur->id)->exists() ? "valide" : "invalide";
            $localite_count   = Operateurlocalite::where('operateurs_id', $operateur->id)->exists() ? "valide" : "invalide";

            // Déterminer le statut de la demande
            $statut_demande = ($module_count === "valide" && $reference_count === "valide" && $equipement_count === "valide" &&
                $formateur_count === "valide" && $localite_count === "valide") ? "valide" : "invalide";

            // Retourner la vue avec les données
            return view('operateurs.show-operateur',
                compact(
                    'operateur_total',
                    'user_files',
                    'files',
                    'departements',
                    'operateur',
                    'operateurA',
                    'operateurs',
                    'statut_demande',
                    'module_count',
                    'reference_count',
                    'equipement_count',
                    'formateur_count',
                    'localite_count'
                ));
        } else {
            // Si aucun opérateur n'est trouvé, afficher une vue différente
            return view('operateurs.show-operateur-aucun',
                compact(
                    'departements',
                    'operateur',
                    'operateurs',
                    'user'
                ));
        }

    }
    public function rapports(Request $request)
    {
        $title          = 'rapports opérateurs';
        $regions        = Region::orderBy("created_at", "desc")->get();
        $module_statuts = Operateurmodule::get()->unique('statut');
        return view('operateurs.rapports', compact(
            'title',
            'regions',
            'module_statuts',
        ));
    }
    public function generateRapport(Request $request)
    {
        if ($request->valeur_region == "1") {
            $this->validate($request, [
                'region' => 'required|string',
                'statut' => 'required|string',
            ]);

            $region = Region::findOrFail($request->region);

            $operateurs = Operateur::where('statut_agrement', 'LIKE', "{$request->statut}")
                ->where('regions_id', "{$request->region}")
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

            $title = $count . ' ' . $operateur . ' ' . $statut . ' à ' . $region->nom;
        } elseif ($request->valeur_module == "1") {
            $this->validate($request, [
                'module' => 'required|string',
                'statut' => 'required|string',
            ]);

            $operateurs = Operateur::join('operateurmodules', 'operateurs.id', 'operateurmodules.operateurs_id')
                ->select('operateurs.*')
                ->where('statut_agrement', 'LIKE', "%{$request->statut}%")
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
            $title = $count . ' ' . $operateur . ' ' . $statut . ' en ' . $request->module;
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

        $regions        = Region::orderBy("created_at", "desc")->get();
        $module_statuts = Operateurmodule::get()->unique('statut');

        return view('operateurs.rapports', compact(
            'module_statuts',
            'operateurs',
            'title',
            'regions'
        ));
    }
    public function observations(Request $request, $id)
    {
        $this->validate($request, [
            'observation'       => 'required|string',
            'visite_conformite' => 'required|string',
        ]);

        $operateur = Operateur::findOrFail($id);

        $operateur->update([
            'observations'      => $request->input('observation'),
            'visite_conformite' => $request->input('visite_conformite'),
        ]);

        $operateur->save();

        Alert::success('Félicitations', 'Observations enregistrées');
        return redirect()->back();
    }

    public function ficheSynthese(Request $request)
    {
        $commission = Commissionagrement::find($request->input('id'));

        /*  $operateurs = Operateur::offset($request->value1)->limit($request->value2)->where('statut_agrement', '!=', 'non retenu')
        ->where('commissionagrements_id', $request->input('id'))
        ->get(); */

        $operateurs = Operateur::where('statut_agrement', '!=', 'non retenu')
            ->where('commissionagrements_id', $request->input('id'))
            ->get();

        $title = 'Fiche de synthèse ' . $commission?->commission . ' du ' . $commission?->date?->translatedFormat('l d F Y') . ' à ' . $commission?->lieu;

        $dompdf  = new Dompdf();
        $options = $dompdf->getOptions();
        $dompdf->setOptions($options);

        $dompdf->loadHtml(view('operateurs.fichesynthese',
            compact(
                'commission',
                'operateurs',
                'title'
            )));

        // (Optional) Setup the paper size and orientation (portrait ou landscape)
        $dompdf->setPaper('Letter', 'portrait');

        // Render the HTML as PDF
        $dompdf->render();

        $name = 'Fiche de synthèse ' . $commission?->commission . ' du ' . $commission?->date?->translatedFormat('l d F Y') . ' à ' . $commission?->lieu . '.pdf';

        // Output the generated PDF to Browser
        $dompdf->stream($name, ['Attachment' => false]);
    }

    public function ficheSyntheseOperateur(Request $request)
    {
        $operateur = Operateur::findOrFail($request->input('id'));

        $title = 'Fiche de synthèse ' . $operateur?->user?->operateur;

        $dompdf  = new Dompdf();
        $options = $dompdf->getOptions();
        $dompdf->setOptions($options);

        $dompdf->loadHtml(view('operateurs.fichesyntheseoperateur',
            compact(
                'operateur',
                'title'
            )));

        // (Optional) Setup the paper size and orientation (portrait ou landscape)
        $dompdf->setPaper('Letter', 'portrait');

        // Render the HTML as PDF
        $dompdf->render();

        $name = 'Fiche de synthèse ' . $operateur?->user?->operateur . '.pdf';

        // Output the generated PDF to Browser
        $dompdf->stream($name, ['Attachment' => false]);
    }

    public function lettreAgrement(Request $request)
    {
        $commission = Commissionagrement::find($request->input('id'));

        $operateurs_count = Operateur::where('statut_agrement', 'agréer')
            ->where('commissionagrements_id', $request->input('id'))
            ->count();

        /* $operateurs = Operateur::offset($request->value1)->limit($request->value2)->where('statut_agrement', 'agréer')
        ->where('commissionagrements_id', $request->input('id'))
        ->get(); */

        $operateurs = Operateur::where('statut_agrement', 'agréer')
            ->where('commissionagrements_id', $request->input('id'))
            ->get();

        $title = 'Lettres agrément opérateurs, ' . $commission?->commission . ' du ' . $commission?->date?->translatedFormat('l d F Y') . ' à ' . $commission?->lieu;

        $dompdf  = new Dompdf();
        $options = $dompdf->getOptions();
        $dompdf->setOptions($options);

        $dompdf->loadHtml(view('operateurs.lettreagrement',
            compact(
                'operateurs',
                'title'
            )));

        // (Optional) Setup the paper size and orientation (portrait ou landscape)
        $dompdf->setPaper('Letter', 'portrait');

        // Render the HTML as PDF
        $dompdf->render();

        $name = 'Lettres agrément opérateurs, ' . $commission?->commission . ' du ' . $commission?->date?->translatedFormat('l d F Y') . ' à ' . $commission?->lieu . '.pdf';

        // Output the generated PDF to Browser
        $dompdf->stream($name, ['Attachment' => false]);
    }

    public function generateReport(Request $request)
    {
        $this->validate($request, [
            'operateur_name'  => 'nullable|string',
            'operateur_sigle' => 'nullable|string',
            'numero_agrement' => 'nullable|string',
            'telephone'       => 'nullable|string',
            'email'           => 'nullable|email',
        ]);

        if ($request?->operateur_name == null && $request->operateur_sigle == null && $request->telephone == null && $request->numero_agrement == null && $request->email == null) {
            Alert::warning('Attention ', 'Renseigner au moins un champ pour rechercher');
            return redirect()->back();
        }

        $departements      = Departement::orderBy("created_at", "desc")->get();
        $operateur_agreer  = Operateur::where('statut_agrement', 'agréer')->count();
        $operateur_rejeter = Operateur::where('statut_agrement', 'Rejetée')->count();
        $operateur_nouveau = Operateur::where('statut_agrement', 'nouveau')->count();
        $operateur_expirer = Operateur::where('statut_agrement', 'expirer')->count();
        $operateur_total   = Operateur::where('statut_agrement', 'agréer')->orwhere('statut_agrement', 'Rejetée')->orwhere('statut_agrement', 'nouveau')->count();
        if (isset($operateur_total) && $operateur_total > '0') {
            $pourcentage_agreer  = ((($operateur_agreer) / ($operateur_total)) * 100);
            $pourcentage_rejeter = ((($operateur_rejeter) / ($operateur_total)) * 100);
            $pourcentage_nouveau = ((($operateur_nouveau) / ($operateur_total)) * 100);
            $pourcentage_expirer = ((($operateur_expirer) / ($operateur_total)) * 100);
        } else {
            $pourcentage_agreer  = "0";
            $pourcentage_rejeter = "0";
            $pourcentage_nouveau = "0";
            $pourcentage_expirer = "0";
        }

        /* $total_count = Operateur::get();
        $total_count = number_format($total_count->count(), 0, ',', ' '); */

        /* $operateur_liste = Operateur::take(100)
        ->latest()
        ->get();

        $count_operateur = number_format($operateur_liste?->count(), 0, ',', ' '); */

        /*      if ($count_operateur < "1") {
        $title = 'Aucun opérateur';
        } elseif ($count_operateur == "1") {
        $title = $count_operateur . ' opérateur sur un total de ' . $total_count;
        } else {
        $title = 'Liste des ' . $count_operateur . ' derniers opérateurs sur un total de ' . $total_count;
        } */

        $operateurs = Operateur::join('users', 'users.id', 'operateurs.users_id')
            ->select('operateurs.*')
            ->where('operateur', 'LIKE', "%{$request?->operateur_name}%")
            ->where('username', 'LIKE', "%{$request?->operateur_sigle}%")
            ->where('numero_agrement', 'LIKE', "%{$request?->numero_agrement}%")
            ->where('telephone', 'LIKE', "%{$request?->telephone}%")
            ->where('email', 'LIKE', "%{$request?->email}%")
            ->distinct()
            ->get();

        $count = $operateurs?->count();

        if (isset($count) && $count < "1") {
            $title = 'aucun opérateur trouvé';
        } elseif (isset($count) && $count == "1") {
            $title = $count . ' opérateur trouvé';
        } else {
            $title = $count . ' opérateurs trouvés';
        }

        return view(
            'operateurs.index',
            compact(
                'operateurs',
                "operateurs",
                "departements",
                "operateur_agreer",
                "operateur_rejeter",
                "pourcentage_agreer",
                "pourcentage_rejeter",
                "operateur_nouveau",
                "operateur_expirer",
                "title",
                "pourcentage_nouveau",
                "pourcentage_expirer"
            )
        );
    }

    public function agreer(Request $request)
    {
        $title      = "Liste des opérateurs agréés";
        $operateurs = Operateur::where('statut_agrement', 'agréer')->get();
        return view(
            'operateurs.agreer',
            compact(
                'title',
                'operateurs'
            )
        );
    }

    public function expirer(Request $request)
    {
        $title      = "Liste des opérateurs dont l'agrément est arrivé à expiration";
        $operateurs = Operateur::where('statut_agrement', 'expirer')->get();
        return view(
            'operateurs.expirer',
            compact(
                'title',
                'operateurs'
            )
        );
    }

    public function lettreOperateur(Request $request)
    {

        $operateur = Operateur::findOrFail($request->id);

        $title = 'Lettres agrément , ' . $operateur?->user?->operateur;

        $dompdf  = new Dompdf();
        $options = $dompdf->getOptions();
        $dompdf->setOptions($options);

        $dompdf->loadHtml(view('operateurs.lettreoperateur', compact(
            'operateur',
            'title'
        )));

        // (Optional) Setup the paper size and orientation (portrait ou landscape)
        $dompdf->setPaper('Letter', 'portrait');

        // Render the HTML as PDF
        $dompdf->render();

        $name = 'Lettres agrément opérateurs, ' . $operateur?->user?->operateur . '.pdf';

        // Output the generated PDF to Browser
        $dompdf->stream($name, ['Attachment' => false]);
    }

}
