<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Subsidiary;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;
class SubsidiaryController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public $nameController = 'Filial';
    public $pluralNameController = 'Filiales';
    public $routeController = 'subsidiaries';

    public function index()
    {
        $data = Subsidiary::paginate(10); // Cambiar Modelo
        return view('admin.' . $this->routeController . '.index', [
            'data' => $data,
            'nameController' => $this->nameController,
            'pluralNameController' => $this->pluralNameController,
            'routeController' => $this->routeController,
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('admin.' . $this->routeController . '.create', [
            'nameController' => $this->nameController,
            'pluralNameController' => $this->pluralNameController,
            'routeController' => $this->routeController,
        ]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:80|unique:subsidiaries,name',
        ]);

        // Generar el slug a partir del nombre
        $slug = Str::slug($request->name, '-');

        // Validar que el slug sea único
        $exists = Subsidiary::where('slug', $slug)->exists(); // Cambiar modelo

        if ($exists) {
            return redirect()->back()
                ->withErrors(['name' => 'El nombre genera un slug que ya está registrado, por favor elige otro.'])
                ->withInput();
        }

        $data = $request->all();
        $data['slug'] = $slug;

        Subsidiary::create($data); // Cambiar modelo

        return redirect()->route('admin.' . $this->routeController . '.index')
            ->with([
                'flash.banner' => $this->nameController . ' creada con exito!', 
                'flash.bannerStyle' => 'success'
            ]);
    }

    /**
     * Display the specified resource.
     */
    public function show(Subsidiary $subsidiary)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Subsidiary $subsidiary)
    {
        return view('admin.' . $this->routeController . '.edit', [
            'item' => $subsidiary,
            'nameController' => $this->nameController,
            'pluralNameController' => $this->pluralNameController,
            'routeController' => $this->routeController,
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Subsidiary $subsidiary)
    {
        $item = $subsidiary;
        $request->validate([
            'name' => 'required|string|max:80|unique:subsidiaries,name,' . $item->id,
        ]);

        // Generar el slug a partir del nombre
        $slug = Str::slug($request->name, '-');

        // Validar que el slug sea único, excepto para el registro actual
        $exists = Subsidiary::where('slug', $slug) // Cambiar modelo
            ->where('id', '!=', $item->id)
            ->exists();

        if ($exists) {
            return redirect()->back()
                ->withErrors(['name' => 'El nombre genera un slug que ya está registrado, por favor elige otro.'])
                ->withInput();
        }

        $data = $request->all();
        $data['slug'] = $slug;

        $item->update($data);

        return redirect()->route('admin.' . $this->routeController . '.edit', $item)
            ->with([
                'flash.banner' => $this->nameController . ' actualizada con exito!', // mensaje de éxito
                'flash.bannerStyle' => 'warning'
            ]);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Request $request, Subsidiary $subsidiary)
    {
        $item = $subsidiary;
        if($item->areas()->count() > 0){ // Verificar si el elemento tiene elementos asociados
            session()->flash('swal', [
                'icon' => 'error',
                'title' => 'Ups...',
                'text' => 'No se puede eliminar la ' . $this->nameController . ' porque tiene areas asociadas.' // mensaje de error
            ]);

            if($request['current_page'] === 'index'){
                return redirect()->route('admin.' . $this->routeController . '.index');
            }

            return redirect()->route('admin.' . $this->routeController . '.edit', $item);
        }

        $item->delete();

        return redirect()->route('admin.' . $this->routeController . '.index')
            ->with([
                'flash.banner' => $this->nameController . ' eliminada con exito!', // mensaje de éxito
                'flash.bannerStyle' => 'warning'
            ]);
            
    }
}
