DEPENSE_PROJECT_DIR ?= $(realpath ./)

DEPENSE_SYMFONY_CONSOLE := php $(DEPENSE_PROJECT_DIR)/bin/console --no-interaction --quiet
DEPENSE_PHPUNIT_CONSOLE := php $(DEPENSE_PROJECT_DIR)/bin/phpunit

test:
	@$(DEPENSE_SYMFONY_CONSOLE) --env=test doctrine:database:create --if-not-exists
	@$(DEPENSE_SYMFONY_CONSOLE) --env=test doctrine:migrations:migrate
	@$(DEPENSE_PHPUNIT_CONSOLE) --testdox
