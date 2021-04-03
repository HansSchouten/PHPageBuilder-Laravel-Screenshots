# PHPageBuilder-Laravel-Screenshots

This repository shows the various Laravel files needed for rendering new block thumbs once block view files have changed.

Use in combination with https://github.com/HansSchouten/Laravel-Pagebuilder, or with https://github.com/HansSchouten/PHPageBuilder manually integrated in Laravel.

Screenshots are made using: https://github.com/spatie/browsershot, so run `composer require spatie/browsershot` in your Laravel project.

Additionally, on CentOS 8 I needed the following commands before browsershot could run:
```
yum -y install pango libXcomposite libXcursor libXdamage libXext libXi libXtst cups-libs libXScrnSaver libXrandr GConf2 alsa-lib atk gtk3 ipa-gothic-fonts xorg-x11-fonts-100dpi xorg-x11-fonts-75dpi xorg-x11-utils xorg-x11-fonts-cyrillic xorg-x11-fonts-Type1 xorg-x11-fonts-misc
```

Ubuntu 20:
```
sudo npm install -g puppeteer --unsafe-perm=true
sudo apt-get install -y gconf-service libasound2 libatk1.0-0 libc6 libcairo2 libcups2 libdbus-1-3 libexpat1 libfontconfig1 libgcc1 libgconf-2-4 libgdk-pixbuf2.0-0 libglib2.0-0 libgtk-3-0 libnspr4 libpango-1.0-0 libpangocairo-1.0-0 libstdc++6 libx11-6 libx11-xcb1 libxcb1 libxcomposite1 libxcursor1 libxdamage1 libxext6 libxfixes3 libxi6 libxrandr2 libxrender1 libxss1 libxtst6 ca-certificates fonts-liberation libappindicator1 libnss3 lsb-release xdg-utils wget
sudo apt-get install -y libxshmfence-dev 
```
