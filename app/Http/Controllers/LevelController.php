<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Level;

class LevelController extends Controller
{
    public function index(Request $request)
    {
        $query = Level::query();
        if ($request->filled('search')) {
            $query->where('level_name', 'like', '%' . $request->search . '%');
        }
        $levels = $query->paginate(10);
        return view('levels.index', compact('levels'));
    }

    public function create()
    {
        return view('levels.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'level_name' => 'required|string|max:255',
        ]);

        Level::create($request->only('level_name'));

        return redirect()->route('levels.index')
        ->with('success', 'Level Berhasil
         Ditambahkan');
    }

    public function edit(Level $level)
    {
        return view('levels.edit', compact
        ('level'));
    }

    public function update(Request $request, 
    Level $level)
    {
        $request->validate([
            'level_name' => 'required|string|max:255',
        ]);

        $level->update($request->only('level_name'));

        return redirect()->route('levels.index')
        ->with('success', 'Level Berhasil Diubah');
    }

    public function destroy(Level $level)
    {
        if (strtolower($level->level_name) === 'super admin') {
            return redirect()->route('levels.index')
                ->with('error', 'Role Super Admin tidak boleh dihapus!');
        }

        $level->delete();
        return redirect()->route('levels.index')
        ->with('success', 'Level Berhasil
         Dihapus');
    }
}