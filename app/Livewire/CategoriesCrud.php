<?php

namespace App\Livewire;

use Livewire\Component;
use App\Models\Category;

class CategoriesCrud extends Component
{
    public $name, $categoryId, $open = false;

    protected $rules = [
        'name' => 'required|string|max:255|unique:categories,name',
    ];

    public function openModal()
    {
        $this->reset(['name', 'categoryId']);
        $this->open = true;
    }

    public function closeModal()
    {
        $this->open = false;
    }

    public function save()
    {
        $this->validate();

        Category::updateOrCreate(
            ['id_category' => $this->categoryId], // Usa la clave primaria correcta
            ['name' => $this->name]
        );

        session()->flash('message', 'Categoría guardada con éxito.');
        $this->closeModal();
        $this->dispatch('refreshCategories'); // Livewire 3: Emite evento para actualizar lista
    }

    public function edit($id)
    {
        $category = Category::findOrFail($id); // Busca la categoría
        $this->categoryId = $category->id_category;
        $this->name = $category->name;
        $this->open = true; // Abre el modal con los datos cargados
    }

    public function delete($id)
    {
        $category = Category::findOrFail($id);
        $category->delete();

        session()->flash('message', 'Categoría eliminada con éxito.');
        $this->dispatch('refreshCategories'); // Emite evento para actualizar la lista
    }

    public function render()
    {
        return view('livewire.categories-crud', [
            'categories' => Category::all()
        ]);
    }
}
