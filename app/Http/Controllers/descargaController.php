<?php

namespace App\Http\Controllers;

use App\Models\Apprentice;
use App\Models\Informe;
use App\Models\RegisterHours;
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

        /* return view('download', compact('teacher')); */
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

    public function qualificationDownload()
    {
        $qualifications = session()->get('qualifications');
        $semestre = session()->get('number');
        if ($semestre == 'Final' || $semestre == 'Tercer') {
            $pdf = Pdf::loadView('qualificationDownload', compact('qualifications', 'semestre'));
            return $pdf->download("Calificaciones-" . $qualifications[0]->apprentice->name . " " . $qualifications[0]->apprentice->apellido . ".pdf");
        } elseif ($semestre == 'Primer') {
            $pdf = Pdf::loadView('qualificationFirst', compact('qualifications', 'semestre'));
            return $pdf->download("Reporte-" . $qualifications[0]->apprentice->name . " " . $qualifications[0]->apprentice->apellido . ".pdf");
        } elseif ($semestre == 'Segundo') {
            $pdf = Pdf::loadView('qualificationSecond', compact('qualifications', 'semestre'));
            return $pdf->download("Reporte-" . $qualifications[0]->apprentice->name . " " . $qualifications[0]->apprentice->apellido . ".pdf");
        }
        /* return view('qualificationFirst', compact('qualifications', 'semestre')); */
    }

    public function copiaseguridad()
    {
        $securityInforme = session()->get('copiaseguridad');
        $fecha = Date::now();

        $pdf = Pdf::loadView('copiaseguridadDescarga', compact('securityInforme', 'fecha'));
        return $pdf->download("Copia Seguridad " . $fecha . " .pdf");
        /*  return view('copiaseguridadDescarga', compact('securityInforme', 'fecha')); */
    }

    public function informeCaja()
    {
        $pagos = session()->get('pagos');
        $fecha = Date::now()->format('d-m-Y');

        $pdf = Pdf::loadView('downloadServices', compact('pagos', 'fecha'));
        return $pdf->download("Informe Caja " . $fecha . " .pdf");
    }

    public function registroHoras(Teacher $teacher)
    {
        $hoursDetails = RegisterHours::where('teacher_id', $teacher->id)->get();

        $pdf = Pdf::loadView('registroHoras', compact('hoursDetails'));
        return $pdf->download("Registro Horas " . $teacher->name . " .pdf");
    }
    public function groupCalification()
    {
        $qualifications = session()->get('qualifications');
        $groupName = session()->get('groupName');
        $nameTeacher = session()->get('nameTeacher');
        $typeGroup = session()->get('typeGroup');

        $pdf = Pdf::loadView('grupoCalificacion', compact('qualifications', 'groupName', 'nameTeacher', 'typeGroup'));
        return $pdf->download("Calificacion - Grupo " . $groupName . " .pdf");
    }

    public function descarga(Apprentice $aprendiz)
    {
        return view('descargaPDF', compact('aprendiz'));
    }

    public function certificado(Apprentice $aprendiz)
    {
        $textReconocimiento = session()->get('textReconocimiento');
        $pdf = Pdf::loadView('certificado', compact('aprendiz', 'textReconocimiento'));
        return $pdf->download("Certificado.pdf");
        /* return view('certificado'); */
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
