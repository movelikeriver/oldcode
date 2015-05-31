#!/usr/bin/python2.4
# -*- coding: utf-8 -*-

"""Usage:
python extract_program.py [path]
"""

__author__ = "mars.lenjoy@gmail.com"

import os
import sys
import time


def GetFiles(path):
  """Gets files from root path."""

  retfiles = []
  target_paths = []
  for root, dirs, files in os.walk(path):
    if root == path:
      target_paths = map(lambda d: os.path.join(root, d), dirs)
      continue
    if root not in target_paths:
      continue
    for f in files:
      if f[-4:] != '.txt':
        continue
      retfiles.append(os.path.join(root, f))
  return retfiles


def GenConvertCmd(files):
  """Generates the shell cmd file for converting files."""

  retfiles = []
  for f in files:
    fnew = f + '.done'
    retfiles.append(fnew)
    f = f.replace('(', '\(').replace(')', '\)')
    line = '/usr/bin/iconv -f GBK -t UTF-8 %s -o %s.done' % (f, f)
    if os.system(line) != 0:
      #print line + ' [FAILED]'
      continue
  return retfiles


def ExtractProgram(filename, todaystr):
  """Extracts today's TV program."""

  report = []
  save = False
  for line in open(filename).readlines():
    if len(line) < 8:
      continue
    # yy/mm/dd
    if line[2] == '/' and line[5] == '/':
      save = line[:8] == todaystr
    if save is True:
      report.append(line)

  return ''.join(report)


def ExtractProgramFromFiles(files, todaystr):
  report = []
  for f in files:
    report.append('* ' + f.split('/')[-1][:-9])
    report.append(ExtractProgram(f, todaystr) + '\n')
  return '\n'.join(report)


def main(argv):
  if len(argv) < 2:
    print 'python extract_program.py [path]'
  path = argv[1]
  todaystr = time.strftime('%y/%m/%d', time.localtime())
  files = GetFiles(path)
  donefiles = GenConvertCmd(files)
  report = ExtractProgramFromFiles(donefiles, todaystr)
  print report


if __name__ == '__main__':
  main(sys.argv)
