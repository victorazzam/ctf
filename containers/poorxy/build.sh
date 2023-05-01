#!/bin/sh

docker build --rm -t poorxy1 . && \
 docker run -d -it --rm -p 8000:8080 --name poorxy1-active poorxy1
