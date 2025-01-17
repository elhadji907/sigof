<?php
namespace App\Http\Controllers;

use App\Http\Requests\StorePostRequest;
use App\Models\Poste;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Intervention\Image\Facades\Image;
use RealRashid\SweetAlert\Facades\Alert;

class PosteController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
        $this->middleware(['role:super-admin|admin|DIOF|DEC|DPP']);
        $this->middleware("permission:post-view", ["only" => ["index"]]);
        $this->middleware("permission:post-create", ["only" => ["create", "store"]]);
        $this->middleware("permission:post-update", ["only" => ["update", "edit"]]);
        $this->middleware("permission:post-show", ["only" => ["show"]]);
        $this->middleware("permission:post-delete", ["only" => ["destroy"]]);
        $this->middleware("permission:give-role-permissions", ["only" => ["givePermissionsToRole"]]);
    }
    public function index()
    {
        $postes = Poste::orderBy("created_at", "desc")->get();
        return view('postes.index', compact('postes'));
    }
    public function store(StorePostRequest $request): RedirectResponse
    {
        $data = $request->validated();

        $image = $request->validated('image');

        $imagePath = request('image')->store('posts', 'public');

        $image = Image::make(public_path("/storage/{$imagePath}"))->fit(1200, 1200);

        $image->save();

        $poste = Poste::create([
            'name'     => $data['name'],
            'legende'  => $data['legende'],
            'users_id' => auth()->user()->id,
            'image'    => $imagePath,
        ]);

        Alert::success("Poster !!!", "Félicitations");

        return redirect()->back();
    }
    public function update(Request $request, $id)
    {
        $data = request()->validate([
            'name'    => ['required', 'string'],
            'legende' => ['required', 'string'],
            'image'   => ['image', 'nullable', 'mimes:jpeg,png,jpg,gif,svg', 'max:2048'],

        ]);

        $poste = Poste::findOrFail($id);

        if (request('image')) {
            Storage::disk('public')->delete($poste->image);
            $imagePath = request('image')->store('posts', 'public');

            $image = Image::make(public_path("/storage/{$imagePath}"))->fit(1200, 1200);

            $image->save();
        } else {
            $imagePath = $poste->image;
        }

        $poste->update([
            'name'     => $data['name'],
            'legende'  => $data['legende'],
            'users_id' => auth()->user()->id,
            'image'    => $imagePath,
        ]);

        $poste->save();

        Alert::success("Modifier !!!", "Félicitations");

        return redirect()->back();
    }

    public function destroy($id)
    {

        $poste = Poste::find($id);

        Storage::disk('public')->delete($poste->image);

        $poste->delete();

        Alert::success('Effectué !', 'post supprimé');

        return redirect()->back();
    }
}
