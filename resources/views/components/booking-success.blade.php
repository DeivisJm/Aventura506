{{-- =====================================================
   BOOKING SUCCESS PANEL
===================================================== --}}
@if(session('booking_success'))
<div id="bookingSuccessPanel"
    class="fixed top-24 right-6 z-50 bg-green-600 text-white px-6 py-5 rounded-lg shadow-2xl transform translate-x-full transition-all duration-500 max-w-sm w-[calc(100%-3rem)]">

    <h3 class="text-lg font-semibold mb-1">
        {{ __('booking.success_title') }}
    </h3>

    <p class="text-sm">
        {{ session('booking_success') }}
    </p>

</div>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        const panel = document.getElementById('bookingSuccessPanel');
        if (!panel) return;

        requestAnimationFrame(() => {
            panel.classList.remove('translate-x-full');
        });

        setTimeout(() => {
            panel.classList.add('translate-x-full');
        }, 5000);
    });
</script>
@endif

{{-- =====================================================
   BOOKING ERROR PANEL
===================================================== --}}
@if(session('booking_error'))
<div id="bookingErrorPanel"
    class="fixed top-24 right-6 z-50 bg-red-600 text-white px-6 py-5 rounded-lg shadow-2xl transform translate-x-full transition-all duration-500 max-w-sm w-[calc(100%-3rem)]">

    <h3 class="text-lg font-semibold mb-1">
        {{ __('booking.error_title') }}
    </h3>

    <p class="text-sm">
        {{ session('booking_error') }}
    </p>

</div>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        const panel = document.getElementById('bookingErrorPanel');
        if (!panel) return;

        requestAnimationFrame(() => {
            panel.classList.remove('translate-x-full');
        });

        setTimeout(() => {
            panel.classList.add('translate-x-full');
        }, 5000);
    });
</script>
@endif