
# install phantom js
sudo curl -O https://phantomjs.googlecode.com/files/phantomjs-1.9.8-linux-x86_64.tar.bz2
sudo tar jxvf phantomjs-1.9.8-linux-x86_64.tar.bz2
sudo cp phantomjs-1.9.8-linux-x86_64/bin/phantomjs /usr/local/bin/phantomjs
sudo chmod +x /usr/local/bin/phantomjs
sudo yum install -y freetype
sudo yum install -y fontconfig


composer global require behat/behat:2.5.*@stable behat/mink:1.5.*@stable behat/mink-extension:1.3.3 behat/mink-goutte-driver:1.0.9 behat/mink-selenium2-driver:1.1.1 behat/mink-zombie-driver:1.1.0
