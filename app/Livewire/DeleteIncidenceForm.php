<?php

namespace App\Livewire;

use App\Models\Incidence;
use Livewire\Component;

class DeleteIncidenceForm extends Component
{

    public $incidence;
    public $confirmationText;

    public function mount($id)
    {
        $user = auth()->user();
        
        if (!$user->hasRole('admin')) {
            return redirect()->route('incidences.index');
        }

        $this->incidence = Incidence::find($id);

        if (!$this->incidence) {
            return redirect()->route('incidences.index');
        }
    }

    public function submit()
    {
        if ($this->confirmationText !== $this->incidence->title) {
            $this->addError('confirmationText', 'The entered text does not match the incidence title.');

            return;
        }

        if (!auth()->check() || !auth()->user()->hasRole('admin')) {
            return redirect()->route('incidences.index');
        }

        $this->incidence->delete();

        session()->flash('message', 'Incidence deleted successfully!');

        return redirect()->route('incidences.index');
    }

    public function render()
    {
        return view('livewire.incidences.delete-incidence-form', [
            'incidence' => $this->incidence,
        ])->layout('layouts.app');
    }
}
