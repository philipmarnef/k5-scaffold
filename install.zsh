#!/bin/zsh

# get the local dev domain
vared -p "What is the local development domain? " -c develop

protocol='http'
vared -p "Does your local domain run on https? (Yes/No) " -c yesno

while true; do
case $yesno in
	[Yy]* ) 
		protocol='https'
		break;;
	[Nn]* ) 
		break;;
	* ) echo "Answer Y(es) or N(o) ";;
esac
done

url="${protocol}://${develop}"
echo "Your local development site runs at ${url}, updating gulpfile.js"

# set baseUrl in gulpfile
sed -i '' "s,http://k5-scaffold.test,${url},g" gulpfile.js

# get the production domain
vared -p "What is the production domain? " -c production
echo "Your production site domain is ${production}, updating html/site/snippets/head.php"

# set robots directive in head.php
sed -i '' "s,k5-scaffold.test,${production},g" html/site/snippets/head.php

# update package.json
sed -i '' "s,\"k5-scaffold\",\"${production}\",g" package.json
sed -i '' "s,https://github.com/philipmarnef/k5-scaffold,,g" package.json
sed -i '' "s,ISC,UNLICENSED,g" package.json
# remove package-lock.json
rm package-lock.json

# install node modules
echo "Installing node modules"
npm install

# install composer packages
echo "Installing composer packages"
(cd ./html && composer install)

# replace .gitignore
rm .gitignore
mv .gitignore-post-install .gitignore
echo "Updated .gitignore"

# initialize a git repo
git init
