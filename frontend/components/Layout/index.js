import React, {Fragment} from "react";
import PropTypes from "prop-types";

import Head from "../Head";
import Header from "../Header";
import Footer from "../Footer";

const Layout = ({children, metaTitle}) => (
    <Fragment>
        <Head metaTitle={metaTitle}/>
        <Header/>
        {children}
        <Footer/>
    </Fragment>
)

/**
 * Define propTypes
 */
Layout.propTypes = {
    children: PropTypes.node,
    metaTitle: PropTypes.string
}

/**
 * Export component
 */
export default Layout;