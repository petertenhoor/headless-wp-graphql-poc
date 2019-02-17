import {Query} from "react-apollo";
import gql from "graphql-tag";

import Layout from "../components/Layout";

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
                if (error) {
                    console.log(error)
                    return <p>Error loading page..</p>
                }
                if (loading) return <div>Loading..</div>
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
}

Page.getInitialProps = async ({query}) => {
    return {slug: query.slug}
}


export default Page;