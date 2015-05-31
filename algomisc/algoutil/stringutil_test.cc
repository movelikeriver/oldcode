// Copyright 2009 Lenjoy. All Rights Reserved.
// Author: mars.lenjoy@gmail.com

#include "algoutil/stringutil.h"

#include <string>
#include <gtest/gtest.h>

namespace algoutil {

class StringutilTest : public ::testing::Test {
 protected:
  StringutilTest() {
  }

  virtual ~StringutilTest() {
  }

  virtual void SetUp() {
  }

  virtual void TearDown() {
  }
};

TEST_F(StringutilTest, ReplaceDigit) {
  string actual_str[] = {
    "sdfasdf2323423",
    "jji/sdf/234",
    "jf345ji/f324df/A234",
    "jji/DE33A3/234",
  };
  string expect_str[] = {
    "sdfasdf0000000",
    "jji/sdf/000",
    "jf000ji/f000df/0000",
    "jji/000000/000",
  };
  for (int j = 0; j < sizeof(actual_str) / sizeof(actual_str[0]); ++j) {
    StringUtil::ReplaceDigit(&actual_str[j]);
    ASSERT_EQ(actual_str[j], expect_str[j]);
  }
}

TEST_F(StringutilTest, ReplaceDigitForURL) {
  string actual_str[] = {
    "http://news.sina.com.cn/sdfasdf23/23423.htm", "sina.com.cn",
    "http://343.sohu.com/sdfasdf23/23423.htm", "sohu.com",
    "http://sichuan.58.com/jji/sdf/234", "58.com",
  };
  string expect_str[] = {
    "http://news.sina.com.cn/sdfasdf00/00000.htm",
    "http://000.sohu.com/sdfasdf00/00000.htm",
    "http://sichuan.58.com/jji/sdf/000",
  };
  for (int j = 0; j < sizeof(expect_str) / sizeof(expect_str[0]); ++j) {
    string str;
    StringUtil::ReplaceDigitForURL(actual_str[2 * j], actual_str[2 * j + 1], &str);
    ASSERT_EQ(str, expect_str[j]);
  }
}

}  // namespace
