<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Qualification;
use Illuminate\Http\Request;

class QualificationController extends Controller
{
    public function evaluateStudent($studentId)
    {
        $subjects = ['listening', 'writing', 'reading', 'speaking'];
        $qualifications = Qualification::where('student_id', $studentId)->get();

        if ($qualifications->count() < 4) {
            return 'Faltan calificaciones.';
        }

        $average = $qualifications->avg('score');

        return $average >= 70 ? 'Aprobado' : 'Reprobado';
    }
}
