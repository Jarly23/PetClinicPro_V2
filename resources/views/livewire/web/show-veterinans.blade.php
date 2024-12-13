<div class="max-w-7xl mx-auto grid grid-cols-1 md:grid-cols-3 gap-8">
    @foreach ($veterinarians as $veterinarian)
    <div class="text-center">
        @if ($veterinarian->photo)
        <img src="{{ asset('storage/' . $veterinarian->photo) }}" alt="Team Member" class="w-24 h-24 mx-auto rounded-full object-cover">
        @else
            <span>Imagen no disponible disponible</span>
        @endif
       
        <h3 class="font-bold text-xl mt-4">{{ $veterinarian->name }}</h3>
        <p class="text-gray-600">{{ $veterinarian->specialty }}</p>
    </div>
    @endforeach
</div>
