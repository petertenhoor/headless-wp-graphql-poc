import React from "react";
import PropTypes from "prop-types";
import NextHead from "next/head";
import initReactFastclick from "react-fastclick";
import {setConfiguration} from "react-grid-system";

//import global scss styling
import "../../scss/global.scss"

//init React Fastclick
initReactFastclick()

//set default react grid system configuration
setConfiguration({
    containerWidths: [768, 1024, 1280, 1440],
    gridColumns: 12,
    gutterWidth: 40
})

class Head extends React.PureComponent {

    render() {
        const {metaTitle} = this.props

        return (
            <NextHead>
                <meta charSet="UTF-8"/>
                <meta name="viewport"
                      content="width=device-width, initial-scale=1, user-scalable=yes, maximum-scale=2"/>
                <title>{`${metaTitle} | Peter ten Hoor` || `Untitled | Peter ten Hoor`}</title>
            </NextHead>
        )
    }
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