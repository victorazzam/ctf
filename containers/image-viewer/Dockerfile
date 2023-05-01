# docker build --rm -t image-viewer:latest . --no-cache
# docker run -d -it --rm -p 80:8080/tcp --name image-viewer-active image-viewer

FROM php:7.4-cli
COPY ./app /app
WORKDIR /app/public
CMD [ "php", "-S", "0.0.0.0:8080" ]
