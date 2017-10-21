#!/usr/bin/env bash

if [[ ! $1 ]]
then
  profile='features'
else
  profile=$1
fi

#set up paths
PATH=vendor/bin:$PATH

#start phantomjs
#echo starting phantomjs
#phantomjs --webdriver=8643 >> phantomjs.log &
#phantomjs_pid=$!

java -jar selenium-server.jar -port=8643

#run the tests
echo starting behat
php vendor/bin/behat.php --config=behat/behat.yml --profile="$profile" --format=pretty --verbose --expand
echo behat completed

#close phantomjs
echo stopping phantomjs
kill $phantomjs_pid




