-include .env
PLUGIN_NAME := nvis-program-pages
PLUGIN_ROOT := plugin
PLUGIN_VERSION := $$(grep "^ \* Version" $(PLUGIN_ROOT)/$(PLUGIN_NAME).php| awk -F' ' '{print $3}' | cut -d ":" -f2 | sed 's/ //g')
# ACF_LIC should be set in .env

# IMPORTANT: Make sure to list all .PHONY commands here.
.PHONY: install clean release docs setupenv getacf

install: | clean setupenv
	npm install

setupenv:
	@if [ ! -f .env  ]; then \
		echo "ACF_LIC=\"\"\n" >> .env; \
	fi
	@echo "Make sure your ACF Pro license key is configured as ACF_LIC in .env file."


getacf:
	@echo "Getting acf pro using license key: $(ACF_LIC)"
	rm -rf $(PLUGIN_ROOT)/src/acf
	wget -O $(PLUGIN_ROOT)/src/acf.zip "http://connect.advancedcustomfields.com/index.php?p=pro&a=download&k=$(ACF_LIC)"
	cd $(PLUGIN_ROOT)/src/ && unzip acf.zip
	cd $(PLUGIN_ROOT)/src/ && mv advanced-custom-fields-pro acf
	rm -rf $(PLUGIN_ROOT)/src/acf.zip

clean:
	rm -rf \
		$(PLUGIN_ROOT)/src/acf
		build
		node_modules
		package-lock.json
		*.cache
		docs
		.phpdoc

release: getacf
	@echo "Building release file: $(PLUGIN_NAME).$(PLUGIN_VERSION).zip"
	rm -rf $(PLUGIN_NAME).$(PLUGIN_VERSION).zip
	rm -rf build
	mkdir build
	cp -av $(PLUGIN_ROOT) build
	mv build/$(PLUGIN_ROOT) build/$(PLUGIN_NAME)
	PLUGIN_VERSION=$(PLUGIN_VERSION) && cd build && zip -r $(PLUGIN_NAME).$$PLUGIN_VERSION.zip *
	rm -rf build/$(PLUGIN_NAME)
	@if [ ! -f build/$(PLUGIN_NAME).$(PLUGIN_VERSION).zip  ]; then \
		echo "\n\n\033[0;31mPlugin file not found. Something went wrong.\033[0m\n\n"; \
		exit 1; \
	fi
	@echo "\n\n\033[92mRelease file built successfully. Check the build directory.\033[0m\n\n"

docs:
	@echo "\nBuilding code docs...\n"
	rm -rf docs
	phpdoc
	@if [ ! -f docs/index.html  ]; then \
		echo "\n\n\033[0;31mPHPDocumentor failed. Check the output.\033[0m\n\n"; \
		exit 1; \
	fi
	@echo "\n\n\033[92mDocs built successfully. Check the docs directory.\033[0m\n\n"
