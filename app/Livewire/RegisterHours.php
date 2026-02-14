<?php

namespace App\Livewire;

use App\Models\RegisterHours as ModelsRegisterHours;
use App\Models\Teacher;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Livewire\Component;

class RegisterHours extends Component
{
    public $filtro = '', $date = '';

    public function pay($value)
    {
        ModelsRegisterHours::find($value)->update(['pago' => true]);
    }

    public function updatedFiltro() {}
    public function updatedDate() {}

    public function delete($value)
    {
        if (Auth::user()->rol_id != 1) {
            $this->dispatch('error', 'No tienes permisos para eliminar.');
            return;
        }
        ModelsRegisterHours::where('id', $value)->delete();
    }

    public function render()
    {
        $registerHours = ModelsRegisterHours::whereHas('teacher', function ($query) {
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

        return view('livewire.register-hours', [
            'registerHours' => $registerHours
        ]);
    }
}
