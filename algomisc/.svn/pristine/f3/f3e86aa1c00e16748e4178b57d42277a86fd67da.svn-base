#include <iostream>
#include <vector>
using namespace std;

void PrintVector(const vector<int>& vec) {
  for (int j = 0; j < vec.size(); ++j) {
    cout << vec[j];
  }
  cout << endl;
}

bool Increase(const vector<int>& max_vec, vector<int>* vec) {
  for (int j = 0; j < vec->size(); ++j) {
    if (vec->at(j) < max_vec[j]) {
      vec->at(j) += 1;
      for (int k = j - 1; k >= 0; --k) {
        vec->at(k) = 0;
      }
      return true;
    }
  }
  return false;
}


void PrintPerm(const vector<int>& inputs) {
  vector<int> index(inputs.size(), 0);
  PrintVector(index);
  while (Increase(inputs, &index)) {
    PrintVector(index);
  }
}

int main() {
  vector<int> vec;
  vec.push_back(3);
  vec.push_back(4);
  vec.push_back(2);
  PrintPerm(vec);
  return 0;
}
