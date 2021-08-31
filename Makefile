PLUGIN_NAME := nvis-program-pages
PLUGIN_VERSION := $$(grep "^ \* Version" src/$(PLUGIN_NAME).php| awk -F' ' '{print $3}' | cut -d ":" -f2 | sed 's/ //g')

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

.PHONY: release
release:
	@echo "Building release file: $(PLUGIN_NAME).$(PLUGIN_VERSION).zip"
	rm -rf $(PLUGIN_NAME).$(PLUGIN_VERSION).zip
	rm -rf build
	mkdir build
	cp -av src build
	mv build/src build/$(PLUGIN_NAME)
	PLUGIN_VERSION=$(PLUGIN_VERSION) && cd build && zip -r $(PLUGIN_NAME).$$PLUGIN_VERSION.zip *
	mv build/$(PLUGIN_NAME).$(PLUGIN_VERSION).zip ./
	if [ ! -f ./$(PLUGIN_NAME).$(PLUGIN_VERSION).zip  ]; then \
		echo "file not available"; \
		exit 1; \
	fi
