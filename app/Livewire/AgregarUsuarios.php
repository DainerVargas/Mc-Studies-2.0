<?php

namespace App\Livewire;

use App\Models\Rol;
use App\Models\Teacher;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Livewire\Component;
use Livewire\WithFileUploads;

use App\Models\Attendant;

class AgregarUsuarios extends Component
{

    use WithFileUploads;

    public $user, $image, $name, $rolname, $typeName, $type, $email, $usuario, $password;

    public $rols, $message, $teachers, $teacherId, $attendants, $attendantId;

    public function mount()
    {
        $this->rols = Rol::all();
        $this->teachers = Teacher::all();
        $this->attendants = Attendant::all();
    }

    public function updatedTeacherId()
    {

        $teacher = Teacher::find($this->teacherId);
        if ($teacher) {
            $this->name = $teacher->name;
            $this->email = $teacher->email;
        }
    }

    public function updatedAttendantId()
    {
        $attendant = Attendant::find($this->attendantId);
        if ($attendant) {
            $this->name = $attendant->name . ' ' . $attendant->apellido;
            $this->email = $attendant->email;
        }
    }

    public function save()
    {
        $validaciones = $this->validate([
            'name' => 'required',
            'email' => 'required|email|unique:users,email',
            'usuario' => 'required|unique:users,usuario',
            'password' => 'required|min:8|different:antigua|regex:/^(?=.*[a-z])(?=.*[A-Z])(?=.*\d).+$/',
            'type' => 'required',
            'image' => 'max:2048'
        ], [
            'required' => 'Este campo es requerido 🙄',
            'email' => 'Eso no parece ser un email 🤨',
            'unique' => '¡Ups!, ya existe 😥',
            'password.min' => 'Requerido minimo 8 caracteres.',
            'password.regex' => 'Requerido al menos una letra minúscula, mayúscula y un número.',
            'max' => 'Maximo peso'
        ]);



        if ($this->image) {
            $imageName = time() . '.' . $this->image->extension();
            $this->image->storeAs('/', $imageName);
        } else {
            $imageName = null;
        }

        if ($validaciones) {

            $usuario = new User();
            $usuario->name = $this->name;
            $usuario->email = $this->email;
            $usuario->usuario = $this->usuario;
            $usuario->password = Hash::make($this->password);
            $usuario->image = $imageName;
            $usuario->rol_id = $this->type;
            $usuario->teacher_id = $this->teacherId;
            $usuario->attendant_id = $this->attendantId;
            $usuario->save();

            $this->message = '🎉 ¡Registro Exitoso! 🎉';
            $this->name = '';
            $this->email = '';
            $this->usuario = '';
            $this->password = '';
            $this->image = '';
            $this->type = '';
            $this->typeName = '';
            $this->teacherId = '';
            $this->attendantId = '';
        }
    }
    public function render()
    {
        $rol = Rol::find($this->type);
        if ($rol) {
            $this->typeName = $rol->name;
        }
        $this->user = Auth::user();
        return view('livewire.agregar-usuarios');
    }
}
