import {Col} from "react-grid-system";
import {Query} from 'react-apollo'
import gql from 'graphql-tag'

import Layout from "../components/Layout";
import Loader from "../components/Loader";
import PostSnippet from "../components/PostSnippet";

const GET_POSTS = gql`
{
  posts {
    nodes {
      id
      title
      slug
      content
      date
      featuredImage {
        mediaDetails {
          sizes {
            name
            sourceUrl
          }
        }
      }
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
                    if (loading) return <Loader loaderText="Loading posts.."/>
                    const {posts: {nodes}} = data
                    return (
                        <React.Fragment>
                            {nodes.map((post) => {
                                    return (
                                        <Col sm={4} key={post.id}>
                                            <PostSnippet post={post}/>
                                        </Col>
                                    )
                                }
                            )}
                        </React.Fragment>
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