<?php
namespace App\Http\Controllers;

use App\Models\Direction;
use App\Models\Employee;
use App\Models\Fonction;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\Rule;
use RealRashid\SweetAlert\Facades\Alert;

class DirectionController extends Controller
{
    public function __construct()
    {
        // examples:
        $this->middleware('auth');
        $this->middleware(['role:super-admin|admin']);
        /* $this->middleware(['permission:arrive-show']); */
        // or with specific guard
        /* $this->middleware(['role_or_permission:super-admin']); */
    }
    public function index()
    {
        $directions = Direction::orderBy("created_at", "desc")->get();
        return view("directions.index", compact("directions"));
    }

    public function create()
    {
        $employe = Employee::orderBy("created_at", "desc")->get();
        return view('directions.create', compact('employe'));
    }

    public function store(Request $request)
    {

        $this->validate($request, [
            "direction" => "required|string|unique:directions,name,except,id",
            "sigle"     => "required|string|unique:directions,sigle,except,id",
            "type"      => "required|string",
        ]);

        $direction = Direction::create([
            "name"    => $request->input("direction"),
            "sigle"   => $request->input("sigle"),
            "type"    => $request->input("type"),
            "chef_id" => $request->input("employe"),
        ]);

        $direction->save();

        Alert::success('Succès !', $direction->name . " a ajoutée avec succès.");

        return redirect()->back();
    }

    public function edit($id)
    {
        /*  $direction = Direction::find($id);
        $employe = Employee::orderBy("created_at", "desc")->get();
        if (isset($direction->chef_id)) {
            $chef = Employee::findOrFail($direction->chef_id);
            $chef_name = $chef->matricule . ' ' . $chef->user->firstname . ' ' . $chef->user->name;
        } else {
            $chef = null;
            $chef_name = null;
        } */

/*         // Récupération de la Direction par son ID
        $direction = Direction::findOrFail($id);

// Récupérer tous les employés, triés par la date de création (descendant)
        $employe = Employee::orderBy("created_at", "desc")->get();

// Vérification si un chef est assigné à la direction
        if (isset($direction->chef_id)) {
            // Récupération des informations sur le chef
            $chef = Employee::findOrFail($direction->chef_id);
            // Construction du nom complet du chef en combinant matricule, prénom et nom
            $chef_name = $chef->user->firstname . ' ' . $chef->user->name;
        } else {
            // Si aucun chef n'est assigné, initialiser ces variables à null
            $chef      = null;
            $chef_name = null;
        } */

        $direction = Direction::findOrFail($id);
        $employes  = Employee::orderBy("created_at", "desc")->get();
        $fonctions = Fonction::orderBy("created_at", "desc")->get();

        return view("directions.update", compact("direction", "employes", "fonctions"));
    }
    public function update(Request $request, $id)
    {
        $this->validate($request, [
            'name'     => ['required', 'string', 'max:255', Rule::unique(Direction::class)->ignore($id)],
            'sigle'    => ['required', 'string', 'max:10', Rule::unique(Direction::class)->ignore($id)],
            "type"     => ['required', 'string'],
            "employe"  => ['required', 'string'],
        ]);

        $direction = Direction::findOrFail($id);
        $employe   = Employee::findOrFail($request->input("employe"));

        $direction->update([
            'name'    => $request->input("name"),
            'sigle'   => $request->input("sigle"),
            'type'    => $request->input("type"),
            'chef_id' => $request->input("employe"),
        ]);

        $employe->update([
            'directions_id' => $direction->id,
        ]);

        $mesage = $direction->name . '  a été modifiée';

        Alert::success('Succès !', $direction->name . " a été modifiée.");

        return redirect()->back();
    }
    public function show($id)
    {
        $direction  = Direction::find($id);
        $directions = Direction::orderBy("created_at", "desc")->get();
        $employes   = Employee::get();

        return view("directions.show", compact("direction", 'directions', 'employes'));
    }
    public function destroy($id)
    {
        $direction = Direction::find($id);

        $direction->delete();

        Alert::success('Succès !', $direction->name . " a supprimée avec succès.");

        return redirect()->back();
    }

    public function adddirectionAgent($iddirection)
    {

        $direction = Direction::findOrFail($iddirection);
        $employes  = Employee::get();

        $employeDirection = DB::table('employees')
            ->where('directions_id', $iddirection)
            ->pluck('directions_id', 'directions_id')
            ->all();

        $employeDirectionCheck = DB::table('employees')
            ->where('directions_id', '!=', null)
            ->where('directions_id', '!=', $iddirection)
            ->pluck('directions_id', 'directions_id')
            ->all();

        return view("directions.direction-employes", compact('employeDirection', 'direction', 'employes', 'employeDirectionCheck'));
    }

    public function givedirectionAgent($iddirection, Request $request)
    {
        $request->validate([
            'employes' => ['required'],
        ]);

        foreach ($request->employes as $employe) {
            $employe = Employee::findOrFail($employe);
            $employe->update([
                "directions_id" => $iddirection,
            ]);

            $employe->save();
        }

        Alert::success('Effectuée !', 'Employé(s) ajouté(s)');

        return redirect()->back();
    }

    public function retirerEmploye(Request $request)
    {
        $employe = Employee::findOrFail($request->input('id'));

        $employe->update([
            'directions_id' => null,
        ]);

        $employe->save();

        Alert::success('Effectué !', 'employé retiré');

        return redirect()->back();
    }

    public function adddirectionChef($iddirection)
    {

        $direction = Direction::findOrFail($iddirection);
        $employes  = Employee::where('directions_id', $iddirection)->get();

        $employeDirection = DB::table('employees')
            ->where('directions_id', $iddirection)
            ->where('id', $direction?->chef_id)
            ->pluck('id', 'id')
            ->all();

        $employeDirectionCheck = DB::table('employees')
            ->where('directions_id', '!=', null)
            ->where('directions_id', '!=', $iddirection)
            ->where('id', $direction?->chef_id)
            ->pluck('id', 'id')
            ->all();

        return view("directions.direction-chef", compact('employeDirection', 'direction', 'employes', 'employeDirectionCheck'));
    }

    public function givedirectionChef($iddirection, Request $request)
    {
        $request->validate([
            'employe' => ['required'],
        ]);

        /* $employe = Employee::findOrFail($request->employe); */

        $direction = Direction::findOrFail($iddirection);

        $direction->update([
            "chef_id" => $request->employe,
        ]);

        $direction->save();

        Alert::success('Effectuée !', 'Responsable ajouté');

        return redirect()->back();
    }
}
