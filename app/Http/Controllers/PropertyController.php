<?php

namespace App\Http\Controllers;

use App\Enum\PropertyTypeEnum;
use App\Models\Property;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;

class PropertyController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $request->query('per_page', 15);
        $properties = Property::paginate($request->query('per_page', 15));

        return response()->json($properties);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:255',
            'owner_email' => 'required|email|max:255',
            'type' => ['required', Rule::enum(PropertyTypeEnum::class)],
        ]);

        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 422);
        }

        $user = User::whereEmail($request->input('owner_email'))->firstOrFail();

        $propery = Property::create([
            'name' => $request->input('name'),
            'owner_id' => $user->id,
            'type' => $request->input('type'),
        ]);

        return response()->json($propery, 201);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        return response()->json(Property::findOrFail($id));
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $property = Property::findOrFail($id);
        $property->delete();

        return response('Property deleted', 204);
    }
}
