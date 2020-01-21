# PHPageBuilder-Laravel-Screenshots

This repository shows the various Laravel files needed for rendering new block thumbs once block view files have changed.

Use in combination with https://github.com/HansSchouten/Laravel-Pagebuilder, or with https://github.com/HansSchouten/PHPageBuilder manually integrated in Laravel.

Screenshots are made using: https://github.com/spatie/browsershot, so run `composer require spatie/browsershot` in your Laravel project.

On CentOS 8 I needed the following commands before browsershot could run:

```yum -y install pango libXcomposite libXcursor libXdamage libXext libXi libXtst cups-libs libXScrnSaver libXrandr GConf2 alsa-lib atk gtk3 ipa-gothic-fonts xorg-x11-fonts-100dpi xorg-x11-fonts-75dpi xorg-x11-utils xorg-x11-fonts-cyrillic xorg-x11-fonts-Type1 xorg-x11-fonts-misc```
