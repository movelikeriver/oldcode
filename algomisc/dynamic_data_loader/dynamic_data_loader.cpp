#include <iostream>
#include <map>
using namespace std;

typedef map<int, string> DefaultType;

//////////////////////////////////////////
//  Sample class for processing the file.
//////////////////////////////////////////

class LogicalMap {
public:
  LogicalMap(const string& path): m_(NULL) {
    if (m_ == NULL) {
      m_ = new DefaultType();
      (*m_)[0] = "LogicalMap_" + path;
    }
  }

  ~LogicalMap() {}

  DefaultType* GetData() const {
    return m_;
  }

private:
  DefaultType* m_;
};

//////////////////////////////////////////
//  Sample class for processing the file.
//////////////////////////////////////////

class DFMap {
public:
  DFMap(const string& path): m_(NULL) {
    if (m_ == NULL) {
      m_ = new DefaultType();
      (*m_)[0] = "DFMap_" + path;
    }
  }

  ~DFMap() {}

  DefaultType* GetData() const {
    return m_;
  }

private:
  DefaultType* m_;
};

////////////////////////////////////////
//  File data interface
////////////////////////////////////////

template<class DataType, class LoaderType>
class IFileData {
public:
  static const IFileData<DataType, LoaderType>* GetFileData(
      const string& path, const bool force_reload);

  const DataType& m() const {
    {
      // read lock
      return *m_;
    }
  }

protected:
  bool LoadData() {
    cout << "LoadData()" << endl;

    // Do sth to decide whether need to reload.
    // ,,,

    DataType* m = LoaderType(path_).GetData();
    if (m->empty()) {
      delete m;
      return false;
    }

    {
      // write lock
      m_ = m;
    }

    return true;
  }

  IFileData(const string& path): path_(path) {
    cout << "IFileData construct" << endl;
    is_health_ = LoadData();
  }

private:
  string path_;
  DataType* m_;
  bool is_health_;
};


template<class DataType, class LoaderType>
const IFileData<DataType, LoaderType>* IFileData<
  DataType, LoaderType>::GetFileData(
      const string& path, const bool force_reload) {
  static map<string, IFileData<DataType, LoaderType>*> file_data_map;
  typename map<string, IFileData<DataType, LoaderType>*>::iterator it =
      file_data_map.find(path);
  if (it == file_data_map.end()) {
    cout << "init..." << endl;
    it = file_data_map.insert(
        typename map<string, IFileData* >::value_type(
            path, new IFileData<DataType, LoaderType>(path))).first;
    return it->second;
  }
  if (!force_reload) {
    cout << "in cache" << endl;
    return it->second;
  }

  IFileData<DataType, LoaderType>* data =
      new IFileData<DataType, LoaderType>(path);
  if (data->is_health_) {
    {
      // write lock
      if (it->second) {
        delete it->second;
      }
      it->second = data;
      cout << "swap..." << endl;
    }
  } else {
    cout << "data is not health" << endl;
  }
  return it->second;
}

//////////////////////////////////////////
//  Testing run.
//////////////////////////////////////////

int test1() {
  cout << "==1==" << endl;
  const DefaultType& m1 = IFileData<DefaultType, LogicalMap>::GetFileData(
      "path_1", false)->m();
  cout << m1.find(0)->second << endl;

  cout << "==2==" << endl;
  const DefaultType& m2 = IFileData<DefaultType, DFMap>::GetFileData(
      "path_2", false)->m();
  cout << m2.find(0)->second << endl;

  cout << "==3==" << endl;
  const DefaultType& m3 = IFileData<DefaultType, DFMap>::GetFileData(
      "path_2", false)->m();
  cout << m3.find(0)->second << endl;

  cout << "==4==" << endl;
  const DefaultType& m4 = IFileData<DefaultType, LogicalMap>::GetFileData(
      "path_1", false)->m();
  cout << m4.find(0)->second << endl;

  cout << "==5==" << endl;
  const DefaultType& m5 = IFileData<DefaultType, LogicalMap>::GetFileData(
      "path_1", true)->m();
  cout << m5.find(0)->second << endl;
  return 0;
}


int main() {
  return test1();
}
