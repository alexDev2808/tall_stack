<?php

namespace App\Http\Controllers\Admin;

use App\Models\Subarea;
use App\Models\Area;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use App\Http\Controllers\Controller;

class SubareaController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public $nameController = 'Subarea';
    public $pluralNameController = 'Subareas';
    public $routeController = 'subareas';

    public function index()
    {
        $data = Subarea::paginate(10); // Cambiar Modelo
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
        $related_items = Area::all();
        return view('admin.' . $this->routeController . '.create', [
            'nameController' => $this->nameController,
            'pluralNameController' => $this->pluralNameController,
            'routeController' => $this->routeController,
            'related_items' => $related_items,
        ]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:80|unique:subareas,name',
            'area_id' => 'required|exists:areas,id', // Validar que la filial exista
        ], [
            'area_id.required' => 'El área es requerida.',
            'area_id.exists' => 'El área seleccionada no existe.',
        ]);

        // Generar el slug a partir del nombre
        $slug = Str::slug($request->name, '-');

        // Validar que el slug sea único
        $exists = Subarea::where('slug', $slug)->exists(); // Cambiar modelo

        if ($exists) {
            return redirect()->back()
                ->withErrors(['name' => 'El nombre genera un slug que ya está registrado, por favor elige otro.'])
                ->withInput();
        }

        $data = $request->all();
        $data['slug'] = $slug;

        Subarea::create($data); // Cambiar modelo

        return redirect()->route('admin.' . $this->routeController . '.index')
            ->with([
                'flash.banner' => $this->nameController . ' creada con exito!', 
                'flash.bannerStyle' => 'success'
            ]);
    }

    /**
     * Display the specified resource.
     */
    public function show(Subarea $subarea)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Subarea $subarea)
    {
        return view('admin.' . $this->routeController . '.edit', [
            'item' => $subarea,
            'nameController' => $this->nameController,
            'pluralNameController' => $this->pluralNameController,
            'routeController' => $this->routeController,
            'related_items' => Area::all(), // Obtener todas las filiales
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Subarea $subarea)
    {
        $item = $subarea;
        $request->validate([
            'name' => 'required|string|max:80|unique:subareas,name,' . $item->id, // Validar nombre único en areas
            'area_id' => 'required|exists:areas,id', // Validar que la filial exista
        ], [
            'area_id.required' => 'El área es requerida.',
            'area_id.exists' => 'El área seleccionada no existe.',
        ]);

        // Generar el slug a partir del nombre
        $slug = Str::slug($request->name, '-');

        // Validar que el slug sea único, excepto para el registro actual
        $exists = Subarea::where('slug', $slug)
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
                'flash.banner' => $this->nameController . ' actualizada con exito!',
                'flash.bannerStyle' => 'warning'
            ]);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Request $request, Subarea $subarea)
    {
        $item = $subarea;
        if($item->departaments()->count() > 0){ // Verificar si el elemento tiene elementos asociados
            session()->flash('swal', [
                'icon' => 'error',
                'title' => 'Ups...',
                'text' => 'No se puede eliminar la ' . $this->nameController . ' porque tiene departamentos asociados.' // mensaje de error
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
