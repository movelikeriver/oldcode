#include <iostream>
#include <map>
#include <string>

using namespace std;

//////////////////////////////////////////
//  Sample class for processing the file.
//////////////////////////////////////////

class FormatBase {
 public:
  FormatBase() : map_int_string_(NULL), map_int_int_(NULL) { }
  ~FormatBase() {
    delete map_int_string_;
    delete map_int_int_;
  }

  const map<int, string>& map_int_string() const {
    return *map_int_string_;
  }

  map<int, string>* mutable_map_int_string() {
    if (!map_int_string_) {
      map_int_string_ = new map<int, string>();
    }
    return map_int_string_;
  }

  const map<int, int>& map_int_int() const {
    return *map_int_int_;
  }

  map<int, int>* mutable_map_int_int() {
    if (!map_int_int_) {
      map_int_int_ = new map<int, int>();
    }
    return map_int_int_;
  }

  // more methods...

 private:
  map<int, string>* map_int_string_;
  map<int, int>* map_int_int_;

  // more types...
};

class LoaderBase {
 public:
  LoaderBase() : name_("== LoaderBase ==") { }
  virtual ~LoaderBase() { }

  const FormatBase& GetData() const {
    return m_;
  }

  const string& name() const {
    return name_;
  }
 protected:
  string name_;
  FormatBase m_;
};

class LogicalMap : public LoaderBase {
 public:
  explicit LogicalMap(const string& path) {
    m_.mutable_map_int_string()->insert(map<int, string>::value_type(
        0, "LogicalMap_" + path));
    name_ = "== LogicalMap ==";
  }

  ~LogicalMap() { }
};

//////////////////////////////////////////
//  Sample class for processing the file.
//////////////////////////////////////////

class DFMap : public LoaderBase {
 public:
  explicit DFMap(const string& path) {
    m_.mutable_map_int_int()->insert(map<int, int>::value_type(
        0, path.length()));
    name_ = "== DFMap ==";
  }

  ~DFMap() { }
};

//////////////////////////////////////////
// Factory
//////////////////////////////////////////

LoaderBase* GetLoaderByName(const string& path) {
  // The more effective way is to put all the Loaders into a pool, then no need
  // to create it each time.
  if (path == "logical_map_path") {
    return new LogicalMap(path);
  } else if (path == "df_map_path") {
    return new DFMap(path);
  } else {
    cout << "FATAL..." << endl;
  }
  return NULL;
}

int test1() {
  LoaderBase* loader = GetLoaderByName("logical_map_path");
  cout << loader->name() << endl;
  const map<int, string>& m1 = loader->GetData().map_int_string();
  for (map<int, string>::const_iterator it = m1.begin();
       it != m1.end(); ++it) {
    cout << it->first << ", " << it->second << endl;
  }
  delete loader;

  loader = GetLoaderByName("df_map_path");
  cout << loader->name() << endl;
  const map<int, int>& m2 = loader->GetData().map_int_int();
  for (map<int, int>::const_iterator it = m2.begin();
       it != m2.end(); ++it) {
    cout << it->first << ", " << it->second << endl;
  }
  delete loader;

  return 0;
}


int main() {
  return test1();
}
