# wp-graphql-test
Proof of concept for headless WordPress using the wp-graphql plugin, apollo-client and next.js. Spent about 20 hours on this little hackathon.

## What can it do?

- Displays WordPress pages
- Displays WordPress posts
- Displays the main navigation
- Has SSR caching
- Caches Graphql requests in the WP object cache

## Concluding

Headless WordPress using wp-graphql works fine, but it's not fast enough in all scenarios.

Even with a few caching layers the WordPress installation always loads the WP core, theme code and plugin code before serving data. These are the average load duration in each scenario:

- Serverside request uncached: 100ms
- Serverside request cached: 5ms (with lru-cache)
- Clientside request uncached: 400-800ms (with Redis Object cache) 
- Clientsidee requests second visit: 5ms (with apollo-client cache)

My next approach for headless WordPress will either be with a static site builder like Gatsby.js or using the REST API with an express API between client and server that acts as caching layer.