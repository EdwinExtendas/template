#!/bin/bash
# Choose which version of yarn you want to use
if [ "$1" != "" ]; then
    EXPECTED_YARN_VERSION="$1"
else
    EXPECTED_YARN_VERSION="1.16.0"
fi

# Choose wich version of node you want to use
if [ "$2" != "" ]; then
    EXPECTED_NODE_VERSION="$2"
else
    EXPECTED_NODE_VERSION="10.16.0"
fi

function install_node {
  mkdir -p .node
  NODE_DOWNLOAD_URL="https://nodejs.org/dist/v$EXPECTED_NODE_VERSION/node-v$EXPECTED_NODE_VERSION-linux-x64.tar.xz"
  echo "Downloading from $NODE_DOWNLOAD_URL"
  curl -fL $NODE_DOWNLOAD_URL > .node/node.tar.xz
  tar xvf .node/node.tar.xz  --strip-components=1 -C .node

  #put nodes path into current Shell PATH
  PATH="$(pwd)/.node/bin:$PATH"
}

function install_yarn {
  mkdir -p .yarn
  DOWNLOAD_URL="https://github.com/yarnpkg/yarn/releases/download/v$EXPECTED_YARN_VERSION/yarn-v$EXPECTED_YARN_VERSION.tar.gz"
  echo "Downloading from $DOWNLOAD_URL"
  curl -fL $DOWNLOAD_URL > .yarn/yarn.tar.gz
  tar zxf .yarn/yarn.tar.gz  --strip-components=1 -C .yarn
}

# Check if node already installed
if [ -f .node/bin/node ]; then
  echo "Node already installed"
else
  echo "The file .node/bin/node does not exist, installing node".
  install_node
fi

# Check if yarn already installed
if [ -f .yarn/bin/yarn ]; then
  echo "The yarn version is $YARN_VERSION, expected $EXPECTED_YARN_VERSION."
else
  echo "The file .yarn/bin/yarn does not exist, installing yarn".
  install_yarn
fi

# Install packages
./.yarn/bin/yarn install

# Build production build
./.yarn/bin/yarn build
