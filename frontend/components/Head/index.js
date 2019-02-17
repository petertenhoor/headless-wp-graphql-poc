import React from "react";
import PropTypes from "prop-types";
import NextHead from "next/head";

const Head = ({metaTitle}) => {
    return (
        <NextHead>
            <meta charSet="UTF-8"/>
            <meta name="viewport" content="width=device-width, initial-scale=1, user-scalable=yes, maximum-scale=2"/>
            <title>{`${metaTitle} | Peter ten Hoor` || `Untitled | Peter ten Hoor`}</title>
        </NextHead>
    )
}

Head.defaultProps = {
    metaTitle: ""
}

/**
 * Define propTypes
 */
Head.propTypes = {
    metaTitle: PropTypes.string
}

/**
 * Export component
 */
export default Head;