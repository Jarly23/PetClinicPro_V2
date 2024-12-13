<div class="max-w-7xl mx-auto grid grid-cols-1 md:grid-cols-3 gap-8">
    @foreach ($services as $service)
        <div class="bg-white shadow-md rounded-lg overflow-hidden">
            @if ($service->image)
            <img src="{{ asset('storage/' . $service->image) }}"alt="Service Image" class="w-full h-48 object-cover">
            @else
                <span>Imagen no disponible disponible</span>
            @endif
            <div class="p-4">
                <h3 class="font-bold text-xl">{{ $service->name }}</h3>
                <p class="text-gray-600 mt-2">{{ $service->price }}</p>
            </div>
        </div>
    @endforeach

</div>
