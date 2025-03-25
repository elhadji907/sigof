<?php
namespace App\Http\Controllers;

use App\Models\Article;
use App\Models\Category;
use App\Models\Decision;
use App\Models\Decret;
use App\Models\Direction;
use App\Models\Employee;
use App\Models\Fonction;
use App\Models\Indemnite;
use App\Models\Loi;
use App\Models\Nommination;
use App\Models\Procesverbal;
use App\Models\User;
use Carbon\Carbon;
use Dompdf\Dompdf;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Validation\Rule;
use Intervention\Image\Facades\Image;
use RealRashid\SweetAlert\Facades\Alert;

class EmployeController extends Controller
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
        $employes = Employee::orderBy("created_at", "desc")->get();
        return view("employes.index", compact("employes"));
    }

    public function create()
    {
        $directions = Direction::orderBy('created_at', 'desc')->get();
        $categories = Category::orderBy('created_at', 'desc')->get();
        $fonctions  = Fonction::orderBy('created_at', 'desc')->get();
        return view("employes.create", compact('directions', 'categories', 'fonctions'));
    }

    public function store(Request $request)
    {
        $this->validate($request, [
            "matricule"           => ['nullable', 'string', 'min:8', 'max:8'],
            'firstname'           => ['required', 'string', 'max:50'],
            'name'                => ['required', 'string', 'max:25'],
            'image'               => ['image', 'max:255', 'nullable', 'mimes:jpeg,png,jpg,gif,svg', 'max:1024'],
            'telephone'           => ['nullable', 'string', 'min:9', 'max:12'],
            'adresse'             => ['nullable', 'string', 'max:255'],
            'civilite'            => ['required', 'string', 'max:10'],
            'cin'                 => [
                'nullable',
                'string',
                'min:16',
                'max:17',
                Rule::unique(User::class)->whereNull('deleted_at'),
            ],
            'date_naissance'      => ['nullable', 'date_format:d/m/Y'],
            'lieu_naissance'      => ['nullable', 'string'],
            'email'               => ['required', 'string', 'lowercase', 'email', 'max:255', Rule::unique(User::class)],
            'date_embauche'       => ['nullable', 'date_format:d/m/Y'],
            'categorie'           => ['nullable', 'string'],
            'fonction'            => ['nullable', 'string'],
            'direction'           => ['nullable', 'string'],
            'situation_familiale' => ['nullable', 'string'],
        ]);

        $categorie = Category::where('name', $request?->categorie)->first();
        $fonction  = Fonction::where('name', $request?->fonction)->first();
        $direction = Direction::where('name', $request?->direction)->first();

        if ($request->date_naissance) {
            $dateNaissance  = $request->date_naissance;
            $date_naissance = Carbon::createFromFormat('d/m/Y', $dateNaissance);
        } else {
            $date_naissance = null;
        }

        $user = User::create([
            'cin'                 => $request?->cin,
            'civilite'            => $request->civilite,
            'firstname'           => $request->firstname,
            'username'            => $request->email,
            'name'                => $request->name,
            'date_naissance'      => $date_naissance,
            'lieu_naissance'      => $request->lieu_naissance,
            'situation_familiale' => $request->situation_familiale,
            'email'               => $request->email,
            'telephone'           => $request->telephone,
            'adresse'             => $request->adresse,
            'password'            => Hash::make($request->email),
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

        if ($request->date_embauche) {
            $dateEmbauche  = $request->date_embauche;
            $date_embauche = Carbon::createFromFormat('d/m/Y', $dateEmbauche);
        } else {
            $date_embauche = null;
        }

        $employe = Employee::create([
            'users_id'      => $user?->id,
            'matricule'     => $request?->matricule,
            'date_embauche' => $date_embauche,
            'fonctions_id'  => $fonction?->id,
            'directions_id' => $direction?->id,
            'categories_id' => $categorie?->id,
        ]);

        $user->assignRole('Employe');
        /* $status = "Enregistrement effectué avec succès";
        return Redirect::route('employes.index')->with("status", $status); */
        Alert::success('Succès ! ', 'Employé enregistré avec succès');
        return redirect()->back();
    }

    public function edit($id)
    {
        $employe    = Employee::find($id);
        $directions = Direction::orderBy('created_at', 'desc')->get();
        $categories = Category::orderBy('created_at', 'desc')->get();
        $fonctions  = Fonction::orderBy('created_at', 'desc')->get();
        return view("employes.update", compact('employe', 'directions', 'categories', 'fonctions'));
    }

    public function update(Request $request, $id)
    {
        $employe = Employee::findOrFail($id);
        $user    = $employe->user;
        $this->validate($request, [
            'civilite'            => ['required', 'string', 'max:10'],
            'firstname'           => ['required', 'string', 'max:50'],
            'name'                => ['required', 'string', 'max:25'],
            'date_naissance'      => ['nullable', 'date_format:d/m/Y'],
            'lieu_naissance'      => ['nullable', 'string'],
            'image'               => ['image', 'max:255', 'nullable', 'mimes:jpeg,png,jpg,gif,svg', 'max:1024'],
            'telephone'           => ['nullable', 'string', 'max:25', 'min:9'],
            'adresse'             => ['nullable', 'string', 'max:255'],
            'password'            => ['string', 'max:255', 'nullable'],
            'situation_familiale' => ['string', 'max:15', 'nullable'],
            'roles.*'             => ['string', 'max:255', 'nullable', 'max:255'],
            "email"               => ["lowercase", 'email', "max:255", Rule::unique(User::class)->ignore($user->id)->whereNull('deleted_at')],
            "matricule"           => ['nullable', 'string', 'min:8', 'max:8', Rule::unique(table: Employee::class)->ignore($employe->id)->whereNull('deleted_at')],
            'cin'                 => ['nullable', 'string', 'min:16', 'max:17', Rule::unique(User::class)->ignore($user->id)->whereNull('deleted_at')],
            'date_embauche'       => ['nullable', 'date_format:d/m/Y'],
            'categorie'           => ['nullable', 'string'],
            'fonction'            => ['required', 'string'],
            'direction'           => ['required', 'string'],
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

        if ($request->input('categorie')) {
            $categorie   = Category::where('name', $request->input('categorie'))->first();
            $categorieid = $categorie->id;
        } else {
            $categorieid = null;
        }

        $fonction  = Fonction::where('name', $request->input('fonction'))->first();
        $direction = Direction::where('name', $request->input('direction'))->first();

        if ($request->date_naissance) {
            $dateNaissance  = $request->date_naissance;
            $date_naissance = Carbon::createFromFormat('d/m/Y', $dateNaissance);
        } else {
            $date_naissance = null;
        }

        if ($request->date_embauche) {
            $dateEmbauche  = $request->date_embauche;
            $date_embauche = Carbon::createFromFormat('d/m/Y', $dateEmbauche);
        } else {
            $date_embauche = null;
        }

        $user->update([
            'cin'                 => $request->cin,
            'civilite'            => $request->civilite,
            'firstname'           => $request->firstname,
            'name'                => $request->name,
            'date_naissance'      => $date_naissance,
            'lieu_naissance'      => $request->lieu_naissance,
            'email'               => $request->email,
            'telephone'           => $request->telephone,
            'adresse'             => $request->adresse,
            'situation_familiale' => $request->situation_familiale,
            'twitter'             => $request->twitter,
            'facebook'            => $request->facebook,
            'instagram'           => $request->instagram,
            'linkedin'            => $request->linkedin,
            'updated_by'          => Auth::user()->id,
        ]);

        $employe->update([
            'users_id'            => $user->id,
            'matricule'           => $request->matricule,
            'diplome'             => $request->diplome,
            'date_embauche'       => $date_embauche,
            'fonction_precedente' => $request->fonction_precedente,
            'fonctions_id'        => $fonction->id,
            'directions_id'       => $direction->id,
            'categories_id'       => $categorieid,
        ]);

        /* $status = 'Mise à jour effectuée avec succès';

        return Redirect::back()->with('status', $status); */
        Alert::success('Succès', 'Mise à jour effectuée avec succès');
        return redirect()->back();
    }

    public function show($id)
    {
        $employe    = Employee::findOrFail($id);
        $directions = Direction::orderBy('created_at', 'desc')->get();
        $categories = Category::orderBy('created_at', 'desc')->get();
        $fonctions  = Fonction::orderBy('created_at', 'desc')->get();
        $user       = $employe->user;

        if ($user->created_by == null || $user->updated_by == null) {
            $user_create_name = "moi même";
            $user_update_name = "moi même";
        } else {
            $user_created_id = $user->created_by;
            $user_updated_id = $user->updated_by;

            $user_create = User::findOrFail($user_created_id);
            $user_update = User::findOrFail($user_updated_id);

            $user_create_name = $user_create->firstname . " " . $user_create->firstname;
            $user_update_name = $user_update->firstname . " " . $user_update->firstname;
        }

        return view("employes.show", compact("user", "user_create_name", "user_update_name", "employe", "directions", "categories", "fonctions"));
    }

    public function destroy($id)
    {
        $employe = Employee::findOrFail($id);
        $employe->delete();
        Alert::success('L\'employé ' . $employe->user->firstname . ' ' . $employe->user->name, 'supprimé avec succès');
        /* $mesage = $employe->user->firstname . ' ' . $employe->user->name . ' a été supprimé(e)';
        return redirect()->back()->with("danger", $mesage); */
        return redirect()->back();
    }

    public function fileDecision($id)
    {
        $employe = Employee::find($id);
        $title   = "Décision de " . $employe->user->civilite . ' ' . $employe->user->firstname . ' ' . $employe->user->name;

        $dompdf  = new Dompdf();
        $options = $dompdf->getOptions();
        $options->setDefaultFont('Courier');
        $dompdf->setOptions($options);

        $dompdf->loadHtml(view('employes.file-decision', compact(
            'employe',
            'title'
        )));

        // (Optional) Setup the paper size and orientation
        $dompdf->setPaper('A4', 'portrait');

        // Render the HTML as PDF
        $dompdf->render();

        $anne = date('d');
        $anne = $anne . ' ' . date('m');
        $anne = $anne . ' ' . date('Y');
        $anne = $anne . ' à ' . date('H') . 'h';
        $anne = $anne . ' ' . date('i') . 'min';
        $anne = $anne . ' ' . date('s') . 's';

        $name = "Décision de " . $employe->user->civilite . ' ' . $employe->user->firstname . ' ' . $employe->user->name . ' ' . $anne . '.pdf';

        // Output the generated PDF to Browser
        $dompdf->stream($name, ['Attachment' => false]);
    }
    public function addLoisToEmploye($employeId)
    {
        $lois         = Loi::orderBy('created_at', 'desc')->get();
        $employe      = Employee::findOrFail($employeId);
        $employesLois = DB::table('employeslois')
            ->where('employeslois.employes_id', $employeId)
            ->pluck('employeslois.lois_id', 'employeslois.lois_id')
            ->all();
        return view("employes.add-lois", compact('employe', 'lois', 'employesLois'));
    }

    public function giveLoisToEmploye($employeId, Request $request)
    {
        $request->validate([
            'lois' => ['required'],
        ]);
        /* dd($request->lois); */
        $employe = Employee::findOrFail($employeId);
        /* dd($employe); */
        /* $employe->lois()->sync($request->lois); */
        $employe->lois()->sync($request->lois);

        $messages = "loi(s) ajoutée(s)";
        return redirect()->back()->with('status', $messages);
    }

    public function addDecretToEmploye($employeId)
    {
        $decrets         = Decret::orderBy('created_at', 'desc')->get();
        $employe         = Employee::findOrFail($employeId);
        $employesDecrets = DB::table('employesdecrets')
            ->where('employesdecrets.employes_id', $employeId)
            ->pluck('employesdecrets.decrets_id', 'employesdecrets.decrets_id')
            ->all();
        return view("employes.add-decrets", compact('employe', 'decrets', 'employesDecrets'));
    }

    public function giveDecretToEmploye($employeId, Request $request)
    {
        $request->validate([
            'decrets' => ['required'],
        ]);
        $employe = Employee::findOrFail($employeId);
        $employe->decrets()->sync($request->decrets);

        $messages = "decret(s) ajoutée(s)";
        return redirect()->back()->with('status', $messages);
    }

    public function addProcesverbalToEmploye($employeId)
    {
        $procesverbals         = Procesverbal::orderBy('created_at', 'desc')->get();
        $employe               = Employee::findOrFail($employeId);
        $employesProcesverbals = DB::table('employesprocesverbals')
            ->where('employesprocesverbals.employes_id', $employeId)
            ->pluck('employesprocesverbals.procesverbals_id', 'employesprocesverbals.procesverbals_id')
            ->all();
        return view("employes.add-procesverbals", compact('employe', 'procesverbals', 'employesProcesverbals'));
    }

    public function giveProcesverbalToEmploye($employeId, Request $request)
    {
        $request->validate([
            'procesverbals' => ['required'],
        ]);
        $employe = Employee::findOrFail($employeId);
        $employe->procesverbals()->sync($request->procesverbals);

        $messages = "procès verbal(s) ajouté(s)";
        return redirect()->back()->with('status', $messages);
    }

    public function addDecisionToEmploye($employeId)
    {
        $decisions         = Decision::orderBy('created_at', 'desc')->get();
        $employe           = Employee::findOrFail($employeId);
        $employesDecisions = DB::table('employesdecisions')
            ->where('employesdecisions.employes_id', $employeId)
            ->pluck('employesdecisions.decisions_id', 'employesdecisions.decisions_id')
            ->all();
        return view("employes.add-decisions", compact('employe', 'decisions', 'employesDecisions'));
    }

    public function giveDecisionToEmploye($employeId, Request $request)
    {
        $request->validate([
            'decisions' => ['required'],
        ]);
        $employe = Employee::findOrFail($employeId);
        $employe->decisions()->sync($request->decisions);

        $messages = "décision(s) ajouté(s)";
        return redirect()->back()->with('status', $messages);
    }

    public function addArticleToEmploye($employeId)
    {
        $articles         = Article::orderBy('created_at', 'desc')->get();
        $employe          = Employee::findOrFail($employeId);
        $employesArticles = DB::table('employesarticles')
            ->where('employesarticles.employes_id', $employeId)
            ->pluck('employesarticles.articles_id', 'employesarticles.articles_id')
            ->all();
        return view("employes.add-articles", compact('employe', 'articles', 'employesArticles'));
    }

    public function giveArticleToEmploye($employeId, Request $request)
    {
        $request->validate([
            'articles' => ['required'],
        ]);
        $employe = Employee::findOrFail($employeId);
        $employe->articles()->sync($request->articles);

        $messages = "article(s) ajouté(s)";
        return redirect()->back()->with('status', $messages);
    }

    public function addNomminationToEmploye($employeId)
    {
        $nomminations         = Nommination::orderBy('created_at', 'desc')->get();
        $employe              = Employee::findOrFail($employeId);
        $employesNomminations = DB::table('employesnomminations')
            ->where('employesnomminations.employes_id', $employeId)
            ->pluck('employesnomminations.nomminations_id', 'employesnomminations.nomminations_id')
            ->all();
        return view("employes.add-nomminations", compact('employe', 'nomminations', 'employesNomminations'));
    }

    public function giveNomminationToEmploye($employeId, Request $request)
    {
        $request->validate([
            'nomminations' => ['required'],
        ]);
        $employe = Employee::findOrFail($employeId);
        $employe->nomminations()->sync($request->nomminations);

        $messages = "nommination(s) ajouté(s)";
        return redirect()->back()->with('status', $messages);
    }

    public function addIndemniteToEmploye($employeId)
    {
        $indemnites         = Indemnite::orderBy('created_at', 'desc')->get();
        $employe            = Employee::findOrFail($employeId);
        $employesIndemnites = DB::table('employesindemnites')
            ->where('employesindemnites.employes_id', $employeId)
            ->pluck('employesindemnites.indemnites_id', 'employesindemnites.indemnites_id')
            ->all();
        return view("employes.add-indemnites", compact('employe', 'indemnites', 'employesIndemnites'));
    }

    public function giveIndemniteToEmploye($employeId, Request $request)
    {
        $request->validate([
            'indemnites' => ['required'],
        ]);
        $employe = Employee::findOrFail($employeId);
        $employe->indemnites()->sync($request->indemnites);

        $messages = "indemnite(s) ajouté(s)";
        return redirect()->back()->with('status', $messages);
    }
}
