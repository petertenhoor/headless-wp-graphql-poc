const express = require('express');
const {ApolloServer} = require('apollo-server-express');
const {HttpLink} = require('apollo-link-http');
const {introspectSchema, makeRemoteExecutableSchema} = require('graphql-tools');
const {InMemoryLRUCache} = require('apollo-server-caching');
const fetch = require('isomorphic-fetch');

const port = 4000
const app = express()
const wpHttpLink = new HttpLink({uri: 'http://admin.petertenhoor.nl/graphql', fetch});

const remoteSchema = introspectSchema(wpHttpLink).then((remoteSchema) => {
    const schema = makeRemoteExecutableSchema({schema: remoteSchema, link: wpHttpLink});
    const server = new ApolloServer({
        schema: schema,
        persistedQueries: {
            cache: new InMemoryLRUCache
        }
    });

    server.applyMiddleware({app});

    //Start server
    app.listen(port, () => {
        console.log(`Proxy is listening on port ${port}`);
    })
});
