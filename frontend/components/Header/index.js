import Link from 'data-prefetch-link'
import {Query} from 'react-apollo'
import gql from 'graphql-tag'
import {Col, Container, Row} from "react-grid-system";

import {ADMIN_URL} from "../../constants";
import stripFinalTrainlingSlash from "../../utils/stripFinalTrailingSlash";
import styles from "./index.scss";
import Loader from "../Loader";

const GET_MAIN_NAV = gql`
{
  menuItems(where: {location: MAIN_NAV}) {
    nodes {
      id
      label
      url
      label
      target
      connectedObject {
        __typename
      }
    }
  }
}
`;

/**
 * get Menu link
 * @param menuItemObject
 * @returns {object}
 */
const getMenuLink = (menuItemObject) => {
    const type = menuItemObject.connectedObject.__typename.toLowerCase()
    const slug = stripFinalTrainlingSlash(menuItemObject.url.replace(ADMIN_URL, '/'))
    let linkHref = ''
    let linkAs = ''

    switch (type) {
        case 'page':
            linkHref = slug !== "/" ? `/page?slug=${slug}` : '/'
            linkAs = slug !== "/" ? slug : "/"
            break
        case 'post':
            linkHref = `/post?slug=${slug}`
            linkAs = `/post${slug}`
            break
        case 'menuitem':
            linkHref = slug
            linkAs = slug
            break
        default:
            break
    }

    return {linkHref, linkAs}
}

const Header = () => {
    return (
        <Query query={GET_MAIN_NAV}>
            {({loading, error, data}) => {
                if (error) return <p>Error loading navigation</p>
                if (loading) return <Loader loaderText="Loading navigation.."/>
                const {menuItems: {nodes: menuItems}} = data

                return (
                    <Container component={'header'} fluid className={styles.header}>
                        <Container style={{width: "100%", padding: "0"}}>
                            <Row style={{width: "100%"}} align="center">
                                <Col sm={3}>
                                    <Link prefetch withData href="/" as="/">
                                        <a>
                                            <h2 className={styles.logo}>
                                                PTH
                                            </h2>
                                        </a>
                                    </Link>
                                </Col>
                                <Col sm={9} component="nav" className={styles.navigation}>
                                    {menuItems.map((menuItem) => {
                                        const {linkHref, linkAs} = getMenuLink(menuItem)
                                        return (
                                            <Link prefetch
                                                  withData
                                                  key={menuItem.id}
                                                  href={linkHref}
                                                  as={linkAs}>
                                                <a className={styles.navigationLink}
                                                   target={menuItem.target !== null ? menuItem.target : "_self"}>
                                                    {menuItem.label}
                                                </a>
                                            </Link>
                                        )
                                    })}
                                </Col>
                            </Row>
                        </Container>
                    </Container>
                )
            }}
        </Query>
    )
}

export default Header;