// Copyright 2009 Lenjoy. All Rights Reserved.
// Author: mars.lenjoy@gmail.com (Lenjoy)

#ifndef URLPATTERN_URLPATTERN_H
#define URLPATTERN_URLPATTERN_H

#include <map>
#include <set>
#include <string>
#include <utility>
#include <vector>
using namespace std;

namespace urlpattern {

typedef vector<string> SignalVector;
typedef string ObjectPattern;
typedef map<ObjectPattern, set<string> > ClusterType;


class UrlPattern {
 public:
  UrlPattern();
  virtual ~UrlPattern();

  // Gets URL object's singal vector.
  int GetVector(const string& url, SignalVector* signal_vector);

  // Gets URL object's pattern by given signal vector.
  int GetPatternByVector(const SignalVector& signal_vector,
			 ObjectPattern* pattern);

  // Compares vectors and gets the score and common vector.
  int VectorCmp(const SignalVector& vec1,
		const SignalVector& vec2,
		SignalVector* common_vec);

  // Evaluates the score is similar or not.
  bool IsSimilarScore(const int score);

  // Looks up SignalVector in map, if not, inserts one.
  const SignalVector& LookupSignalMap(
      const string& url,
      map<string, SignalVector>* signal_map);

  // Adds the new pair to cluster.
  int AddToCluster(const ObjectPattern& patternkey,
		   const string& url,
		   ClusterType* clusters);

  // A cluster algorithm. Given some urls, devides them into several clusters.
  int Cluster(const vector<string>& urls,
	      ClusterType* clusters);

  // Filters the clusters whose size is lower than min_size.
  int Filter(ClusterType* clusters, const int min_size);

  void PrintOutCluster(const ClusterType& clusters);

 protected:
  void Init();
  int IsSegment(const string& str);

  // (TODO): move to a string lib.
  void SplitStringBySegments(const string& inputstr,
			     const set<char>& segments,
			     vector<string>* segs);

  // (TODO): move to a string lib.
  void JoinString(const vector<string>& input_vector,
		  const string& segment,
		  string* joined_string);

 private:
  set<char> segments_;
};
}  // namespace urlpattern

#endif
