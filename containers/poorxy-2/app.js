'use strict';

// Libraries
const url = require('url')
const dns = require('dns')
const path = require('path')
const http = require('http')
const https = require('https')
const priv = require('private-ip')
const express = require('express')
const validate = require('valid-url')
const { execSync } = require('child_process')

// Setup
const port = process.env.PORT || 5000
const host = '0.0.0.0'
const app = express()
app.set('view engine', 'ejs')

// Local IP
const local_ip = execSync('ip addr | grep "global eth0" | cut -d" " -f6 | cut -d/ -f1')

app.get('/', (req, res) => {
	var adr = req.query.url
	var agt = (typeof req.query.agt == 'undefined') ? 'Mozilla/5.0' : req.query.agt
	console.log(adr) // DEBUG

	if (typeof adr == 'undefined') {
		res.sendFile(path.join(__dirname, 'views/index.html'))
		return
	}
	// Conforms to RFC 3986
	if (validate.isHttpUri(adr) === validate.isHttpsUri(adr)) {
		res.render('error.ejs', {error: 'Provided address must be a valid HTTP(S) URL.'})
		return
	}

	try {
		var u = new url.URL(adr)
	} catch (e) {
		res.render('error.ejs', {error: e.toString()})
	}

	// Regular expressions for IPv4 and IPv6 (very safe)
	var reg4 = /^\s*((25[0-5]|2[0-4][0-9]|[01]?[0-9][0-9]?[0-9]?)\.(25[0-5]|2[0-4][0-9]|[01]?[0-9][0-9]?[0-9]?)\.(25[0-5]|2[0-4][0-9]|[01]?[0-9][0-9]?[0-9]?)\.(25[0-5]|2[0-4][0-9]|[01]?[0-9][0-9]?[0-9]?))\s*$/
	var reg6 = /^\s*((([0-9A-Fa-f]{1,4}:){7}([0-9A-Fa-f]{1,4}|:))|(([0-9A-Fa-f]{1,4}:){6}(:[0-9A-Fa-f]{1,4}|((25[0-5]|2[0-4]\d|1\d\d|[1-9]?\d)(\.(25[0-5]|2[0-4]\d|1\d\d|[1-9]?\d)){3})|:))|(([0-9A-Fa-f]{1,4}:){5}(((:[0-9A-Fa-f]{1,4}){1,2})|:((25[0-5]|2[0-4]\d|1\d\d|[1-9]?\d)(\.(25[0-5]|2[0-4]\d|1\d\d|[1-9]?\d)){3})|:))|(([0-9A-Fa-f]{1,4}:){4}(((:[0-9A-Fa-f]{1,4}){1,3})|((:[0-9A-Fa-f]{1,4})?:((25[0-5]|2[0-4]\d|1\d\d|[1-9]?\d)(\.(25[0-5]|2[0-4]\d|1\d\d|[1-9]?\d)){3}))|:))|(([0-9A-Fa-f]{1,4}:){3}(((:[0-9A-Fa-f]{1,4}){1,4})|((:[0-9A-Fa-f]{1,4}){0,2}:((25[0-5]|2[0-4]\d|1\d\d|[1-9]?\d)(\.(25[0-5]|2[0-4]\d|1\d\d|[1-9]?\d)){3}))|:))|(([0-9A-Fa-f]{1,4}:){2}(((:[0-9A-Fa-f]{1,4}){1,5})|((:[0-9A-Fa-f]{1,4}){0,3}:((25[0-5]|2[0-4]\d|1\d\d|[1-9]?\d)(\.(25[0-5]|2[0-4]\d|1\d\d|[1-9]?\d)){3}))|:))|(([0-9A-Fa-f]{1,4}:){1}(((:[0-9A-Fa-f]{1,4}){1,6})|((:[0-9A-Fa-f]{1,4}){0,4}:((25[0-5]|2[0-4]\d|1\d\d|[1-9]?\d)(\.(25[0-5]|2[0-4]\d|1\d\d|[1-9]?\d)){3}))|:))|(:(((:[0-9A-Fa-f]{1,4}){1,7})|((:[0-9A-Fa-f]{1,4}){0,5}:((25[0-5]|2[0-4]\d|1\d\d|[1-9]?\d)(\.(25[0-5]|2[0-4]\d|1\d\d|[1-9]?\d)){3}))|:)))(%.+)?\s*$/

	// Resolve hostname if needed and filter private addresses
	// Prevent accessing the 172.X.0.X:1337 internal server EVAR AGAIN!!!!1!
	var hostname = adr.split("/")[2].split(":")[0]
	console.log(hostname) // DEBUG

	if (hostname.match(reg4)) {
		if (priv(hostname)) {
			res.render('error.ejs', {error: 'Accessing internal addresses is disallowed.'})
			console.log(`HOST ${hostname} = ${priv(hostname)}`) // DEBUG
			return
		}
	} else if (hostname.match(reg6)) {
		res.render('error.ejs', {error: 'IPv6 is not supported.'})
		return
	} else {
		// Hostname is a registered domain name
		dns.lookup(hostname, {'family': 4}, (err, ip) => {
			if (err) {
				res.render('error.ejs', {error: 'Could not resolve hostname.'})
				return
			}
			if (priv(ip)) {
				res.render('error.ejs', {error: 'Accessing internal addresses is disallowed.'})
				console.log(`IP ${ip} = ${priv(ip)}`) // DEBUG
				return
			}
		})
	}

	try {
		// Set up connection to target
		var options = {
			port: u.port !== '' ? Number(u.port) : (u.protocol === 'http:' ? 80 : 443),
			host: hostname,
			method: 'GET',
			path: u.pathname,
			headers: {'User-Agent': agt},
			accept: 'image/*',
			timeout: 3000
		}
		console.log(options) // DEBUG
		var protocol = options.port === 443 ? https : http

		var request = protocol.request(options, (response) => {
			response.on('error', function(e) {
				res.render('error.ejs', {error: e.toString()})
			})

			// Mime type is an image
			console.log(response.headers) // DEBUG
			var ctype = response.headers['content-type']
			if (typeof ctype !== 'string' || !ctype.startsWith('image/')) {
				var ctype = "text/plain"
			}
			//i love regex
			if (!adr.match(/\.(jpg|jpeg|png|apng|bmp|tiff|gif)$/)) {
				res.render('error.ejs', {error: 'Target resource is not an image.'})
				return
			}

			// Read and serve file
			var offset = 0
			var length = parseInt(response.headers['content-length'], 10)
			var body = new Buffer(length)
			response.setEncoding('binary')
			response.on('data', (chunk) => {
				body.write(chunk, offset, 'binary')
				offset += chunk.length
			})
			response.on('end', () => {
				res.setHeader('content-type', ctype)
				res.send(body)
				res.end()
			})
		})
		request.on('timeout', () => {
			request.destroy()
		})
		request.on('error', (e) => {
			res.render('error.ejs', {error: 'Error while requesting remote content.'})
			console.log(e.toString()) // DEBUG
		})
		request.end()
	} catch(e) {
		res.render('error.ejs', {error: e.toString()})
	}
})

// DEBUG
app.get('/ip', (req, res) => {
	res.setHeader('content-type', 'text/plain')
	res.send(local_ip)
	res.end()
})

app.use('/.bzr', express.static(__dirname + '/.bzr', {dotfiles:'allow'}))

app.listen(port, host, () => console.log(`Running on ${host}:${port}`))
