<?php
namespace App\Http\Controllers;

use App\Models\Domaine;
use App\Models\Individuelle;
use App\Models\Module;
use App\Models\Region;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use RealRashid\SweetAlert\Facades\Alert;

class ModuleController extends Controller
{
    public function __construct()
    {
        // examples:
        $this->middleware('auth');
        $this->middleware(['role:super-admin|admin|DIOF|ADIOF']);
        /* $this->middleware(['permission:arrive-show']); */
        // or with specific guard
        /* $this->middleware(['role_or_permission:super-admin']); */
    }
    public function index()
    {
        // Récupérer toutes les données en une seule requête par type
        $modules  = Module::latest('created_at')->get();
        $domaines = Domaine::latest('created_at')->get();
        $regions  = Region::latest('created_at')->get();

// Compter directement les modules sans récupérer toute la collection
        $total_count  = Module::count();
        $count_module = $modules->count();

// Gestion du titre
        if ($count_module === 0) {
            $title = 'Aucun module';
        } elseif ($count_module === 1) {
            $title = "$count_module module sur un total de $total_count";
        } else {
            $title = "Liste des $count_module modules sur un total de $total_count";
        }

        return view(
            "modules.index",
            compact(
                "modules",
                "domaines",
                "regions",
                "title"
            )
        );
    }

    public function edit($id)
    {
        $module   = Module::find($id);
        $domaines = Domaine::orderBy("created_at", "desc")->get();
        return view("modules.update", compact("module", "domaines"));
    }

    public function show($id)
    {
        $module = Module::find($id);
        return view("modules.show", compact("module"));
    }

    public function update(Request $request, $id)
    {
        $this->validate($request, [
            "name"                 => ["required", "string", Rule::unique(Module::class)->ignore($id)->whereNull('deleted_at')],
            "domaine"              => ["required", "string"],
            "niveau_qualification" => ["required", "string"],
        ]);

        $module = Module::findOrFail($id);

        $module->update([
            'name'                 => $request->input('name'),
            'domaines_id'          => $request->input('domaine'),
            'niveau_qualification' => $request->input('niveau_qualification'),
        ]);

        $module->save();

        Alert::success('Succès !', 'Les modifications ont été enregistrées avec succès.');

        return redirect()->back();
    }

    public function modulelocalite($idlocalite, $idmodule)
    {
        $localite = Region::findOrFail($idlocalite);
        $module   = Module::findOrFail($idmodule);

        $individuelles = Individuelle::where('regions_id', $idlocalite)->where('modules_id', $idmodule)->get();

        return view("modules.modulelocalite", compact("module", "localite", "individuelles"));
    }

    public function modulelocalitestatut($idlocalite, $idmodule, $statut)
    {
        $localite = Region::findOrFail($idlocalite);
        $module   = Module::findOrFail($idmodule);

        $individuelles = Individuelle::where('regions_id', $idlocalite)
            ->where('modules_id', $idmodule)
            ->where('statut', $statut)->get();

        return view("modules.modulelocalitestatut", compact("module", "localite", "individuelles", "statut"));
    }

    public function modulestatut($statut, $idmodule)
    {
        $module = Module::findOrFail($idmodule);

        $individuelles = Individuelle::where('statut', $statut)->where('modules_id', $idmodule)->get();

        return view("modules.modulestatut", compact("module", "statut", "individuelles"));
    }

    public function modulestatutlocalite($idlocalite, $idmodule, $statut)
    {
        $localite = Region::findOrFail($idlocalite);
        $module   = Module::findOrFail($idmodule);

        $individuelles = Individuelle::where('regions_id', $idlocalite)
            ->where('modules_id', $idmodule)
            ->where('statut', $statut)->get();

        return view("modules.modulestatutlocalite", compact("module", "localite", "individuelles", "statut"));
    }

    public function addModule(Request $request)
    {
        $this->validate($request, [
            "name"    => ["required", "string", Rule::unique(Module::class)->whereNull('deleted_at')],
            "domaine" => ["nullable", "string"],
        ]);

        $module = Module::create([
            'name'        => $request->input('name'),
            'domaines_id' => $request->input('domaine'),
        ]);

        $module->save();

        Alert::success('Succès !', 'Le module ' . $module->name . ' a été ajouté avec succès');

        return redirect()->back();
    }

