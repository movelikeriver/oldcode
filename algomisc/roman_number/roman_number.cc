// author: mars.lenjoy@gmail.com (2009)

#include "roman_number.h"
#include <iostream>
using namespace std;

static const int kUnits[4] = {1, 10, 100, 1000};

const string RomanNumber::kRomanLetters[7] = {
  "I", "V", "X", "L", "C", "D", "M"};

RomanNumber::RomanNumber() {
}

RomanNumber::~RomanNumber() {
}

int RomanNumber::ArabToRoman(const int n_arab, string *str_roman) {
  if (n_arab <= 0 || n_arab > 3999) {
    cout << __LINE__ << " ERROR: n_arab <= 0 || n_arab > 3999" << endl;
    return -1;
  }
  for (int j = 3; j >= 0; --j) {
    GetRomanByPosi((int)(n_arab / kUnits[j]) % 10, j, str_roman);
  }
  return 0;
}

int RomanNumber::GetRomanByPosi(const int value,
				const int posi,
				string *str_roman) {
  if (posi < 0 || posi > 3) {
    cout << "ERROR: posi < 0 || posi > 3" << endl;
    return -1;
  }
  if (value < 0 || value > 9) {
    cout << "ERROR: value < 0 || value > 9" << endl;
    return -1;
  }
  if (posi == 3 && value > 3) {
    cout << "ERROR: posi == 0 && value > 3" << endl;
    return -1;
  }

  switch(value) {
  case 1:
  case 2:
  case 3:
    for (int j = 0; j < value; ++j) {
      str_roman->append(kRomanLetters[2*posi]);
    }
    break;
  case 4:
    str_roman->append(kRomanLetters[2*posi]);
    str_roman->append(kRomanLetters[2*posi+1]);
    break;
  case 5:
  case 6:
  case 7:
  case 8:
    str_roman->append(kRomanLetters[2*posi+1]);
    for (int j = 5; j < value; ++j) {
      str_roman->append(kRomanLetters[2*posi]);
    }
    break;
  case 9:
    str_roman->append(kRomanLetters[2*posi]);
    str_roman->append(kRomanLetters[2*posi+2]);
    break;
  default:
    ;
  }
  return 0;
}
