// calculate: [1, 2, 3] + [2, 1] = [1, 4, 4]

#include <iostream>
using namespace std;

void PlusTwoArraysHelp(
    const int arr1[], const int size1,
    const int arr2[], const int size2,
    int** arr, int* size) {
  const int size_diff = size1 - size2;
  int last_v = 0;
  for (int j = size1 - 1; j >= 0; --j) {
    int v = (j >= size_diff) ?
        arr1[j] + arr2[j - size_diff] + last_v :
        arr1[j] + last_v;
    last_v = v / 10;
  }
  if (*arr != NULL) {
    delete *arr;
  }
  const int new_size = (last_v > 0) ? size1 + 1 : size1;
  *arr = new int[new_size];
  *size = new_size;
  const int size_diff2 = new_size - size2;
  last_v = 0;
  for (int j = size1 - 1; j >=0; --j) {
    int v = (j >= size_diff) ?
        arr1[j] + arr2[j - size_diff] + last_v :
        arr1[j] + last_v;
    (*arr)[size_diff2 - size_diff + j] = v % 10;
    last_v = v / 10;
  }
  if (last_v > 0) {
    (*arr)[0] = last_v;
  }
}

void PlusTwoArrays(
    const int arr1[], const int size1,
    const int arr2[], const int size2,
    int** arr, int* size) {
  (size1 >= size2) ?
      PlusTwoArraysHelp(arr1, size1, arr2, size2, arr, size) :
      PlusTwoArraysHelp(arr2, size2, arr1, size1, arr, size);
}

int main() {
  int arr1[4] = {9, 9, 9, 1};
  int arr2[2] = {3, 1};
  int *arr = NULL;
  int size = 0;
  PlusTwoArrays(arr1, 4, arr2, 2, &arr, &size);
  for (int j = 0; j < size; ++j) {
    cout << arr[j] << ", ";
  }
  cout << endl;
  if (arr != NULL) {
    delete arr;
  }
  return 0;
}
