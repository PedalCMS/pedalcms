-include .env
# ACF_LIC should be set in .env
BIN := ./node_modules/.bin
PLUGIN_NAME := nvis-program-pages
PLUGIN_ROOT := plugin
PLUGIN_VERSION := $$(grep "^ \* Version" $(PLUGIN_ROOT)/$(PLUGIN_NAME).php| awk -F' ' '{print $3}' | cut -d ":" -f2 | sed 's/ //g')
INCLUDES_DIR := $(PLUGIN_ROOT)/src
ASSETS_DIR := $(PLUGIN_ROOT)/assets
SASS_DIR := $(ASSETS_DIR)/scss
CSS_DIR := $(ASSETS_DIR)/css
JS_SRC_DIR := $(ASSETS_DIR)/js/src
JS_OUT_DIR := $(ASSETS_DIR)/js

GREEN := \033[92m
RED := \033[0;31m
COLOR_END := \033[0m

# ----------------------------------------------------------------------------
# BEGIN: Front End Assets
# ----------------------------------------------------------------------------

CSS_SOURCE_MAP :=
JS_SOURCE_MAP := --source-maps=true

.PHONY: production
production: | prodprep build-css build-js
	@echo "\nAll done!\n"

.PHONY: prodprep
prodprep: | clean-assets
	$(eval CSS_SOURCE_MAP := --no-source-map)
	$(eval JS_SOURCE_MAP := --source-maps=false)

.PHONY: clean-assets
clean-assets:
	@echo "\n🗑  Cleaning up asset output directories ..."
	@rm -rf $(CSS_DIR)/*.* && \
	rm -rf $(JS_OUT_DIR)/*.* && \
	echo "Done."

.PHONY: assets
assets: | build-css build-js

.PHONY: lint
lint: | lint-css lint-js

.PHONY: lint-css
lint-css:
	$(call LINT_CSS,$(SASS_DIR))

.PHONY: lint-js
lint-js:
	$(call LINT_JS,$(JS_SRC_DIR)/*.js)

JS_SRC = $(wildcard $(JS_SRC_DIR)/*.js)
JS_OUT = $(JS_SRC:$(JS_SRC_DIR)/%.js=$(JS_OUT_DIR)/%.min.js)

.PHONY: build-js
build-js: $(JS_OUT)

$(JS_OUT_DIR)/%.min.js: $(JS_SRC_DIR)/%.js package.json
	$(call LINT_JS,$<)
	@echo "Compiling $< ..."
	@$(BIN)/babel $< -o $@ --minified --no-comments $(JS_SOURCE_MAP) && echo "$(GREEN)Compiled $@$(COLOR_END)"

SASS_VARS := $(SASS_DIR)/common/_variables.scss
SASS = $(wildcard $(SASS_DIR)/*.scss)
CSS = $(SASS:$(SASS_DIR)/%.scss=$(CSS_DIR)/%.min.css)

.PHONY: build-css
build-css: $(CSS)

.SECONDEXPANSION:
$(CSS_DIR)/%.min.css: $(SASS_DIR)/%.scss $$(wildcard $(SASS_DIR)/%/*.scss) $(SASS_VARS)
	$(call LINT_CSS,$?)
	@echo "Compiling $<..."
	@$(BIN)/sass --update $(CSS_SOURCE_MAP) $<:$@ --style compressed


define LINT_CSS
@echo "\nLinting:";
@IFS=' ' read -r -a FILES <<< "$1"; \
for FILE in "$${FILES[@]}"; do \
	echo "$$FILE"; \
done;
@$(BIN)/stylelint $1 --fix && $(call CONGRATULATE_MSG,No CSS issues detected.) || true;
endef

define LINT_JS
@echo "\nLinting ...";
@IFS=' ' read -r -a FILES <<< "$1"; \
for FILE in "$${FILES[@]}"; do \
	echo "$$FILE"; \
done;
@$(BIN)/eslint $1 --fix && $(call CONGRATULATE_MSG,No JS issues detected.) || true;
endef

define CONGRATULATE_MSG
(EMOJIS=(🎉 🙌 😃 🎊 🥳 👏 ✊ 🤘 👍 😁 🤩 😎 🍾) && \
INDEX=$$(($$RANDOM % $${#EMOJIS[@]})) && \
EMOJI=$${EMOJIS[$$INDEX]} && \
EXCLAIMS=('Yay' 'Congrats' 'Hooray' 'Well done' 'Nice' 'Good job' 'Dope' 'Way to go' 'Awesome' 'Fantastic' 'Amazing' 'Boom' 'Wonderful' 'Super' 'Excellent' 'You rock') && \
INDEX=$$(($$RANDOM % $${#EXCLAIMS[@]})) && \
EXCLAIM=$${EXCLAIMS[$$INDEX]} && \
echo "$(GREEN)$$EMOJI $1 $$EXCLAIM!$(COLOR_END)\n")
endef

# ----------------------------------------------------------------------------
# BEGIN: Commands
# ----------------------------------------------------------------------------
.PHONY: help
help:
	@echo "Please view the Makefile for instructions."

.PHONY: watch
watch:
	@which fswatch > /dev/null || (echo "$(RED)⚠️  ERROR: Command 'fswatch' not found. Make sure it is installed and in your system path.$(COLOR_END)\n" && exit 1;)
	@clear;
	@$(MAKE) assets;
	@echo "\n🔎 Watching assets for changes … \n"
	@echo "[To $(RED)STOP$(COLOR_END), double-press $(GREEN)CTRL-C$(COLOR_END)]\n"
	@while true; do \
		fswatch -1 $(ASSETS_DIR) | xargs echo '{}' > /dev/null && $(MAKE) assets; \
		sleep 1; \
	done

.PHONY: install
install: | clean setupenv
	npm install

.PHONY: setupenv
setupenv:
	@if [ ! -f .env  ]; then \
		echo "ACF_LIC=\"\"\n" >> .env; \
	fi
	@echo "📝 Make sure your ACF Pro license key is configured as ACF_LIC in .env file."

.PHONY: getacf
getacf:
	@echo "Downloading ACF Pro using license key: $(ACF_LIC)"
	rm -rf $(INCLUDES_DIR)/acf
	wget -O $(INCLUDES_DIR)/acf.zip "http://connect.advancedcustomfields.com/index.php?p=pro&a=download&k=$(ACF_LIC)"
	cd $(INCLUDES_DIR)/ && unzip acf.zip
	cd $(INCLUDES_DIR)/ && mv advanced-custom-fields-pro acf
	rm -rf $(INCLUDES_DIR)/acf.zip

.PHONY: clean
clean:
	rm -rf \
		$(INCLUDES_DIR)/acf \
		build \
		node_modules \
		package-lock.json \
		*.cache \
		docs \
		.phpdoc \

.PHONY: release
release: getacf
	@echo "Building release file: $(PLUGIN_NAME).$(PLUGIN_VERSION).zip"
	rm -rf $(PLUGIN_NAME).$(PLUGIN_VERSION).zip
	rm -rf build
	mkdir build
	cp -av $(PLUGIN_ROOT) build
	rm -rf build/$(SASS_DIR)
	mv build/$(PLUGIN_ROOT) build/$(PLUGIN_NAME)
	PLUGIN_VERSION=$(PLUGIN_VERSION) && cd build && zip -r $(PLUGIN_NAME).$$PLUGIN_VERSION.zip *
	rm -rf build/$(PLUGIN_NAME)
	@if [ ! -f build/$(PLUGIN_NAME).$(PLUGIN_VERSION).zip  ]; then \
		echo "\n\n$(RED)🙁 Plugin file not found. Something went wrong.$(COLOR_END)\n\n"; \
		exit 1; \
	fi
	@echo "\n\n$(GREEN)🚀 Release file built successfully! Check the 'build' directory.$(COLOR_END)\n\n"

.PHONY: docs
docs:
	@echo "\nBuilding code docs...\n"
	rm -rf docs
	phpdoc
	@if [ ! -f docs/index.html  ]; then \
		echo "\n\n$(RED)🙁 PHPDocumentor failed. Check the output.$(COLOR_END)\n\n"; \
		exit 1; \
	fi
	@echo "\n\n$(GREEN)📔 Docs built successfully!  Check the 'docs' directory.$(COLOR_END)\n\n"
