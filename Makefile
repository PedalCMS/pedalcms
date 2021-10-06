PLUGIN_NAME := nvis-program-pages
PLUGIN_VERSION := $$(grep "^ \* Version" plugin/$(PLUGIN_NAME).php| awk -F' ' '{print $3}' | cut -d ":" -f2 | sed 's/ //g')

# IMPORTANT: Make sure to list all .PHONY commands here.
.PHONY: install clean release docs

install: | clean
	npm install

clean:
	rm -rf \
		build
		node_modules
		package-lock.json
		*.cache
		docs
		.phpdoc

release:
	@echo "Building release file: $(PLUGIN_NAME).$(PLUGIN_VERSION).zip"
	rm -rf $(PLUGIN_NAME).$(PLUGIN_VERSION).zip
	rm -rf build
	mkdir build
	cp -av plugin build
	mv build/plugin build/$(PLUGIN_NAME)
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
	phpdoc -d ./plugin -t ./docs/
	@if [ ! -f docs/index.html  ]; then \
		echo "\n\n\033[0;31mPHPDocumentor failed. Check the output.\033[0m\n\n"; \
		exit 1; \
	fi
	@echo "\n\n\033[92mDocs built successfully. Check the docs directory.\033[0m\n\n"
