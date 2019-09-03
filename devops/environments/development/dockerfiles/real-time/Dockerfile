FROM node:8.11.4
WORKDIR /app
COPY package.json /app
RUN npm install
EXPOSE 6001

ENTRYPOINT ["/app/node_modules/.bin/laravel-echo-server", "start"]
