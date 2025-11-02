<?php

namespace App\Livewire;

use App\Models\RegisterHours as ModelsRegisterHours;
use App\Models\Teacher;
use Illuminate\Support\Facades\DB;
use Livewire\Component;

class RegisterHours extends Component
{
    public $registerHours, $profesores, $view = false, $teacher_id = '', $horas = '', $lunes = '', $martes = '', $miercoles = '', $jueves = '', $viernes = '', $sabado = '', $filtro = '', $id = null, $date = '', $hoursDetails, $showHour = false;

    public function mount()
    {
        $this->registerHours = ModelsRegisterHours::orderByDesc('updated_at')->get();

        $this->profesores = Teacher::all();
    }

    public function show($value = null)
    {
        $this->view = !$this->view;

        if ($this->view) {
            $registerHorus = ModelsRegisterHours::find($value);
            if ($registerHorus) {
                $this->teacher_id = $registerHorus->teacher_id;
                $this->horas = $registerHorus->horas;
                $this->lunes = $registerHorus->lunes;
                $this->martes = $registerHorus->martes;
                $this->miercoles = $registerHorus->miercoles;
                $this->jueves = $registerHorus->jueves;
                $this->viernes = $registerHorus->viernes;
                $this->sabado = $registerHorus->sabado;
                $this->id = $registerHorus->id;
            } else {
                $this->id = null;
            }
        }
    }

    public function updatedFiltro()
    {
        $this->Filtro();
    }
    public function updatedDate()
    {
        $this->Filtro();
    }
    public function Filtro()
    {
       /*  $this->registerHours = ModelsRegisterHours::whereHas('teacher', function ($query) {
            $query->where('name', 'like', "%{$this->filtro}%");
        })
            ->when($this->date, function ($query) {
                $query->where(function ($q) {
                    $q->whereDate('lunes', $this->date)
                        ->orWhereDate('martes', $this->date)
                        ->orWhereDate('miercoles', $this->date)
                        ->orWhereDate('jueves', $this->date)
                        ->orWhereDate('viernes', $this->date)
                        ->orWhereDate('sabado', $this->date);
                });
            })
            ->join(
                DB::raw('(SELECT teacher_id, MAX(updated_at) as last_update FROM register_hours GROUP BY teacher_id) as latest'),
                function ($join) {
                    $join->on('register_hours.teacher_id', '=', 'latest.teacher_id')
                        ->on('register_hours.updated_at', '=', 'latest.last_update');
                }
            )
            ->orderByDesc('register_hours.updated_at')
            ->select('register_hours.*')
            ->get(); */
    }
    public function delete($value)
    {
        ModelsRegisterHours::where('id', $value)->delete();
    }
    public function save()
    {
        $validaciones = $this->validate([
            'teacher_id' => 'required',
            'horas' => 'required',
            'lunes' => 'nullable',
            'martes' => 'nullable',
            'miercoles' => 'nullable',
            'jueves' => 'nullable',
            'viernes' => 'nullable',
            'sabado' => 'nullable',
        ], [
            'required' => 'Este campo es requerido.',
        ]);

        foreach (['lunes', 'martes', 'miercoles', 'jueves', 'viernes', 'sabado'] as $dia) {
            if (empty($validaciones[$dia])) {
                $validaciones[$dia] = null;
            }
        }

        ModelsRegisterHours::updateOrCreate(
            ['id' => $this->id],
            $validaciones
        );

        $this->view = false;
    }

    public function donwload($teacher)
    {
        return redirect()->route('registroHoras', compact('teacher'));
    }

    public function showHours($value = null)
    {
        $this->hoursDetails = ModelsRegisterHours::where('teacher_id', $value)->get();
        $this->showHour = !$this->showHour;
    }
    public function render()
    {

        $this->registerHours = ModelsRegisterHours::whereHas('teacher', function ($query) {
            $query->where('name', 'like', "%{$this->filtro}%");
        })
            ->when($this->date, function ($query) {
                $query->where(function ($q) {
                    $q->whereDate('lunes', $this->date)
                        ->orWhereDate('martes', $this->date)
                        ->orWhereDate('miercoles', $this->date)
                        ->orWhereDate('jueves', $this->date)
                        ->orWhereDate('viernes', $this->date)
                        ->orWhereDate('sabado', $this->date);
                });
            })
            ->join(
                DB::raw('(SELECT teacher_id, MAX(updated_at) as last_update FROM register_hours GROUP BY teacher_id) as latest'),
                function ($join) {
                    $join->on('register_hours.teacher_id', '=', 'latest.teacher_id')
                        ->on('register_hours.updated_at', '=', 'latest.last_update');
                }
            )
            ->orderByDesc('register_hours.updated_at')
            ->select('register_hours.*')
            ->get();
        return view('livewire.register-hours');
    }
}
