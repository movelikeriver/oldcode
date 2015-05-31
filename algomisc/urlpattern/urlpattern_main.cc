// Copyright 2009 Lenjoy. All Rights Reserved.
// Author: mars.lenjoy@gmail.com (Lenjoy)

#include "urlpattern.h"

#include <iostream>
#include <map>
#include <set>
#include <string>
#include <vector>
using namespace std;


void OutputVector(const urlpattern::SignalVector& vec) {
  for (urlpattern::SignalVector::const_iterator it = vec.begin();
       it != vec.end(); ++it) {
    cout << *it << endl;
  }
}

void OutputMap(const map<string, urlpattern::SignalVector>& signal_map) {
  for (map<string, urlpattern::SignalVector>::const_iterator it =
	 signal_map.begin();
       it != signal_map.end(); ++it) {
    cout << "key: " << it->first << endl;
    OutputVector(it->second);
  }
}

void DoLookupSignalMap() {
  string url = "http://domain.com/product/sdf/id//a/a/";
  map<string, urlpattern::SignalVector> signal_map;
  urlpattern::UrlPattern up;
  up.LookupSignalMap(url, &signal_map);
  url = "http://domain.com/product/sdf/id//a/fffa/";
  up.LookupSignalMap(url, &signal_map);
  url = "http://domain.com/product/sddff/id//a/a/";
  up.LookupSignalMap(url, &signal_map);
  url = "http://domain.com/product/sdf/id/fsdfa/a/a/";
  up.LookupSignalMap(url, &signal_map);
  OutputMap(signal_map);
}

void DoVectorCmp() {
  string str1[] = {
    "http", ":", "/", "/", "domain.com", "/",
    "ffds", "/", "product", "/", "sdf", "/", "id"
  };
  string str2[] = {
    "http", ":", "/", "/", "domain.com", "/",
    "fsdffds", "/", "product", "/", "34sdf", "/", "id"
  };
  urlpattern::SignalVector vec1, vec2, common_vec;
  for (int j = 0; j < sizeof(str1) / sizeof(str1[0]); ++j) {
    vec1.push_back(str1[j]);
  }
  for (int j = 0; j < sizeof(str2) / sizeof(str2[0]); ++j) {
    vec2.push_back(str2[j]);
  }
  urlpattern::UrlPattern up;
  int score = up.VectorCmp(vec1, vec2, &common_vec);
  cout << score << endl;
  for (int j = 0; j < common_vec.size(); ++j) {
    cout << common_vec[j] << endl;
  }
}

void DoCluster() {
  string rawurls[] = {
    "http://domain.com/product/sdf/id",
    "http://domain.com/product/ffa/id",
    "http://domain.com/product/234/id",
    "http://domain.com/product/sgg/id",
    "http://domain.com/product/sdflk/id",
    "http://domain.com/pro2duct/sgg/id",
    "http://domain.com/pro2duct/sdflk/id",
    "http://domain.com/pro2duct/sgg/id",
    "http://domain.com/pro2duct/sdflk/id",
    "http://domain.com/product/sgg/id",
    "http://domain.com/product/sdflk/id",
    "http://domain.com/product/4r98h/id",
    "http://domain.com/pro2duct/0oouyf/id",
    "http://domain.com/product/sfff8/id",
    "http://domain.com/product/s2df7/id",
  };
  vector<string> urls;
  for (int j = 0; j < sizeof(rawurls) / sizeof(rawurls[0]); ++j) {
    urls.push_back(rawurls[j]);
  }
  urlpattern::UrlPattern up;
  urlpattern::ClusterType clusters;
  up.Cluster(urls, &clusters);
  up.Filter(&clusters, 3);
  up.PrintOutCluster(clusters);
}

int main() {
  DoLookupSignalMap();
  DoVectorCmp();
  DoCluster();
  return 0;
}
