ARG PHP_VER=7.4
FROM php:$PHP_VER-apache
ARG PHP_VER
ARG APACHEUSER=dev
ARG FAKE_SENDMAIL=0
ENV FAKE_SENDMAIL=${FAKE_SENDMAIL}
RUN a2enmod rewrite
RUN set -xe \
   && apt-get update;

RUN echo "!!! install pvp version $PHP_VER !!!";
RUN echo "FAKE_SENDMAIL=${FAKE_SENDMAIL}" >> /etc/bash.bashrc

RUN set -xe \
   && apt-get install -y git \
   && apt-get install -y wget \
   && apt-get install -y curl \
   && apt-get install -y nano \
   && apt-get install -y sendmail \
   && apt-get install -y libpng-dev libjpeg-dev libmcrypt-dev libxslt-dev libxml2-dev libgd-dev libonig-dev libjpeg62-turbo-dev libfreetype6-dev libzip-dev \
   && rm -rf /var/lib/apt/lists/* \
   && docker-php-ext-configure gd --with-jpeg=/usr --with-freetype=/usr/lib64/ \
   && docker-php-ext-install gd mbstring mysqli zip sockets;

RUN if [ "$PHP_VER" = "7.3" ] ; then \
       pecl install mcrypt-1.0.2 \
       && docker-php-ext-enable mcrypt; \
    elif [ "$PHP_VER" = "5.6" ] || [ "$PHP_VER" = "7.1" ] ; then \
       docker-php-ext-install mcrypt \
       && docker-php-ext-enable mcrypt; \
    fi

RUN docker-php-ext-install ctype;
RUN docker-php-ext-install dom;
RUN docker-php-ext-install intl;
RUN docker-php-ext-install simplexml;
RUN docker-php-ext-install pdo_mysql;
RUN docker-php-ext-install soap;
RUN docker-php-ext-install xsl;
RUN docker-php-ext-install bcmath;

# libsodium if 7.2
RUN if [ "$PHP_VER" = "7.2" ] || [ "$PHP_VER" = "7.3" ] || [ "$PHP_VER" = "7.4" ] ; then \
     curl -LO https://download.libsodium.org/libsodium/releases/libsodium-1.0.18.tar.gz \
     && tar xfvz libsodium-1.0.18.tar.gz \
     && cd libsodium-1.0.18 \
     && ./configure \
     && make && make install \
     && pecl install -f libsodium \
     && cd ../ \
     && rm libsodium-1.0.18.tar.gz; \
    fi


#ioncube
COPY ./Docker/httpd/ioncube/ioncube_loader_lin_$PHP_VER.so /usr/local/lib/php/extensions/ioncube_loader_lin.so
COPY ./Docker/httpd/ioncube/docker-php-ext-ioncube.ini /usr/local/etc/php/conf.d/docker-php-ext-ioncube.ini

# fake mail
#COPY ./Docker/httpd/fakemail2.php /home/fakemail2.php
#RUN chmod +x /home/fakemail2.php

# composer
RUN wget https://composer.github.io/installer.sig -O - -q | tr -d '\n' > installer.sig \
    && php -r "copy('https://getcomposer.org/installer', 'composer-setup.php');" \
    && php -r "if (hash_file('SHA384', 'composer-setup.php') === file_get_contents('installer.sig')) { echo 'Installer verified'; } else { echo 'Installer corrupt'; unlink('composer-setup.php'); } echo PHP_EOL;" \
    && php composer-setup.php \
    && php -r "unlink('composer-setup.php'); unlink('installer.sig');" \
    && mv composer.phar /usr/local/bin/composer

RUN curl -sL https://deb.nodesource.com/setup_12.x | bash
RUN set -xe \
   && apt-get update \
   && apt-get install -y nodejs;

# grunt
RUN npm install -g grunt-cli;

# build with xdebug if arg XDEBUG_ENABLED != 0
ARG WITH_XDEBUG=1

COPY ./Docker/httpd/xdebug.ini /usr/local/etc/php/conf.d/docker-php-ext-xdebug-extend.ini

RUN if [ $WITH_XDEBUG = "1" ] && [ "$PHP_VER" = "7.2" ] ; then \
        pecl install xdebug-2.9.2 \
        && docker-php-ext-enable xdebug; \
    elif [ $WITH_XDEBUG = "1" ] && [ "$PHP_VER" = "7.4" ] ; then \
        pecl install xdebug-2.9.2 \
	&& docker-php-ext-enable xdebug; \
    elif [ $WITH_XDEBUG = "1" ] && [ "$PHP_VER" = "7.3" ] ; then \
        pecl install xdebug-2.9.2 \
        && docker-php-ext-enable xdebug; \
    elif [ $WITH_XDEBUG = "1" ] && [ "$PHP_VER" = "7.1" ] ; then \
        pecl install xdebug-2.6.1 \
        && docker-php-ext-enable xdebug; \
    elif [ $WITH_XDEBUG = "1" ] && [ "$PHP_VER" = "7.0" ] ; then \
        pecl install xdebug-2.6.1 \
        && docker-php-ext-enable xdebug; \
    elif [ $WITH_XDEBUG = "1" ] && [ "$PHP_VER" = "5.6" ] ; then \
        pecl install xdebug-2.5.1 \
        && docker-php-ext-enable xdebug; \
    else rm -f /usr/local/etc/php/conf.d/docker-php-ext-xdebug.ini; \
    fi

# add user
RUN useradd $APACHEUSER;
RUN usermod -u 1000 $APACHEUSER
RUN usermod -a -G $APACHEUSER $APACHEUSER
RUN usermod -a -G root $APACHEUSER
RUN usermod -a -G sudo $APACHEUSER
RUN usermod --shell /bin/bash $APACHEUSER

RUN mkdir "/home/$APACHEUSER"
RUN chmod 777 "/home/$APACHEUSER"

# create aliases
RUN echo '#!/bin/bash\n php bin/magento $*' > /usr/bin/mage && \
    chmod +x /usr/bin/mage;

RUN echo '#!/bin/bash\n php bin/magento c:f' > /usr/bin/cache && \
    chmod +x /usr/bin/cache;

RUN echo '#!/bin/bash\n mv "/usr/local/etc/php/conf.d/docker-php-ext-xdebug.ini" "/usr/local/etc/php/conf.d/docker-php-ext-xdebug.ini.off" && service apache2 restart' > /usr/bin/xoff && \
    chmod +x /usr/bin/xoff;

RUN echo '#!/bin/bash\n mv "/usr/local/etc/php/conf.d/docker-php-ext-xdebug.ini.off" "/usr/local/etc/php/conf.d/docker-php-ext-xdebug.ini" && service apache2 restart' > /usr/bin/xon && \
    chmod +x /usr/bin/xon;

CMD service sendmail start && apache2-foreground
