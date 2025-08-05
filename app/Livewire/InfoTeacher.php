<?php

namespace App\Livewire;

use App\Mail\ComprobanteMail;
use App\Mail\ConfirmacionMail;
use App\Models\Account;
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

    public $teacher, $type, $name, $apellido, $email, $group, $telefono, $name_acount, $type_account, $number_account;
    public $grupos, $type_teachers, $view;
    public $image, $comprobante, $valor, $periodo;

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
        $this->periodo = '';
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
            $comprobante = $this->comprobante->store('', 'public');
            $teacher = Teacher::find($idTeacher);

            $informe = Tinforme::where('teacher_id', $teacher->id)->first();
            if ($informe && $informe->abono == 0) {
                $informe->abono = $this->valor;
                $informe->fecha = Carbon::now();
                $informe->periodo = $this->periodo;
                $informe->save();
            } else {
                Tinforme::create([
                    'teacher_id' => $teacher->id,
                    'abono' => $this->valor,
                    'fecha' => Carbon::now(),
                    'periodo' => $this->periodo,
                ]);
            }

            try {
                Mail::to('dainer2607@gmail.com')->send(new ComprobanteMail($teacher, $comprobante, $this->valor, $this->periodo));
                /* Mail::to($teacher->email)->send(new ComprobanteMail($teacher, $comprobante, $this->valor)); */
                session()->flash('message', 'Email enviado con éxito!');
            } catch (\Throwable $th) {
                return back()->withErrors([
                    'comprobante' => 'Hubo un error al enviar, revisa tu conexion por favor.'
                ]);
            }

            $this->view = 0;
            $this->comprobante = '';
            $this->valor = '';
            $this->periodo = '';
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
        $acount = Account::where('teacher_id', $teacher->id)->first();
        if ($acount) {
            $this->name_acount = $acount->name;
            $this->type_account = $acount->type_account;
            $this->number_account = $acount->number;
        } else {
            $this->name_acount = '';
            $this->type_account = '';
            $this->number_account = '';
        }
    }

    public function update(Teacher $teacher)
    {
        if (isset($this->image)) {
            $path = $this->image->store('', 'public');
            $foto = basename($path);
        } else {
            $foto = $teacher->image;
        }

        $acount = Account::where('teacher_id', $teacher->id)->first();
        if ($acount) {
            $acount->name = $this->name_acount;
            $acount->type_account = $this->type_account;
            $acount->number = $this->number_account;
            $acount->save();
        } else {

            Account::create([
                'name' => $this->name_acount,
                'type_account' => $this->type_account,
                'number' => $this->number_account,
                'teacher_id' => $teacher->id,
            ]);
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
