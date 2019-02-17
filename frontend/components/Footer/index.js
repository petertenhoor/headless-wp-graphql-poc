import {Col, Container, Row} from "react-grid-system";

import styles from "./index.scss";

const Footer = () => {
    return (
        <Container component="footer" className={styles.footer} fluid>
            <Container style={{width: "100%", padding: "0"}}>
                <Row style={{width: "100%"}} align="center">
                    <Col sm={12}>
                    <span className={styles.copyrightText}>
                        &copy; {(new Date()).getFullYear()} - Peter ten Hoor
                    </span>
                    </Col>
                </Row>
            </Container>
        </Container>
    )
}

export default Footer;