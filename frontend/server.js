const express = require('express')
const next = require('next')
const compression = require("compression")

const server = express()
const dev = process.env.NODE_ENV !== 'production'
const app = next({dir: '.', dev})
const handle = app.getRequestHandler()
const port = process.argv[2] ? process.argv[2] : 1337

app.prepare().then(() => {
    //use compression and helmet
    server.use(compression({threshold: 0}))

    server.get('/posts/:slug', (req, res) => {
        app.render(req, res, '/post', {slug: req.params.slug})
    })

    //let regular next handler handle all other requests
    server.get('*', (req, res) => handle(req, res))
})

//Start server
server.listen(port, (err) => {
    if (err) throw err
    console.log(`> Ready on http://localhost:${port}`)
})