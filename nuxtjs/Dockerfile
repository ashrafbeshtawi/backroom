FROM node:21-alpine

# Create app directory
RUN mkdir -p /nuxtjs
WORKDIR /nuxtjs

# update and install dependency
RUN apk update && apk upgrade
RUN apk add git

# Install dependencies
COPY . /nuxtjs/
RUN npm install

# Build the Nuxt.js application
CMD [ "npm", "run", "dev" ]
