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

GREEN := \033[92m
RED := \033[0;31m
COLOR_END := \033[0m

# ----------------------------------------------------------------------------
# BEGIN: Front End Assets
# ----------------------------------------------------------------------------
.PHONY: production
production: | prodprep lint-css css

.PHONY: prodvars
prodprep:
	@echo "\nCleaning up CSS directory …"
	@rm -rf $(CSS_DIR)/*.*
	$(eval SOURCE_MAP := --no-source-map)

.PHONY: css
css: | $(CSS_DIR)/global.min.css $(CSS_DIR)/base.min.css $(CSS_DIR)/global-full.min.css $(CSS_DIR)/full.min.css

.PHONY: lint-css
lint-css:
	@echo "Linting SCSS files …"
	@$(BIN)/stylelint $(SASS_DIR)/* --fix && echo "$(GREEN)🎉 No issues detected. Congrats!$(COLOR_END)" || true

SASS_VARS := $(SASS_DIR)/_variables.scss

define COMPILE_SASS
@echo "Compiling $@...";
@$(BIN)/sass --update $(SOURCE_MAP) $1:$2 --style compressed;
endef

$(CSS_DIR)/global.min.css: $(SASS_DIR)/global.scss $(SASS_DIR)/global/*.scss $(SASS_VARS)
	$(call COMPILE_SASS,$<,$@)

$(CSS_DIR)/base.min.css: $(SASS_DIR)/base.scss $(SASS_DIR)/base/*.scss $(SASS_VARS)
	$(call COMPILE_SASS,$<,$@)

$(CSS_DIR)/global-full.min.css: $(SASS_DIR)/global-full.scss $(SASS_DIR)/global-full/*.scss $(SASS_VARS)
	$(call COMPILE_SASS,$<,$@)

$(CSS_DIR)/full.min.css: $(SASS_DIR)/full.scss $(SASS_DIR)/full/*.scss $(SASS_VARS)
	$(call COMPILE_SASS,$<,$@)

# ----------------------------------------------------------------------------
# BEGIN: Commands
# ----------------------------------------------------------------------------
.PHONY: help
help:
	@echo "Please view the Makefile for instructions."

.PHONY: watch
watch:
	@echo "Watching assets for changes … \n"
	@while true; do $(MAKE) -q || $(MAKE); sleep 1; done

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
