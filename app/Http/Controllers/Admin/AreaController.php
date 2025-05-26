<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Area;
use App\Models\Subsidiary;
use Illuminate\Support\Str;
use Illuminate\Http\Request;

class AreaController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public $nameController = 'Área';
    public $pluralNameController = 'Áreas';
    public $routeController = 'areas';

    public function index()
    {
        $data = Area::paginate(10); // Cambiar Modelo
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
        $related_items = Subsidiary::all();
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
            'name' => 'required|string|max:80|unique:subsidiaries,name',
            'subsidiary_id' => 'required|exists:subsidiaries,id', // Validar que la filial exista
        ], [
            'subsidiary_id.required' => 'La filial es requerida.',
            'subsidiary_id.exists' => 'La filial seleccionada no existe.',
        ]);

        // Generar el slug a partir del nombre
        $slug = Str::slug($request->name, '-');

        // Validar que el slug sea único
        $exists = Area::where('slug', $slug)->exists(); // Cambiar modelo

        if ($exists) {
            return redirect()->back()
                ->withErrors(['name' => 'El nombre genera un slug que ya está registrado, por favor elige otro.'])
                ->withInput();
        }

        $data = $request->all();
        $data['slug'] = $slug;

        Area::create($data); // Cambiar modelo

        return redirect()->route('admin.' . $this->routeController . '.index')
            ->with([
                'flash.banner' => $this->nameController . ' creada con exito!', 
                'flash.bannerStyle' => 'success'
            ]);
    }

    /**
     * Display the specified resource.
     */
    public function show(Area $area)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Area $area)
    {
        return view('admin.' . $this->routeController . '.edit', [
            'item' => $area,
            'nameController' => $this->nameController,
            'pluralNameController' => $this->pluralNameController,
            'routeController' => $this->routeController,
            'related_items' => Subsidiary::all(), // Obtener todas las filiales
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Area $area)
    {
        $item = $area;
        $request->validate([
            'name' => 'required|string|max:80|unique:areas,name,' . $item->id, // Validar nombre único en areas
            'subsidiary_id' => 'required|exists:subsidiaries,id', // Validar que la filial exista
        ], [
            'subsidiary_id.required' => 'La filial es requerida.',
            'subsidiary_id.exists' => 'La filial seleccionada no existe.',
        ]);

        // Generar el slug a partir del nombre
        $slug = Str::slug($request->name, '-');

        // Validar que el slug sea único, excepto para el registro actual
        $exists = Area::where('slug', $slug)
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
    public function destroy(Request $request, Area $area)
    {
        $item = $area;
        if($item->subareas()->count() > 0){ // Verificar si el elemento tiene elementos asociados
            session()->flash('swal', [
                'icon' => 'error',
                'title' => 'Ups...',
                'text' => 'No se puede eliminar la ' . $this->nameController . ' porque tiene subareas asociadas.' // mensaje de error
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
