import Link from 'next/link'
import {Query} from 'react-apollo'
import gql from 'graphql-tag'

import Layout from "../components/Layout";

const GET_POSTS = gql`
{
  posts {
    nodes{
      id
      title
      slug    
      content
      date
    }
  }
}
`;

const PostsPage = () => {
    return (
        <Layout metaTitle={`Posts`}>
            <Query query={GET_POSTS}>
                {({loading, error, data}) => {
                    if (error) return <p>Error loading posts</p>
                    if (loading) return <p>Loading..</p>
                    const {posts: {nodes}} = data
                    return (
                        <section>
                            {nodes.map((post) => (
                                <article key={post.id}>
                                    <h3>{post.title}</h3>
                                    <span>{post.date}</span>
                                    <div dangerouslySetInnerHTML={{__html: post.content}}></div>
                                    <Link prefetch href={`/post?slug=${post.slug}`} as={`/post/${post.slug}`}>
                                        <a>Read more</a>
                                    </Link>
                                </article>
                            ))}
                        </section>
                    )
                }}
            </Query>
        </Layout>
    )
}


/**
 * Export component
 */
export default PostsPage;