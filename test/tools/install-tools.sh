
# install phantom js
curl -O https://phantomjs.googlecode.com/files/phantomjs-1.9.1-linux-i686.tar.bz2
tar xvf phantomjs-1.9.1-linux-i686.tar.bz2
cp phantomjs-1.9.1-linux-i686/bin/phantomjs /usr/local/bin
sudo yum install -y freetype
sudo yum install -y fontconfig


# install selenium web driver
yum install firefox Xvfb libXfont Xorg
mkdir /usr/lib/selenium /var/log/selenium /var/log/Xvfb
chown screener.screener  /usr/lib/selenium /var/log/selenium /var/log/Xvfb
cd /usr/lib/selenium ;
wget http://selenium-release.storage.googleapis.com/2.40/selenium-server-standalone-2.40.0.jar

# install java
yum install -y jre

# setup scripts
cp etc_init.d_selenium /etc/init.d/selenium
cp etc_init.d_Xvfb /etc/init.d/Xvfb


# start the services
/etc/init.d/Xvfb start
/etc/init.d/selenium start




