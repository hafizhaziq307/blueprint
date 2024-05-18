<script>
    import { writeTextFile, readTextFile, BaseDirectory, createDir } from '@tauri-apps/api/fs';
    import { downloadDir } from '@tauri-apps/api/path';
    import { invoke } from "@tauri-apps/api/tauri";
    import Swal from 'sweetalert2';
    import { imask } from '@imask/svelte';

    import { IconCircleCheck, IconPlus  } from '@tabler/icons-svelte';

    import { inputTypes, templates } from "./data.js";
    import AddModal from './lib/modals/AddModal.svelte';
    import EditModal from './lib/modals/EditModal.svelte';
    import Card from './lib/Card.svelte';
    import { fields } from './stores.js';
    import { isEmpty, fetchFileContents, getNamingConventionsForLaravel, isSnakeCase, serialize, capitalize } from './helper.js';

    let showAddModal = false;
    let showEditModal = false;

    let title = null;
    let tableName = null;
    let primaryKey = "id";

    let editObj = {
        id: null,
        label: null,
        fieldName: null,
        inputTypeId: null
    };
    let addObj = {
        id: null,
        label: null,
        fieldName: null,
        inputTypeId: inputTypes[0].id
    };

    function openCreateModal() {
        showAddModal = true;
    }

    function closeCreateModal() {
        showAddModal = false;
    }

    function openEditModal(id) {
        const record = $fields.find(x => x.id == id);

        if (record) {
            editObj = {
                id: record.id,
                label: record.label,
                fieldName: record.fieldName,
                inputTypeId: record.inputTypeId
            };
            showEditModal = true;
        }
    }

    function closeEditModal() {
        editObj = {
            id: null,
            label: null,
            fieldName: null,
            inputTypeId: null
        };

        showEditModal = false;
    }

    function saveData(e) {
        let obj = serialize(e.target);
        obj['id'] = Math.floor(Date.now() / 1000);

        $fields = [...$fields, obj];

        closeCreateModal();

        addObj = {
            id: null,
            label: null,
            fieldName: null,
            inputTypeId: inputTypes[0].id
        };
    }

    function updateData(e) {
        let obj = serialize(e.target);

        $fields = $fields.map(x => x.id == obj.id ? obj : x);

        closeEditModal();
    }

    function deleteData(id) {
        $fields = $fields.filter(x => x.id !== id);
    }

    async function generateCode(e) {
        let obj = serialize(e.target);
        obj['fields'] = $fields;

        if (Object.values(obj).some(x => isEmpty(x))) {
            Swal.fire({
                title: 'Error!',
                text: 'Please complete all the forms!',
                icon: 'error',
                confirmButtonText: 'Close'
            });
            return;
        }

        if (!isSnakeCase(obj.tableName)) {
            Swal.fire({
                title: 'Error!',
                text: 'Table name must be in snake case!',
                icon: 'error',
                confirmButtonText: 'Close'
            });
            return;
        }

        const model = getNamingConventionsForLaravel(obj.tableName, "model");
        const view = getNamingConventionsForLaravel(obj.tableName, "view");
        const controller = getNamingConventionsForLaravel(obj.tableName, "controller");
        const url = getNamingConventionsForLaravel(obj.tableName, "url");
        const folderDownload = `${Math.floor(Date.now() / 1000)}-${obj.title}`;

        await createDir(folderDownload, { dir: BaseDirectory.Download, recursive: true });

        generateModel(folderDownload, obj.tableName, obj.primaryKey, model);
        generateRoute(folderDownload, view, controller);
        generateController(folderDownload, model, view, obj.fields, controller);
        generateView(folderDownload, view, obj.primaryKey, obj.fields, url, obj.title);

        const output = `${await downloadDir()}${folderDownload}`.replace(/\\/g, '/');

        Swal.fire({
            title: 'Success',
            text: 'Source code generated successfully!',
            icon: 'success',
            confirmButtonText: 'Go To Directory',
            showCloseButton: true,
            preConfirm: async() => {
                await invoke('show_in_folder', {path: output});
                return false; // Prevent confirmed
            },
        });
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

        let thead = [];
        for (const field of fields) {
            const temp = `<th>${field.label}</th>`;
            thead.push(temp);
        }
        thead = `${thead.join('\r\n\t\t\t\t\t\t\t\t\t\t\t\t\t')}`;

        let tbody = [];
        for (const field of fields) {
            const temp = `{
                \tdata: "${field.fieldName}",
                \tclassName: "text-center",
            \t},`;
            tbody.push(temp);
        }
        tbody = `${tbody.join('\r\n\t\t\t\t')}`;

        let editInputs = [];
        for (const field of fields) {
            const temp = `$("#editModal [name='${field.fieldName}']").val(res.${field.fieldName});`;
            editInputs.push(temp);
        }
        editInputs = `${editInputs.join('\r\n\t\t\t\t\t')}`;


        let htmlInputs = getHtmlInputs(fields);

        contents = contents
            .replaceAll('@@@crudtitle@@@', capitalize(title))
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
        let data = [];
 
        for (const field of fields) {
            if (field.inputTypeId == 1) { // text
                const temp = `<div class="form-group">
                    \t\t\t\t\t<label class="mb-1">${field.label}</label>
                    \t\t\t\t\t<input type="text" class="form-control" placeholder="${field.label}" name="${field.fieldName}">
                    \t\t\t\t\t<div id="${field.fieldName}-error" class="invalid-feedback"></div>
                \t\t\t\t\t</div>`;
                data.push(temp);
            } 
            else if (field.inputTypeId == 2) { // number
                const temp = `<div class="form-group">
                    \t\t\t\t\t<label class="mb-1">${field.label}</label>
                    \t\t\t\t\t<input type="number" class="form-control" placeholder="${field.label}" name="${field.fieldName}">
                    \t\t\t\t\t<div id="${field.fieldName}-error" class="invalid-feedback"></div>
                \t\t\t\t\t</div>`;
                data.push(temp);
            } 
            else if (field.inputTypeId == 3) { // date
                const temp = `<div class="form-group">
                    \t\t\t\t\t<label class="mb-1">${field.label}</label>
                    \t\t\t\t\t<input type="date" class="form-control" placeholder="${field.label}" name="${field.fieldName}">
                    \t\t\t\t\t<div id="${field.fieldName}-error" class="invalid-feedback"></div>
                \t\t\t\t\t</div>`;
                data.push(temp);
            } 
            else if (field.inputTypeId == 4) { // textarea
                const temp = `<div class="form-group">
                    \t\t\t\t\t<label class="mb-1">${field.label}</label>
                    \t\t\t\t\t<textarea class="form-control" rows="3" placeholder="${field.label}" name="${field.fieldName}"></textarea>
                    \t\t\t\t\t<div id="${field.fieldName}-error" class="invalid-feedback"></div>
                \t\t\t\t\t</div>`;
                data.push(temp);
            } 
            else if (field.inputTypeId == 5) { // select
                const temp = `<div class="form-group">
                    \t\t\t\t\t<label class="mb-1">${field.label}</label>
                    \t\t\t\t\t<select class="form-control" rows="3" name="${field.fieldName}">
                        \t\t\t\t\t<option value=""></option>
                    \t\t\t\t\t</select>
                    \t\t\t\t\t<div id="${field.fieldName}-error" class="invalid-feedback"></div>
                \t\t\t\t\t</div>`;
                data.push(temp);
            } 
        }
        
        data = `${data.join('\r\n\t\t\t\t\t\t\t\t\t')}`;
        return data;
    }

    function getValidationRules(fields) {
        let data = [];

        for (const field of fields) {
            let str;

            if (field.inputTypeId == 1) {
                const temp = `'${field.fieldName}' => 'required|string',`;
                data.push(temp);
            } 
            else if (field.inputTypeId == 2) {
                const temp = `'${field.fieldName}' => 'required|numeric',`;
                data.push(temp);
            } 
            else if (field.inputTypeId == 3) {
                const temp = `'${field.fieldName}' => 'required|date',`;
                data.push(temp);
            } 
            else if (field.inputTypeId == 4) {
                const temp = `'${field.fieldName}' => 'required|string',`;
                data.push(temp);
            } 
        }

        data = `${data.join('\r\n\t\t\t')}`;
        return data;
    }
