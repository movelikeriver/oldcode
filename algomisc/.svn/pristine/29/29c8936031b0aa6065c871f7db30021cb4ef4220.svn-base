#include <iostream>
#include <map>
#include <set>
#include <vector>
using namespace std;

typedef int int64;

static const int kAccountId = 10001;

struct Node {
  ~Node() {
    cout << "~Node: (" << id << ", " << type << ")" << endl;
  }
  int64 id;
  int type;
  vector<Node*> children;
};


vector<Node*> g_node_list;

Node* AddNew() {
  Node* n = new Node;
  g_node_list.push_back(n);
  return n;
}

void ReleaseNodes() {
  cout << "ReleaseNodes" << endl;
  for (int j = 0; j < g_node_list.size(); ++j) {
    if (NULL != g_node_list[j]) {
      delete g_node_list[j];
      g_node_list[j] = NULL;
    }
  }
}

// circule
Node* CreateNodes1(
    map<int64, Node*>* lists,
    set<pair<int, int64> >* permissioned_lists) {
  Node *n1 = AddNew();
  n1->id = 5;
  n1->type = 1;
  Node *n2 = AddNew();
  n2->id = 1;
  n2->type = 2;
  Node *n3 = AddNew();
  n3->id = 50;
  n3->type = 1;
  Node *n4 = AddNew();
  n4->id = 2;
  n4->type = 1;
  Node *n5 = AddNew();
  n5->id = 100;
  n5->type = 3;

  (*lists)[n1->id] = n1;
  (*lists)[n2->id] = n2;
  (*lists)[n3->id] = n3;
  (*lists)[n4->id] = n4;
  (*lists)[n5->id] = n5;
  permissioned_lists->insert(make_pair(n1->id, kAccountId));
  permissioned_lists->insert(make_pair(n2->id, kAccountId));
  permissioned_lists->insert(make_pair(n3->id, kAccountId));
  permissioned_lists->insert(make_pair(n4->id, kAccountId));
  permissioned_lists->insert(make_pair(n5->id, kAccountId));

  n1->children.push_back(n2);
  n2->children.push_back(n3);
  n2->children.push_back(n5);
  n3->children.push_back(n4);
  n4->children.push_back(n1);
  n4->children.push_back(n5);

  return n1;
}

// circle, don't move the same child up.
Node* CreateNodes2(map<int64, Node*>* lists,
                   set<pair<int, int64> >* permissioned_lists) {
  Node *n1 = AddNew();
  n1->id = 5;
  n1->type = 1;
  Node *n2 = AddNew();
  n2->id = 1;
  n2->type = 2;
  Node *n3 = AddNew();
  n3->id = 50;
  n3->type = 3;

  (*lists)[n1->id] = n1;
  (*lists)[n2->id] = n2;
  (*lists)[n3->id] = n3;
  permissioned_lists->insert(make_pair(n1->id, kAccountId));
  permissioned_lists->insert(make_pair(n2->id, kAccountId));
  permissioned_lists->insert(make_pair(n3->id, kAccountId));

  n1->children.push_back(n2);
  n2->children.push_back(n3);
  n2->children.push_back(n1);

  return n1;
}

// child has single child
Node* CreateNodes3(map<int64, Node*>* lists,
                   set<pair<int, int64> >* permissioned_lists) {
  Node *n1 = AddNew();
  n1->id = 1;
  n1->type = 3;
  Node *n2 = AddNew();
  n2->id = 2;
  n2->type = 2;
  Node *n3 = AddNew();
  n3->id = 3;
  n3->type = 1;
  Node *n4 = AddNew();
  n4->id = 4;
  n4->type = 2;

  (*lists)[n1->id] = n1;
  (*lists)[n2->id] = n2;
  (*lists)[n3->id] = n3;
  (*lists)[n4->id] = n4;
  permissioned_lists->insert(make_pair(n1->id, kAccountId));
  permissioned_lists->insert(make_pair(n2->id, kAccountId));
  permissioned_lists->insert(make_pair(n3->id, kAccountId));
  permissioned_lists->insert(make_pair(n4->id, kAccountId));

  n2->children.push_back(n1);
  n3->children.push_back(n1);
  n3->children.push_back(n2);
  n4->children.push_back(n1);
  n4->children.push_back(n3);

  return n4;
}

