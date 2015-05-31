// Copyright 2009 Lenjoy. All Rights Reserved.
// Author: mars.lenjoy@gmail.com (Lenjoy)

#include "urlpattern.h"

#include <algorithm>
#include <iostream>
using namespace std;

namespace urlpattern {
static const int kThreshold = 70;


UrlPattern::UrlPattern() {
  Init();
}

UrlPattern::~UrlPattern() {}

void UrlPattern::Init() {
  segments_.clear();
  segments_.insert('/');
  segments_.insert('?');
}

void UrlPattern::SplitStringBySegments(const string& inputstr,
				       const set<char>& segments,
				       vector<string>* segs) {
  segs->clear();
  int index = -1;
  for (int j = 0; j < inputstr.length(); ++j) {
    if (segments.find(inputstr[j]) != segments.end()) {
      if (index + 1 < j) {
	segs->push_back(inputstr.substr(index + 1, j - index - 1));
	segs->push_back(inputstr.substr(j, 1));
      }
      index = j;
    }
  }
  if (index + 1 < inputstr.length()) {
    segs->push_back(inputstr.substr(index + 1,
				    inputstr.length() - index - 1));
  }
}

void UrlPattern::JoinString(const vector<string>& input_vector,
			    const string& segment,
			    string* joined_string) {
  joined_string->clear();
  for (vector<string>::const_iterator it = input_vector.begin();
       it != input_vector.end(); ++it) {
    if (!joined_string->empty() && !segment.empty()) {
      joined_string->append(segment);
    }
    joined_string->append(*it);
  }
}

int UrlPattern::GetVector(const string& url, SignalVector* signal_vector) {
  signal_vector->clear();
  SplitStringBySegments(url, segments_, signal_vector);
  return 0;
}

int UrlPattern::GetPatternByVector(const SignalVector& signal_vector,
				   ObjectPattern* pattern) {
  JoinString(signal_vector, "", pattern);
  return 0;
}

int UrlPattern::IsSegment(const string& str) {
  return str.length() == 1 && segments_.find(str[0]) != segments_.end();
}

int UrlPattern::VectorCmp(const SignalVector& vec1,
			  const SignalVector& vec2,
			  SignalVector* common_vec) {
  set<string> s;
  for (int j = 0; j < vec1.size(); ++j) {
    if (!IsSegment(vec1[j])) {
      s.insert(vec1[j]);
    }
  }
  bool last_is_term = false;
  for (int j = 0; j < vec2.size(); ++j) {
    if (IsSegment(vec2[j])) {
      continue;
    }
    if (s.find(vec2[j]) != s.end()) {
      if (!last_is_term && j > 0) {
	if (j > 0 && IsSegment(vec2[j - 1])) {
	  common_vec->push_back(vec2[j - 1]);
	}
	common_vec->push_back("(.+)");
      }
      if (j > 0 && IsSegment(vec2[j - 1])) {
	common_vec->push_back(vec2[j - 1]);
      }
      common_vec->push_back(vec2[j]);
      last_is_term = true;
    } else {
      last_is_term = false;
    }
  }
  return static_cast<int>(static_cast<float>(common_vec->size()) * 100.0 /
			  static_cast<float>(min(vec1.size(), vec2.size())));
}

bool UrlPattern::IsSimilarScore(const int score) {
  return kThreshold < score;
}

const SignalVector& UrlPattern::LookupSignalMap(
    const string& url,
    map<string, SignalVector>* signal_map) {
  map<string, SignalVector>::iterator it = signal_map->find(url);
  if (signal_map->end() == it) {
    SignalVector signal_vector;
    GetVector(url, &signal_vector);
    pair<map<string, SignalVector>::iterator, bool> p =
      signal_map->insert(
	  map<string, SignalVector>::value_type(url, signal_vector));
    return p.first->second;
  }
  return it->second;
}

int UrlPattern::AddToCluster(const ObjectPattern& patternkey,
			     const string& url,
			     ClusterType* clusters) {
  ClusterType::iterator it = clusters->find(patternkey);
  if (it == clusters->end()) {
    set<string> s;
    s.insert(url);
    clusters->insert(ClusterType::value_type(patternkey, s));
  } else {
    it->second.insert(url);
  }
  return 0;
}

int UrlPattern::Cluster(const vector<string>& urls,
			ClusterType* clusters) {
  clusters->clear();
  map<string, SignalVector> signal_map;
  for (int i = 0; i < urls.size(); ++i) {
    const SignalVector& signal_vector1 =
      LookupSignalMap(urls[i], &signal_map);
    for (int j = i + 1; j < urls.size(); ++j) {
      const SignalVector& signal_vector2 =
	LookupSignalMap(urls[j], &signal_map);
      SignalVector common_vector;
      // if object1 and object2 are similar, we generate:
      // common_pattern {object1, object2}
      if (IsSimilarScore(VectorCmp(signal_vector1,
				   signal_vector2,
				   &common_vector))) {
	ObjectPattern pattern;
	GetPatternByVector(common_vector, &pattern);
	AddToCluster(pattern, urls[i], clusters);
	AddToCluster(pattern, urls[j], clusters);
      }
    }
  }
  return 0;
}

int UrlPattern::Filter(ClusterType* clusters,
		       const int min_size) {
  for (ClusterType::iterator it = clusters->begin();
       it != clusters->end();) {
    if (it->second.size() < min_size) {
      ClusterType::iterator oldit = it;
      ++it;
      clusters->erase(oldit);
    } else {
      ++it;
    }
  }
  return 0;
}

void UrlPattern::PrintOutCluster(const ClusterType& clusters) {
  for (ClusterType::const_iterator it = clusters.begin();
       it != clusters.end(); ++it) {
    cout << "pattern: [" << it->first << "]" << endl;
    for (set<string>::const_iterator it2 = it->second.begin();
	 it2 != it->second.end(); ++it2) {
      cout << *it2 << endl;
    }
  }
}

}  // namespace urlpattern
