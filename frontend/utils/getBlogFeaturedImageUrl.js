/**
 * Get image url for blog featured image
 *
 * @param sizes {array}
 * @param sizeKey {string}
 * @returns {*}
 */
export default function (sizes, sizeKey) {
    const imageSizePost = sizes.filter((size) => size.name === sizeKey)
    if (imageSizePost.length > 0) return imageSizePost[0].sourceUrl
    return false
}