#!/usr/bin/env bash

rm -Rf ~/.composer

curl -sS https://getcomposer.org/installer | php
mv composer.phar /usr/local/bin/composer


composer global require behat/behat:2.5.*@stable behat/mink:1.5.*@stable behat/mink-extension:1.3.3 behat/mink-goutte-driver:1.0.9 behat/mink-selenium2-driver:1.1.1 behat/mink-zombie-driver:1.1.0

echo "~/.composer/vendor/bin" >> /etc/paths

#install phantomjs

#install selenium
