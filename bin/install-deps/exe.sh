#!/bin/bash

export WP_REACT_GITHUB_SECRET=$1

for var in "$@"
do
    if [ "$var" = "--production" ]
	then
		export WP_REACT_PRODUCTION=$var
	fi
done

php wp-content/plugins/wp-react-plugin-boilerplate/bin/install-deps/main.php
