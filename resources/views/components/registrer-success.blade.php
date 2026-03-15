{{-- =====================================================
   REGISTER SUCCESS PANEL
===================================================== --}}
@if(session('register_success'))
<div id="registerSuccessPanel"
    class="fixed top-24 right-6 z-50 bg-green-600 text-white px-6 py-5 rounded-lg shadow-2xl transform translate-x-full transition-all duration-500">

    <h3 class="text-lg font-semibold mb-1">
        {{ __('admin.register_success_title') }}
    </h3>

    <p class="text-sm">
        {{ __('admin.register_success_message') }}
    </p>

</div>

<script>
    document.addEventListener('DOMContentLoaded', function() {

        const panel = document.getElementById('registerSuccessPanel');
        if (!panel) return;

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
   REGISTER ERROR PANEL
===================================================== --}}
@if($errors->any())
<div id="registerErrorPanel"
    class="fixed top-24 right-6 z-50 bg-red-600 text-white px-6 py-5 rounded-lg shadow-2xl transform translate-x-full transition-all duration-500">

    <h3 class="text-lg font-semibold mb-1">
        {{ __('admin.register_error_title') }}
    </h3>

    <p class="text-sm">
        {{ $errors->first() ?: __('admin.register_error_message') }}
    </p>

</div>

<script>
    document.addEventListener('DOMContentLoaded', function() {

        const panel = document.getElementById('registerErrorPanel');
        if (!panel) return;

        setTimeout(() => {
            panel.classList.remove('translate-x-full');
        }, 100);

        setTimeout(() => {
            panel.classList.add('translate-x-full');
        }, 5000);

    });
</script>
@endif