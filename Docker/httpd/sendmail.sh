#!/usr/bin/env bash

if [[ "$FAKE_SENDMAIL" == 0 ]]; then
  sendmail -t -i "$@" # >> /var/www/var/log/sendmail.log
else
  php /home/fakemail2.php "$@"
fi

