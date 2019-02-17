import {Query} from "react-apollo";
import gql from "graphql-tag";
import {Col} from "react-grid-system";

import Layout from "../components/Layout";
import Loader from "../components/Loader";

export const GET_PAGE_DATA = gql`
 query Page($slug: String!) {
  pageBy(uri: $slug) {
    title
    slug
    content
    date
  }
}
`

const Page = ({slug}) => {
    return (
        <Query query={GET_PAGE_DATA} variables={{slug: slug}}>
            {({loading, error, data}) => {
                if (error) return <p>Error loading page..</p>
                if (loading) return <Loader loaderText="Loading page.."/>
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
}

Page.getInitialProps = async ({query}) => {
    return {slug: query.slug}
}


export default Page;