<?php

namespace App\Http\Controllers;

use App\Models\Pet;
use Illuminate\Http\Request;

class PetController extends Controller
{
    public function history(Pet $pet)
    {
        // Obtiene todas las consultas de la mascota
        $consultations = $pet->consultations()->orderBy('consultation_date', 'desc')->get();

        // Retorna la vista con el historial de consultas
        return view('pages.dashboard.history', compact('pet', 'consultations'));
    }
}
