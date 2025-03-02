<?php
namespace App\Http\Controllers;

use App\Models\Antenne;
use App\Models\Contact;
use App\Models\Module;
use Dompdf\Dompdf;
use Dompdf\Options;
use Illuminate\Http\Request;
use RealRashid\SweetAlert\Facades\Alert;

class ContactController extends Controller
{
    public function __construct()
    {
        /* $this->middleware('auth');
        $this->middleware(['role:super-admin|admin|DIOF|DEC|DPP']);
        $this->middleware("permission:contact-view", ["only" => ["index"]]);
        $this->middleware("permission:contact-create", ["only" => ["create", "store"]]);
        $this->middleware("permission:contact-update", ["only" => ["update", "edit"]]);
        $this->middleware("permission:contact-show", ["only" => ["show"]]);
        $this->middleware("permission:contact-delete", ["only" => ["destroy"]]);
        $this->middleware("permission:give-role-permissions", ["only" => ["givePermissionsToRole"]]); */
    }
    public function index()
    {
        $contacts = Contact::orderBy("created_at", "desc")->get();
        return view('contacts.index', compact('contacts'));
    }

    public function store(Request $request)
    {
        $data = request()->validate([
            'emailadresse' => ['required', 'email'],
            'telephone'    => ['required', 'string', 'max:9', 'min:9'],
            'objet'        => ['required', 'string'],
            'message'      => ['required', 'string'],

        ]);

        $contact = new Contact([
            'email'     => $data['emailadresse'],
            'telephone' => $data['telephone'],
            'objet'     => $data['objet'],
            'message'   => $data['message'],
        ]);

        $contact->save();

        Alert::success("Félicitations !!!", "Votre message a été envoyé. Merci! !");

        /* $status = "Félicitation, Votre message a été envoyé. Merci !"; */

        /* return redirect()->back()->with('status', $status); */
        return redirect()->back();
    }

    public function update(Request $request, $id)
    {
        $data = request()->validate([
            'telephone' => ['required', 'string', 'max:9', 'min:9'],
            'objet'     => ['required', 'string'],
            'message'   => ['required', 'string'],
            'reponse'   => ['nullable', 'string'],
            'statut'    => ['nullable', 'string'],

        ]);

        $contact = Contact::findOrFail($id);

        $contact->update([
            'telephone' => $data['telephone'],
            'objet'     => $data['objet'],
            'message'   => $data['message'],
            'reponse'   => $data['reponse'],
            'statut'    => $data['statut'],
        ]);

        $contact->save();

        Alert::success("Modification effectuée !!!");

        return redirect()->back();
    }

    public function destroy($id)
    {

        $Contact = Contact::find($id);

        $Contact->delete();

        Alert::success('Suppression effectuée !');

        return redirect()->back();
    }

    public function uneContacts(Request $request)
    {

        $une = Contact::findOrFail(request('alaune'));

        $une->update([
            'statut' => 'Evidence',
        ]);

        $une->save();

        Alert::success('Mis en évidence !');

        return redirect()->back();
    }

    public function servicesDetails()
    {

        $antennes = Antenne::get();

        return view('service-details', compact('antennes'));
    }

    public function nosModules(Request $request)
    {
        $modules = Module::join('domaines', 'domaines.id', '=', 'modules.domaines_id')
            ->join('secteurs', 'secteurs.id', '=', 'domaines.secteurs_id')                          // Ajout de la jointure entre domaines et secteurs
            ->select('modules.*', 'domaines.name as domaine_name', 'secteurs.name as secteur_name') // Sélectionner les champs nécessaires
            ->whereNotNull('modules.domaines_id')                                                   // Vérifie que l'ID du domaine n'est pas nul
            ->whereNotNull('domaines.secteurs_id')                                                  // Vérifie que l'ID du secteur n'est pas nul
            ->get();

        $modules = $modules->sortBy(function ($module) {
            return $module->domaine->name; // Trie par le nom du domaine
        });

        $title = 'Nos modules de formation';

        $options = new Options();
        $options->set('isHtml5ParserEnabled', true);
        $options->set('isPhpEnabled', true);

        $dompdf = new Dompdf($options);
        $dompdf->loadHtml(view('nos-modules', compact('modules', 'title'))->render());
        $dompdf->setPaper('A4', 'landscape');

        $dompdf->render();

        $canvas = $dompdf->getCanvas();
        $canvas->page_script(function ($pageNumber, $pageCount, $canvas, $fontMetrics) {
            $text = "Page $pageNumber sur $pageCount";

            // Obtenir les dimensions de la page (en pixels)
            $canvasWidth  = $canvas->get_width();
            $canvasHeight = $canvas->get_height();

            /*  // Positionnement horizontal : centré
            $textWidth = $fontMetrics->getTextWidth($text, "Arial", 10);  // Calculer la largeur du texte
            $x = ($canvasWidth - $textWidth) / 2;  // Centrer le texte horizontalement */

                                                                         // Positionnement horizontal : complètement à droite
            $textWidth = $fontMetrics->getTextWidth($text, "Arial", 10); // Calculer la largeur du texte
            $x         = $canvasWidth - $textWidth - 10;                 // Positionner à 10 pixels du bord droit

                                                                // Positionnement vertical : juste en dessous du footer
            $footerHeight = 30;                                 // Hauteur estimée du footer (ajuster si nécessaire)
            $y            = $canvasHeight - $footerHeight + 10; // 10 pixels en dessous du footer

            // Choisir la police et la taille de texte
            $font = $fontMetrics->get_font("Arial", "normal");

            // Ajouter le texte de la pagination
            $canvas->text($x, $y, $text, $font, 10);
        });

        $anne = date('d');
        $anne = $anne . ' ' . date('m');
        $anne = $anne . ' ' . date('Y');
        $anne = $anne . ' à ' . date('H') . 'h';
        $anne = $anne . ' ' . date('i') . 'min';
        $anne = $anne . ' ' . date('s') . 's';

        $name = ' Nos modules de formation - ' . $anne . '.pdf';

        $dompdf->stream($name, ['Attachment' => false]);
    }
}
