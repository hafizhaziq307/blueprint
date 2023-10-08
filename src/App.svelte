<script>
    import { writeTextFile, readTextFile, BaseDirectory, createDir } from '@tauri-apps/api/fs';


    import { frontendTemplates, inputTypes } from "./data.js";
    import CreateModal from './lib/modals/CreateModal.svelte';
    import EditModal from './lib/modals/EditModal.svelte';
    import Card from './lib/Card.svelte';
    import { fields } from './stores.js';
    import { serializeFormArray, getTimestamp, isEmpty, fetchFileContents, getNamingConventionsForLaravel, isSnakeCase } from './helper.js';

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

        isEditModalOpen = false;
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

    async function generateCode(e) {
        let data = {};
        const formData = new FormData(e.target);
        for (const [name, value] of formData) {
            data[name] = value;
        }
        data['fields'] = $fields;

        if (Object.values(data).some(x => isEmpty(x))) {
            console.log('Please complete all the forms.');
            return;
        }

        if (!isSnakeCase(data.tableName)) {
            console.log('table name must be in snake case');
            return;
        }

        let model = getNamingConventionsForLaravel(data.tableName, "model");
        let view = getNamingConventionsForLaravel(data.tableName, "view");
        let controller = getNamingConventionsForLaravel(data.tableName, "controller");
        let url = getNamingConventionsForLaravel(data.tableName, "url");

        const folderDownload = `${Math.floor(Date.now() / 1000)}-${data.title}`;

        // console.log(data.fields);


        await createDir(folderDownload, { dir: BaseDirectory.Download, recursive: true });

        generateModel(folderDownload, data.tableName, data.primaryKey, model);
        generateRoute(folderDownload, view, controller);
        generateController(folderDownload, model, view, data.fields, controller);

        // TODO: test later
        generateView(folderDownload, view, data.primaryKey, data.fields, url, data.title);
    }

    async function generateController(folderDownload , modelname, folderView, fields, controller) {
        let validationRules = getValidationRules(fields);
        let contents = await fetchFileContents('laravel10/controller.php');

        contents = contents
            .replaceAll('@@@modelname@@@', modelname)
            .replaceAll('@@@folderviewname@@@', folderView)
            .replaceAll('@@@validationrules@@@', validationRules);

        await writeTextFile({ path: `${folderDownload}/${controller}.php`, contents: contents }, { dir: BaseDirectory.Download });

    }

    async function generateModel(folderDownload, table, primarykey, model) {
        let contents = await fetchFileContents('laravel10/model.php');

        contents = contents
            .replaceAll('@@@tablename@@@', table)
            .replaceAll('@@@modelname@@@', model)
            .replaceAll('@@@primarykey@@@', primarykey);

        await writeTextFile({ path: `${folderDownload}/${model}.php`, contents: contents }, { dir: BaseDirectory.Download });
    }

    async function generateRoute(folderDownload, folderView, controller) {
        let contents = await fetchFileContents('laravel10/web.php');

        contents = contents
            .replaceAll('@@@controllername@@@', controller)
            .replaceAll('@@@folderviewname@@@', folderView)

        await writeTextFile({ path: `${folderDownload}/web.php`, contents: contents }, { dir: BaseDirectory.Download });
    }

    async function generateView(folderDownload, folderView, primaryKey, fields, url, title) {
        let contents = await fetchFileContents('laravel10/view.blade.php');

        let thead = ``;
        for (const field of fields) {
            thead += `<th>${field.label}</th>\n`;
        }

        let tbody = [];
        for (const field of fields) {
            const temp = `\t\t\t\t{
                    data: "${field.fieldName}",
                    className: "text-center",
                },`;
            tbody.push(temp);
        }
        tbody = `${tbody.join('\n')}`;

        let editInputs = ``;
        for (const field of fields) {
            editInputs += `$("#editModal [name='${fields.fieldName}']").val(res.${fields.fieldName})\n`;
        }

        let htmlInputs = getHtmlInputs(fields);

        contents = contents
            .replaceAll('@@@crudtitle@@@', title.toUpperCase())
            .replaceAll('@@@thead@@@', thead)
            .replaceAll('@@@tbody@@@', tbody)
            .replaceAll('@@@primarykey@@@', primaryKey)
            .replaceAll('@@@folderviewname@@@', folderView)
            .replaceAll('@@@editInputs@@@', editInputs)
            .replaceAll('@@@htmlInputs@@@', htmlInputs);


        await createDir(`${folderDownload}/${url}`, { dir: BaseDirectory.Download, recursive: true });

        await writeTextFile({ path: `${folderDownload}/${url}/index.blade.php`, contents: contents }, { dir: BaseDirectory.Download });
    }
    

    function getHtmlInputs(fields) {
        let data = ``;

        for (const field of fields) {
            if (field.inputTypeId == 1) { // text
                data += `<div class="form-group">\n\t<label class="mb-1">${field.label}</label>\n\t<input type="text" class="form-control" placeholder="${field.label}" name="${field.fieldName}">\n\t<div id="${field.fieldName}-error" class="invalid-feedback"></div></div>\n`;
            } 
            else if (field.inputTypeId == 2) { // number
                data += `<div class="form-group">
                    <label class="mb-1">${field.label}</label>
                    <input type="number" class="form-control" placeholder="${field.label}" name="${field.fieldName}">
                    <div id="${field.fieldName}-error" class="invalid-feedback"></div>
                </div>\n`;
            } 
            else if (field.inputTypeId == 3) { // date
                data += `<div class="form-group">
                    <label class="mb-1">${field.label}</label>
                    <input type="date" class="form-control" placeholder="${field.label}" name="${field.fieldName}">
                    <div id="${field.fieldName}-error" class="invalid-feedback"></div>
                </div>\n`;
            } 
            else if (field.inputTypeId == 4) { // textarea
                data += `<div class="form-group">
                    <label class="mb-1">${field.label}</label>
                    <textarea class="form-control" rows="3" placeholder="${field.label}" name="${field.fieldName}"></textarea>
                    <div id="${field.fieldName}-error" class="invalid-feedback"></div>
                </div>\n`;
            } 
        }

        return data;
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
    
            data += str;
        }

        return data;
    }
