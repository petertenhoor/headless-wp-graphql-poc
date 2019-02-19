import {Query} from 'react-apollo'
import gql from 'graphql-tag'
import {Col} from "react-grid-system";

import Layout from "../components/Layout";
import Loader from "../components/Loader";

const GET_HOME_PAGE_ID = gql`
{
  allSettings{
    pageOnFront
  }
}
`;

const GET_HOME_PAGE_CONTENT = gql`
query HomeContent($id: Int) {
 pageBy(pageId: $id) {
    title
    slug
    content
    date
  }
}
`

const HomePage = () => {
    return (
        <Query query={GET_HOME_PAGE_ID}>
            {({loading, error, data}) => {
                if (error) return <p>Error loading homepage id!</p>
                if (loading) return <Loader loaderText="Loading homepage id.."/>
                const {allSettings: {pageOnFront}} = data
                return (
                    <Query query={GET_HOME_PAGE_CONTENT} variables={{id: pageOnFront}}>
                        {({loading, error, data}) => {
                            if (error) return <p>Error loading homepage content!</p>
                            if (loading) return <Loader loaderText="Loading homepage content.."/>
                            const {pageBy: page} = data

                            return (
                                <Layout metaTitle={`${page.title}`}>
                                    <Col sm={12}>
                                        <h1>{page.title}</h1>
                                        <div dangerouslySetInnerHTML={{__html: page.content}}></div>
                                    </Col>
                                </Layout>
                            )

                        }}
                    </Query>
                )
            }}
        </Query>
    )
}

/**
 * Export component
 */
export default HomePage;