#!/usr/bin/env bash

# Writes a single version number into every version-bearing published file in
# the plugin. The plugin header in the main PHP file is the canonical version;
# this script keeps the runtime constant, package.json and readme.txt in lockstep
# with it. Per-file @version/@since docblocks are intentionally left untouched.
#
# Usage: bin/set-version.sh <version>
#   <version> may be given as "0.4.0" or "v0.4.0"; a single leading "v" is
#   stripped and the normalized "0.4.0" form is written everywhere.

set -euo pipefail

if [[ $# -ne 1 ]]; then
	echo "Usage: $0 <version>" >&2
	exit 2
fi

# Normalize: strip a single leading "v" (v0.4.0 -> 0.4.0).
VERSION="${1#v}"

if [[ ! "${VERSION}" =~ ^[0-9]+\.[0-9]+\.[0-9]+([-.][0-9A-Za-z.]+)?$ ]]; then
	echo "Invalid version '${1}'. Expected X.Y.Z (optionally with a suffix), e.g. 0.4.0 or v0.4.0." >&2
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

# Plugin header:  * Version: 0.4.0
apply "${PLUGIN_MAIN}" \
	"s/^([[:space:]]*\*[[:space:]]*Version:[[:space:]]*).*/\1${VERSION}/" \
	"^[[:space:]]*\*[[:space:]]*Version:[[:space:]]*${VERSION}[[:space:]]*$"

# Runtime constant:  define( 'PEDALCMS_VERSION', '0.4.0' );
apply "${PLUGIN_MAIN}" \
	"s/(define\\( 'PEDALCMS_VERSION', ')[^']*(' \\))/\\1${VERSION}\\2/" \
	"define\\( 'PEDALCMS_VERSION', '${VERSION}' \\)"

# WordPress readme:  Stable tag: 0.4.0
apply "readme.txt" \
	"s/^(Stable tag:[[:space:]]*).*/\1${VERSION}/" \
	"^Stable tag:[[:space:]]*${VERSION}[[:space:]]*$"

# npm manifest:  "version": "0.4.0"  (first, top-level occurrence only)
apply "package.json" \
	"0,/\"version\":/ s/(\"version\":[[:space:]]*\")[^\"]*(\")/\\1${VERSION}\\2/" \
	"\"version\":[[:space:]]*\"${VERSION}\""

echo "Done."
