# If the first argument is "format_check"...
ifeq (format_check,$(firstword $(MAKECMDGOALS)))
  # use the rest as arguments for "format_check"
  RUN_ARGS := $(wordlist 2,$(words $(MAKECMDGOALS)),$(MAKECMDGOALS))
  # ...and turn them into do-nothing targets
  $(eval $(RUN_ARGS):;@:)
endif

# If the first argument is "format_fix"...
ifeq (format_fix,$(firstword $(MAKECMDGOALS)))
  # use the rest as arguments for "format_fix"
  RUN_ARGS := $(wordlist 2,$(words $(MAKECMDGOALS)),$(MAKECMDGOALS))
  # ...and turn them into do-nothing targets
  $(eval $(RUN_ARGS):;@:)
endif

format_check:
	@./vendor/bin/phpcs --standard=./tests/CI/phpcs.xml -n $(RUN_ARGS)

format_fix:
	@./vendor/bin/phpcbf --standard=./tests/CI/phpcs.xml $(RUN_ARGS)