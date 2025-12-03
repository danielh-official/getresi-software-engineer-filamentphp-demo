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
        $perPage = $request->query('per_page', 15);
        $page = $request->query('page', 1);

        $properties = Property::paginate(
            perPage: $perPage,
            page: $page
        );

        return $properties->toResourceCollection();
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:255',
            'owner_email' => 'required|email|max:255|exists:users,email',
            'type' => ['required', Rule::enum(PropertyTypeEnum::class)],
        ]);

        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 422);
        }

        $user = User::whereEmail($request->input('owner_email'))->firstOrFail();

        $property = Property::create([
            'name' => $request->input('name'),
            'owner_id' => $user->id,
            'type' => $request->input('type'),
        ]);

        return $property->toResource();
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        return Property::findOrFail($id)->toResource();
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
