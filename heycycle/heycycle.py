import cgi
import datetime
import os
import urllib
import wsgiref.handlers

import greeting_lib

from google.appengine.api import users
from google.appengine.ext import webapp
from google.appengine.ext.webapp import template
from google.appengine.ext.webapp.util import run_wsgi_app


class MainPage(webapp.RequestHandler):
	def get(self):
		signup_name = self.request.get('signup_name')
		greetings_query = greeting_lib.Greeting.all().order('-date')
		greetings = greetings_query.fetch(10)

		if users.get_current_user():
			url = users.create_logout_url(self.request.uri)
			url_linktext = 'Logout'
		else:
			url = users.create_login_url(self.request.uri)
			url_linktext = 'Login'

		template_values = {
			'greetings': greetings,
		    'url': url,
		    'url_linktext': url_linktext,
		}

		path = os.path.join(os.path.dirname(__file__), 'index.html')
		self.response.out.write(template.render(path, template_values))


class Sign(webapp.RequestHandler):
	def SaveGreeting(self, k, e, l):
		key_name = greeting_lib.SignupKey(k, e, l)
		greeting = greeting_lib.Greeting(key_name=key_name)
		if users.get_current_user():
			greeting.author = users.get_current_user()
		greeting.keyword = k
		greeting.email = e
		greeting.location = l
		greeting.put()
		
	def post(self):
		# We set the same parent key on the 'Greeting' to ensure each greeting is in
		# the same entity group. Queries across the single entity group will be
		# consistent. However, the write rate to a single entity group should
		# be limited to ~1/second.
		k = self.request.get('keyword')
		e = self.request.get('email')
		l = self.request.get('location')
		self.SaveGreeting(k, e, l)
		link = '/'
		url_linktext = 'HeyCycle Home Page'
		template_values = {
			'keyword': k,
			'email': e,
			'location': l,
			'url': link,
			'url_linktext': url_linktext
		}
		path = os.path.join(os.path.dirname(__file__), 'sign.html')
		self.response.out.write(template.render(path, template_values))


class Unsubscribe(webapp.RequestHandler):
	def get(self):
		k = self.request.get('keyword')
		e = self.request.get('email')
		l = self.request.get('location')
		greeting = greeting_lib.Greeting(key_name=greeting_lib.SignupKey(k, e, l))
		greeting.keyword = k
		greeting.email = e
		greeting.location = l
		#		greeting.date = self.request.get('date')
		greeting.delete()
		url = '/'
		url_linktext = 'Try another keyword'
		template_values = {
			'greeting': greeting,
			'url': url,
			'url_linktext': url_linktext,
		}

		path = os.path.join(os.path.dirname(__file__), 'unsubscribe.html')
		self.response.out.write(template.render(path, template_values))


application = webapp.WSGIApplication(
	[('/', MainPage),
	 ('/sign', Sign),
	 ('/unsubscribe', Unsubscribe),
    ],
    debug=True)


def main():
    run_wsgi_app(application)

if __name__ == "__main__":
    main()