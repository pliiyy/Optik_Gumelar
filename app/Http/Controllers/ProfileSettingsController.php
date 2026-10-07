<?php

namespace App\Http\Controllers;

use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class ProfileSettingsController extends Controller
{
    public function edit(Request $request): View
    {
        return view('settings.profile', ['user' => $request->user()]);
    }

    public function update(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'address' => ['nullable', 'string', 'max:500'],
            'phone' => ['nullable', 'string', 'max:30', 'regex:/^[0-9+\s().-]*$/'],
        ], [
            'phone.regex' => 'Nomor HP hanya boleh berisi angka, spasi, dan tanda + ( ) . -.',
        ]);

        $request->user()->fill($validated)->save();

        return redirect()->route('settings.profile.edit')->with('success', 'Alamat dan nomor HP berhasil diperbarui.');
    }
}
