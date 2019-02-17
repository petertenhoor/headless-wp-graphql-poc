import Link from 'next/link'
import {Query} from "react-apollo";
import gql from "graphql-tag";

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
                    <section>
                        <article>
                            <h1>{post.title}</h1>
                            <span>{post.date}</span>
                            <div dangerouslySetInnerHTML={{__html: post.content}}></div>
                            <Link prefetch href={'/'}>
                                <a>Back to home</a>
                            </Link>
                        </article>
                    </section>
                )
            }}
        </Query>
    )
}

Post.getInitialProps = async ({query}) => {
    return {slug: query.slug}
}


export default Post;