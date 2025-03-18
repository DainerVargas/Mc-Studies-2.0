<?php

namespace App\Livewire;

use App\Models\Apprentice;
use App\Models\Group;
use App\Models\Message;
use Livewire\Component;

class SendEmail extends Component
{
    public $estudiantes, $hidden = false, $hidden2 = false, $messages, $groups, $selectEstudents = [], $check = false;

    public $asunto, $text, $message, $group = 'false', $name, $selects;

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
            session()->flash('asunto', $this->asunto);
            session()->flash('text', $this->text);
            session()->flash('selectEstudents', $this->selectEstudents);

            return redirect()->route('send');
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
