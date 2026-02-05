document.addEventListener('DOMContentLoaded', () => {

    const toursGrid = document.getElementById('tours-grid');
    if (!toursGrid) return; // 👈 CLAVE

    const noResults = document.getElementById('no-results');
    const filterCards = document.querySelectorAll('.filter-card');

    const toursData = [
        {
            id: 1,
            name: 'Canopy Adventure',
            slug: 'canopy-adventure',
            category: 'adventure',
            image: 'https://source.unsplash.com/600x400/?zipline,jungle',
            description: 'Viví la adrenalina del canopy en plena selva.'
        },
        {
            id: 2,
            name: 'Rafting Extreme',
            slug: 'rafting-extreme',
            category: 'extreme',
            image: 'https://source.unsplash.com/600x400/?rafting,river',
            description: 'Aventura extrema en rápidos de clase mundial.'
        },
        {
            id: 3,
            name: 'Caminata Volcán Arenal',
            slug: 'caminata-volcan-arenal',
            category: 'nature',
            image: 'https://source.unsplash.com/600x400/?volcano,hiking',
            description: 'Explorá senderos naturales alrededor del volcán.'
        },
        {
            id: 4,
            name: 'Aguas Termales',
            slug: 'aguas-termales',
            category: 'water',
            image: 'https://source.unsplash.com/600x400/?hotsprings',
            description: 'Relajate en aguas termales naturales.'
        },
        {
            id: 5,
            name: 'ATV Tour',
            slug: 'atv-tour',
            category: 'vehicle',
            image: 'https://source.unsplash.com/600x400/?atv,jungle',
            description: 'Recorré senderos en cuadraciclo.'
        },
        {
            name: 'Nature Tours La Fortuna',
            slug: 'nature-tours-la-fortuna',
            category: 'nature',
            image: '...',
            description: '...'
        }

    ];


    function renderTours(category) {
        toursGrid.innerHTML = '';

        const filtered = category === 'all'
            ? toursData
            : toursData.filter(t => t.category === category);

        if (!filtered.length) {
            noResults.classList.remove('hidden');
            return;
        }

        noResults.classList.add('hidden');

        filtered.forEach(tour => {

            const card = document.createElement('article');

            card.className =
                'scroll-hero bg-white rounded-2xl shadow hover:shadow-lg transition overflow-hidden';

            card.innerHTML = `
        <img src="${tour.image}" alt="${tour.name}"
             class="h-48 w-full object-cover">

        <div class="p-6">
            <h3 class="text-xl font-semibold mb-2">${tour.name}</h3>

            <p class="text-gray-600 text-sm mb-4">
                ${tour.description}
            </p>

            <a href="/tours/${tour.slug}"
               class="btn-primary inline-block text-sm">
                Ver más
            </a>
        </div>
    `;

            toursGrid.appendChild(card);

            // 🔥 AHORA SÍ FUNCIONA
            if (window.scrollObserver) {
                window.scrollObserver.observe(card);
            } else {
                // fallback de seguridad
                card.classList.add('show');
            }
        });

    }

    filterCards.forEach(card => {
        card.addEventListener('click', () => {
            filterCards.forEach(c => c.classList.remove('active'));
            card.classList.add('active');
            renderTours(card.dataset.category);
        });
    });

    renderTours('all');
});
