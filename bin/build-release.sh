#!/usr/bin/env bash
#
# Build a distributable Wp-Insert plugin archive from the current git HEAD.
#
# Uses `git archive`, so every path marked `export-ignore` in .gitattributes
# (tests, composer files, vendor, .vscode, CI config) is excluded automatically.
#
# Usage: bin/build-release.sh [output-dir]

set -euo pipefail

PLUGIN_SLUG="wp-insert"
ROOT="$( cd "$( dirname "${BASH_SOURCE[0]}" )/.." && pwd )"
OUT_DIR="${1:-${ROOT}/build}"

VERSION="$( grep -oP "^\s*\*\s*Version:\s*\K[0-9.]+" "${ROOT}/wp-insert.php" )"
README_TAG="$( grep -oP "^Stable tag:\s*\K[0-9.]+" "${ROOT}/readme.txt" )"

if [ "${VERSION}" != "${README_TAG}" ]; then
	echo "Version mismatch: plugin header ${VERSION} vs readme Stable tag ${README_TAG}" >&2
	exit 1
fi

mkdir -p "${OUT_DIR}"
ZIP_PATH="${OUT_DIR}/${PLUGIN_SLUG}-${VERSION}.zip"

git -C "${ROOT}" archive --format=zip --prefix="${PLUGIN_SLUG}/" -o "${ZIP_PATH}" HEAD

echo "Built ${ZIP_PATH}"
unzip -l "${ZIP_PATH}" | tail -1
