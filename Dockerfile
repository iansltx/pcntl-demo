FROM alpine:3.8

# install packages
RUN apk add --no-cache curl php php-common php-curl php-phar php-mbstring \
php-pcntl php-shmop php-sysvshm php-opcache php php-json php-openssl \
php-tokenizer openssl

# Install Composer
RUN curl https://getcomposer.org/composer.phar > /usr/sbin/composer && chmod +x /usr/sbin/composer
RUN composer g require psy/psysh

# set up app; order of operations optimized for maximum layer reuse
RUN mkdir /var/app
WORKDIR /var/app
CMD /root/.composer/vendor/bin/psysh

COPY composer.lock /var/app/composer.lock
COPY composer.json /var/app/composer.json
RUN composer install --prefer-dist -o
COPY . /var/app
