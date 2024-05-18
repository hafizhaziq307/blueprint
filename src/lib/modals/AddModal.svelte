<script>
    import Modal from './Modal.svelte';
    import { inputTypes } from "../../data.js";

    export let isOpen;
    export let save;
    export let obj;
    export let closeModal;
</script>

<Modal bind:isOpen bind:closeModal>
    <!-- modal header -->
    <div slot="modal-title">Add Field</div>

    <!-- modal content -->
    <form slot="modal-body" class="row" on:submit|preventDefault={save}>
        <div class="space-y-4">
            <div>
                <p class="mb-1 font-medium">Label</p>
                <input type="text" name="label" placeholder="label" bind:value={obj.label} autocomplete="off" required on:blur={(e) => e.target.value = (e.target.value).trim()} class="bg-slate-50 border border-slate-400 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent w-full p-2.5 outline-none" >
            </div>
    
            <div>
                <p class="mb-1 font-medium">Column name</p>
                <input type="text" name="fieldName" placeholder="column name" bind:value={obj.fieldName} autocomplete="off" required on:blur={(e) => e.target.value = (e.target.value).trim()} class="bg-slate-50 border border-slate-400 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent w-full p-2.5 outline-none">
            </div>
    
            <div>
                <p class="mb-1 font-medium">Input type</p>
                <select name="inputTypeId" bind:value={obj.inputTypeId} class="bg-slate-50 border border-slate-400 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent w-full p-2.5 outline-none">
                    {#each inputTypes as inputType}
                        <option value={inputType.id}>{inputType.title}</option>
                    {/each}
                </select>
            </div>
        </div>
    
        <div class="text-right mt-4">
            <button type="submit" class="bg-indigo-600 hover:bg-indigo-500 rounded w-16 py-1 text-white font-medium">Save</button>
        </div>
    </form>
</Modal>