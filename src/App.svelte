<script>
    import { writeTextFile, readTextFile, BaseDirectory, createDir } from '@tauri-apps/api/fs';


    import { backendFrameworks, frontendTemplates, inputTypes } from "./data.js";
    import CreateModal from './lib/modals/CreateModal.svelte';
    import EditModal from './lib/modals/EditModal.svelte';
    import Card from './lib/Card.svelte';
    import { fields } from './stores.js';

    let backendChecked = null;
    let frontendChecked = null;
    let title = null;
    let tableName = null;
    let primaryKey = "id";

    let isCreateModalOpen = false;
    let isEditModalOpen = false;
    let editedRecord = {
        id: null,
        label: null,
        fieldName: null,
        inputTypeId: null
    };
    let createdRecord = {
        id: null,
        label: null,
        fieldName: null,
        inputTypeId: null
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
                inputTypeId: record.inputTypeId
            };
            isEditModalOpen = true;
        }
    }

    function closeEditModal() {
        editedRecord = {
            id: null,
            label: null,
            fieldName: null,
            inputTypeId: null
        };

        isEditModalOpen  = false;
    }

    function saveData(e) {
        let obj = {};

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

    async function generateCode() {
        // const foldername = `${getTimestamp()}-crudtitle`;
        // await createDir(foldername, { dir: BaseDirectory.Download, recursive: true });

        generateModel();
        generateView();
        generateController();
        generateRoute();
    }

    // TODO: test later
    async function generateController(modelname, foldername, fields) {
        let validationRules = getValidationRules(fields);

        let contents = await fetchFileContents('laravel10/controller.php');
        contents = contents
            .replace('@@@modelname@@@', modelname)
            .replace('@@@foldername@@@', foldername)
            .replace('@@@validationrules@@@', validationRules);

        await writeTextFile({ path: `${folderViewName}/controller.php`, contents: contents }, { dir: BaseDirectory.Download });

    }

    async function generateModel(tableName, folderViewName, primarykey) {
        let contents = await fetchFileContents('laravel10/model.php');
        contents = contents
            .replace('@@@tablename@@@', tableName)
            .replace('@@@primarykey@@@', primarykey);
        await writeTextFile({ path: `${folderViewName}/model.php`, contents: contents }, { dir: BaseDirectory.Download });
    }

    // TODO: test later
    async function generateRoute(folderDownloadName, folderViewName, controllerName) {
        let contents = await fetchFileContents('laravel10/web.php');
        contents = contents
            .replace('@@@controllername@@@', controllerName)
            .replace('@@@folderviewname@@@', folderViewName)
        await writeTextFile({ path: `${folderDownloadName}/web.php`, contents: contents }, { dir: BaseDirectory.Download });
    }

    async function generateView() {

    }


    function getValidationRules(fields) {
        let data = ``;

        for (const field of fields) {
            let str;

            if (field.inputTypeId == 1) {
                str = `'${field.fieldName}' => 'required|string',\n`;
            } 
            else if (field.inputTypeId == 2) {
                str = `'${field.fieldName}' => 'required|numeric',\n`;
            } 
            else if (field.inputTypeId == 3) {
                str = `'${field.fieldName}' => 'required|date',\n`;
            } 
            else if (field.inputTypeId == 4) {
                str = `'${field.fieldName}' => 'required|string',\n`;
            } 
            else if (field.inputTypeId == 5) {
                str = `'${field.fieldName}' => 'required',\n`;
            }
    
            data += str;
        }

        return data;
    }


    function fetchFileContents(path) {
        return new Promise(async (resolve, reject) => {
            const response = await fetch(path);

            try {
                const contents = await response.text(); 
                resolve(contents);

            } catch (error) {
                reject(error.message);
            }
        });
    }

    function getTimestamp() {
        const currentDate = new Date();
        const year = currentDate.getFullYear();
        const month = String(currentDate.getMonth() + 1).padStart(2, '0');
        const day = String(currentDate.getDate()).padStart(2, '0');

        return `${year}${month}${day}`;
    }
</script>

<main>
    <div class="min-h-screen w-full p-4 space-y-3">

        <h1 class="text-2xl font-medium">Laravel Generator</h1>
        
        <div class="grid grid-cols-2 gap-3">
            <Card headerTitle="Backend Framework (Choose one)">
                <div class="grid grid-cols-1 md:grid-cols-2 xl:grid-cols-3 gap-2">
                    {#each backendFrameworks as backendFramework, i}
                        <article class="text-sm">
                            <label for="backend{backendFramework.id}" class={`hover:bg-gray-50 flex items-center justify-between px-4 py-2 border-2 rounded-lg cursor-pointer ${backendChecked == backendFramework.id ? 'border-blue-500' : 'border-gray-200'}`}>
                                <h2 class="font-medium text-gray-700">{backendFramework.title}</h2>
                                <i class={`fas fa-check-circle text-xl text-blue-600 ${backendChecked == backendFramework.id ? 'visible' : 'invisible' }`}></i>
                            </label>
                            <input type="radio" id="backend{backendFramework.id}" value={backendFramework.id} bind:group={backendChecked} class="hidden">
                        </article>
                    {/each}
                </div>
            </Card>

            <Card headerTitle="Frontend Template (Choose one)">
                <div class="grid grid-cols-1 md:grid-cols-2 xl:grid-cols-3 gap-2">
                    {#each frontendTemplates as frontendTemplate, i}
                        <article class="text-sm">
                            <label for="frontend{frontendTemplate.id}" class={`hover:bg-gray-50 flex items-center justify-between px-4 py-2 border-2 rounded-lg cursor-pointer ${frontendChecked == frontendTemplate.id ? 'border-blue-500' : 'border-gray-200'}`}>
                                <h2 class="font-medium text-gray-700">{frontendTemplate.title}</h2>
                                <i class={`fas fa-check-circle text-xl text-blue-600 ${frontendChecked == frontendTemplate.id ? 'visible' : 'invisible' }`}></i>
                            </label>
                            <input type="radio" id="frontend{frontendTemplate.id}" value={frontendTemplate.id} bind:group={frontendChecked} class="hidden">
                        </article>
                    {/each}
                </div>
            </Card>
        </div>
    
        <div class="rounded-lg border shadow bg-white">
            <Card headerTitle="CRUD">
                <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 gap-4">
                    <div>
                        <label class="block mb-1 text-sm font-medium text-gray-900">CRUD Title</label>
                        <input type="text" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-1 focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 focus:outline-none" placeholder="CRUD title" bind:value={title} required>
                    </div>
                    
                    <div>
                        <label class="block mb-1 text-sm font-medium text-gray-900">Table</label>
                        <input type="text" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-1 focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 focus:outline-none" placeholder="table" bind:value={tableName} required>
                    </div>
        
                    <div>
                        <label class="block mb-1 text-sm font-medium text-gray-900">Primary Key</label>
                        <input type="text" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-1 focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 focus:outline-none" placeholder="primary key" bind:value={primaryKey} required>
                    </div>
                </div>
            </Card>
        </div>
    
        <div class="space-y-2">
            <div class="flex justify-end">
                <button class="w-16 py-1.5 rounded text-white bg-green-500 hover:bg-green-600 flex items-center justify-center gap-1" on:click={openCreateModal}>
                    <i class="fas fa-plus text-xs"></i>
                    <div class="font-medium text-sm">Add</div>
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
                                        { inputTypes.find((x) => x.id == field.inputTypeId)?.title ?? '-' }
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

        <div>
            <button class="bg-blue-600 hover:bg-blue-500 rounded w-full px-4 py-2 text-white font-medium" on:click={generateCode}>Generate</button>
        </div>
    </div>

    <CreateModal isOpen={isCreateModalOpen} closeModal={closeCreateModal} saveData={saveData} createdRecord={createdRecord} />
    <EditModal isOpen={isEditModalOpen} closeModal={closeEditModal} updateData={updateData} editedRecord={editedRecord} />
</main>