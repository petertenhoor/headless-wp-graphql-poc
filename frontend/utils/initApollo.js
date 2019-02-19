import {ApolloClient, InMemoryCache, HttpLink} from 'apollo-boost'
import fetch from "isomorphic-fetch";
import {Base64} from 'js-base64'

let apolloClient = null

function create(initialState) {
    // Check out https://github.com/zeit/next.js/pull/4611 if you want to use the AWSAppSyncClient
    return new ApolloClient({
        connectToDevTools: process.browser,
        ssrMode: !process.browser, // Disables forceFetch on the server (so queries are only run once)
        link: new HttpLink({
            fetch: customFetch,
            uri: "http://admin.petertenhoor.nl/graphql",
            credentials: 'same-origin'
        }),
        cache: new InMemoryCache({
            dataIdFromObject: obj => obj.id,
            addTypename: false,
            fragmentMatcher: {
                match: ({id}, typeCond, context) => !!context.store.get(id)
            }
        }).restore(initialState || {})
    })
}

/**
 * Custom fetch (add header for caching)
 *
 * @param uri
 * @param options
 * @returns {*}
 */
const customFetch = (uri, options) => {
    const cacheKey = Base64.encode(JSON.stringify(options.body))
    options.headers['x-graphql-cache'] = cacheKey
    return fetch(uri, options)
}

export default function initApollo(initialState) {
    // Make sure to create a new client for every server-side request so that data
    // isn't shared between connections (which would be bad)
    if (!process.browser) {
        return create(initialState)
    }

    // Reuse client on the client-side
    if (!apolloClient) {
        apolloClient = create(initialState)
    }

    return apolloClient
}