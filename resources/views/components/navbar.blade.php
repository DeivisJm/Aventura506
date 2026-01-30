<header class="fixed top-0 left-0 w-full bg-white shadow z-50">
    <nav class="max-w-7xl mx-auto px-4">
        <div class="flex justify-between items-center h-16">

            {{-- Logo --}}
            <div class="text-xl font-bold text-green-600">
                Aventura506
            </div>



            {{-- Desktop menu --}}
            <ul class="nav-links hidden md:flex space-x-6 font-medium">

                <li> <a href="#" class="nav-link active"> Inicio</a></li>
                <li> <a href="#destinos" class="nav-link">Destinos</a></li>
                <li> <a href="#paquetes" class="nav-link">Paquetes</a></li>
                <li> <a href="#contacto" class="nav-link">Contacto</a></li>

            </ul>

            {{-- Mobile button --}}
            <button id="menu-btn" class="md:hidden focus:outline-none">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" stroke-width="2"
                    viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round"
                        d="M4 6h16M4 12h16M4 18h16" />
                </svg>
            </button>
        </div>
    </nav>

    {{-- Mobile menu --}}
    <div id="mobile-menu" class="hidden md:hidden bg-white border-t">
        <ul class="flex flex-col p-4 space-y-3 font-medium">
            <li><a href="#" class="block hover:text-indigo-600">Inicio</a></li>
            <li><a href="#" class="block hover:text-indigo-600">Destinos</a></li>
            <li><a href="#" class="block hover:text-indigo-600">Paquetes</a></li>
            <li><a href="#" class="block hover:text-indigo-600">Contacto</a></li>
        </ul>
    </div>
</header>