// child has single child with NOT.
Node* CreateNodes4(map<int64, Node*>* lists,
                   set<pair<int, int64> >* permissioned_lists) {
  Node *n1 = AddNew();
  n1->id = 5;
  n1->type = 1;
  Node *n2 = AddNew();
  n2->id = 1;
  n2->type = 0;
  Node *n3 = AddNew();
  n3->id = 100;
  n3->type = 3;

  (*lists)[n1->id] = n1;
  (*lists)[n2->id] = n2;
  (*lists)[n3->id] = n3;
  permissioned_lists->insert(make_pair(n1->id, kAccountId));
  permissioned_lists->insert(make_pair(n2->id, kAccountId));
  permissioned_lists->insert(make_pair(n3->id, kAccountId));

  n1->children.push_back(n2);
  n2->children.push_back(n3);

  return n1;
}

// with a revoked node
Node* CreateNodes5(map<int64, Node*>* lists,
                   set<pair<int, int64> >* permissioned_lists) {
  Node *n1 = AddNew();
  n1->id = 5;
  n1->type = 1;
  Node *n2 = AddNew();
  n2->id = 1;
  n2->type = 2;
  Node *n3 = AddNew();
  n3->id = 50;
  n3->type = 1;
  Node *n4 = AddNew();
  n4->id = 2;
  n4->type = 1;
  Node *n5 = AddNew();
  n5->id = 500;
  n5->type = 3;
  Node *n6 = AddNew();
  n6->id = 10;
  n6->type = 3;
  Node *n7 = AddNew();
  n7->id = 1;
  n7->type = 3;

  (*lists)[n1->id] = n1;
  (*lists)[n2->id] = n2;
  (*lists)[n3->id] = n3;
  (*lists)[n4->id] = n4;
  (*lists)[n5->id] = n5;
  (*lists)[n6->id] = n6;
  (*lists)[n7->id] = n7;
  permissioned_lists->insert(make_pair(n1->id, kAccountId));
  permissioned_lists->insert(make_pair(n2->id, kAccountId));
  // n3 (id=50, type=1) is not in permissioned list.
  permissioned_lists->insert(make_pair(n4->id, kAccountId));
  permissioned_lists->insert(make_pair(n5->id, kAccountId));
  permissioned_lists->insert(make_pair(n6->id, kAccountId));
  permissioned_lists->insert(make_pair(n7->id, kAccountId));

  n1->children.push_back(n2);
  n2->children.push_back(n3);
  n2->children.push_back(n7);
  n3->children.push_back(n4);
  n4->children.push_back(n5);
  n4->children.push_back(n6);

  return n1;
}

Node* CreateNodes(map<int64, Node*>* lists,
                  set<pair<int, int64> >* permissioned_lists) {
  return CreateNodes5(lists, permissioned_lists);
}

bool LogicalListContainsThisNode(const map<int64, Node*>& lists, Node* node) {
  map<int64, Node*>::const_iterator it = lists.find(node->id);
  return (it != lists.end()) && (it->second == node);
}

bool PermissionedUserlistsContainsThisId(
    const set<pair<int, int64> >& permissioned_userlists,
    const int account_id, const int64 userlist_id) {
  return permissioned_userlists.count(make_pair(account_id, userlist_id)) > 0;
}

bool MoveChildrenUp(Node* node, const int idx) {
  Node* child = node->children[idx];
  if (child->children.size() == 0) {
    return false;
  }
  if (child == node) {
    cout << "same node, don't move up." << endl;
    return false;
  }
  node->children.erase(node->children.begin() + idx);
  node->children.insert(node->children.end(),
			child->children.begin(), child->children.end());
  return true;
}

