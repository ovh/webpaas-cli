#!/usr/bin/env bash
set -xe
filename=$(realpath "${1:-webpaas.phar}")
if [ -z "$filename" ]; then
  echo >&2 "Usage: ./build.sh [filename] [version-ref]"
  exit 1
fi
tag="$(cat latest-tag)"
tag=${2:-"$tag"}
if [ -d cli ]; then
    rm -rf cli
fi
git clone --branch "$tag" https://github.com/platformsh/platformsh-cli.git cli
cp config.yaml cli/config.yaml
cd cli/vendor-bin/box
composer install --no-interaction
cd -
cd cli
export version="$(git describe --tags)"
composer install --no-dev --no-interaction
mkdir -p vendor/bin
ln -s "$(realpath vendor-bin/box/vendor/bin/box)" vendor/bin/box
./bin/platform self:build --no-composer-rebuild --replace-version="$version" --yes --output "$filename"