    public function destroy($id)
    {
        $module = Module::find($id);
// Vérifiez si le module est lié à des demandes individuelles
        if ($module->individuelles()->count() > 0) {
            // Si des demandes individuelles sont liées, empêchez la suppression
            Alert::warning('Attention !', 'Ce module est lié à une ou plusieurs demandes individuelles et ne peut pas être supprimé.');
            return redirect()->back();
        }

// Si aucune demande individuelle n'est liée, procédez à la suppression
        $module->delete();

        Alert::success('Succès !', 'Le module ' . $module->name . ' a été supprimé avec succès');

        return redirect()->back();
    }
    public function rapports(Request $request)
    {
        $title   = 'rapports opérateurs';
        $regions = Region::orderBy("created_at", "desc")->get();
        return view('modules.rapports', compact(
            'title',
            'regions',
        ));
    }
    public function generateRapport(Request $request)
    {
        $this->validate($request, [
            'region' => 'required|string',
            'module' => 'required|string',
            'statut' => 'required|string',
        ]);

        $region = Region::findOrFail($request->region);

        $individuelles = Individuelle::join('modules', 'individuelles.modules_id', 'modules.id')
            ->select('individuelles.*')
            ->where('statut', 'LIKE', "%{$request->statut}%")
            ->where('regions_id', "{$request->region}")
            ->where('modules.name', 'LIKE', "%{$request->module}%")
            ->distinct()
            ->get();

        $count = $individuelles->count();

        /* if (isset($count) && $count <= "1") {
            $individuelle = 'demandeur';
            if (isset($request->statut) && $request->statut == "Nouvelle") {
                $statut = 'Nouvelle';
            } elseif (isset($request->statut) && $request->statut == "Former") {
                $statut = 'a terminé la formation';
            } elseif (isset($request->statut) && $request->statut == 'Rejetée') {
                $statut = 'Rejeté';
            } elseif (isset($request->statut) && $request->statut == 'Attente') {
                $statut = 'en attente de formation';
            } elseif (isset($request->statut) && $request->statut == "Retenue") {
                $statut = 'Retenue';
            } else {
                $statut = $request->statut;
            }
        } else {
            $individuelle = 'demandeurs';
            if (isset($request->statut) && $request->statut == "Nouvelle") {
                $statut = 'Nouvelle';
            } elseif (isset($request->statut) && $request->statut == "Former") {
                $statut = 'ont terminé leur formation';
            } elseif (isset($request->statut) && $request->statut == 'Rejetée') {
                $statut = 'Rejetés';
            } elseif (isset($request->statut) && $request->statut == 'Attente') {
                $statut = 'en attente de formation';
            } elseif (isset($request->statut) && $request->statut == "Fetenu") {
                $statut = 'Retenus';
            } else {
                $statut = $request->statut;
            }
        } */

        // Définir l'assignation de $individuelle en fonction de $count
        $individuelle = ($count <= 1) ? 'demandeur' : 'demandeurs';

// Définir le statut en fonction de la valeur de $request->statut
        $statutMapping = [
            "Nouvelle" => ($count <= 1) ? 'Nouvelle' : 'Nouvelle',
            "Former"   => ($count <= 1) ? 'a terminé la formation' : 'ont terminé leur formation',
            "Rejetée"  => ($count <= 1) ? 'Rejeté' : 'Rejetés',
            "Attente"  => 'en attente de formation',
            "Retenue"  => ($count <= 1) ? 'Retenue' : 'Retenus',
        ];

// Utiliser la valeur par défaut du statut si elle n'est pas dans le tableau de mapping
        $statut = $statutMapping[$request->statut] ?? $request->statut;

        $title = $count . ' ' . $individuelle . ' ' . $statut . ' en ' . $request->module . ' dans la région de  ' . $region->nom;

        $regions = Region::orderBy("created_at", "desc")->get();

        return view('modules.rapports', compact(
            'individuelles',
            'title',
            'regions',
        ));
    } /*
    public function reports(Request $request)
    {
        $title = 'rapports opérateurs';

        $modules = Module::orderBy("created_at", "desc")->get();
        $domaines = Domaine::orderBy("created_at", "desc")->get();
        $regions = Region::orderBy("created_at", "desc")->get();

        $total_count = Module::count();

        $count_module = number_format($modules?->count(), 0, ',', ' ');

        if ($count_module < "1") {
            $title = 'Aucun module';
        } elseif ($count_module == "1") {
            $title = $count_module . ' module sur un total de ' . $total_count;
        } else {
            $title = 'Liste des ' . $count_module . ' modules sur un total de ' . $total_count;
        }

        return view(
            "modules.index",
            compact(
                "modules",
                "domaines",
                "regions",
                "title"
            )
        );
    }
    public function generateReport(Request $request)
    {
        $this->validate($request, [
            'region' => 'required|string',
            'module' => 'required|string',
            'statut' => 'required|string',
        ]);

        $region = Region::findOrFail($request->region);

        $individuelles = Individuelle::join('modules', 'individuelles.modules_id', 'modules.id')
            ->select('individuelles.*')
            ->where('statut', 'LIKE', "%{$request->statut}%")
            ->where('regions_id',  "{$request->region}")
            ->where('modules.name', 'LIKE', "%{$request->module}%")
            ->distinct()
            ->get();

        $count = $individuelles->count();

        if (isset($count) && $count <= "1") {
            $individuelle = 'demandeur';
            if (isset($request->statut) && $request->statut == "Nouvelle") {
                $statut = 'nouveau';
            } elseif (isset($request->statut) && $request->statut == "Terminée") {
                $statut = 'a terminé la formation';
            } elseif (isset($request->statut) && $request->statut == 'Rejetée') {
                $statut = 'rejeté';
            } elseif (isset($request->statut) && $request->statut == 'Attente') {
                $statut = 'en attente de formation';
            } elseif (isset($request->statut) && $request->statut == "retenue") {
                $statut = 'Retenue';
            } else {
                $statut = $request->statut;
            }
        } else {
            $individuelle = 'demandeurs';
            if (isset($request->statut) && $request->statut == "Nouvelle") {
                $statut = 'nouveaux';
            } elseif (isset($request->statut) && $request->statut == "Terminée") {
                $statut = 'ont terminé leur formation';
            } elseif (isset($request->statut) && $request->statut == 'Rejetée') {
                $statut = 'rejetés';
            } elseif (isset($request->statut) && $request->statut == 'Attente') {
                $statut = 'en attente de formation';
            } elseif (isset($request->statut) && $request->statut == "retenue") {
                $statut = 'retenus';
            } else {
                $statut = $request->statut;
            }
        }
        $title = $count . ' ' . $individuelle . ' ' . $statut . ' en ' . $request->module . ' dans la région de  ' . $region->nom;

        $regions = Region::orderBy("created_at", "desc")->get();

        return view('modules.rapports', compact(
            'individuelles',
            'title',
            'regions',
        ));
    } */

}
