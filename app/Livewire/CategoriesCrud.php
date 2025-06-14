<?php

namespace App\Livewire;

use Livewire\Component;
use App\Models\Category;

class CategoriesCrud extends Component
{
    public $name, $categoryId, $open = false;
    public $confirmingDelete = false;
    public $categoryToDelete = null;

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
            ['id_category' => $this->categoryId],
            ['name' => $this->name]
        );

        session()->flash('message', 'Categoría guardada con éxito.');
        $this->closeModal();
        $this->dispatch('refreshCategories');
    }

    public function edit($id)
    {
        $category = Category::findOrFail($id);
        $this->categoryId = $category->id_category;
        $this->name = $category->name;
        $this->open = true;
    }

    // Nuevo método para abrir modal de confirmación
    public function confirmDelete($id)
    {
        $this->categoryToDelete = $id;
        $this->confirmingDelete = true;
    }

    // Método para eliminar la categoría tras confirmar
    public function delete()
    {
        $category = Category::findOrFail($this->categoryToDelete);

        // Aquí puedes eliminar productos relacionados si ya tienes la relación
        // $category->products()->delete();

        $category->delete();

        session()->flash('message', 'Categoría eliminada con éxito.');
        $this->confirmingDelete = false;
        $this->categoryToDelete = null;
        $this->dispatch('refreshCategories');
    }

    public function render()
    {
        return view('livewire.categories-crud', [
            'categories' => Category::all()
        ]);
    }
}
