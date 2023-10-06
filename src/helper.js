export function serializeFormArray(form) {
    let formData = [];
    for (let i = 0; i < form.elements.length; i++) {
        const element = form.elements[i];
        if (element.name) {
            let item = {};
            item.name = element.name;
            if (element.type === "checkbox" || element.type === "radio") {
                item.value = element.checked ? element.value : null;
            } else {
                item.value = element.value;
            }
            formData.push(item);
        }
    }
    return formData;
}

export function getTimestamp() {
    const currentDate = new Date();
    const year = currentDate.getFullYear();
    const month = String(currentDate.getMonth() + 1).padStart(2, '0');
    const day = String(currentDate.getDate()).padStart(2, '0');

    return `${year}${month}${day}`;
}

export function isEmpty(x) {
    if (Array.isArray(x)) return !x.length; // array
    if (typeof x === "object") return !Object.keys(x).length; // object
    return !x; // string & number
}

export function fetchFileContents(path) {
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

export function getNamingConventionsForLaravel(value, type) {
    switch (type) {
        case "model": // PascalCase
            return value
                .replace(/[-_](.)/g, (_, char) => char.toUpperCase())
                .replace(/^(.)/, (char) => char.toUpperCase());

        case "view": // snake_case
            return value.replace(/([a-z])([A-Z])/g, '$1_$2').toLowerCase();

        case "controller": // PascalCase
            let str = value
                .replace(/[-_](.)/g, (_, char) => char.toUpperCase())
                .replace(/^(.)/, (char) => char.toUpperCase());

            return `${str}Controller`;

        case "url": // kebab-case
            return value.replace(/([a-z])([A-Z])/g, '$1-$2').toLowerCase();

        default:
            return null;
    }
}

export function isSnakeCase(value) {
    return /^[a-z]+(_[a-z]+)*$/.test(value);
}