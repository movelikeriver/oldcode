// Copyright 2009 Lenjoy. All Rights Reserved.
// Author: mars.lenjoy@gmail.com

#include "position_arrange/position_arrange.h"
#include <stdio.h>
#include <iostream>
#include <map>
#include <utility>

namespace position_arrange {

PositionArrange::PositionArrange() {
}

PositionArrange::PositionArrange(const int n_side, const int n_towers) {
  Init(n_side, n_towers);
}

PositionArrange::PositionArrange(PositionArrange &pa) {
  Clear();
  Init(pa.n_side_, pa.n_towers_);
}

PositionArrange::~PositionArrange() {
  Clear();
}

void PositionArrange::Reset(const int n_side, const int n_towers) {
  Clear();
  Init(n_side, n_towers);
}

void PositionArrange::Init(const int n_side, const int n_towers) {
  n_side_ = n_side;
  n_towers_ = n_towers;
  solutions_ = new int[n_side_];
  for (int j = 0; j < n_side_; ++j) {
    solutions_[j] = 0;
  }
  PermutateAll(n_side_, n_towers_, &oneline_solutions_);
}

void PositionArrange::Clear() {
  if (solutions_ != NULL) {
    delete[] solutions_;
  }
}

int PositionArrange::GetSolutionNum() {
  map<int, int> pres;
  map<int, int> curs;
  for (int j = 0; j < oneline_solutions_.size(); ++j) {
    pres.insert(make_pair(oneline_solutions_[j], 1));
  }
  for (int j = 1; j < n_side_; ++j) {
    cout << "level: " << j << endl;
    curs.clear();
    for (map<int, int>::iterator it = pres.begin();
	 it != pres.end(); ++it) {
      // Analyzes all the oneline solutions and choose the valid one.
      for (int k = 0; k < oneline_solutions_.size(); ++k) {
	int solution = oneline_solutions_[k];
	if (IsValidLine(it->first, solution)) {
	  cout << "k: " << k;
	  OutputAsBits(it->first, n_side_);
	  OutputAsBits(solution, n_side_);
	  cout << endl;
	  pair<map<int, int>::iterator, bool> p =
	    curs.insert(make_pair(solution, it->second));
	  if (!p.second) {
	    p.first->second += it->second;
	  }
	}
      }
    }
    cout << "pres:" << endl;
    OutputMap(pres);
    cout << "curs:" << endl;
    pres = curs;
    OutputMap(curs);
  }
  int count = 0;
  for (map<int, int>::iterator it = curs.begin();
       it != curs.end(); ++it) {
    count += it->second;
  }
  return count;
}

int PositionArrange::CountBitOnes(int v) {
  int count = 0;
  while (v > 0) {
    v = v & (v - 1);
    ++count;
  }
  return count;
}

bool PositionArrange::IsValidLine(int line1, int line2) {
  return ((line1 & line2) == 0 &&
	  (line1 & (line2 << 1)) == 0 &&
	  (line1 & (line2 >> 1)) == 0);
}

void PositionArrange::PermutateAll(int n_side,
				   int n_valid,
				   vector<int>* results) {
  results->clear();
  for (int j = 0; j < 1 << n_side; ++j) {
    if (CountBitOnes(j) == n_valid) {
      // the ( and ) cannot be removed.
      if (((j << 1) & j) == 0 &&
	  ((j >> 1) & j) == 0) {
	results->push_back(j);
      }
    }
  }
}

int PositionArrange::BitstrToInt(const string& bitstr) {
  int n = 0;
  for (int j = bitstr.length() - 1; j >= 0; --j) {
    if (bitstr[j] == '1') {
      n += (1 << (bitstr.length() - 1 - j));
    }
  }
  return n;
}

void PositionArrange::LToBitString(int n,
				   int n_size,
				   string* bits) {
  bits->resize(n_size);
  for (int j = 0; j < n_size; ++j) {
    (*bits)[n_size - 1 - j] = (n >> j) & 1;
  }
}

void PositionArrange::LToBits(int n,
			      int n_size,
			      vector<bool>* bits) {
  bits->resize(n_size);
  for (int j = 0; j < n_size; ++j) {
    (*bits)[n_size - 1 - j] = (n >> j) & 1;
  }
}

void PositionArrange::OutputBits(const vector<bool>& bits) {
  cout << "\"";
  for (int j = 0; j < bits.size(); ++j) {
    cout << bits[j];
  }
  cout << "\",";
}

void PositionArrange::OutputAsBits(int n, int n_side) {
  vector<bool> bits;
  LToBits(n, n_side, &bits);
  OutputBits(bits);
}

void PositionArrange::OutputMap(const map<int, int>& m) {
  for (map<int, int>::const_iterator it = m.begin();
       it != m.end(); ++it) {
    OutputAsBits(it->first, n_side_);
    cout << it->second << endl;
  }
}

}  // namespace position_arrange
