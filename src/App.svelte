<script>
    import { backendFrameworks, frontendTemplates, inputTypes } from "./data.js";
    import CreateModal from './lib/modals/CreateModal.svelte';
    import EditModal from './lib/modals/EditModal.svelte';
    import Card from './lib/Card.svelte';
    import { fields } from './stores.js';


    let backendChecked;
    let frontendChecked;
    let isCreateModalOpen = false;
    let isEditModalOpen = false;
    let editedRecord = {
        id: null,
        label: null,
        fieldName: null,
        inputType: null
    };
    let createdRecord = {
        id: null,
        label: null,
        fieldName: null,
        inputType: null
    };

    function openCreateModal() {
        isCreateModalOpen = true;
    }

    function closeCreateModal() {
        isCreateModalOpen = false;
    }

    function openEditModal(id) {
        const record = $fields.find(x => x.id == id);

        if (record) {
            editedRecord = {
                id: record.id,
                label: record.label,
                fieldName: record.fieldName,
                inputType: record.inputType
            };
            isEditModalOpen = true;
        }
    }

    function closeEditModal() {
        editedRecord = {
            id: null,
            label: null,
            fieldName: null,
            inputType: null
        };

        isEditModalOpen  = false;
    }

    function saveData(e) {
        let obj = {}

        const formData = new FormData(e.target);
        for (const [name, value] of formData) {
            obj[name] = value;
        }

        $fields = [...$fields, obj];

        closeCreateModal();

        createdRecord = {};
    }

    function updateData() {
        let obj = {};

        const formData = new FormData(e.target);
        for (const [name, value] of formData) {
            obj[name] = value;
        }

        let foundIndex  = $fields.findIndex(x => x.id == obj.id); 

        // tbc
    }
</script>

<main>
    <div class="min-h-screen w-full p-4 space-y-3">
        <h1 class="text-2xl font-medium">Laravel Generator</h1>
        <div class="grid grid-cols-2 gap-3">
            <Card headerTitle="Backend Framework (Choose one)">
                <div class="grid grid-cols-3 gap-2">
                    {#each backendFrameworks as backendFramework, i}
                        <article class="text-sm">
                            <label for="{backendFramework.id}" class={`hover:bg-gray-50 flex items-center justify-between px-4 py-2 border-2 rounded-lg cursor-pointer ${backendChecked == backendFramework.id ? 'border-blue-500' : 'border-gray-200'}`}>
                                <h2 class="font-medium text-gray-700">{backendFramework.title}</h2>
                                <i class={`fas fa-check-circle text-xl text-blue-600 ${backendChecked == backendFramework.id ? 'visible' : 'invisible' }`}></i>
                            </label>
                            <input type="radio" id="{backendFramework.id}" value={backendFramework.id} bind:group={backendChecked} class="hidden">
                        </article>
                    {/each}
                </div>
            </Card>

            <Card headerTitle="Frontend Template (Choose one)">
                <div class="grid grid-cols-3 gap-2">
                    {#each frontendTemplates as frontendTemplate, i}
                        <article class="text-sm">
                            <label for="{frontendTemplate.id}" class={`hover:bg-gray-50 flex items-center justify-between px-4 py-2 border-2 rounded-lg cursor-pointer ${frontendChecked == frontendTemplate.id ? 'border-blue-500' : 'border-gray-200'}`}>
                                <h2 class="font-medium text-gray-700">{frontendTemplate.title}</h2>
                                <i class={`fas fa-check-circle text-xl text-blue-600 ${frontendChecked == frontendTemplate.id ? 'visible' : 'invisible' }`}></i>
                            </label>
                            <input type="radio" id="{frontendTemplate.id}" value={frontendTemplate.id} bind:group={frontendChecked} class="hidden">
                        </article>
                    {/each}
                </div>
            </Card>

            
        </div>
    
        <div class="rounded-lg border shadow bg-white">
            <Card headerTitle="CRUD">
                <div class="grid grid-cols-3 gap-4">
                    <div>
                        <label for="first_name" class="block mb-1 text-sm font-medium text-gray-900 ">CRUD Title</label>
                        <input type="text" id="first_name" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5" placeholder="CRUD title" required>
                    </div>
                    
                    <div>
                        <label for="first_name" class="block mb-1 text-sm font-medium text-gray-900 ">Table</label>
                        <input type="text" id="first_name" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5" placeholder="table" required>
                    </div>
        
                    <div>
                        <label for="first_name" class="block mb-1 text-sm font-medium text-gray-900 ">Primary Key</label>
                        <input type="text" id="first_name" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5" placeholder="primary key" value="id" required>
                    </div>
                </div>
            </Card>
        </div>
    
        <div class="space-y-2">
            <div class="flex justify-end">
                <button class="w-16 py-1.5 rounded text-sm text-white bg-green-500 hover:bg-green-600 font-medium flex items-center justify-center" on:click={openCreateModal}>
                    <div>
                        <i class="fas fa-plus text-xs"></i>
                    </div>
                    <div class="ml-1">Add</div>
                </button>
            </div>
    
            <div class="bg-white shadow-md rounded border">
                <table class="min-w-max w-full table-auto text-sm">
                    <thead>
                        <tr class="bg-gray-200 text-gray-600 leading-normal">
                            <th class="py-2 px-4 text-left">Label</th>
                            <th class="py-2 px-4 text-left">Field name</th>
                            <th class="py-2 px-4 text-center">Input type</th>
                            <th class="py-2 px-4 text-center">Actions</th>
                        </tr>
                    </thead>
                    <tbody class="text-gray-600">
                            {#each $fields as field}
                                <tr class="border-b border-gray-200 hover:bg-gray-100">
                                    <td class="py-2 px-4 text-left whitespace-nowrap">
                                        {field.label}
                                    </td>
                                    <td class="py-2 px-4 text-left">
                                        {field.fieldName}
                                    </td>
                                    <td class="py-2 px-4 text-center">
                                        {inputTypes[field.inputType].title}
                                    </td>
                                    <td class="py-2 px-4 text-center">
                                        <div class="flex item-center justify-center gap-4">
                                            <button type="button" class="bg-yellow-500 hover:bg-yellow-600 rounded w-16 py-1.5 text-white" on:click={() => openEditModal(field.id)}>
                                                <i class="fas fa-edit"></i>
                                            </button>
                                            <button type="button" class="bg-red-500 hover:bg-red-600 rounded w-16 py-1.5 text-white" >
                                                <i class="fas fa-trash"></i>
                                            </button>
                                            
                                        </div>
                                    </td>
                                </tr>
                            {:else}
                                <tr class="border-b border-gray-200 hover:bg-gray-100">
                                    <td colspan="4" class="py-2 px-4 text-center">
                                        No Fields!
                                    </td>
                                </tr>
                            {/each}
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <CreateModal isOpen={isCreateModalOpen} closeModal={closeCreateModal} saveData={saveData} createdRecord={createdRecord} />
    <EditModal isOpen={isEditModalOpen} closeModal={closeEditModal} updateData={updateData} editedRecord={editedRecord} />
</main>