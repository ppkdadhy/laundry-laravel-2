<?php

namespace App\Http\Controllers;

use App\Models\Service;
use Illuminate\Http\Request;

class ServiceController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'service_name' => 'required',
            'price' => 'required|numeric',
            'description' => 'required'
        ]);

        Service::create([
            'service_name' => $request->service_name,
            'price' => $request->price,
            'description' => $request->description
        ]);

        return redirect()->route('service.index')->with('status', 'Berhasil ditambah!');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
       $service = Service::findOrFail($id);

       return view('service.edit', compact('service'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $request->validate([
            'service_name' => 'sometimes',
            'price' => 'sometimes|numeric',
            'description' => 'sometimes'
        ]);

        $service = Service::findOrFail($id);
        $service->service_name = $request->service_name;
        $service->price = $request->price;
        $service->description = $request->description;
        $service->save();

        return redirect()->route('service.index')->with('status', 'Berhasil Ubah data');
    }

    public function softDelete(string $id)
    {
        $service = Service::findOrFail($id);
        $service->delete();

        return redirect()->route('service.index')->with('status', 'Berhasil di Hapus Sementara!');
    }

    public function recycle()
    {

        $services = Service::onlyTrashed()->paginate(50);
        return view('service.recycle', compact('services'));
    }

    public function restore(string $id)
    {
        $service = Service::withTrashed($id);
        $service->restore();

        return redirect()->route('service.index')->with('status', 'Berhasil di Restore!');
    }
    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $service = Service::withTrashed()->findOrFail($id);
        $service->forceDelete();

        return redirect()->route('service.index')->with('status', 'Berhasil di Restore!');
    }
}
