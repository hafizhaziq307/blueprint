<script>
    import { inputTypes } from "../../data.js";

    export let isOpen;
    export let closeModal;
    export let updateData;
    export let editedRecord;
</script>

<div class={`bg-slate-800 bg-opacity-50 flex justify-center items-center p-6 ${isOpen ? 'fixed inset-0' : 'hidden'}` } >
    <!-- overlay -->
    <div class="fixed inset-0 -z-10" role="button" tabindex="0" on:click={closeModal} on:keydown={closeModal}></div>
    
    <!-- modal -->
    <div class="bg-white px-10 py-6 rounded-md max-w-xl w-full space-y-4">
        <!-- modal header -->
        <header class="mb-4">
            <h1 class="text-xl font-bold text-slate-500">Edit Field</h1>
        </header>

        <!-- modal content -->
        <form class="row" on:submit|preventDefault={updateData}>
            <div class="space-y-4">
                <div>
                    <label for="label" class="block text-sm font-bold ml-1 mb-1">Label</label>
                    <input type="text" name="label" id="label" value={editedRecord.label} autocomplete="off" required on:blur={(e) => e.target.value = (e.target.value).trim()} class="py-2 px-3 block w-full border-2 border-gray-200 rounded-md outline-none text-sm focus:border-blue-500 focus:ring-blue-500 shadow-sm" >
                </div>
    
                <div>
                    <label for="field-name" class="block text-sm font-bold ml-1 mb-1">Field name</label>
                    <input type="text" name="fieldName" id="field-name" value={editedRecord.fieldName} autocomplete="off" required on:blur={(e) => e.target.value = (e.target.value).trim()} class="py-2 px-3 block w-full border-2 border-gray-200 rounded-md outline-none text-sm focus:border-blue-500 focus:ring-blue-500 shadow-sm">
                </div>
    
                <div>
                    <label for="input-type" class="block text-sm font-bold ml-1 mb-1">Input type</label>
                    <select name="inputTypeId" id="input-type" class="py-2 px-3 block w-full border-2 border-gray-200 rounded-md outline-none text-sm focus:border-blue-500 focus:ring-blue-500 shadow-sm">
                        {#each inputTypes as inputType}
                            <option value={inputType.id} selected={(inputType.id == editedRecord.inputTypeId) ? 'selected' : ''}>{inputType.title}</option>
                        {/each}
                    </select>
                </div>
            </div>

            <div class="text-right">
                <input type="hidden" name="id" value="{editedRecord.id}">
                <button type="submit" class="bg-indigo-600 hover:bg-indigo-500 leading-snug px-4 py-2 rounded-md text-md text-white font-semibold mt-4 text-sm">Save</button>
            </div>
        </form>
    </div>
</div>