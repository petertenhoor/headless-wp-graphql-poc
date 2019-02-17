import Link from 'next/link'
import {Query} from "react-apollo";
import gql from "graphql-tag";

import Layout from "../components/Layout";

export const GET_POST_DATA = gql`
 query Post($slug: String!) {
  postBy(slug: $slug) {
    title
    slug
    content
    date
  }
}
`

const Post = ({slug}) => {
    return (
        <Query query={GET_POST_DATA} variables={{slug: slug}}>
            {({loading, error, data}) => {
                if (error) return <p>Error loading post..</p>
                if (loading) return <div>Loading..</div>
                const {postBy: post} = data

                return (
                    <Layout metaTitle={`${post.title} | Blog`}>
                        <section>
                            <article>
                                <h1>{post.title}</h1>
                                <span>{post.date}</span>
                                <div dangerouslySetInnerHTML={{__html: post.content}}></div>
                                <Link prefetch href={'/posts'} as={'/posts'}>
                                    <a>Back to posts</a>
                                </Link>
                            </article>
                        </section>
                    </Layout>
                )
            }}
        </Query>
    )
}

Post.getInitialProps = async ({query}) => {
    return {slug: query.slug}
}


export default Post;