#include <iostream>
#include <vector>
using namespace std;

void Trade(const vector<int>& history, int* begin, int* end) {
  vector<int> mins;
  vector<int> maxs;
  int max, min, last_max, last_min;
  int j = history.size() - 1;
  last_max = last_min = max = min = j;
  --j;
  for (; j >= 0; --j) {
    while (history[j] > history[max]) {
      max = j;
      --j;
    }
    while (j >= 0 && history[j] < history[min]) {
      min = j;
      --j;
    }

    // be careful about the empty vector.
    if (history[max] > history[last_max] || mins.empty()) {
      // a new candidate.
      maxs.push_back(max);
      mins.push_back(min);
      last_max = max;
      last_min = min;
    } else {
      // update the min.
      if (history[min] < history[last_min]) {
        last_min = min;
        mins[mins.size() - 1] = last_min;
      }
    }
  }

  j = 0;
  int diff = -1;
  for (; j < mins.size(); ++j) {
    cout << "min: " << mins[j] << " " << history[mins[j]]
         << ", max: " << maxs[j] << " " << history[maxs[j]] << endl;
    int d = history[maxs[j]] - history[mins[j]];
    if (d > diff) {
      *begin = mins[j];
      *end = maxs[j];
    }
  }
}

int main() {
  int arr[] = {1,3,4,3,4,5,6,7,8,6,4,3,7};
  vector<int> history;
  for (int j = 0; j < sizeof(arr) / sizeof(arr[0]); ++j) {
    history.push_back(arr[j]);
  }
  int begin, end;
  Trade(history, &begin, &end);
  cout << "buy at: " << begin << "(" << history[begin]
       << ") sell at: " << end << "(" << history[end] << ")" << endl;
}
