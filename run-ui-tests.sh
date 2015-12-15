#!/usr/bin/env bash

if [[ ! $1 ]]
then
  profile='features'
else
  profile=$1
fi

#start phantomjs
phantomjs --webdriver=8643 >> phantomjs.log &
phantomjs_pid=$!

#run the tests
behat --config=test/specs/tools/behat.yml --profile="$profile" --format=pretty

#close phantomjs
kill $phantomjs_pid




