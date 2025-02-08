<?php

namespace App\Http\Controllers;

use App\Models\CnnModel;
use Illuminate\Http\Request;

class CnnModelController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return view('cnn-model.index');
    }

    /**
     * Display the specified resource.
     */
    public function show(CnnModel $cnnModel)
    {
        return view('cnn-model.show', compact('cnnModel'));
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(CnnModel $cnnModel)
    {
        //
    }
}
