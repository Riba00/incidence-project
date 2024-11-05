<?php

namespace App\Livewire;

use App\Models\Incidence;
use App\Models\User;
use Livewire\Component;

class CreateIncidenceForm extends Component
{
    public $users;
    public $title;
    public $description;
    public $status;
    public $user_id;

    protected $rules = [
        'title' => 'required|max:255',
        'status' => 'required',
        'user_id' => 'required',
    ];

    public function mount()
    {
        $this->users = User::role('support')->get();
    }

    public function submit()
    {
        if (auth()->user()->hasRole('support')) {
            $this->user_id = auth()->id();
        }

        // Valida los datos
        $this->validate();

        try {
            Incidence::create([
                'title' => $this->title,
                'description' => $this->description,
                'status' => $this->status,
                'user_id' => $this->user_id,
            ]);

            $this->reset(['title', 'description', 'status', 'user_id']);
            session()->flash('message', 'Incidence created successfully.');

            return redirect()->route('incidences.index');
        } catch (\Throwable $th) {
            $this->addError('title', $th->getMessage());
            return redirect()->route('incidences.index');
        }
    }


    public function render()
    {
        return view('livewire.create-incidence-form', [
            'users' => $this->users,
        ]);
    }
}
