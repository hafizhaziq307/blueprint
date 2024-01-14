export function serialize(formTag) {
    let obj = {};

    const formData = new FormData(formTag);
    for (const [name, value] of formData) {
        obj[name] = value;
    }

    return obj;
}

export function isEmpty(x) {
    return [Object, Array].includes((x || {}).constructor) && !Object.entries((x || {})).length;
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
        case "model": // pascal case
            return toPascalCase(value);

        case "view": // snake case
            return toSnakeCase(value);

        case "controller": // pascal case
            let str = toPascalCase(value);
            return `${str}Controller`;

        case "url": // kebab case
            return toKebabCase(value);

        default:
            return null;
    }
}

export function isSnakeCase(value) {
    return /^[a-z]+(_[a-z]+)*$/.test(value);
}

function toPascalCase(string) {
    return string
        .match(/[A-Z]{2,}(?=[A-Z][a-z]+[0-9]*|\b)|[A-Z]?[a-z]+[0-9]*|[A-Z]|[0-9]+/g)
        .map(x => x.charAt(0).toUpperCase() + x.slice(1).toLowerCase())
        .join('');

}

function toSnakeCase(string) {
    return string
        .match(/[A-Z]{2,}(?=[A-Z][a-z]+[0-9]*|\b)|[A-Z]?[a-z]+[0-9]*|[A-Z]|[0-9]+/g)
        .map(x => x.toLowerCase())
        .join('_');
}

function toKebabCase(string) {
    return string
        .match(/[A-Z]{2,}(?=[A-Z][a-z]+[0-9]*|\b)|[A-Z]?[a-z]+[0-9]*|[A-Z]|[0-9]+/g)
        .map(x => x.toLowerCase())
        .join('-');
}

export function capitalize(string) {
    return string ? string.charAt(0).toUpperCase() + string.slice(1).toLowerCase() : '';
};