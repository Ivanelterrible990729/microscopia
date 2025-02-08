<?php

namespace App\Http\Controllers;

use App\Models\CNNModel;
use Illuminate\Http\Request;

class CNNModelController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return view('c-n-n-model.index');
    }

    /**
     * Display the specified resource.
     */
    public function show(CNNModel $model)
    {
        return view('c-n-n-model.show', compact('model'));
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(CNNModel $model)
    {
        //
    }
}
