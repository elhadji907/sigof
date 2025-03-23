<?php
namespace App\Http\Controllers;

use App\Imports\ArrivesImport;
use Illuminate\Http\Request;
use Maatwebsite\Excel\Facades\Excel;
use RealRashid\SweetAlert\Facades\Alert;

class ImportController extends Controller
{
    public function importArrives(Request $request)
    {
        $request->validate([
            'file' => 'required|mimes:xlsx,csv,xls',
        ]);

        try {
            Excel::import(new ArrivesImport, $request->file('file'));
            Alert::success("Succès !", "Importation des courriers arrivés réussie !");
        } catch (\Exception $e) {
            Alert::warning("Erreur !", 'Erreur lors de l\'importation: ' . $e->getMessage());
        }
        Alert::success("Succès !", "Importation des courriers arrivés réussie !");

        return redirect()->back();
    }

    public function importA()
    {
        return view('courriers.arrives.import'); // Assure-toi que le fichier import.blade.php existe
    }
}