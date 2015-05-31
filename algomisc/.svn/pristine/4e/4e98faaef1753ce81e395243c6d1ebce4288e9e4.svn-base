// Copyright 2009 Lenjoy. All Rights Reserved.
// Author: mars.lenjoy@gmail.com

#include "algoutil/stringutil.h"

const char kNumberChar = '0';

namespace algoutil {

StringUtil::StringUtil() {}

StringUtil::~StringUtil() {}

void StringUtil::ReplaceDigit(string *str) {
  for (int j = 0; j < str->length(); ++j) {
    const char ch = str->at(j);
    if (isdigit(ch)) {
      (*str)[j] = kNumberChar;
    } else if (ch <= 'F' && ch >= 'A') {
      if (!((j > 1 &&
             str->at(j-1) >= 'a' && str->at(j-1) <= 'z') ||
            (j < str->length() - 1 &&
             str->at(j+1) >= 'a' && str->at(j+1) <= 'z'))) {
        (*str)[j] = kNumberChar;
      }
    }
  }
}

int StringUtil::ReplaceDigitForURL(const string& ori_str,
                                   const string& domain,
                                   string *str) {
  int idx = ori_str.find(domain);
  if (idx == string::npos) {
    return -1;
  }
  string pre = ori_str.substr(0, idx);
  string suf = ori_str.substr(idx + domain.length(), ori_str.length());
  ReplaceDigit(&pre);
  ReplaceDigit(&suf);
  *str = pre + domain + suf;
  return 0;
}

}  // namesapce algoutil
