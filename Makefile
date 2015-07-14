all: init test docs
init:
	# - Install dependencies via composer
test:
	# Run unit tests, code coverage, and linters
docs:
	# Generate your API documentation (you do have some, don't you?)
.PHONY: test docs