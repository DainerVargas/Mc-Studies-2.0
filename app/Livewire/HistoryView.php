<?php

namespace App\Livewire;

use App\Models\History;
use Carbon\Carbon;
use Livewire\Component;

class HistoryView extends Component
{

    public $class, $histories, $year;

    public function vista($value)
    {
        $this->class = $value;
    }

    public function activeYear($value)
    {
        if ($value == 1) {
            if ($this->year != 23) {
                $this->year--;
            }
        } else {
            if ($this->year < 99) {
                $this->year++;
            }
        }
    }

    public function mount()
    {
        $this->histories = History::all();
        $this->year = Carbon::now()->format('y');
    }

    public function render()
    {
        return view('livewire.history-view');
    }
}
