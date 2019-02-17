import Link from 'next/link'

import {Query} from 'react-apollo'
import gql from 'graphql-tag'

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

const HomePage = () => {
    return (
        <Query query={GET_POSTS}>
            {({loading, error, data}) => {
                if (error) return <p>Error loading posts</p>
                if (loading) return <p>Loading..</p>

                return (
                    <section>
                        {data.posts.nodes.map((post) => (
                            <article key={post.id}>
                                <h3>{post.title}</h3>
                                <span>{post.date}</span>
                                <div dangerouslySetInnerHTML={{__html: post.content}}></div>
                                <Link prefetch href={`/post?slug=${post.slug}`} as={`/posts/${post.slug}`}>
                                    <a>Read more</a>
                                </Link>
                            </article>
                        ))}
                    </section>
                )
            }}
        </Query>
    )
}


/**
 * Export component
 */
export default HomePage;