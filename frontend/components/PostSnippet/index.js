import Link from 'next/link'
import moment from "moment";

import styles from "./index.scss";
import {BLOG_EXCERPT_SIZE_CHARACTERS} from "../../constants";
import getBlogFeaturedImageUrl from "../../utils/getBlogFeaturedImageUrl";

const PostSnippet = ({post}) => {
    const featuredImageUrl = getBlogFeaturedImageUrl(post.featuredImage.mediaDetails.sizes, 'imageSizePost')
    return (
        <Link prefetch href={`/post?slug=${post.slug}`} as={`/post/${post.slug}`}>

            <a className={styles.postSnippet}>

                {featuredImageUrl !== false ? (
                    <figure className={styles.postSnippetImageContainer}>
                        <img src={featuredImageUrl}
                             className={styles.postSnippetImage}
                             alt={post.title}/>
                    </figure>
                ) : null}

                <div className={styles.postSnippetMeta}>

                    <h3 className={styles.snippetPostTitle}>
                        {post.title}
                    </h3>

                    <span className={styles.snippetPostDate}>
                        {moment(post.date).format("MMM Do YYYY")}
                     </span>

                    <div className={styles.snippetPostContent}
                         dangerouslySetInnerHTML={{__html: `${post.content.substr(0, BLOG_EXCERPT_SIZE_CHARACTERS)}`}}>
                    </div>

                </div>

            </a>

        </Link>
    )
}

export default PostSnippet;