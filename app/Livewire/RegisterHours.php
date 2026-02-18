<?php

namespace App\Livewire;

use App\Models\RegisterHours as ModelsRegisterHours;
use App\Models\Teacher;
use App\Mail\PaymentReportMail;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Mail;
use Livewire\Component;

class RegisterHours extends Component
{
    public $filtro = '', $date = '';
    public $showModal = false;
    public $selectedHourId;
    public $metodoPago = 'Transferencia';
    public $enviarEmail = true;

    public function openPayModal($id)
    {
        $this->selectedHourId = $id;
        $this->showModal = true;
    }

    public function closePayModal()
    {
        $this->showModal = false;
        $this->reset(['selectedHourId', 'metodoPago', 'enviarEmail']);
    }

    public function pay()
    {
        $registerHour = ModelsRegisterHours::with('teacher')->find($this->selectedHourId);

        if ($registerHour) {
            $registerHour->update([
                'pago' => true,
                'metodo' => $this->metodoPago
            ]);

            if ($this->enviarEmail) {
                Mail::to($registerHour->teacher->email)->send(new PaymentReportMail($registerHour, $this->metodoPago));
            }

            $this->dispatch('success', 'Pago registrado correctamente.');
        }

        $this->closePayModal();
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
