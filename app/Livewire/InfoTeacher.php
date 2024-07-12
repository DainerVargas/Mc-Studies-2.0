<?php

namespace App\Livewire;

use App\Mail\ComprobanteMail;
use App\Models\Group;
use App\Models\Informe;
use App\Models\Teacher;
use App\Models\Tinforme;
use App\Models\TypeTeacher;
use Carbon\Carbon;
use Illuminate\Support\Facades\Mail;
use Livewire\Component;
use Livewire\WithFileUploads;

class InfoTeacher extends Component
{
    use WithFileUploads;

    public $teacher, $type, $name, $apellido, $email, $group, $telefono;
    public $grupos, $type_teachers, $view;
    public $image, $comprobante, $valor;

    public $idTeacher;

    public function toggleEstado(Teacher $teacher)
    {
        $teacher->estado = !$teacher->estado;

        if ($teacher->estado) {
            $teacher->fecha_inicio = now();
            $teacher->fecha_fin = now()->addDays(7);
        }
        $teacher->save();

        $this->teacher = $teacher;
    }

    public function comprobantePago()
    {
        $this->view = 1;
    }

    public function ocultar()
    {
        $this->view = 0;
        $this->comprobante = '';
        $this->valor = '';
    }

    public function sendEmail($idTeacher)
    {
        $validacion =   $this->validate([
            'comprobante' => 'required',
            'valor' => 'required'
        ], [
            'required' => 'Este campo es requerido'
        ]);

        if ($validacion) {
            $comprobante = $this->comprobante->store('/');
            $teacher = Teacher::find($idTeacher);

            $informe = Tinforme::where('teacher_id', $teacher->id)->first();
            if ($informe->abono == 0) {
                $informe->abono = $this->valor;
                $informe->fecha = Carbon::now();
                $informe->save();
            }else{
                Tinforme::create([
                    'teacher_id' => $teacher->id,
                    'abono' => $this->valor,
                    'fecha' => Carbon::now(),
                ]);
            }

            try {
                /* Mail::to('dainer2607@gmail.com')->send(new ComprobanteMail($teacher, $comprobante, $this->valor)); */
                Mail::to($teacher->email)->send(new ComprobanteMail($teacher, $comprobante, $this->valor));
                /* Mail::to('info@mcstudies.com')->send(new ConfirmacionMail($estudiante)); */
                session()->flash('message', 'Email enviado con éxito!');
            } catch (\Throwable $th) {
                return back()->withErrors([
                    'comprobante' => 'Hubo un error al enviar, revisa tu conexion por favor.'
                ]);
            }

            $this->view = 0;
            $this->comprobante = '';
            $this->valor = '';
        }
    }

    public function mount(Teacher $teacher)
    {
        $this->grupos = Group::all();
        $this->type_teachers = TypeTeacher::all();
        $this->name = $teacher->name;
        $this->apellido = $teacher->apellido;
        $this->email = $teacher->email;
        $this->telefono = $teacher->telefono;
        $this->type = $teacher->type_teacher_id;
    }

    public function update(Teacher $teacher)
    {
        if (isset($this->image)) {
            $path = $this->image->store('/');
            $foto = basename($path);
        } else {
            $foto = $teacher->image;
        }

        $teacher->update([
            'name' => $this->name,
            'apellido' => $this->apellido,
            'email' => $this->email,
            'telefono' => $this->telefono,
            'type_teacher_id' => $this->type,
            'image' => $foto,
        ]);
        $this->teacher = $teacher;
    }

    public function render()
    {

        return view('livewire.info-teacher');
    }
}
