/**
 * strip final trailing slash from string
 *
 * @param str
 * @returns {*}
 */
export default function (str) {
    if (str.substr(-1) === '/' && str !== '/') return str.substr(0, str.length - 1)
    return str
}