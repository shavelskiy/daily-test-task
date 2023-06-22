FROM node:16.14-alpine

RUN mkdir -p /application
WORKDIR /application

COPY . /application

RUN npm install
RUN npm run build

EXPOSE 3000
CMD [ "npm", "run", "start" ]
