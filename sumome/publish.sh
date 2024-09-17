#!/bin/bash

VERSION=$(grep -i 'Stable tag:' Readme.txt | awk -F' ' '{print $NF}')

# clean up from any previous deploys
rm -rf /tmp/sumome-svn
rm -rf /tmp/sumome-wp-plugin

# check out the SVN repo
svn co https://plugins.svn.wordpress.org/sumome /tmp/sumome-svn

# copy the new build to a tmp locaation
unzip ./builds/sumome."$VERSION".zip -d /tmp/sumome-wp-plugin

# copy the new build into the svn repo
cp -r /tmp/sumome-wp-plugin/sumome/* /tmp/sumome-svn/trunk

# copy the assets into the svn repo
cp -r ./plugin/assets/* /tmp/sumome-svn/assets

# create the new tag
cd /tmp/sumome-svn
svn cp trunk "tags/$VERSION"

# commit changes
svn add . --force
svn update
svn commit -m "Update to version $VERSION" --username "SumoMe"
