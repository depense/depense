DEPENSE_SYMFONY_CONSOLE := ./bin/console --no-interaction --quiet
DEPENSE_PHPUNIT_CONSOLE := ./bin/phpunit

test:
	@$(DEPENSE_SYMFONY_CONSOLE) --env=test doctrine:database:create --if-not-exists
	@$(DEPENSE_SYMFONY_CONSOLE) --env=test doctrine:migrations:migrate
	@$(DEPENSE_PHPUNIT_CONSOLE) --testdox
