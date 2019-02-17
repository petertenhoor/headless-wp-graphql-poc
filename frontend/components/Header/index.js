import Link from 'next/link'
import {Query} from 'react-apollo'
import gql from 'graphql-tag'

import {ADMIN_URL} from "../../constants";
import stripFinalTrainlingSlash from "../../utils/stripFinalTrailingSlash";

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
                if (loading) return <p>Loading..</p>
                const {menuItems: {nodes: menuItems}} = data

                return (
                    <header>
                        <h1>Peter ten Hoor</h1>
                        <nav>
                            {menuItems.map((menuItem) => {
                                const {linkHref, linkAs} = getMenuLink(menuItem)
                                return (
                                    <Link prefetch
                                          key={menuItem.id}
                                          href={linkHref}
                                          as={linkAs}>
                                        <a target={menuItem.target !== null ? menuItem.target : "_self"}>
                                            {menuItem.label}
                                        </a>
                                    </Link>
                                )
                            })}
                        </nav>
                    </header>
                )
            }}
        </Query>
    )
}

export default Header;