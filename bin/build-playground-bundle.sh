#!/usr/bin/env bash

set -euo pipefail

if [[ $# -ne 2 ]]; then
	echo "Usage: $0 <plugin-zip> <output-bundle>" >&2
	exit 2
fi

PLUGIN_ZIP="$(realpath -m "$1")"
OUTPUT_BUNDLE="$(realpath -m "$2")"
BUILD_ROOT="$(mktemp -d)"

cleanup() {
	rm -rf "${BUILD_ROOT}"
}
trap cleanup EXIT

if [[ ! -f "${PLUGIN_ZIP}" ]]; then
	echo "Plugin zip not found: ${PLUGIN_ZIP}" >&2
	exit 1
fi

if [[ ! -f .github/demo-content.xml ]]; then
	echo "Demo content not found: .github/demo-content.xml" >&2
	exit 1
fi

mkdir -p "$(dirname "${OUTPUT_BUNDLE}")"
cp "${PLUGIN_ZIP}" "${BUILD_ROOT}/pedalcms.zip"
cp .github/demo-content.xml "${BUILD_ROOT}/demo-content.xml"
node scripts/playground-blueprint.mjs bundle "${BUILD_ROOT}/blueprint.json"

rm -f "${OUTPUT_BUNDLE}"
(cd "${BUILD_ROOT}" && zip -rq "${OUTPUT_BUNDLE}" blueprint.json pedalcms.zip demo-content.xml)
ZIP_ENTRIES="$(unzip -Z1 "${OUTPUT_BUNDLE}")"

for required_file in blueprint.json pedalcms.zip demo-content.xml; do
	if ! grep -qxF "${required_file}" <<< "${ZIP_ENTRIES}"; then
		echo "Playground bundle is missing ${required_file}." >&2
		exit 1
	fi
done

echo "Built ${OUTPUT_BUNDLE}"
