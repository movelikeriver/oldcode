// author: mars.lenjoy@gmail.com (2009)

#include "roman_number/roman_number.h"
#include <iostream>
#include <string>
#include <vector>

#include <gtest/gtest.h>

using namespace std;

class RomanNumberTest : public testing::Test {
 protected:
  virtual void SetUp() {
  }
  virtual void TearDown() {
  }
};

TEST_F(RomanNumberTest, ArabToRoman) {
  vector<int> nums;
  vector<string> expect_strs;
  nums.push_back(9);
  expect_strs.push_back("IX");
  nums.push_back(19);
  expect_strs.push_back("XIX");
  nums.push_back(476);
  expect_strs.push_back("CDLXXVI");

  for (int j = 0; j < nums.size(); ++j) {
    string str;
    RomanNumber::ArabToRoman(nums[j], &str);
    ASSERT_EQ(expect_strs[j], str);
  }
}
