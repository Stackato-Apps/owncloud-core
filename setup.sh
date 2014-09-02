#!/bin/bash
if [ ! -s $STACKATO_FILESYSTEM/config.php ]; then
    echo "Creating configuration file in Stackato Filesystem..."
    touch $STACKATO_FILESYSTEM/config.php
fi
ln -s $STACKATO_FILESYSTEM/config.php config/config.php
