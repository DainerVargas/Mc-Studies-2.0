<?php

namespace App\Http\Controllers;

use App\Models\Apprentice;
use App\Models\Informe;
use App\Models\Teacher;
use App\Models\Tinforme;
use Barryvdh\DomPDF\Facade\Pdf;
use Carbon\Carbon;
use Dompdf\Dompdf;

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

    public function descargar()
    { 
        $informes = Informe::all();
        $aprendices = Apprentice::all();

        $fecha = Carbon::now()->format('d-m-Y');
        $pdf = Pdf::loadView('excelDescarga', compact('informes', 'aprendices', 'fecha'));

        return $pdf->download('Informe-Estudiantes.pdf');


       /*  
        $pdf = Pdf::loadView('excelDescarga',compact('informes', 'aprendices', 'fecha'));
       return $pdf->download("Informe-Estudiantes.pdf"); */


      /*   $html = View('excelDescarga', compact('informes', 'aprendices', 'fecha'))->render();

        $dompdf = new Dompdf();
        $dompdf->loadHtml($html);
        $dompdf->setPaper('A3', 'landscape');
        $dompdf->render();
        return $dompdf->stream('Informe-Estudiantes.pdf'); */

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
}
