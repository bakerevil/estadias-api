<?php

namespace App\Http\Controllers;

use App\Models\landings;
use Illuminate\Http\Request;

class landingsController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    public function getAlllandings()
    {
        // $landings = landings::all();
        $landings = Landings::select('landings.id', 'landings.logo', 'landings.slugs', 'landings.hero', 'landings.company_id', 'landings.services', 'landings.packages', 'company.name')
        ->leftjoin('company', 'landings.company_id', '=', 'company.id')
        ->get();
        return response()->json(["landings" => $landings]);
    }

    public function showlandings($id)
    {
        $landings = landings::where('id', $id)->first();
        return response($landings);
    }
    public function showlandingsBySlug($slug)
    {
        $landing = landings::where('slugs', $slug)->first();
    
        if ($landing) {
            return response()->json($landing);
        } else {
            return response()->json(['message' => 'Landing not found'], 404);
        }
    }
    public function insertlandings(Request $request)
    {
        $landings = new landings();
        $landings->slugs = $request->slugs;
        $landings->logo = $request->logo;
        $landings->hero = $request->hero;
        $landings->services = $request->services;
        $landings->packages = $request->packages;
        $landings->company_id = $request->company_id;
        $landings->save();
    }
    public function deletelandings($id)
    {
        $landings = landings::where('id', $id)->first();
        if (!$landings) {
            return response()->json(["error" => "landings not found"]);
        }
        $landings->delete();
        return response()->json(["data" => "landing with id $id deleted successfully"]);
    }

    public function updatelandings(Request $request, $id)
    {
        $landings = landings::where('id', $id)->first();
    
        if (!$landings) {
            return response()->json(['error' => 'Landing not found'], 404);
        }

        if ($request->hasFile('logo')) {
            $file = $request->file('logo');
            $filename = time() . '_' . $file->getClientOriginalName();
            $file->move(public_path('public'), $filename); 
            $landings->logo = $filename;
        }

        if ($request->has('hero') && !is_null($request->hero)) {
            $landings->hero = $request->hero;
        }

        if ($request->has('company_id') && !is_null($request->company_id)) {
            $landings->company_id = $request->company_id;
        }

        $landings->save();

        return response()->json(['data' => 'Se actualizó correctamente']);
    }

}
