// Copyright 2009 Lenjoy. All Rights Reserved.
// Author: mars.lenjoy@gmail.com
//
// There're some towers need to be settled into a square. To avoid wasting,
// we prevent letting two towers sticking too near.
//   0*0  000  *00
//   0*0  **0  0*0
//   000  000  000
// The cases above are not allowed.
// Given a N*N square, and putting K towers into each line.
// How many available solutions?
// If the solution number is too big, just mod as 1000000.


#ifndef POSITION_ARRANGE_H
#define POSITION_ARRANGE_H

#include <map>
#include <vector>
using namespace std;

namespace position_arrange {
class PositionArrange {
 public:
  PositionArrange();
  PositionArrange(const int n_side, const int n_towers);
  PositionArrange(PositionArrange &pa);
  virtual ~PositionArrange();
  void Reset(const int n_side, const int n_towers);

  int GetSolutionNum();
  int BitstrToInt(const string& bitstr);
  void LToBitString(int n, int n_size, string* bits);
  void LToBits(int n, int n_size, vector<bool>* bits);
  void OutputBits(const vector<bool>& bits);
  void OutputAsBits(int n, int n_side);
  void OutputMap(const map<int, int>& m);

 protected:
  void Init(const int n_side, const int n_towers);
  void Clear();


  // counts the 1 bits number.
  int CountBitOnes(int v);

  // is valid line which has not too near towers,
  // line1 is the old line, line2 is the new one.
  bool IsValidLine(int line1, int line2);

  // permutate all the bits.
  void PermutateAll(int n_side,
		    int n_valid,
		    vector<int>* results);

 private:
  friend class PositionArrangeTest;

  int* solutions_;
  int n_side_;
  int n_towers_;
  vector<int> oneline_solutions_;
};
}  // namespace position_arrange

#endif
