<script>
    import Modal from './Modal.svelte';
    import { inputTypes } from "../../data.js";

    export let isOpen;
    export let saveData;
    export let addObj;
</script>

<Modal bind:isOpen>
    <!-- modal header -->
    <div slot="modal-title">Add Field</div>

    <!-- modal content -->
    <form slot="modal-body" class="row" on:submit|preventDefault={saveData}>
        <div class="space-y-4">
            <div>
                <label for="label" class="block text-sm font-bold ml-1 mb-1">Label</label>
                <input type="text" name="label" id="label" bind:value={addObj.label} autocomplete="off" required on:blur={(e) => e.target.value = (e.target.value).trim()} class="py-2 px-3 block w-full border-2 border-gray-200 rounded-md outline-none text-sm focus:border-blue-500 focus:ring-blue-500 shadow-sm" >
            </div>
    
            <div>
                <label for="field-name" class="block text-sm font-bold ml-1 mb-1">Field name</label>
                <input type="text" name="fieldName" id="field-name" bind:value={addObj.fieldName} autocomplete="off" required on:blur={(e) => e.target.value = (e.target.value).trim()} class="py-2 px-3 block w-full border-2 border-gray-200 rounded-md outline-none text-sm focus:border-blue-500 focus:ring-blue-500 shadow-sm">
            </div>
    
            <div>
                <label for="input-type" class="block text-sm font-bold ml-1 mb-1">Input type</label>
                <select name="inputTypeId" id="input-type" bind:value={addObj.inputTypeId} class="py-2 px-3 block w-full border-2 border-gray-200 rounded-md outline-none text-sm focus:border-blue-500 focus:ring-blue-500 shadow-sm">
                    {#each inputTypes as inputType}
                        <option value={inputType.id}>{inputType.title}</option>
                    {/each}
                </select>
            </div>
        </div>
    
        <div class="text-right">
            <button type="submit" class="bg-indigo-600 hover:bg-indigo-500 leading-snug px-4 py-2 rounded-md text-md text-white font-semibold mt-4 text-sm">Save</button>
        </div>
    </form>
</Modal>