bool SimplifyNodeIter(const map<int64, Node*>& lists,
                      const set<pair<int, int64> >& permissioned_lists,
                      const int account_id,
                      Node* node, set<Node*>* processed_set, bool* is_circle) {
  if (processed_set->find(node) != processed_set->end()) {
    cout << "circle: " << node->id << endl;
    *is_circle = true;
    return false;
  }

  bool has_changed = false;
  bool is_logical_root = LogicalListContainsThisNode(lists, node);

  // copys the only child's type and children.
  if (is_logical_root && node->children.size() == 1) {
    Node* child = node->children[0];
    if ((node->type == 1 || node->type == 2) &&
        (child->type == 0 || child->type == 1 || child->type == 2)) {
      // Make sure the removed child has not any permission issue.
      if (!(LogicalListContainsThisNode(lists, child) &&
            !PermissionedUserlistsContainsThisId(
                permissioned_lists, account_id, child->id))) {
        if (MoveChildrenUp(node, 0)) {
          has_changed = true;
          node->type = child->type;
        }
      }
    }
  }

  if (is_logical_root && (node->type == 1 || node->type == 2)) {
    for (int j = 0; j < node->children.size(); ++j) {
      Node* child = node->children[j];
      // Make sure the removed child has not any permission issue.
      if ((LogicalListContainsThisNode(lists, child) &&
           !PermissionedUserlistsContainsThisId(
               permissioned_lists, account_id, child->id))) {
        continue;
      }

      // single child for AND/OR
      if (child->children.size() == 1 && child->type != 0) {
	has_changed = has_changed || MoveChildrenUp(node, j);
      }
      // same operation for AND/OR
      if (node->type == child->type) {
	has_changed = has_changed || MoveChildrenUp(node, j);
      }
    }
  }
  // recursive
  processed_set->insert(node);
  for (int j = 0; j < node->children.size(); ++j) {
    Node* child = node->children[j];
    if (child->type == 0 || child->type == 1 || child->type == 2) {
      has_changed = (has_changed ||
                     SimplifyNodeIter(lists, permissioned_lists,
                                      account_id,
                                      child, processed_set, is_circle));
    }
  }
  processed_set->erase(node);
  // dedupe
  set<int64> s;
  for (int j = 0; j < node->children.size(); ++j) {
    Node* child = node->children[j];
    if (s.find(child->id) == s.end()) {
      s.insert(child->id);
    } else {
      node->children.erase(node->children.begin() + j);
      --j;
      has_changed = true;
    }
  }

  return has_changed;
}

string TypeToStr(const int type) {
  switch (type) {
    case 0:
      return "NOT";
    case 1:
      return "AND";
    case 2:
      return "OR";
    case 3:
      return "TERM";
    default:
      return "ERROR";
  }
}

void PrintNode(const int depth, int64 parent_id, Node* node, set<Node*>* processed_set) {
  cout << "[" << depth << "], parent: [" << parent_id
       << "]\tnode: (" << node->id << ", "
       << TypeToStr(node->type) << ")" << endl;

  if (processed_set->find(node) != processed_set->end()) {
    cout << "circle...." << endl;
    return;
  }
  processed_set->insert(node);
  for (int j = 0; j < node->children.size(); ++j) {
    PrintNode(depth + 1, node->id, node->children[j], processed_set);
  }
  processed_set->erase(node);
}


bool SimplifyNode(const map<int64, Node*>& lists,
                  const set<pair<int, int64> >& permissioned_lists,
                  const int account_id,
                  Node* node, bool* is_circle) {
  set<Node*> processed_set;
  int cnt = 0;
  do {
    ++cnt;
    processed_set.clear();
    cout << "========1========" << endl;
    PrintNode(0, 0, node, &processed_set);
  } while (SimplifyNodeIter(lists, permissioned_lists,
                            account_id, node, &processed_set, is_circle));

  return cnt > 1;
}

int main() {
  map<int64, Node*> lists;
  set<pair<int, int64> > permissioned_lists;
  const int account_id = kAccountId;
  Node* node = CreateNodes(&lists, &permissioned_lists);

  bool is_circle = false;
  SimplifyNode(lists, permissioned_lists, account_id, node, &is_circle);
  cout << "is_circle: " << is_circle << endl;

  set<Node*> processed_set;
  cout << "========2========" << endl;
  PrintNode(0, 0, node, &processed_set);

  ReleaseNodes();
  return 0;
}
