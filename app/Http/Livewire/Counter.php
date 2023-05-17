<?php

namespace App\Http\Livewire;

use Livewire\Component;

class Counter extends Component
{

    public $video;
    public $videos = array();

    public function render()
    {
        return view('livewire.counter');
    }

    public function save(){
        dd($this->video);
    }
}
