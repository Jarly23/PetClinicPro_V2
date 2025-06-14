<?php

    namespace App\Livewire;

    use Livewire\Component;
    use App\Models\Product;
    use App\Models\Category;
    use App\Models\Supplier;

    class ProductsCrud extends Component
    {
        public $productId, $name, $description, $id_category, $id_supplier;
        public $purchase_price, $sale_price, $current_stock, $minimum_stock;
        public $open = false;
        public $lowStockAlert = false;
        public $search = '';
        public $categoryFilter = '';
        // Nuevas propiedades
        public $confirmingDelete = false;
        public $productToDelete = null;


        protected $rules = [
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'id_category' => 'required|exists:categories,id_category',
            'id_supplier' => 'required|exists:suppliers,id_supplier',
            'purchase_price' => 'required|numeric|min:0',
            'sale_price' => 'required|numeric|min:0',
            'current_stock' => 'required|integer|min:0',
            'minimum_stock' => 'required|integer|min:0',
        ];

        public function openModal()
        {
            $this->resetInputFields();
            $this->open = true;
        }

        public function closeModal()
        {
            $this->open = false;
        }

        public function save()
        {
            $this->validate();

            Product::updateOrCreate(
                ['id_product' => $this->productId],
                [
                    'name' => $this->name,
                    'description' => $this->description,
                    'id_category' => $this->id_category,
                    'id_supplier' => $this->id_supplier,
                    'purchase_price' => $this->purchase_price,
                    'sale_price' => $this->sale_price,
                    'current_stock' => $this->current_stock,
                    'minimum_stock' => $this->minimum_stock,
                ]
            );

            session()->flash('message', $this->productId ? 'Producto actualizado correctamente' : 'Producto creado correctamente');

            if ($this->current_stock <= $this->minimum_stock) {
                $this->dispatch('low-stock-alert', message: '\u26a0\ufe0f El producto tiene stock bajo o agotado.');
            }

            $this->closeModal();
            $this->resetInputFields();
        }

        public function edit($id)
        {
            $product = Product::findOrFail($id);

            $this->productId = $product->id_product;
            $this->name = $product->name;
            $this->description = $product->description;
            $this->id_category = $product->id_category;
            $this->id_supplier = $product->id_supplier;
            $this->purchase_price = $product->purchase_price;
            $this->sale_price = $product->sale_price;
            $this->current_stock = $product->current_stock;
            $this->minimum_stock = $product->minimum_stock;

            $this->open = true;
        }

        public function delete($id)
        {
            Product::findOrFail($id)->delete();
            session()->flash('message', 'Producto eliminado correctamente.');
        }

        public function checkStockLevels()
        {
            $this->lowStockAlert = Product::whereColumn('current_stock', '<=', 'minimum_stock')->exists();
        }

        private function resetInputFields()
        {
            $this->reset([
                'productId', 'name', 'description', 'id_category', 'id_supplier',
                'purchase_price', 'sale_price', 'current_stock', 'minimum_stock'
            ]);
        }
        public function confirmDelete($id)
        {
            $this->productToDelete = $id;
            $this->confirmingDelete = true;
        }

        public function cancelDelete()
        {
            $this->confirmingDelete = false;
            $this->productToDelete = null;
        }

        public function deleteConfirmed()
        {
            Product::findOrFail($this->productToDelete)->delete();

            session()->flash('message', 'Producto eliminado correctamente.');

            $this->confirmingDelete = false;
            $this->productToDelete = null;
        }


        public function render()
        {
            $this->checkStockLevels();

            $products = Product::with('category')
                ->when($this->search, fn($query) =>
                    $query->where('name', 'like', '%' . $this->search . '%')
                )
                ->when($this->categoryFilter, fn($query) =>
                    $query->where('id_category', $this->categoryFilter)
                )
                ->get();

            return view('livewire.products-crud', [
                'products' => $products,
                'categories' => Category::all(),
                'suppliers' => Supplier::all(),
            ]);
        }
    }
