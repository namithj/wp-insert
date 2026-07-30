#!/usr/bin/env bash
#
# Writes a single version number into every version-bearing published file.
#
# Wp-Insert carries its version in three places that must never drift apart:
#   1. the plugin header in wp-insert.php  (what WordPress shows)
#   2. the WP_INSERT_VERSION constant      (used for asset cache-busting)
#   3. Stable tag in readme.txt            (what WordPress.org serves)
#
# There is no package.json — this plugin has no JavaScript build step.
#
# Usage: bin/set-version.sh <version>
#   <version> may be given as "2.6.0" or "v2.6.0"; a single leading "v" is
#   stripped and the normalized form is written everywhere.

set -euo pipefail

if [[ $# -ne 1 ]]; then
	echo "Usage: $0 <version>" >&2
	exit 2
fi

# Normalize: strip a single leading "v" (v2.6.0 -> 2.6.0).
VERSION="${1#v}"

if [[ ! "${VERSION}" =~ ^[0-9]+\.[0-9]+\.[0-9]+([-.][0-9A-Za-z.]+)?$ ]]; then
	echo "Invalid version '${1}'. Expected X.Y.Z (optionally with a suffix), e.g. 2.6.0 or v2.6.0." >&2
	exit 1
fi

# Resolve the repository root from this script's location so it works from anywhere.
REPO_ROOT="$(cd "$(dirname "${BASH_SOURCE[0]}")/.." && pwd)"
cd "${REPO_ROOT}"

PLUGIN_MAIN="$(grep -lE '^[[:space:]]*\* Plugin Name:' ./*.php | head -n 1 || true)"
if [[ -z "${PLUGIN_MAIN}" ]]; then
	echo "Unable to detect plugin main file in repository root." >&2
	exit 1
fi
PLUGIN_MAIN="$(basename "${PLUGIN_MAIN}")"

# apply <file> <sed-expression> <verify-grep-pattern>
# Runs the substitution, then fails loudly if the expected value is not present
# afterwards (guards against a pattern that silently matched nothing).
apply() {
	local file="$1" expr="$2" verify="$3"
	[[ -f "${file}" ]] || { echo "Expected file '${file}' not found." >&2; exit 1; }
	sed -i -E "${expr}" "${file}"
	if ! grep -qE "${verify}" "${file}"; then
		echo "Failed to set version in ${file} (pattern did not match)." >&2
		exit 1
	fi
	echo "  ${file} -> ${VERSION}"
}

echo "Setting version to ${VERSION}"

# Plugin header:  * Version: 2.6.0
apply "${PLUGIN_MAIN}" \
	"s/^([[:space:]]*\*[[:space:]]*Version:[[:space:]]*).*/\1${VERSION}/" \
	"^[[:space:]]*\*[[:space:]]*Version:[[:space:]]*${VERSION}[[:space:]]*$"

# Runtime constant:  define( 'WP_INSERT_VERSION', '2.6.0' );
apply "${PLUGIN_MAIN}" \
	"s/(define\\( 'WP_INSERT_VERSION', ')[^']*(' \\))/\\1${VERSION}\\2/" \
	"define\\( 'WP_INSERT_VERSION', '${VERSION}' \\)"

# WordPress readme:  Stable tag: 2.6.0
apply "readme.txt" \
	"s/^(Stable tag:[[:space:]]*).*/\1${VERSION}/" \
	"^Stable tag:[[:space:]]*${VERSION}[[:space:]]*$"

echo "Done."
