<?php

namespace App\Http\Controllers;

use App\Models\Apprentice;
use App\Models\Informe;
use App\Models\Teacher;
use App\Models\Tinforme;
use Barryvdh\DomPDF\Facade\Pdf;
use Carbon\Carbon;
use Dompdf\Dompdf;
use Illuminate\Support\Facades\Date;

class descargaController extends Controller
{
    public function donwload(Apprentice $aprendiz)
    {
        $aprendiz->load('attendant', 'modality');

        $pdf = Pdf::loadView('descargaPDF', ['aprendiz' => $aprendiz]);
        return $pdf->download("Informe - $aprendiz->name  $aprendiz->apellido .pdf");
    }
    public function descargap(Teacher $teacher)
    {
        $pdf = Pdf::loadView('download', ['teacher' => $teacher]);
        return $pdf->download("Informe - $teacher->name  $teacher->apellido .pdf");
    }

    public function descargar($mes)
    {
        if ($mes == '00') {
            $informes = Informe::all();
        } else {
            $informes = Informe::whereMonth('fecha', $mes)
                ->get();
        }

        $informe = Informe::selectRaw('MIN(id) as id, apprentice_id, MIN(abono) as abono')
            ->groupBy('apprentice_id')
            ->with('apprentice')
            ->get();


        $totalDescuento = $informe->sum(fn($inform) => $inform->apprentice->descuento);

        $aprendices = Apprentice::all();

        $fecha = Carbon::now()->format('d-m-Y');
        $pdf = Pdf::loadView('excelDescarga', compact('informes', 'aprendices', 'fecha', 'totalDescuento'));

        return $pdf->download('Informe-Estudiantes.pdf');
    }

    public function informedescarga()
    {
        $informes = Tinforme::all();
        $fecha = Carbon::now()->format('d-m-Y');

        $pdf = Pdf::loadView('tinformeDescarga', compact('informes', 'fecha'));
        return $pdf->download("Informe-Profesores.pdf");
    }

    public function descarga(Apprentice $aprendiz)
    {

        return view('descargaPDF', compact('aprendiz'));
    }

    public function descargarInforme($estudiante)
    {
        $informes = Informe::where('apprentice_id', $estudiante)->get();

        $fecha = Date::now()->format('d-m-Y');

        $aprendiz = Apprentice::with('group')->find($estudiante);

        $year = Date::now()->year;

        $count = $informes->where('fechaRegistro', $year)->count();

        $pdf = Pdf::loadView('descargaInforme', ['aprendiz' => $aprendiz, 'informes' => $informes, 'fecha' => $fecha, 'count' => $count]);
        
        return $pdf->download("Informe - $aprendiz->name  $aprendiz->apellido .pdf");
        

       /*  return view('descargaInforme', compact('informes', 'aprendiz', 'fecha')); */
    }
}
