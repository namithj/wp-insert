#!/usr/bin/env bash
#
# Download a WordPress core checkout for the PHPUnit suite to run against.
#
# The wp-phpunit package ships the core *test library* but not WordPress itself,
# so CI needs a core checkout to point WP_TESTS_ABSPATH at. Locally this is not
# needed: the plugin already lives inside a WordPress install and the test config
# defaults to it.
#
# Usage: bin/install-wp-core.sh [version] [destination]
#   version      WordPress version to fetch, or "latest" (default: latest).
#   destination  Where to unpack it (default: ${RUNNER_TEMP:-/tmp}/wordpress).
#
# Prints the resulting ABSPATH on stdout.

set -euo pipefail

VERSION="${1:-latest}"
DEST="${2:-${RUNNER_TEMP:-/tmp}/wordpress}"

if [[ "${VERSION}" == "latest" ]]; then
	ARCHIVE_URL="https://wordpress.org/latest.tar.gz"
else
	ARCHIVE_URL="https://wordpress.org/wordpress-${VERSION}.tar.gz"
fi

if [[ -f "${DEST}/wp-settings.php" ]]; then
	echo "WordPress already present at ${DEST}" >&2
	echo "${DEST}"
	exit 0
fi

TMP_DIR="$(mktemp -d)"
trap 'rm -rf "${TMP_DIR}"' EXIT

echo "Downloading ${ARCHIVE_URL}" >&2
curl -fsSL "${ARCHIVE_URL}" -o "${TMP_DIR}/wordpress.tar.gz"

mkdir -p "${DEST}"
# The archive contains a top-level wordpress/ directory; strip it.
tar -xzf "${TMP_DIR}/wordpress.tar.gz" -C "${DEST}" --strip-components=1

if [[ ! -f "${DEST}/wp-settings.php" ]]; then
	echo "Extraction failed: no wp-settings.php in ${DEST}" >&2
	exit 1
fi

echo "WordPress core ready at ${DEST}" >&2
echo "${DEST}"
