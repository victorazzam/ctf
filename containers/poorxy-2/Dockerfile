# https://nodejs.org/en/docs/guides/nodejs-docker-webapp
# https://docs.docker.com/language/nodejs/build-images
# https://learnk8s.io/blog/smaller-docker-images

# docker build --rm -t poorxy2 .
# docker run -d -it --rm -p 80:80 --name poorxy2-active poorxy2

FROM alpine:latest

# Work in challenge directory
WORKDIR /app
COPY . ./

# Install dependencies
ENV NODE_ENV=production
ENV PORT=80
RUN apk update && apk add --update --no-cache python3 npm && npm install --production

# Expose port for node
EXPOSE 80

# Run the node app
CMD ["sh","-c","node app.js & (cd public; python3 -m http.server -b 127.0.0.1 1337)"]

# Configure a healthcheck to validate that everything is up and running
HEALTHCHECK --timeout=10s CMD curl --silent --fail http://127.0.0.1 || exit 1
