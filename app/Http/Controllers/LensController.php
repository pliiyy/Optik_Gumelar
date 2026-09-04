<?php

namespace App\Http\Controllers;

use App\Models\Lens;
use Illuminate\Http\Request;

class LensController extends Controller
{
    public function index()
    {
        $lenses = Lens::latest()->get();

        return view('lenses', compact('lenses'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'category' => 'required|string|max:100',
            'description' => 'nullable|string',
            'price' => 'required|numeric|min:0',
            'stock' => 'required|integer|min:0',
        ]);

        Lens::create($request->all());

        return redirect()->route('lenses.index')->with('success', 'Data lensa berhasil ditambahkan!');
    }

    public function update(Request $request, Lens $lens)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'category' => 'required|string|max:100',
            'description' => 'nullable|string',
            'price' => 'required|numeric|min:0',
            'stock' => 'required|integer|min:0',
        ]);

        $lens->update($request->all());

        return redirect()->route('lenses.index')->with('success', 'Data lensa berhasil diperbarui!');
    }

    public function destroy(Lens $lens)
    {
        $lens->delete();

        return redirect()->route('lenses.index')->with('success', 'Data lensa berhasil dihapus!');
    }
}
