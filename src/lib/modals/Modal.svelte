<script>
    export let isOpen;
</script>

<div class={`bg-slate-800 bg-opacity-50 flex justify-center items-center p-6 ${isOpen ? 'fixed inset-0' : 'hidden'}` }>
    <!-- overlay -->
    <div class="fixed inset-0 -z-10" role="button" tabindex="0" on:click={() => isOpen = false} ></div>
    
    <!-- modal -->
    <div class="bg-white px-10 py-6 rounded-md max-w-xl w-full">
        <!-- modal header -->
        <header class="mb-8 text-xl font-bold text-slate-500">
            <slot name="modal-title"></slot>
        </header>

        <slot name="modal-body"></slot>
    </div>
</div>