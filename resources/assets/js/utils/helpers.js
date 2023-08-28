export function static_rev(path) {
    const manifest = window.__manifest;

    if (manifest[ path ]) {
        return `/static/${ manifest[ path ].file }`;
    }
}
