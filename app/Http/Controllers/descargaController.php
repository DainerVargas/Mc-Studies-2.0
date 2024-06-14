<?php

namespace App\Http\Controllers;

use App\Models\Apprentice;
use App\Models\Modality;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Http\Request;

class descargaController extends Controller
{
    public function donwload(Apprentice $aprendiz)
    {
        $aprendiz->load('attendant', 'modality');

        $pdf = Pdf::loadView('descargaPDF', ['aprendiz' => $aprendiz]);

        return $pdf->download("Documento - $aprendiz->name  $aprendiz->apellido .pdf");
    }

    public function descarga(Apprentice $aprendiz)
    {

        return view('descargaPDF', compact('aprendiz'));
    }
}
