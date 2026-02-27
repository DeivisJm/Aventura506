{{-- =====================================================
   SUBSCRIBE SUCCESS PANEL
===================================================== --}}
@if(session('subscribe_success'))
<div id="subscribeSuccessPanel"
    class="fixed top-24 right-6 z-50 bg-green-600 text-white px-6 py-5 rounded-lg shadow-2xl transform translate-x-full transition-all duration-500">

    <h3 class="text-lg font-semibold mb-1">
        {{ __('subscribe.success_title') }}
    </h3>

    <p class="text-sm">
        {{ __('subscribe.success_message') }}
    </p>

</div>

<script>
    document.addEventListener('DOMContentLoaded', function() {

        const panel = document.getElementById('subscribeSuccessPanel');

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
   SUBSCRIBE ERROR PANEL
===================================================== --}}
@if($errors->any())
<div id="subscribeErrorPanel"
    class="fixed top-24 right-6 z-50 bg-red-600 text-white px-6 py-5 rounded-lg shadow-2xl transform translate-x-full transition-all duration-500">

    <h3 class="text-lg font-semibold mb-1">
        {{ __('subscribe.error_title') }}
    </h3>

    <p class="text-sm">
        {{ __('subscribe.error_message') }}
    </p>

</div>

<script>
    document.addEventListener('DOMContentLoaded', function() {

        const panel = document.getElementById('subscribeErrorPanel');

        setTimeout(() => {
            panel.classList.remove('translate-x-full');
        }, 100);

        setTimeout(() => {
            panel.classList.add('translate-x-full');
        }, 5000);

    });
</script>
@endif