#!/usr/bin/env bash
set -xe
filename=$(realpath "${1:-webpaas.phar}")
if [ -z "$filename" ]; then
  echo >&2 "Usage: ./build.sh [filename] [version-ref]"
  exit 1
fi
version=$2
if [ -d cli ]; then
    rm -rf cli
fi
if [ -n "$version" ]; then
    git clone --branch "$version" https://github.com/platformsh/platformsh-cli.git cli
else
    git clone https://github.com/platformsh/platformsh-cli.git cli
    export version="$(git describe --tags)"
fi
cp config.yaml cli/config.yaml
cd cli/vendor-bin/box
composer install --no-interaction
cd -
cd cli
composer install --no-dev --no-interaction
mkdir -p vendor/bin
ln -s "$(realpath vendor-bin/box/vendor/bin/box)" vendor/bin/box
./bin/platform self:build --no-composer-rebuild --replace-version="$version" --yes --output "$filename"