</script>

<main>
    <form on:submit|preventDefault={generateCode} class="min-h-screen w-full p-4 space-y-3">

        <h1 class="text-2xl font-medium">Laravel Generator</h1>
        
        <Card headerTitle="Frontend Template (Choose one)">
            <div class="grid grid-cols-1 md:grid-cols-2 xl:grid-cols-3 gap-2">
                {#each frontendTemplates as frontendTemplate, i}
                    <label>
                        <input type="radio" value={frontendTemplate.id} class="peer hidden" name="frontendRadio" checked={i == 0 && 'checked'}>
                        
                        <div class="hover:bg-gray-50 flex items-center justify-between px-4 py-2 border-2 rounded-lg cursor-pointer text-sm border-gray-200 group peer-checked:border-blue-500">
                            <h2 class="font-medium text-gray-700">{frontendTemplate.title}</h2>
                            <i class="fas fa-check-circle text-xl text-blue-600 invisible group-[.peer:checked+&]:visible"></i>
                        </div>
                    </label>
                {/each}
            </div>
        </Card>
    
        <Card headerTitle="CRUD">
            <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 gap-4">
                <div>
                    <p class="block mb-1 text-sm font-medium text-gray-900">CRUD Title</p>
                    <input type="text" name="title" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-1 focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 focus:outline-none" placeholder="CRUD title" bind:value={title} required>
                </div>
                
                <div>
                    <p class="block mb-1 text-sm font-medium text-gray-900">Table</p>
                    <input type="text" name="tableName" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-1 focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 focus:outline-none" placeholder="table" bind:value={tableName} required>
                </div>
    
                <div>
                    <p class="block mb-1 text-sm font-medium text-gray-900">Primary Key</p>
                    <input type="text" name="primaryKey" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-1 focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 focus:outline-none" placeholder="primary key" bind:value={primaryKey} required>
                </div>
            </div>
        </Card>
    
        <div class="text-right">
            <button type="button" class="w-16 py-1.5 rounded text-white bg-green-500 hover:bg-green-600 inline-flex items-center justify-center gap-1" on:click={openCreateModal}>
                <i class="fas fa-plus text-xs"></i>
                <div class="font-medium text-sm">Add</div>
            </button>
        </div>

        <table class="min-w-max w-full table-auto text-sm bg-white shadow rounded-lg border">
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
                            <td class="py-2 px-4 text-center space-x-0.5">
                                <button type="button" class="bg-yellow-500 hover:bg-yellow-600 rounded w-16 py-1.5 text-white" on:click={() => openEditModal(field.id)}>
                                    <i class="fas fa-edit"></i>
                                </button>
                                <button type="button" class="bg-red-500 hover:bg-red-600 rounded w-16 py-1.5 text-white" >
                                    <i class="fas fa-trash"></i>
                                </button>
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

        <button type="submit" class="bg-blue-600 hover:bg-blue-500 rounded w-full px-4 py-2 text-white font-medium block">Generate</button>
    </form>

    <CreateModal isOpen={isCreateModalOpen} closeModal={closeCreateModal} saveData={saveData} createdRecord={createdRecord} />
    <EditModal isOpen={isEditModalOpen} closeModal={closeEditModal} updateData={updateData} editedRecord={editedRecord} />
</main>