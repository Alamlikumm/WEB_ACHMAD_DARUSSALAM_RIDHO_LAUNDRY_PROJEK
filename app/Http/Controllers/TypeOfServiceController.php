<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\TypeOfService;

class TypeOfServiceController extends Controller
{
    public function index(Request $request)
    {
        $query = TypeOfService::query();
        if ($request->filled('search')) {
            $query->where('service_name', 'like', '%' . $request->search . '%')
                  ->orWhere('description', 'like', '%' . $request->search . '%');
        }
        $services = $query->paginate(10);
        return view('type-of-services.index', compact('services'));
    }

    public function create()
    {
        return view('type-of-services.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'service_name' => 'required|string|max:255|unique:type_of_services,service_name',
            'price' => 'required|numeric|min:0',
            'description' => 'nullable|string',
            'unit' => 'required|in:Kg,Pcs',
        ]);

        TypeOfService::create($request->only('service_name', 'price', 'description', 'unit'));

        return redirect()->route
        ('type-of-services.index')
        ->with('success', 'Layanan Berhasil Ditambahkan');
    }

    public function edit(TypeOfService $type_of_service)
    {
        return view('type-of-services.edit', compact('type_of_service'));
    }

    public function update(Request $request, TypeOfService $type_of_service)
    {
        $request->validate([
            'service_name' => 'required|string|max:255',
            'price' => 'required|numeric|min:0',
            'description' => 'nullable|string',
            'unit' => 'required|in:Kg,Pcs',
        ]);

        $type_of_service->update($request->only('service_name', 'price', 'description', 'unit'));

        return redirect()->route
        ('type-of-services.index')
        ->with('success', 'Layanan Berhasil Diubah');
    }

    public function destroy(TypeOfService $type_of_service)
    {
        $type_of_service->delete();
        return redirect()->route
        ('type-of-services.index')
        ->with('success', 'Layanan Berhasil Dihapus');
    }
}
