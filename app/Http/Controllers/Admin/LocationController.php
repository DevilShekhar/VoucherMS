<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Http\Location;
use Illuminate\Support\Facades\Auth;


class LocationController extends Controller
{
    //
    public function index()
    {  $location=\App\Models\Location::get();
       return view ('admin.location.index',compact('location'));
    }

    public function create()
    {
       return view( 'admin.location.create');
    }

     public function edit($id)

    {
        $location=\App\Models\Location::findOrFail($id);
       return view( 'admin.location.edit',compact('location'));
    }

   public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',

        ]);

        \App\Models\Location::create($validated);

        return redirect()
            ->route('locations.index')
            ->with('success', 'Location added successfully.');
    }

    public function update(Request $request, \App\Models\Location $location)
    {
        $request->validate([
            'name' => 'required',

        ]);

        $location->update($request->all());

        return redirect()
            ->route('locations.index')
            ->with('success', 'location updated successfully.');
    }

    public function destroy($id)
    {
        $vendor = \App\Models\Location::findOrFail($id);

        $vendor->delete();

        return redirect()
            ->route('locations.index')
            ->with('success', 'Location deleted successfully.');
    }


}


