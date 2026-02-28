{{-- =====================================================
   CONTACT SUCCESS PANEL
===================================================== --}}
@if(session('contact_success'))
<div id="contactSuccessPanel"
    class="fixed top-24 right-6 z-50 bg-green-600 text-white px-6 py-5 rounded-lg shadow-2xl transform translate-x-full transition-all duration-500">

    <h3 class="text-lg font-semibold mb-1">
        {{ __('contact.success_title') }}
    </h3>

    <p class="text-sm">
        {{ __('contact.success_message') }}
    </p>

</div>

<script>
    document.addEventListener('DOMContentLoaded', function() {

        const panel = document.getElementById('contactSuccessPanel');

        setTimeout(() => {
            panel.classList.remove('translate-x-full');
        }, 100);

        setTimeout(() => {
            panel.classList.add('translate-x-full');
        }, 5000);

    });
</script>
@endif


{{-- =====================================================
   CONTACT ERROR PANEL
===================================================== --}}
@if(session('contact_error'))
<div id="contactErrorPanel"
    class="fixed top-24 right-6 z-50 bg-red-600 text-white px-6 py-5 rounded-lg shadow-2xl transform translate-x-full transition-all duration-500">

    <h3 class="text-lg font-semibold mb-1">
        {{ __('contact.error_title') }}
    </h3>

    <p class="text-sm">
        {{ __('contact.error_message') }}
    </p>

</div>

<script>
    document.addEventListener('DOMContentLoaded', function() {

        const panel = document.getElementById('contactErrorPanel');

        setTimeout(() => {
            panel.classList.remove('translate-x-full');
        }, 100);

        setTimeout(() => {
            panel.classList.add('translate-x-full');
        }, 5000);

    });
</script>
@endif