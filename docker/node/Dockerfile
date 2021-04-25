FROM node:lts

ARG DEBIAN_FRONTEND=noninteractive

# Install Libs
RUN apt-get update && apt-get install -y --no-install-recommends \
    apt-utils build-essential git curl zip openssl openssh-server ssh vim && \
    apt-get -y autoremove && apt-get -y clean && \
    rm -rf /var/lib/apt/lists/* /tmp/* /var/tmp/*

WORKDIR /usr/src/app

COPY package*.json ./
COPY server.js ./

RUN npm install

EXPOSE 8080
CMD [ "node", "server.js" ]
