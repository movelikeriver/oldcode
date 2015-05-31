#!/bin/sh
# Copyright 2009 Lenjoy. All Rights Reserved.
# Author: mars.lenjoy@gmail.com
#
# The build shell script.
#
# Usage:
#   build.sh [build|test|clean] code/path


param=$1
codepath=$2
option=$3

buildpath=".build"
testpath=$buildpath/$codepath

helpinfo="Usage: build.sh code/path [build|test|clean] [debug=1]"

if [ -z $codepath ] || [ -z $param ]; then
    echo $helpinfo;
    exit
fi

echo "param: "$param
echo "path: "$codepath

if [ $param = "build" ]; then
    cd $codepath
    scons -Q $option
    cd -
elif [ $param = "test" ]; then
    echo "testpath: "$testpath
    cd $codepath
    scons -Q $option
    cd -
    files=`ls ${testpath}/*_test`
    for f in $files; do
	echo "run "$f
	$f
    done
elif [ $param = "clean" ]; then
    echo "testpath: "$testpath
    cd $codepath
    scons -c
    cd -
    rm -rfv $testpath
else
    echo $helpinfo
fi

