<?php

namespace App\Http\Controllers;

use App\Models\Frame;
use Illuminate\Http\Request;

class FrameController extends Controller
{
    public function index()
    {
        $frames = Frame::latest()->get();

        return view('frames', compact('frames'));
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

        Frame::create($request->all());

        return redirect()->route('frames.index')->with('success', 'Data frame berhasil ditambahkan!');
    }

    public function update(Request $request, Frame $frame)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'category' => 'required|string|max:100',
            'description' => 'nullable|string',
            'price' => 'required|numeric|min:0',
            'stock' => 'required|integer|min:0',
        ]);

        $frame->update($request->all());

        return redirect()->route('frames.index')->with('success', 'Data frame berhasil diperbarui!');
    }

    public function destroy(Frame $frame)
    {
        $frame->delete();

        return redirect()->route('frames.index')->with('success', 'Data frame berhasil dihapus!');
    }
}
