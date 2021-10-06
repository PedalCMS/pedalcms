PLUGIN_NAME := nvis-program-pages
PLUGIN_VERSION := $$(grep "^ \* Version" plugin/$(PLUGIN_NAME).php| awk -F' ' '{print $3}' | cut -d ":" -f2 | sed 's/ //g')

.PHONY: install
install: | clean
	npm install

.PHONY: clean
clean:
	rm -rf \
		build
		node_modules
		package-lock.json
		*.cache
		.phpdoc

.PHONY: release
release:
	@echo "Building release file: $(PLUGIN_NAME).$(PLUGIN_VERSION).zip"
	rm -rf $(PLUGIN_NAME).$(PLUGIN_VERSION).zip
	rm -rf build
	mkdir build
	cp -av plugin build
	mv build/plugin build/$(PLUGIN_NAME)
	PLUGIN_VERSION=$(PLUGIN_VERSION) && cd build && zip -r $(PLUGIN_NAME).$$PLUGIN_VERSION.zip *
	mv build/$(PLUGIN_NAME).$(PLUGIN_VERSION).zip ./
	if [ ! -f ./$(PLUGIN_NAME).$(PLUGIN_VERSION).zip  ]; then \
		echo "file not available"; \
		exit 1; \
	fi

.PHONY: docs
docs:
	@echo "\nBuilding code docs. Output will be saved to ./docs\n"
	phpdoc -d ./plugin -t ./docs/
