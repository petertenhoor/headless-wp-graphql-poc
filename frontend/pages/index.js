import {Query} from 'react-apollo'
import gql from 'graphql-tag'

import Layout from "../components/Layout";

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
                if (loading) return <p>Loading homepage id..</p>
                const {allSettings: {pageOnFront}} = data
                return (
                    <Query query={GET_HOME_PAGE_CONTENT} variables={{id: pageOnFront}}>
                        {({loading, error, data}) => {
                            if (error) return <p>Error loading homepage content!</p>
                            if (loading) return <p>Loading homepage content..</p>
                            const {pageBy: page} = data

                            return (
                                <Layout metaTitle={`${page.title}`}>
                                    <section>
                                        <article>
                                            <h1>{page.title}</h1>
                                            <div dangerouslySetInnerHTML={{__html: page.content}}></div>
                                        </article>
                                    </section>
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