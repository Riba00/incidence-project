<?php

namespace App\Livewire;

use App\Models\Incidence;
use App\Models\User;
use Livewire\Component;

class EditIncidenceForm extends Component
{
    public $incidence;
    public $title;
    public $description;
    public $status;
    public $user_id;
    public $users;

    protected $rules = [
        'title' => 'required|max:255',
        'status' => 'required',
    ];

    public function mount($id)
    {
        $user = auth()->user();
        $this->users = User::role('support')->get();

        if ($user->hasRole('admin')) {
            $this->incidence = Incidence::find($id);
        } else {
            $this->incidence = Incidence::where('id', $id)
                ->where('user_id', $user->id)
                ->first();
        }

        if (!$this->incidence) {
            return redirect()->route('incidences.index');
        }

        $this->title = $this->incidence->title;
        $this->description = $this->incidence->description;
        $this->status = $this->incidence->status;
        $this->user_id = $this->incidence->user_id;
    }

    public function submit()
    {
        $this->validate();

        if (auth()->user()->hasRole('support')) {
            $this->user_id = auth()->id();

            $this->incidence->update([
                'status' => $this->status,
            ]);
        } else {
            $this->incidence->update([
                'title' => $this->title,
                'description' => $this->description,
                'status' => $this->status,
                'user_id' => $this->user_id,
            ]);
        }

        session()->flash('message', 'Incidence updated successfully!');

        return redirect()->route('incidences.show', $this->incidence->id);
    }


    public function render()
    {
        return view('livewire.incidences.edit-incidence-form', [
            'incidence' => $this->incidence,
        ])->layout('layouts.app');
    }
}
