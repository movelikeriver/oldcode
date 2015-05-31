// Copyright 2009 Lenjoy. All Rights Reserved.
// Author: mars.lenjoy@gmail.com

#include "position_arrange/position_arrange.h"

#include <string>
#include <gtest/gtest.h>

namespace position_arrange {

class PositionArrangeTest : public ::testing::Test {
protected:
  PositionArrangeTest() {
    pa_ = new PositionArrange(3, 1);
  }

  virtual ~PositionArrangeTest() {
    delete pa_;
  }

  virtual void SetUp() {
  }

  virtual void TearDown() {
  }

  int CountBitOnes(int v) {
    return pa_->CountBitOnes(v);
  }

  bool IsValidLine(int line1, int line2) {
    return pa_->IsValidLine(line1, line2);
  }

  void PermutateAll(int n_side,
		    int n_valid,
		    vector<int>* results) {
    pa_->Reset(n_side, n_valid);
    pa_->PermutateAll(n_side, n_valid, results);
  }

  void OutputAsBits(int n, int n_side) {
    return pa_->OutputAsBits(n, n_side);
  }

  int B2I(const string& str) {
    return pa_->BitstrToInt(str);
  }

  PositionArrange* pa_;
};

TEST_F(PositionArrangeTest, CountBitOnes) {
  vector<bool> bits;
  string arr_str[] = {
    "0000000000001010",
    "0000000000010001",
    "0000000100010010",
    "0000000000000100",
    "0000000000100111",
    "0000000000110010",
    "0000000000101100",
    "1000011110101000",
  };
  int arr_int[] = {
    2,
    2,
    3,
    1,
    4,
    3,
    3,
    7,
  };
  for (int j = 0; j < sizeof(arr_int) / sizeof(arr_int[0]); ++j) {
    ASSERT_EQ(CountBitOnes(B2I(arr_str[j])), arr_int[j]);
  }
}

TEST_F(PositionArrangeTest, IsValidLine) {
  string arrs[] = {
    // case 1
    "0000000000000001",
    "0000000000000010",
    // case 2
    "0000000000000010",
    "0000000000000010",
    // case 3
    "0000000000000100",
    "0000000000000010",
    // case 4
    "0000000010000001",
    "0000000000100100",
  };
  bool rets[] = {
    false,
    false,
    false,
    true,
  };
  for (int j = 0; j < sizeof(arrs) / sizeof(arrs[0]); j+=2) {
    IsValidLine(B2I(arrs[j]), B2I(arrs[j+1]));
  }
}

TEST_F(PositionArrangeTest, BitstrToInt) {
  const string arrs_str[] = {
    "00001000",
    "00010000",
    "00000001",
  };
  const int arrs_int[] = {
    8,
    16,
    1,
  };
  for (int j = 0; j < sizeof(arrs_str) / sizeof(arrs_str[0]); ++j) {
    ASSERT_EQ(B2I(arrs_str[j]), arrs_int[j]);
  }
}

TEST_F(PositionArrangeTest, PermutateAll) {
  vector<int> rets;
  string exp_arrs[] = {
    "0000000000000101",
    "0000000000001001",
    "0000000000001010",
    "0000000000010001",
    "0000000000010010",
    "0000000000010100",
    "0000000000100001",
    "0000000000100010",
    "0000000000100100",
    "0000000000101000",
    "0000000001000001",
    "0000000001000010",
    "0000000001000100",
    "0000000001001000",
    "0000000001010000",
    "0000000010000001",
    "0000000010000010",
    "0000000010000100",
    "0000000010001000",
    "0000000010010000",
    "0000000010100000",
  };
  PermutateAll(8, 2, &rets);
  for (int j = 0; j < rets.size(); ++j) {
    ASSERT_EQ(rets[j], B2I(exp_arrs[j]));
  }

  string exp_arrs2[] = {
    "0001",
    "0010",
    "0100",
    "1000",
  };
  PermutateAll(4, 1, &rets);
  for (int j = 0; j < rets.size(); ++j) {
    ASSERT_EQ(rets[j], B2I(exp_arrs2[j]));
  }
}

TEST_F(PositionArrangeTest, GetSolutionNum) {
  const int arr[] = {
    4, 1, 16,
    8, 2, 1550,
  };
  for (int j = 0; j < sizeof(arr) / sizeof(arr[0]); j+=3) {
    //    cout << j << endl;
    pa_->Reset(arr[j], arr[j+1]);
    ASSERT_EQ(pa_->GetSolutionNum(), arr[j+2]);
  }
}
}  // namespace
