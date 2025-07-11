<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Family;
use Illuminate\Http\Request;

class FamilyController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $families = Family::orderBy('id', 'desc')->paginate(10);
        return view('admin.families.index', compact('families'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('admin.families.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:100'
        ]);

        Family::create($request->all());

        // session(['flash.banner' => 'Familia creada exitosamente.']);
        // session(['flash.bannerStyle' => 'success']);

        return redirect()->route('admin.families.index')
            ->with([
                'flash.banner' => 'Familia creada con exito!', 
                'flash.bannerStyle' => 'success'
            ]);
    }

    /**
     * Display the specified resource.
     */
    public function show(Family $family)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Family $family)
    {
        return view('admin.families.edit', compact('family'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Family $family)
    {
        $request->validate([
            'name' => 'required|string|max:100'
        ]);

        $family->update($request->all());

        return redirect()->route('admin.families.edit', $family)
            ->with([
                'flash.banner' => 'Familia actualizada con exito!',
                'flash.bannerStyle' => 'warning'
            ]);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Family $family, Request $request)
    {

        if($family->categories()->count() > 0){
            session()->flash('swal', [
                'icon' => 'error',
                'title' => 'Ups...',
                'text' => 'No se puede eliminar la familia porque tiene categorias asociadas.'
            ]);

            if($request['current_page'] === 'index'){
                return redirect()->route('admin.families.index');
            }

            return redirect()->route('admin.families.edit', $family);
        }

        $family->delete();

        return redirect()->route('admin.families.index')
            ->with([
                'flash.banner' => 'Familia eliminada con exito!',
                'flash.bannerStyle' => 'warning'
            ]);
            
    }
}
