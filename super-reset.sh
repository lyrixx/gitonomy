#!/bin/bash
./reset.sh
./put-symfony.sh
./put-gitonomy.sh

./app/console gitonomy:user-create julien julien 'genzo.wm@gmail.com' "Julien DIDIER"
./app/console gitonomy:user-create alex alex 'alexandre.salome@gmail.com' "Alexandre Salomé"

if [ "`whoami`" = "alex" ]; then
    username="alex"
else
    username="julien"
fi

./app/console gitonomy:user-ssh-key-create $username "Autokey" "`cat ~/.ssh/id_rsa.pub`"
./app/console gitonomy:authorized-keys -i | tee ~/.ssh/authorized_keys

./app/console gitonomy:user-add-to-project julien gitonomy "Lead developer"
./app/console gitonomy:user-add-to-project alex gitonomy "Lead developer"


