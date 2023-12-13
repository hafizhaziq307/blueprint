export function serialize(formTag) {
    let obj = {};

    const formData = new FormData(formTag);
    for (const [name, value] of formData) {
        obj[name] = value;
    }

    return obj;
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


export function capitalize(text) {
    const arr_text = text.toLowerCase().split(" ");

    for (let i = 0; i < arr_text.length; i++) {
        arr_text[i] = arr_text[i][0].toUpperCase() + arr_text[i].substr(1);
    }

    return arr_text.join(" ");
};