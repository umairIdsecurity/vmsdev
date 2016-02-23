#!/usr/bin/env bash

if [[ ! $1 ]]
then
  profile='features'
else
  profile=$1
fi

#start phantomjs
echo starting phantomjs

phantomjs --webdriver=8643 >> phantomjs.log &
phantomjs_pid=$!


#run the tests
echo startong behat
behat --config=test/specs/tools/behat.yml --profile="$profile" --format=pretty --verbose --expand
echo behat completed

#close phantomjs
echo stopping phantomjs
kill $phantomjs_pid




