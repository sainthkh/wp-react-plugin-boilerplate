#!/bin/bash

export WP_REACT_GITHUB_SECRET=$2

echo "Hi?"
echo $1
echo $2

for var in "$@"
do
	echo "$var"

    if [ "$var" = "--production" ]
	then
		export WP_REACT_PRODUCTION=$var
	fi
done

php wp-content/plugins/wp-react-plugin-boilerplate/bin/install-deps/main.php
