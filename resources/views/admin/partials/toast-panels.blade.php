@if(session('success'))
<div class="toast-panel fixed top-24 right-6 z-50 bg-green-600 text-white px-6 py-5 rounded-xl shadow-2xl transform translate-x-full transition-all duration-500">

    <h3 class="text-lg font-semibold mb-1">
        Cambios Guardados con Éxito!
    </h3>

    <p class="text-sm">
        {{ session('success') }}
    </p>

</div>
@endif

@if(session('error'))
<div class="toast-panel fixed top-24 right-6 z-50 bg-red-600 text-white px-6 py-5 rounded-xl shadow-2xl transform translate-x-full transition-all duration-500">

    <h3 class="text-lg font-semibold mb-1">
        Error!
    </h3>

    <p class="text-sm">
        {{ session('error') }}
    </p>

</div>
@endif