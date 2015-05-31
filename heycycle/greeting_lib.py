from google.appengine.ext import db


class Greeting(db.Model):
  """Models an individual signup entry with an author, keyword, email, location, and date."""
  author = db.UserProperty()
  keyword = db.StringProperty(multiline=False)
  email = db.StringProperty(multiline=False)
  location = db.StringProperty(multiline=False)
  date = db.DateTimeProperty(auto_now_add=True)


def SignupKey(k, e, l):
  """Constructs a datastore key."""
  return '%s-%s-%s' % (k, e, l)


class Document(db.Model):
	keyword = db.StringProperty(multiline=False)
	location = db.StringProperty(multiline=False)
	title = db.StringProperty(multiline=False)
	addr = db.StringProperty(multiline=False)
	date = db.DateTimeProperty(auto_now_add=True)