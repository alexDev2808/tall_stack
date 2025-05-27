<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Departament;
use App\Models\Subarea;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class DepartamentController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public $nameController = 'Departamento';
    public $pluralNameController = 'Departamentos';
    public $routeController = 'departaments';

    public function index()
    {
        $data = Departament::paginate(10); // Cambiar Modelo
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
        $related_items = Subarea::all();
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
            'name' => 'required|string|max:80|unique:departaments,name',
            'subarea_id' => 'required|exists:subareas,id', // Validar que la filial exista
        ], [
            'subarea_id.required' => 'La subarea es requerida.',
            'subarea_id.exists' => 'La subarea seleccionada no existe.',
        ]);

        // Generar el slug a partir del nombre
        $slug = Str::slug($request->name, '-');

        // Validar que el slug sea único
        $exists = Departament::where('slug', $slug)->exists(); // Cambiar modelo

        if ($exists) {
            return redirect()->back()
                ->withErrors(['name' => 'El nombre genera un slug que ya está registrado, por favor elige otro.'])
                ->withInput();
        }

        $data = $request->all();
        $data['slug'] = $slug;

        Departament::create($data); // Cambiar modelo

        return redirect()->route('admin.' . $this->routeController . '.index')
            ->with([
                'flash.banner' => $this->nameController . ' creada con exito!', 
                'flash.bannerStyle' => 'success'
            ]);
    }

    /**
     * Display the specified resource.
     */
    public function show(Departament $departament)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Departament $departament)
    {
        return view('admin.' . $this->routeController . '.edit', [
            'item' => $departament,
            'nameController' => $this->nameController,
            'pluralNameController' => $this->pluralNameController,
            'routeController' => $this->routeController,
            'related_items' => Subarea::all(), // Obtener todas las subareas
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Departament $departament)
    {
        $item = $departament;
        $request->validate([
            'name' => 'required|string|max:80|unique:departaments,name,' . $item->id, // Validar nombre único en areas
            'subarea_id' => 'required|exists:subareas,id', // Validar que la filial exista
        ], [
            'subarea_id.required' => 'La subarea es requerida.',
            'subarea_id.exists' => 'La subarea seleccionada no existe.',
        ]);

        // Generar el slug a partir del nombre
        $slug = Str::slug($request->name, '-');

        // Validar que el slug sea único, excepto para el registro actual
        $exists = Departament::where('slug', $slug)
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
                'flash.banner' => $this->nameController . ' actualizado con exito!',
                'flash.bannerStyle' => 'warning'
            ]);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Request $request, Departament $departament)
    {
        $item = $departament;
        if($item->users()->count() > 0){ // Verificar si el elemento tiene elementos asociados
            session()->flash('swal', [
                'icon' => 'error',
                'title' => 'Ups...',
                'text' => 'No se puede eliminar el ' . $this->nameController . ' porque tiene usuarios asociados.' // mensaje de error
            ]);

            if($request['current_page'] === 'index'){
                return redirect()->route('admin.' . $this->routeController . '.index');
            }

            return redirect()->route('admin.' . $this->routeController . '.edit', $item);
        }

        $item->delete();

        return redirect()->route('admin.' . $this->routeController . '.index')
            ->with([
                'flash.banner' => $this->nameController . ' eliminado con exito!', // mensaje de éxito
                'flash.bannerStyle' => 'warning'
            ]);
            
    }
}
