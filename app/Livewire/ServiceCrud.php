<?php

namespace App\Livewire;

use Livewire\Component;
use App\Models\Service;
use Livewire\WithFileUploads;

class ServiceCrud extends Component
{
    use WithFileUploads;
    public $open = false;
    public $service_id, $name, $description, $price, $image;

    protected $rules = [
        'name'=> 'required',
        'description' => 'required',
        'price'=>'required',
        'image' => 'nullable|image|max:1440',
    ];

    public function render()
    {
        $services = Service::all();
        return view('livewire.service-crud', compact('services'));
    }

    public function save()
    {
        $this->validate();

        $imagePath = null;
        if ($this->image){
            $imagePath = $this->image->store('images', 'public');
        }

        if ($this->service_id){
            $service = Service::find($this->service_id);
            $service-> update([
                'name' => $this->name,
                'description' => $this->description,
                'price'=> $this->price,
                'image' => $imagePath,
            ]);
        } else {
            Service::create([
                'name' => $this->name,
                'description' => $this->description,
                'price'=> $this->price,
                'image' => $imagePath,
            ]);
        }
        $this->resetForm();
        $this->open=false;
    }

    public function edit($id)
    {
        $service = Service::find($id);
        $this->service_id = $service->id;
        $this->name = $service ->name;
        $this->description = $service ->description;
        $this->price = $service ->price;
        $this->image = $service ->image;
        $this->open = true;
    }
        
    public function delete($id)
    {
        $service = Service::find($id);
        $service -> delete();
    }
    private function resetForm()
    {
        $this->service_id = null;
        $this->name = '';
        $this->description = '';
        $this->price = '';
        $this->image = '';
    }
}
