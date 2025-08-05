<?php

namespace App\Livewire;

use App\Mail\SendMail;
use App\Models\Apprentice;
use App\Models\Group;
use App\Models\Message;
use Illuminate\Support\Facades\Mail;
use Livewire\Component;
use Livewire\WithFileUploads;

class SendEmail extends Component
{
    use  WithFileUploads;

    public $estudiantes, $hidden = false, $hidden2 = false, $messages, $groups, $selectEstudents = [], $check = false;

    public $asunto, $text, $message, $group = 'false', $name, $selects, $documento;

    public function mount()
    {
        $this->estudiantes = Apprentice::all();
        $this->messages = Message::all();
        $this->groups = Group::all();
    }

    public function active()
    {
        if ($this->hidden === false) {
            $this->hidden = true;
        } else {
            $this->hidden = false;
        }
    }
    public function show()
    {
        if ($this->hidden2 === false) {
            $this->hidden2 = true;
        } else {
            $this->hidden2 = false;
        }
    }

    public function save()
    {
        if ($this->message != '') {
            Message::create([
                'message' => $this->message
            ]);

            $this->reset('message');
        }
        $this->messages = Message::all();
    }

    public function delete(Message $message)
    {
        $message->delete();
        $this->messages = Message::all();
    }

    public function select($estudentId)
    {
        if (in_array($estudentId, $this->selectEstudents)) {

            $this->selectEstudents = array_values(array_diff($this->selectEstudents, [$estudentId]));
        } else {
            $this->selectEstudents[] = $estudentId;
        }
    }

    public function selectAll()
    {
        foreach ($this->estudiantes as $key => $estudiante) {
            if (in_array($estudiante->id, $this->selectEstudents)) {

                $this->selectEstudents = array_values(array_diff($this->selectEstudents, [$estudiante->id]));
            } else {
                $this->selectEstudents[] = $estudiante->id;
            }
        }
    }

    public function send()
    {
        if ($this->asunto != '' && $this->text != '' && $this->selectEstudents != []) {

            $documento = $this->documento->store('', 'public');

            $estudiantes = Apprentice::whereIn('id', $this->selectEstudents)->get();

            foreach ($estudiantes as $estudiant) {
                try {
                    $email = $estudiant->edad >= 18 ? $estudiant->email : $estudiant->attendant->email;
                    Mail::to($email)->send(new SendMail($this->asunto, $this->text, $documento));
                } catch (\Throwable $th) {

                    return redirect()->route('sendEmail')->with('error', 'Ha ocurrido un error');
                }
            }

            return redirect()->route('sendEmail')->with('success', 'Emails enviados satisfactoriamente');
        } else {
            dd('llena los campos');
        }
    }

    public function render()
    {
        $query = Apprentice::query();

        if ($this->group !== 'false') {
            $query->where('group_id', $this->group);
        }

        if (!empty($this->name)) {
            $query->where('name', 'like', "%{$this->name}%");
        }

        $this->estudiantes = $query->get();

        $this->selectEstudents;

        $this->selects = Apprentice::whereIn('id', $this->selectEstudents)->get();


        return view('livewire.send-email');
    }
}
