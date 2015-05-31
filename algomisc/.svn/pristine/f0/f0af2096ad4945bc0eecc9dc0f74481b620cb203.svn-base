// author: mars.lenjoy@gmail.com (2009)

#include "roman_number/roman_number.h"
#include <iostream>
#include <string>
#include <vector>

using namespace std;

int main() {
  vector<int> nums;
  vector<string> expect_strs;
  vector<string> actual_strs;
  nums.push_back(9);
  expect_strs.push_back("IX");
  nums.push_back(19);
  expect_strs.push_back("XIX");
  nums.push_back(476);
  expect_strs.push_back("CDLXXVI");

  for (int j = 0; j < nums.size(); ++j) {
    string str;
    RomanNumber::ArabToRoman(nums[j], &str);
    actual_strs.push_back(str);
  }
  for (int j = 0; j < expect_strs.size(); ++j) {
    if (expect_strs[j] == actual_strs[j]) {
      cout << "SUCCESS: "
	   << expect_strs[j] << " vs " << actual_strs[j] << endl;
    } else {
      cout << "FAILED:  "
	   << expect_strs[j] << " vs " << actual_strs[j] << endl;
    }
  }
  return 0;
}
