#!/usr/bin/env python
#
# Copyright 2007 Google Inc.
#
# Licensed under the Apache License, Version 2.0 (the "License");
# you may not use this file except in compliance with the License.
# You may obtain a copy of the License at
#
#     http://www.apache.org/licenses/LICENSE-2.0
#
# Unless required by applicable law or agreed to in writing, software
# distributed under the License is distributed on an "AS IS" BASIS,
# WITHOUT WARRANTIES OR CONDITIONS OF ANY KIND, either express or implied.
# See the License for the specific language governing permissions and
# limitations under the License.
#

__author__ = 'jcgregorio@google.com (Joe Gregorio)'


import cgi
import httplib2
import logging
import os
import pickle
import time

from apiclient import discovery
from apiclient.discovery import build
from oauth2client.appengine import CredentialsProperty
from oauth2client.appengine import StorageByKeyName
from oauth2client.client import OAuth2WebServerFlow
from google.appengine.api import memcache
from google.appengine.api import users
from google.appengine.ext import db
from google.appengine.ext import webapp
from google.appengine.ext.webapp import template
from google.appengine.ext.webapp import util
from google.appengine.ext.webapp.util import login_required


class Credentials(db.Model):
  credentials = CredentialsProperty()


class MainHandler(webapp.RequestHandler):

  def _Merge(self, actlist1, actlist2):
    for idx, data in enumerate(actlist2.items()):
      (key, value) = data
      if key == 'items':
        items_index2 = idx
        break

    for idx, data in enumerate(actlist1.items()):
      (key, value) = data
      if key == 'items':
        items_index1 = idx
        break

    # ft... Merge doesn't work...
    actlist1.items()[items_index1] = (
      'items',
      actlist1.items()[items_index1][1] + actlist2.items()[items_index2][1])
    return actlist1

  def _ParseTime(self, time_str):
    """Parse time like: '2011-03-24T18:47:40.160Z'."""
    idx1 = time_str.find('T')
    idx2 = time_str.rfind('.')
    return (time_str[0 : idx1], time_str[idx1+1 : idx2])

  def _Count(self, activity):
    post_cnt = 0
    replied_cnt = 0
    TIME_DIFF_SEC = 3600 * 24 * 14  # 2 weeks
    NOW = time.time()
    for key, data in activity.items():
      if key == 'items':
        for d in data:
          date_str, hour_str = self._ParseTime(d['updated'])
          ts = time.mktime(
            time.strptime('%s %s' % (date_str, hour_str),
                          '%Y-%m-%d %H:%M:%S'))
          if NOW - ts > TIME_DIFF_SEC:
            continue
          post_cnt += 1
          replies = d['links']['replies']
          for reply in replies:
            replied_cnt += reply['count']
        break

    return post_cnt, replied_cnt

  def _GetList(self, http, scope, userId, max_results=50):
    """Get lists from service.

    Refers to:
    https://code.google.com/apis/explorer/#_s=buzz&_v=v1&_m=activities.list
    """

    service = build("buzz", "v1", http=http)
    activities = service.activities()
    return activities.list(scope=scope, userId=userId,
                           max_results=max_results).execute()

  def _GetGroup(self, http, userId, groupId):
    """Get followers and following."""

    service = build("buzz", "v1", http=http)
    people = service.people()
    return people.list(userId=userId, groupId=groupId).execute()

  @login_required
  def get(self):
    user = users.get_current_user()
    credentials = StorageByKeyName(
        Credentials, user.user_id(), 'credentials').get()

    if credentials is None or credentials.invalid == True:
      flow = OAuth2WebServerFlow(
          # Visit https://code.google.com/apis/console to
          # generate your client_id, client_secret and to
          # register your redirect_uri.
          client_id=discovery.CLIENT_ID,
          client_secret=discovery.CLIENT_SECRET,
          scope='https://www.googleapis.com/auth/buzz',
          user_agent='buzz-cmdline-sample/1.0',
          domain='http://localhost:8080/',
          xoauth_displayname='Google App Engine Example App')

      callback = self.request.relative_url('/auth_return')
      authorize_url = flow.step1_get_authorize_url(callback)
      memcache.set(user.user_id(), pickle.dumps(flow))
      self.redirect(authorize_url)
    else:
      user_id = cgi.escape(self.request.get('user_id'))
      if not user_id:
        user_id = '@me'
      http = httplib2.Http()
      http = credentials.authorize(http)
      selflist = self._GetList(http, scope='@self', userId=user_id)

      followerslist = self._GetGroup(http, userId=user_id, groupId='@followers')
      followinglist = self._GetGroup(http, userId=user_id, groupId='@following')

      debug_str = user_id + ', '
      k, v = self._Count(selflist)
      debug_str += '(%d, re: %d), ' % (k, v)

      path = os.path.join(os.path.dirname(__file__), 'welcome.html')
      logout = users.create_logout_url('/')
      self.response.out.write(
          template.render(
              path, {'selflist': selflist,
                     'followerslist': followerslist,
                     'followinglist': followinglist,
                     'debug_str': debug_str,
                     'logout': logout
                     }))


class OAuthHandler(webapp.RequestHandler):

  @login_required
  def get(self):
    user = users.get_current_user()
    flow = pickle.loads(memcache.get(user.user_id()))
    if flow:
      credentials = flow.step2_exchange(self.request.params)
      StorageByKeyName(
          Credentials, user.user_id(), 'credentials').put(credentials)
      self.redirect("/")
    else:
      pass


def main():
  application = webapp.WSGIApplication(
      [
      ('/', MainHandler),
      ('/auth_return', OAuthHandler)
      ],
      debug=True)
  util.run_wsgi_app(application)


if __name__ == '__main__':
  main()
