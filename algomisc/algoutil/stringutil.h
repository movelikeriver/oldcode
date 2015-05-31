// Copyright 2009 Lenjoy. All Rights Reserved.
// Author: mars.lenjoy@gmail.com
//
// a library for string and URL operation.

#ifndef ALGOUTIL_STRINGUTIL_H_
#define ALGOUTIL_STRINGUTIL_H_

#include <string>
using namespace std;

namespace algoutil {
class StringUtil {
 public:
  StringUtil();
  virtual ~StringUtil();

  static void ReplaceDigit(string *str);
  static int ReplaceDigitForURL(const string& ori_str,
                                const string& domain,
                                string *str);
};
}  // namespace algoutil

#endif  // ALGOUTIL_STRINGUTIL_H_
