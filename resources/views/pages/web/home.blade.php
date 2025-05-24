<x-guest-layout>
    <!-- Hero Section -->
    <section class=" text-white py-16 text-center"
        style="background: linear-gradient(rgba(0, 0, 0, 0.5), rgba(0, 0, 0, 0.5)), url('/images/hero-img.webp'); height:600px; background-size:cover;">
        <h1 class="text-4xl font-bold">Bienvenidos a nuestra Clínica Veterinaria</h1>
        <p class="mt-4 text-lg">Cuidamos a tus mascotas como si fueran nuestras</p>
    </section>

    <!-- Services Section -->
    <section class="py-16" id="services">
        <div class="text-center mb-8">
            <h2 class="text-3xl font-bold">Nuestros Servicios</h2>
            <p class="text-gray-600">Explora nuestra gama de servicios para tus amigos peludos</p>
        </div>
        @livewire('web.show-services')
    </section>

    <!-- Our Team Section -->
    <section class="py-16 bg-gray-50" id="our-team">
        <div class="text-center mb-8">
            <h2 class="text-3xl font-bold">Conozca a nuestro equipo</h2>
            <p class="text-gray-600">Profesionales dedicados al cuidado de tus mascotas</p>
        </div>
      
    </section>
    <!-- Reservation Section -->
    <section class="py-16" id="contact">
        <div class="max-w-7xl mx-auto flex flex-col md:flex-row items-center">
            <div class="w-full md:w-1/2">
                <h2 class="text-3xl font-bold mb-4">Make a Reservation</h2>
                <p class="text-gray-600 mb-8">Book your pet's next appointment online</p>
            </div>
            <form class="w-full md:w-1/2 bg-white shadow-md rounded-lg p-8">
                <label class="block text-gray-700 font-bold mb-2">Pet's Name</label>
                <input type="text" class="w-full px-4 py-2 mb-4 border rounded-md">

                <label class="block text-gray-700 font-bold mb-2">Appointment Date</label>
                <input type="datetime-local" class="w-full px-4 py-2 mb-4 border rounded-md">

                <label class="block text-gray-700 font-bold mb-2">Service Required</label>
                <select class="w-full px-4 py-2 mb-4 border rounded-md">
                    <option>Select a service</option>
                    <option>Service 1</option>
                    <option>Service 2</option>
                    <option>Service 3</option>
                </select>

                <button type="submit" class="bg-black text-white px-6 py-2 rounded-md hover:bg-gray-700">Confirm
                    Reservation</button>
            </form>
        </div>
    </section>

    <!-- Testimonials Section -->
    <section class="py-16 bg-gray-50">
        <div class="text-center mb-8">
            <h2 class="text-3xl font-bold">Testimonios de clientes</h2>
            <p class="text-gray-600">Vea lo que nuestros clientes dicen sobre nosotros</p>
        </div>
        <div class="max-w-7xl mx-auto grid grid-cols-1 md:grid-cols-3 gap-8">
            <div class="bg-white shadow-md rounded-lg p-4">
                <p class="text-lg font-bold">Emily</p>
                <p class="text-gray-600 mt-2">¡Excelente servicio! Mi mascota recibió una atención de primera.</p>
            </div>
            <div class="bg-white shadow-md rounded-lg p-4">
                <p class="text-lg font-bold">Michael</p>
                <p class="text-gray-600 mt-2">Equipo altamente capacitado. ¡Recomiendo esta clínica!</p>
            </div>
            <div class="bg-white shadow-md rounded-lg p-4">
                <p class="text-lg font-bold">Sarah</p>
                <p class="text-gray-600 mt-2">Personal amable y excelente atención para mi perro.</p>
            </div>
        </div>
    </section>

    <!-- Address Section -->
    <section class="py-16">
        <div class="max-w-7xl mx-auto">
            <iframe
                src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d1609.9431321139905!2d-71.54151186149731!3d-16.31723820587318!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x9142490e69cc1acd%3A0x4e048d757bfbb445!2sFerreteria%20la%20Quinta%20Grande!5e0!3m2!1sen!2spe!4v1733033123940!5m2!1sen!2spe"
                width="100%" height="450" style="border:0;" allowfullscreen="" loading="lazy"
                referrerpolicy="no-referrer-when-downgrade"></iframe>
        </div>
    </section>
</x-guest-layout>
