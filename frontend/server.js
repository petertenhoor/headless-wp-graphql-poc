const express = require('express')
const next = require('next')
const compression = require("compression")
const cors = require('cors')
const LRUCache = require('lru-cache');

const server = express()
const dev = process.env.NODE_ENV !== 'production'
const app = next({dir: '.', dev})
const handle = app.getRequestHandler()
const port = process.argv[2] ? process.argv[2] : 3000

//set up SSR cache for 30 days with max amount of items to infinity
const ssrCache = new LRUCache({
    max: 0,
    maxAge: 1000 * 60 * 60 * 24 * 30
})

app.prepare().then(() => {
    //use compression
    server.use(compression({threshold: 0}))

    //use cors
    server.use(cors())

    server.get('/_next/*', (req, res) => {
        /* serving _next static content using next.js handler */
        handle(req, res);
    })

    server.get('/posts', (req, res) => {
        if (dev) {
            handle(req, res)
        } else {
            return renderAndCache(req, res)
        }
    })

    //add cache flush endpoint
    server.post('/flush-ssr-cache', (req, res) => {
        const amountOfItemsInCache = ssrCache.length
        ssrCache.reset()
        const newAmountOfItemsInCache = ssrCache.length
        if (newAmountOfItemsInCache === 0) {
            console.log(`Successfully flushed ${amountOfItemsInCache} items from cache.`)
            res.status(200).send(`Successfully flushed ${amountOfItemsInCache} items from cache.`);
        } else {
            console.log(`Failed flushing ${amountOfItemsInCache} items from cache. There are still ${newAmountOfItemsInCache} in there.`)
            res.status(500).send(`Failed flushing ${amountOfItemsInCache} items from cache. There are still ${newAmountOfItemsInCache} in there.`);
        }
    })

    //add post route
    server.get('/post/:slug/', (req, res) => {
        if (dev) {
            app.render(req, res, '/post', {slug: req.params.slug})
        } else {
            return renderAndCacheDynamic(req, res, '/post', {slug: req.params.slug})
        }
    })

    //add page route
    server.get('/:slug/', (req, res) => {
        if (dev) {
            app.render(req, res, '/page', {slug: req.params.slug})
        } else {
            return renderAndCacheDynamic(req, res, '/page', {slug: req.params.slug})
        }
    })

    //let regular next handler handle all other requests
    server.get('*', (req, res) => {
        if (dev) {
            handle(req, res)
        } else {
            return renderAndCache(req, res)
        }
    })
})

//Start server
server.listen(port, (err) => {
    if (err) throw err
    //clear cache
    ssrCache.reset()
    console.log(`> Ready on http://localhost:${port}`)
})

/*
 * NB: make sure to modify this to take into account anything that should trigger
 * an immediate page change (e.g a locale stored in req.session)
 */
function getCacheKey(req) {
    return `${req.path}`
}

/**
 * Render and cache simple route
 *
 * @param req
 * @param res
 * @returns {Promise<void>}
 */
async function renderAndCache(req, res) {
    const key = getCacheKey(req);

    // If we have a page in the cache, let's serve it
    if (ssrCache.has(key)) {
        //console.log(`serving from cache ${key}`);
        res.setHeader('x-cache', 'HIT');
        res.send(ssrCache.get(key));
        return
    }

    try {
        //console.log(`key ${key} not found, rendering`);
        // If not let's render the page into HTML
        const html = await app.renderToHTML(req, res, req.path, req.query);

        // Something is wrong with the request, let's skip the cache
        if (res.statusCode !== 200) {
            res.send(html);
            return
        }

        // Let's cache this page
        ssrCache.set(key, html);

        res.setHeader('x-cache', 'MISS');
        res.send(html)
    } catch (err) {
        app.renderError(err, req, res, req.path, req.query)
    }
}

/**
 * Handle and cache dynamic route
 *
 * @param req
 * @param res
 * @param path
 * @param query
 * @returns {Promise<void>}
 */
async function renderAndCacheDynamic(req, res, path, query) {
    const key = getCacheKey(req);

    // If we have a page in the cache, let's serve it
    if (ssrCache.has(key)) {
        //console.log(`serving from cache ${key}`);
        res.setHeader('x-cache', 'HIT');
        res.send(ssrCache.get(key));
        return
    }

    try {
        //console.log(`key ${key} not found, rendering`);
        // If not let's render the page into HTML
        const html = await app.renderToHTML(req, res, path, query);

        // Something is wrong with the request, let's skip the cache
        if (res.statusCode !== 200) {
            res.send(html);
            return
        }

        // Let's cache this page
        ssrCache.set(key, html);

        res.setHeader('x-cache', 'MISS');
        res.send(html)
    } catch (err) {
        app.renderError(err, req, res, path, query)
    }
}