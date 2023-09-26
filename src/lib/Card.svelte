<script>
    export let headerTitle; 
</script>

<div class="rounded-lg border shadow bg-white">
    
    <header class="font-medium text-gray-700 mb-2 border-b px-3 py-2">{headerTitle}</header>

    <div class="px-3 py-2">
        <slot/>
    </div>
</div>