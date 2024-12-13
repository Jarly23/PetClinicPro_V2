<?php

namespace App\Livewire\Web;

use Livewire\Component;
use App\Models\Service;

class ShowServices extends Component
{
    public function render()
    {
        $services = Service::all();
        return view('livewire.web.show-services',compact('services'));
    }
}
