// Given a non-empty binary search tree with integer values in each node, find the closest value in the tree to given K.
// e.g.
//         n4(31)
//        /     \
//     n2(25)   n5(34)
//     /    \
// n1(20)  n3(26)
//
// given K = 27, return 26(n3).

#include <iostream>
#include <vector>
using namespace std;

struct Node {
  explicit Node(const int v) : value(v) { }
  int value;
  Node* left;
  Node* right;
};

bool FindClosest(const Node* node, const int target, int* result) {
  if (!node) {
    return false;
  }
  if (target == node->value) {
    *result = node->value;
    return true;
  }
  if (target > node->value) {
    if (FindClosest(node->right, target, result)) {
      return true;
    }
    if ((target - node->value) > abs(*result - target)) {
      return false;
    } else {
      *result = node->value;
      return false;
    }
  } else {
    if (FindClosest(node->left, target, result)) {
      return true;
    }
    if ((node->value - target) > abs(*result - target)) {
      return false;
    } else {
      *result = node->value;
      return false;
    }
  }
  return false;
}


int main() {
  vector<Node*> vec;
  Node* n1 = new Node(20);
  Node* n2 = new Node(25);
  Node* n3 = new Node(26);
  Node* n4 = new Node(31);
  Node* n5 = new Node(34);
  vec.push_back(n1);
  vec.push_back(n2);
  vec.push_back(n3);
  vec.push_back(n4);
  vec.push_back(n5);

  //         n4(31)
  //        /     \
  //     n2(25)   n5(34)
  //     /    \
  // n1(20)  n3(26)
  n1->left = NULL;
  n1->right = NULL;
  n2->left = n1;
  n2->right = n3;
  n3->left = NULL;
  n3->right = NULL;
  n4->left = n2;
  n4->right = n5;
  n5->left = NULL;
  n5->right = NULL;

  int n = 0;
  FindClosest(n4, 27, &n);
  cout << n << endl;
  for (int i = 0; i < vec.size(); ++i) {
    delete vec[i];
    vec[i] = NULL;
  }
}
