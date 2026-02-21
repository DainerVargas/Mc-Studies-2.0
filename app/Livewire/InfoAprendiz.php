<?php

namespace App\Livewire;

use App\Models\Apprentice;
use App\Models\Attendant;
use App\Models\Group;
use App\Models\Level;
use App\Models\Modality;
use App\Models\Qualification;
use App\Models\Asistencia;
use App\Models\Teacher;
use Carbon\Carbon;
use DateTime;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;
use Livewire\WithFileUploads;

class InfoAprendiz extends Component
{
    use WithFileUploads;

    public $aprendiz;
    public $textReconocimiento;

    // Filters for qualification modal
    public $selectedYear;
    public $selectedSemester = null;
    public $selectedResult = '';

    // UI State
    public $view = false;
    public $viewCertificate = false;
    public $valor = 0; // 0: hidden, 1: viewer
    public $viewAttendance = false;

    // Filters for attendance
    public $attendanceYear;
    public $attendanceStatus = '';

    // Computed properties or passed directly to render to avoid hydration overhead
    // public $grupos; 
    // public $modalidades;
    // public $qualifications;

    public function mount(Apprentice $aprendiz)
    {
        $this->aprendiz = $aprendiz;
        $this->selectedYear = date('Y');
        $this->attendanceYear = date('Y');
    }

    public function toggleEstado()
    {
        $this->aprendiz->estado = !$this->aprendiz->estado;

        if ($this->aprendiz->estado) {
            $this->aprendiz->fecha_inicio = date('Y-m-d');

            $monthsToAdd = match ($this->aprendiz->modality_id) {
                1 => 1,
                2 => 2,
                3 => 4,
                default => 0,
            };

            if ($monthsToAdd > 0) {
                $this->aprendiz->fecha_fin = Carbon::now()->addMonths($monthsToAdd)->toDateString();
            }
        }

        $this->aprendiz->save();
    }

    public function show($value)
    {
        $this->valor = $value;
    }

    public function showQualification()
    {
        $this->view = !$this->view;
    }

    public function showCertificate()
    {
        $this->viewCertificate = !$this->viewCertificate;
        if (!$this->viewCertificate) {
            $this->textReconocimiento = '';
        }
    }

    public function showAttendance()
    {
        $this->viewAttendance = !$this->viewAttendance;
    }

    public function generateCertificate()
    {
        $this->validate([
            'textReconocimiento' => 'required|string|max:500',
        ], [
            'textReconocimiento.required' => 'El campo de texto es obligatorio.',
            'textReconocimiento.string' => 'El campo de texto debe ser una cadena de caracteres.',
            'textReconocimiento.max' => 'El campo de texto no debe exceder los 500 caracteres.',
        ]);

        session()->put('textReconocimiento', $this->textReconocimiento);
        return redirect()->route('certificado', ['aprendiz' => $this->aprendiz->id]);
    }

    public function donwloadQualification()
    {
        $query = Qualification::with(['apprentice', 'teacher', 'group'])
            ->where('apprentice_id', $this->aprendiz->id)
            ->where('year', (string)$this->selectedYear);

        if ($this->selectedSemester) {
            $query->where('semestre', $this->selectedSemester);
        }

        $qualifications = $query->get();

        if ($qualifications->isEmpty()) {
            session()->flash('error_modal', 'No hay calificaciones para los filtros seleccionados.');
            return;
        }

        session()->put('qualifications', $qualifications);
        session()->forget('aprendiz');

        return redirect()->route('donwloadQualification');
    }

    public function sendQualification()
    {
        $query = Qualification::with(['apprentice', 'teacher', 'group'])
            ->where('apprentice_id', $this->aprendiz->id)
            ->where('year', (string)$this->selectedYear);

        if ($this->selectedSemester) {
            $query->where('semestre', $this->selectedSemester);
        }

        $qualifications = $query->get();

        if ($qualifications->isEmpty()) {
            session()->flash('error_modal', 'No hay calificaciones para los filtros seleccionados.');
            return;
        }

        session()->put('qualifications', $qualifications);
        session()->put('aprendiz', $this->aprendiz);

        return redirect()->route('donwloadQualification');
    }

    public function render()
    {
        // Calculate age
        $fechaNacimiento = new DateTime($this->aprendiz->fecha_nacimiento);
        $hoy = new DateTime();
        $edadActualizada = $hoy->diff($fechaNacimiento)->y;

        // Fetch data here with filters
        $query = Qualification::where('apprentice_id', $this->aprendiz->id)
            ->where('year', (string)$this->selectedYear);

        if ($this->selectedSemester) {
            $query->where('semestre', $this->selectedSemester);
        }

        $qualifications = $query->orderBy('resultado', 'asc')->get();

        // Fetch attendance data
        $attendanceQuery = Asistencia::where('apprentice_id', $this->aprendiz->id)
            ->whereYear('fecha', $this->attendanceYear);

        if ($this->attendanceStatus) {
            $attendanceQuery->where('estado', $this->attendanceStatus);
        }

        $attendances = $attendanceQuery->orderBy('fecha', 'desc')->get();

        $grupos = Group::all();
        $user = Auth::user();

        return view('livewire.info-aprendiz', compact('qualifications', 'edadActualizada', 'user', 'attendances'));
    }
}
