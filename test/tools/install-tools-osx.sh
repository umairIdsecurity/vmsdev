#!/usr/bin/env bash

#curl -sS https://getcomposer.org/installer | php
#mv composer.phar /usr/local/bin/composer


composer global require behat/behat behat/mink behat/mink-extension:dev-master behat/mink-goutte-driver:dev-master behat/mink-selenium2-driver:dev-master

echo "~/.composer/vendor/bin" >> /etc/paths

#install phantomjs

#install selenium
