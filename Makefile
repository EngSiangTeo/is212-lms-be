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

MYSQL_USERNAME = homestead
MYSQL_PASSWORD = secret

define create_db
  @mysql -u $(MYSQL_USERNAME) -p$(MYSQL_PASSWORD) --execute="CREATE USER IF NOT EXISTS 'forge'@'localhost';"
  @mysql -u $(MYSQL_USERNAME) -p$(MYSQL_PASSWORD) --execute="CREATE DATABASE IF NOT EXISTS $1;"
  @mysql -u $(MYSQL_USERNAME) -p$(MYSQL_PASSWORD) --execute="GRANT ALL PRIVILEGES ON *.* TO 'forge'@'localhost';"
endef

define create_db_in_travis
  @mysql --execute="CREATE USER IF NOT EXISTS 'forge'@'localhost';"
  @mysql --execute="CREATE DATABASE IF NOT EXISTS $1;"
  @mysql --execute="GRANT ALL PRIVILEGES ON *.* TO 'forge'@'localhost';"
endef

format_check:
	@./vendor/bin/phpcs --standard=./tests/CI/phpcs.xml -n $(RUN_ARGS)

format_fix:
	@./vendor/bin/phpcbf --standard=./tests/CI/phpcs.xml $(RUN_ARGS)

setup_run_migration_test:
	php artisan migrate --env=testing

setup_add_additional_database_user_in_travis:
#   add additional username and password to databases in travis
ifdef TRAVIS
	@mysql -u root --execute="CREATE USER IF NOT EXISTS 'homestead'@'localhost' IDENTIFIED BY 'secret';"
	@mysql -u root --execute="GRANT ALL PRIVILEGES ON *.* TO 'homestead'@'localhost';"
endif

setup_create_db_test:
	make setup_add_additional_database_user_in_travis
ifdef TRAVIS
	$(call create_db_in_travis,test_is212_lms)
else
	$(call create_db,test_is212_lms)
endif

db_setup_test:
	make setup_create_db_test
	make setup_run_migration_test