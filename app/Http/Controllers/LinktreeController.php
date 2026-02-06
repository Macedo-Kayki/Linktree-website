<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Linktree;
use App\Models\Linktreedado;
use Illuminate\Support\Facades\Auth;

class LinktreeController extends Controller
{
    public function index()
    {
        $linktree = Linktree::with('dados')->where('user_id', Auth::id())->first();

        return view('editor.editor', compact('linktree'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'input_name' => 'required|string|max:255',
            'bg_color' => 'nullable|regex:/^#[0-9A-Fa-f]{6}$/',
            'text_color' => 'nullable|regex:/^#[0-9A-Fa-f]{6}$/',
            'bg_image' => 'nullable|image|max:5120',
            'links.*.name_link' => 'required|string',
            'links.*.url_link' => 'required|url',
            'links.*.icon' => 'nullable|image|max:2048',
            'links.*.button_color' => 'nullable|regex:/^#[0-9A-Fa-f]{6}$/',
        ]);

        $user = Auth::user();

        $bgImage = null;
        $existingBgImage = null;

        // Get existing background image
        $existing = Linktree::where('user_id', $user->id)->first();
        if ($existing && $existing->bg_image) {
            $existingBgImage = $existing->bg_image;
        }

        // Handle new background image upload
        if ($request->hasFile('bg_image')) {
            $bgImage = $request->file('bg_image')->store('backgrounds', 'public');
        } else {
            $bgImage = $existingBgImage;
        }

        $linktree = Linktree::updateOrCreate(
            ['user_id' => $user->id],
            [
                'title' => $request->input_name,
                'bg_color' => $request->bg_color ?? '#1f2937',
                'text_color' => $request->text_color ?? '#ffffff',
                'bg_image' => $bgImage
            ]
        );

        $existingLinks = $linktree->dados()->pluck('icon', 'id')->toArray();
        $existingIcons = array_values($existingLinks);

        $linktree->dados()->delete();

        if ($request->has('links') && is_array($request->links)) {
            foreach ($request->links as $index => $linkData) {
                
                if (empty($linkData['name_link']) || empty($linkData['url_link'])) {
                    continue;
                }

                $caminhoImagem = null;

                if (isset($linkData['icon']) && $linkData['icon'] instanceof \Illuminate\Http\UploadedFile) {
                    $caminhoImagem = $linkData['icon']->store('assets', 'public');
                } elseif (isset($existingIcons[$index])) {
                    $caminhoImagem = $existingIcons[$index];
                }

                Linktreedado::create([
                    'linktree_id' => $linktree->id,
                    'name_link'   => $linkData['name_link'],
                    'url_link'    => $linkData['url_link'],
                    'icon'        => $caminhoImagem,
                    'button_color' => $linkData['button_color'] ?? '#ffffff'
                ]);
            }
        }

        return redirect()->back()->with('success', 'Linktree salvo com sucesso!');
    }

    public function show($id){
        $linktree = Linktree::with('dados')->findOrFail($id);

        return view('linktree.show', compact('linktree'));
    }
}