<?php

namespace App\Livewire;

use App\Models\Teacher;
use App\Models\Tinforme as ModelsTinforme;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;

class Tinforme extends Component
{
    public $tinformes, $profesores, $filtro = '', $informe = [], $view;

    public $name, $abono, $teacher, $selectTeachers = [] ,$message2, $year, $user;

    public function mount()
    {
        $this->tinformes = ModelsTinforme::all();
        $this->profesores = Teacher::all();
        $this->year = date('Y');

        $this->user = Auth::user();
    }

    public function active($value){
        $infor = ModelsTinforme::find($value);
        $this->teacher = Teacher::where('id', $infor->teacher_id)->first();
        $this->view = 1;
    }

    public function next()
	{
		$this->year += 1;
		$this->tinformes = ModelsTinforme::whereYear('fecha', $this->year)->get();
	}
	public function previous()
	{
		$this->year -= 1;
		$this->tinformes = ModelsTinforme::whereYear('fecha', $this->year)->get();
	}
    
    public function select($teacherId)
    {
        if (in_array($teacherId, $this->selectTeachers)) {

            $this->selectTeachers = array_values(array_diff($this->selectTeachers, [$teacherId]));
        } else {
            $this->selectTeachers[] = $teacherId;
        }
    }

    public function download(){

        if($this->selectTeachers != []){
            session()->flash('selectTeachers', $this->selectTeachers);
        }
        
        return redirect()->route('informedescarga');
    }

    public function eliminar(ModelsTinforme $informe)
    {

        if (!$informe) {
            $this->message2 = "El informe no existe.";
            return;
        }
        $informCount = ModelsTinforme::where('teacher_id', $informe->teacher_id)->count();

        if ($informCount == 1) {
            $this->message2 = "No se puede eliminar el único informe del profesor.";
        } else {
            $informe->delete();
            $this->informe = ModelsTinforme::all();
        }
    }
    public function reseter(ModelsTinforme $informe)
    {

        if (!$informe) {
            $this->message2 = "El informe no existe.";
            return;
        }
       
        $informe->abono = 0;
        $informe->fecha = null;
        $informe->save();
    }

    public function render()
    {
        $this->profesores = Teacher::where('name', 'LIKE', '%' . $this->filtro . '%')->get();
        
        $this->informe = collect(); 

        foreach ($this->profesores as $profesor) {
            $informesProfesor = ModelsTinforme::where('teacher_id', $profesor->id)->whereYear('fecha', $this->year)->get();
            $this->informe = $this->informe->merge($informesProfesor); 
        }

        return view('livewire.tinforme', [
            'informes' => $this->informe,
        ]);
    }
}