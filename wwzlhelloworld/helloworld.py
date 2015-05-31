import cgi
import getopt
import os
import sys
import traceback

from google.appengine.ext.webapp import template

from google.appengine.api import users
from google.appengine.ext import webapp
from google.appengine.ext.webapp.util import run_wsgi_app
from google.appengine.ext import db


#
# Load Buzz library (if available...)
#

try:
    import buzz
except ImportError:
    print 'Error importing Buzz library!!!'

print '-' * 80
print __doc__
print '-' * 80

token = verification_code = buzz_client = ''


def GetLoginData():
    'Obtains login information from either the command line or by querying the user'

    global token, verification_code, buzz_client
    key = secret = ''
 
    # Check first if anything is specified in the command line

    print '=' * 30
    print sys.argv
    print '=' * 30

    if len(sys.argv[1:]):
        try:
            (opts, args) = getopt.getopt(sys.argv[1:], 'k:s:v:', ['key','secret', 'vercode']) 
            if (len(args)):        raise getopt.GetoptError('bad parameter')

        except getopt.GetoptError:
            print '''
Usage:    %s <-t access token> <-a verification_code>

-k (--key):        OPTIONAL, previously obtained access token key
-s (--secret):        OPTIONAL, previously obtained access token secret

Exiting...
            ''' % (sys.argv[0])
            sys.exit(0)

        print opts
        for (opt, arg) in opts:
            if opt in ('-k', '--key'):
                key = arg
            elif opt in ('-s', '--secret'):
                secret = arg

    print '=' * 40

    # Query the user for data otherwise - we need key and secret for our OAuth request token.

    if ((key == '') or (secret == '')):
        token = buzz_client.fetch_oauth_request_token ('oob')
        token = buzz_client.oauth_request_token

        print '''
Please access the following URL to confirm access to Google Buzz:

%s

Once you're done enter the verification code to continue: ''' % (buzz_client.build_oauth_authorization_url(token)),

        verification_code = raw_input().strip()
        buzz_client.fetch_oauth_access_token (verification_code, token)
    else:
        buzz_client.build_oauth_access_token(key, secret)

    # Do we have a valid OAUth access token?

    if (buzz_client.oauth_token_info().find('Invalid AuthSub signature') != (-1)):
        print 'Access token is invalid!!!'
        sys.exit(0)
    else:
        print '''
Your access token key is \'%s\', secret is \'%s\'
Keep this data handy in case you want to reuse the session later!
''' % (buzz_client.oauth_access_token.key, buzz_client.oauth_access_token.secret)



def DoBuzz():
    global buzz_client
    buzz_client = buzz.Client()
    buzz_client.oauth_scopes=[buzz.FULL_ACCESS_SCOPE]
#    buzz_client.api_key = 'AIzaSyDnz3pf-uhM0CirG9MwgtEXFQr41zc22Es'
    buzz_client.use_anonymous_oauth_consumer()

    GetLoginData()
    print '~' * 30

    print '\nEnter user ID to query (ENTER for \"@me\"): ',
    user_id = raw_input().strip()
    if (user_id == ''): user_id = '@me'

    followers = buzz_client.followers('@me').data
    followings = buzz_client.following('@me').data

    print 'User %s has %d followers ...' % (user_id, len(followers))
    print '\n'.join(["%s: %s" % (follower.id, follower.name) for follower in followers])

    print '... and is following %d users' % (len(followings))
    print '\n'.join(["%s: %s" % (following.id, following.name) for following in followings])

    print '\nAll done'


class Buzz(webapp.RequestHandler):
    def get(self):
        DoBuzz();


application = webapp.WSGIApplication(
                                     [('/buzz', Buzz)],
                                     debug=True)

def main():
    run_wsgi_app(application)

if __name__ == "__main__":
    main()
