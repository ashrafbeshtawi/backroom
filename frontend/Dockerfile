FROM node:14-alpine

# Create app directory
RUN mkdir -p /app
WORKDIR /app

# update and install dependency
RUN apk update && apk upgrade
RUN apk add git

# Install dependencies
COPY . /app/
RUN npm install
RUN npm run build

# Build the Nuxt.js application
CMD [ "npm", "start" ]
