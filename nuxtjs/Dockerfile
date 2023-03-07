FROM node:11.13.0-alpine

# Create app directory
RUN mkdir -p /frontend
WORKDIR /frontend

# update and install dependency
RUN apk update && apk upgrade
RUN apk add git

# Install dependencies
COPY . /frontend/
RUN npm install

# Build the Nuxt.js application
CMD [ "npm", "run", "dev" ]