</script>

<main>
    <form on:submit|preventDefault={generateCode} class="min-h-screen w-full p-4 space-y-3">

        <Card>
            <header slot="card-header">Choose Templates</header>

            <div slot="card-body" class="sm:grid sm:grid-cols-2 gap-2">

                {#each templates as template, i}
                    <label class="block cursor-pointer rounded-lg px-4 py-2 has-[:checked]:bg-blue-500 has-[:checked]:text-white relative border border-slate-400 peer-checked:border-transparent">

                        <input type="radio" name="template" value="1" class="peer hidden" checked={i == 0 && 'checked'}/>

                        <header class="font-bold text-lg">{template.title}</header>

                        <ul class="list-inside list-disc">
                            {#each template.stacks as stack}
                                <li>{stack}</li>
                            {/each}
                        </ul>

                        <IconCircleCheck stroke={2} class="hidden peer-checked:block absolute right-2 bottom-2 size-7 sm:size-8 lg:size-9" />

                    </label>
                {/each}
                
            </div>
        </Card>    
    
        <Card>
            <header slot="card-header">CRUD Information</header>

            <div slot="card-body" class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 gap-4">
                <div>
                    <p class="mb-1 font-medium">Title</p>
                    <input type="text" name="title" class="bg-slate-50 border border-slate-400 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent w-full p-2.5 outline-none" placeholder="title" bind:value={title} required>
                </div>
                
                <div>
                    <p class="mb-1 font-medium">Table Name</p>
                    <input type="text" name="tableName" class="bg-slate-50 border border-slate-400 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent w-full p-2.5 outline-none" placeholder="table name" bind:value={tableName} required>
                </div>
    
                <div>
                    <p class="mb-1 font-medium">Primary Key</p>
                    <input type="text" name="primaryKey" class="bg-slate-50 border border-slate-400 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent w-full p-2.5 outline-none" placeholder="primary key" bind:value={primaryKey} required>
                </div>
            </div>
        </Card>
    
        <div class="text-right">
            <button type="button" class="bg-green-500 hover:bg-green-600 rounded w-16 py-1 text-white font-medium" on:click={openCreateModal}>
                Add
            </button>
        </div>
        

        <table class="min-w-max w-full table-auto bg-white">
            <thead>
                <tr class="bg-slate-200">
                    <th class="py-2 px-4 text-center border-y border-l border-slate-400 w-10">#</th>
                    <th class="py-2 px-4 text-left border-y border-slate-400">Label</th>
                    <th class="py-2 px-4 text-left border-y border-slate-400">Column name</th>
                    <th class="py-2 px-4 text-center border-y border-slate-400">Input type</th>
                    <th class="py-2 px-4 text-center border-y border-r border-slate-400">Actions</th>
                </tr>
            </thead>
            <tbody>
                {#each $fields as field, i}
                    <tr class="hover:bg-slate-100">
                        <td class="py-2 px-4 text-center border-y border-l border-slate-400">{i}</td>
                        <td class="py-2 px-4 text-left whitespace-nowrap border-y border-slate-400">
                            {field.label}
                        </td>
                        <td class="py-2 px-4 text-left border-y border-slate-400">
                            {field.fieldName}
                        </td>
                        <td class="py-2 px-4 text-center border-y border-slate-400">
                            { inputTypes.find((x) => x.id == field.inputTypeId)?.title ?? '-' }
                        </td>
                        <td class="py-2 px-4 text-center border-y border-r border-slate-400 space-x-0.5"> 
                            <button type="button" class="bg-yellow-500 hover:bg-yellow-600 rounded w-16 py-1 text-white font-medium" on:click={() => openEditModal(field.id)}>
                                Edit
                            </button>
                            <button type="button" class="bg-red-500 hover:bg-red-600 rounded w-16 py-1 text-white font-medium" on:click={() => deleteData(field.id)}>
                                Delete
                            </button>
                        </td>
                    </tr>
                {:else}
                    <tr class="hover:bg-slate-100">
                        <td colspan="5" class="py-2 px-4 text-center border border-slate-400">
                            No Column!
                        </td>
                    </tr>
                {/each}
            </tbody>
        </table>

        <button type="submit" class="bg-blue-600 hover:bg-blue-500 rounded w-full px-4 py-2 text-white font-medium">Generate</button>
    </form>

    <AddModal isOpen={showAddModal} closeModal={closeCreateModal} save={saveData} obj={addObj} />
    <EditModal isOpen={showEditModal} closeModal={closeEditModal} update={updateData} obj={editObj} />
</main>
