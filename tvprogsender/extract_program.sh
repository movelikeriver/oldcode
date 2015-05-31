#!/bin/sh
# Author: mars.lenjoy@gmail.com

# make sure the extract_program.py is in the current path.
PROGRAM=`pwd`/extract_program.py

WORKPATH=/tmp/${USER}_tvprogsender
TARGETMAIL=mars.lenjoy@gmail.com
if [ -z $MAILLIST ]; then
  MAILLIST=$TARGETMAIL
fi

MAILFILE=$WORKPATH/tvprogram.txt
SUBJECT="电视日报"`date +%Y-%m-%d`

rm -rf $WORKPATH
mkdir -p $WORKPATH
cd $WORKPATH
wget http://www.cctv.com/download/showtime.zip
unzip showtime.zip
rm -rf showtime.zip
convmv -f GB2312 -t UTF-8 -r . --notest
python $PROGRAM $WORKPATH > $MAILFILE
cat $MAILFILE
echo `date` | mutt -s $SUBJECT -a $MAILFILE $TARGETMAIL -b $MAILLIST

cd -
