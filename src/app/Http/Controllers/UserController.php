<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Symfony\Component\HttpFoundation\StreamedResponse;

class UserController extends Controller
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
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(User $user)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(User $user)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, User $user)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(User $user)
    {
        //
    }

    public function downloadProfilePhoto(User $user): StreamedResponse
    {
        // Verifica si el usuario tiene una foto de perfil
        if (!$user->profile_photo_path || !Storage::disk(config('jetstream.profile_photo_disk'))->exists($user->profile_photo_path)) {
            abort(404, 'La fotografía de perfil no existe.');
        }

        // Descargar el archivo
        return Storage::download($user->profile_photo_path, 'profile_photo_' . $user->id . '.jpg');
    }
}
