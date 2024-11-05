<?php

namespace App\Livewire;

use App\Models\Incidence;
use Livewire\Component;

class ShowIncidence extends Component
{
    public $incidence;

    public function mount($id)
    {
        $user = auth()->user();

        $query = Incidence::where('id', $id);

        if (!$user->hasRole('admin')) {
            $query->where('user_id', $user->id);
        }

        $this->incidence = $query->first();

        if (!$this->incidence) {
            return redirect()->route('incidences.index');
        }
    }

    public function render()
    {
        return view('livewire.incidences.show-incidence')->layout('layouts.app');
    }
}
