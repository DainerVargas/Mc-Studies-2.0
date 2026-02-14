<?php

namespace App\Livewire;

use Livewire\Component;
use Illuminate\Support\Facades\Auth;
use App\Models\ActivityLog;

class HistoryComponent extends Component
{
    public $limit = 15;
    public $category = null;
    public $totalLogsCount = 0;

    protected $queryString = ['category'];

    public function mount()
    {
        if (Auth::user()->rol_id != 1) {
            return redirect()->route('listaAprendiz');
        }
        $this->limit = 15;
    }

    public function loadMore()
    {
        $this->limit += 15;
    }

    public function setCategory($category)
    {
        $this->category = $category === '' ? null : $category;
        $this->limit = 15; // Reset limit when filter changes
    }

    public function render()
    {
        $user = Auth::user();

        $query = ActivityLog::query();

        // Si no es administrador (rol_id != 1), solo mostrar sus propias acciones
        if ($user->rol_id != 1) {
            $query->where('user_id', $user->id);
        }

        // Mapping de categorías a entity_type
        if ($this->category) {
            switch ($this->category) {
                case 'student':
                    $query->whereIn('entity_type', ['Estudiante', 'Descuento', 'Informe']);
                    break;
                case 'teachers':
                    $query->whereIn('entity_type', ['Profesor']);
                    break;
                case 'services':
                    $query->whereIn('entity_type', ['Servicio']);
                    break;
                case 'payments':
                    $query->whereIn('entity_type', ['Pagos', 'Abono']);
                    break;
                case 'cashier':
                    $query->whereIn('entity_type', ['Caja']);
                    break;
            }
        }

        $this->totalLogsCount = $query->count();
        $logs = $query->latest()->take($this->limit)->get();

        return view('livewire.history-component', [
            'logs' => $logs
        ]);
    }
}
