#!/bin/bash
cd ~/Projects/chippyash/source/Type-Calculator
vendor/bin/phpunit -c test/phpunit.xml --testdox-html contract.html test/
tdconv -t "Chippyash Strong Type Calculator" contract.html docs/Test-Contract.md
rm contract.html

