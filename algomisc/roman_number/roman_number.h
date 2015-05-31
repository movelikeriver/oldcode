// author: mars.lenjoy@gmail.com (2009)
//
// How to convert Arabic numerals to Roman numerals?
// I(1)，V(5)，X(10)，L(50)，C(100)，D(500)，M(1000)

#ifndef ROMAN_NUMBER_H
#define ROMAN_NUMBER_H

#include <string>
using namespace std;

class RomanNumber {
 public:
  RomanNumber();
  ~RomanNumber();

  // return 0: success, -1: error.
  static int ArabToRoman(const int n_arab, string *str_roman);

  // protected:
  // posi: 3210
  // return 0: success, -1: error.
  static int GetRomanByPosi(const int value,
			    const int posi,
			    string *str_roman);

 private:
  static const string kRomanLetters[];
};

#endif
