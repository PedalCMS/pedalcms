#!/usr/bin/env bash

set -euo pipefail

if [[ $# -ne 1 ]]; then
	echo "Usage: $0 <output-zip>" >&2
	exit 2
fi

OUTPUT_ZIP="$(realpath -m "$1")"
PLUGIN_MAIN="$(grep -lE '^[[:space:]]*\* Plugin Name:' ./*.php | head -n 1 || true)"

if [[ -z "${PLUGIN_MAIN}" ]]; then
	echo "Unable to detect plugin main file in repository root." >&2
	exit 1
fi

PLUGIN_MAIN="$(basename "${PLUGIN_MAIN}")"
PLUGIN_SLUG="${PLUGIN_MAIN%.php}"
BUILD_ROOT="$(mktemp -d)"
STAGE_DIR="${BUILD_ROOT}/${PLUGIN_SLUG}"

cleanup() {
	rm -rf "${BUILD_ROOT}"
}
trap cleanup EXIT

mkdir -p "${STAGE_DIR}" "$(dirname "${OUTPUT_ZIP}")"
git archive "${GITHUB_SHA:-HEAD}" | tar -x -C "${STAGE_DIR}"

if [[ -f package.json ]]; then
	shopt -s nullglob
	css_files=(assets/css/*.min.css)
	js_files=(assets/js/*.min.js)
	admin_js_files=(admin/js/*.min.js)

	if [[ ${#css_files[@]} -eq 0 || ${#js_files[@]} -eq 0 || ${#admin_js_files[@]} -eq 0 ]]; then
		echo "Compiled frontend assets are missing." >&2
		exit 1
	fi

	rm -rf "${STAGE_DIR}/assets/css" "${STAGE_DIR}/assets/js" "${STAGE_DIR}/admin/js"
	mkdir -p "${STAGE_DIR}/assets/css" "${STAGE_DIR}/assets/js" "${STAGE_DIR}/admin/js"
	cp "${css_files[@]}" "${STAGE_DIR}/assets/css/"
	cp "${js_files[@]}" "${STAGE_DIR}/assets/js/"
	cp "${admin_js_files[@]}" "${STAGE_DIR}/admin/js/"
	rm -rf "${STAGE_DIR}/assets/scss" "${STAGE_DIR}/assets/js/src" "${STAGE_DIR}/admin/js/src"
fi

if [[ -f composer.json ]]; then
	if [[ ! -d vendor ]]; then
		echo "Composer dependencies were not installed; vendor directory is missing." >&2
		exit 1
	fi

	rm -rf "${STAGE_DIR}/vendor"
	cp -R vendor "${STAGE_DIR}/vendor"
fi

rm -f \
	"${STAGE_DIR}/Makefile" \
	"${STAGE_DIR}/README.md" \
	"${STAGE_DIR}/composer.json" \
	"${STAGE_DIR}/.env.e2e.example" \
	"${STAGE_DIR}/playwright.config.js" \
	"${STAGE_DIR}/wpmu-config.xml"

rm -f "${OUTPUT_ZIP}"
(cd "${BUILD_ROOT}" && zip -rq "${OUTPUT_ZIP}" "${PLUGIN_SLUG}")
ZIP_ENTRIES="$(unzip -Z1 "${OUTPUT_ZIP}")"

if ! grep -qxF "${PLUGIN_SLUG}/${PLUGIN_MAIN}" <<< "${ZIP_ENTRIES}"; then
	echo "Zip does not contain expected plugin main file at ${PLUGIN_SLUG}/${PLUGIN_MAIN}." >&2
	exit 1
fi

for required_file in \
	"assets/css/base.min.css" \
	"assets/css/full.min.css" \
	"assets/css/global.min.css" \
	"assets/css/global-full.min.css" \
	"assets/css/terms-grid.min.css" \
	"assets/js/global.min.js" \
	"admin/js/pdl-acf.min.js" \
	"admin/js/pdl-conditional.min.js" \
	"vendor/autoload.php"; do
	if ! grep -qxF "${PLUGIN_SLUG}/${required_file}" <<< "${ZIP_ENTRIES}"; then
		echo "Zip is missing required runtime file ${required_file}." >&2
		exit 1
	fi
done

if grep -Eq "${PLUGIN_SLUG}/(tests/|node_modules/|\.github/|\.git/|\.cache/)" <<< "${ZIP_ENTRIES}"; then
	echo "Zip contains development-only files." >&2
	exit 1
fi

if grep -Eq "${PLUGIN_SLUG}/(assets/scss/|assets/js/src/|admin/js/src/)" <<< "${ZIP_ENTRIES}"; then
	echo "Zip contains source asset directories that should not ship in production." >&2
	exit 1
fi

if grep -Eq "${PLUGIN_SLUG}/(Makefile|README\.md|composer\.json|\.env\.e2e\.example|playwright\.config\.js|wpmu-config\.xml)$" <<< "${ZIP_ENTRIES}"; then
	echo "Zip contains non-runtime development files." >&2
	exit 1
fi

echo "Built and validated ${OUTPUT_ZIP}"
