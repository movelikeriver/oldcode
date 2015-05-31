// 2 strings are given. One is the super string and the other is a subsequence of the super string.
// Get the indexes in the super string, where is for deletion, to result the super one to sub one.
// e.g. super string "helloworld" and substring "llw", the indexes will be 0, 2, 4, 5, 6, 10.


#include <iostream>
#include <vector>
using namespace std;

bool GetDeletion(const string& super, const string& sub, vector<int>* vec) {
  int c1 = 0;
  int c2 = 0;
  vec->clear();
  bool in = true;
  for(; c1 < super.size() && c2 < sub.size();) {
    if (super[c1] == sub[c2]) {
      if (!in) {
	vec->push_back(c1);
      }
      ++c1;
      ++c2;
      in = true;
    } else {
      if (in) {
	vec->push_back(c1);
      }
      ++c1;
      in = false;
    }
  }
  if (c2 < sub.size()) {
    return false;
  }
  if (in && c1 < super.size() - 1) {
    vec->push_back(c1);
    vec->push_back(super.size());
  }
  else {
    vec->push_back(super.size());
  }
  return true;
}

int main() {
  string super = "helloworld";
  string sub = "llw";
  vector<int> vec;
  
  GetDeletion(super, sub, &vec);
  for (int i = 0; i < vec.size(); ++i) {
    cout << vec[i] << endl;
  }
}
