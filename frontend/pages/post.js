import Link from 'data-prefetch-link'
import {Query} from "react-apollo";
import gql from "graphql-tag";
import moment from "moment";
import {Col} from "react-grid-system";

import Layout from "../components/Layout";
import Loader from "../components/Loader";
import getBlogFeaturedImageUrl from "../utils/getBlogFeaturedImageUrl";
import styles from "../scss/page/post.scss";

const GET_POST_DATA = gql`
 query Post($slug: String!) {
  postBy(slug: $slug) {
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
`

const Post = ({slug}) => {
    return (
        <Query query={GET_POST_DATA} variables={{slug: slug}}>
            {({loading, error, data}) => {
                if (error) return <p>Error loading post..</p>
                if (loading) return <Loader loaderText="Loading post.."/>
                const {postBy: post} = data
                const featuredImageUrl = getBlogFeaturedImageUrl(post.featuredImage.mediaDetails.sizes, 'large')

                return (
                    <Layout metaTitle={`${post.title} | Blog`}>

                        {featuredImageUrl !== false ? (
                            <Col sm={6} component="figure">
                                <img src={featuredImageUrl}
                                     className={styles.featuredImage}
                                     alt={post.title}/>
                            </Col>
                        ) : null}


                        <Col sm={featuredImageUrl !== false ? 6 : 12}>

                            <h1 className={styles.postTitle}>
                                {post.title}
                            </h1>

                            <span className={styles.postDate}>
                                {moment(post.date).format("MMM Do YYYY")}
                            </span>

                            <div className={styles.postContent}
                                 dangerouslySetInnerHTML={{__html: post.content}}></div>

                            <Link prefetch withData href={'/posts'} as={'/posts'}>
                                <a className={styles.archiveLink}>Back to posts</a>
                            </Link>

                        </Col>

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