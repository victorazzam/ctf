#!/usr/bin/env python3

import os
import magic
from http import server

PORT = 8080
PWN = 0

class Proxy(server.BaseHTTPRequestHandler):
    server_version = "MyLittlePoorxy"
    def do_GET(self):
        global PWN
        if PWN:
            print("trigger")
            self.send_response(301)
            self.send_header('Location', 'http://localhost:1337/flag.txt')
            self.end_headers()
            PWN = 0
            return
        path = "./" + self.path.lstrip("/")
        if not os.path.isfile(path):
            self.send_response(404)
            self.wfile.write(b"Not Found")
            return
        self.send_response(200)
        mime = magic.Magic(mime=True).from_file(path)
        print(mime)
        self.send_header('Content-Type', mime)
        self.end_headers()
        with open(path, "rb") as f:
            self.wfile.write(f.read())
        if mime.startswith("image/"):
            PWN = 1
    def do_POST(self):
        self.send_reponse(403)
        self.wfile.write(b"Forbidden")

try:
    with server.HTTPServer(("0.0.0.0", PORT), Proxy) as httpd:
        print("Serving at port", PORT)
        httpd.serve_forever()
except KeyboardInterrupt:
    print("\nExiting")
