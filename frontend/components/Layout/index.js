import React, {Fragment} from "react";
import PropTypes from "prop-types";
import {Col, Container, Row} from "react-grid-system";

import Head from "../Head";
import Header from "../Header";
import Footer from "../Footer";

const Layout = ({children, metaTitle}) => (
    <Fragment>
        <Head metaTitle={metaTitle}/>
        <Header/>
        <Container component={'section'} fluid>
            <Container style={{width: "100%", padding: "0"}}>
                <Row style={{width: "100%"}}>
                    {children}
                </Row>
            </Container>
        </Container>
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