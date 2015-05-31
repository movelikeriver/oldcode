import re
import time
import urllib
import urllib2
import greeting_lib
from google.appengine.api import mail

print time.time()

def GetSignups(num=10):
	greetings_query = greeting_lib.Greeting.all().order('-date')
	greetings = greetings_query.fetch(num)
	rets = []
	for g in greetings:
		if g.keyword is None or g.email is None or g.location is None:
			break
		rets.append((g.keyword, g.email, g.location))
	return rets


def SendMail(to_addr, to_body, to_subject='HeyCycle Notification'):
	print 'SendMail to [', to_addr, ']'
	message = mail.EmailMessage(sender="Hey Cycle <heycycle.help@gmail.com>",
				    subject=to_subject)
	if not mail.is_email_valid(to_addr):
		print 'Invalid email: [', to_addr, ']'
		return
	if to_addr.find('@') == -1:
		return
	message.to = to_addr
	message.html = to_body
	message.send()

def ParsePage(content):
	content = content.replace('\n', '')	
	PATTERN = '\<td class=\'l.*?\'\>.*?\<strong\>(.*?)\</strong\>(.*?)\<br \/\>'
	p = re.compile(PATTERN)
	segs = p.findall(content)
	rets = []
	for seg in segs:
		title = seg[0].strip()
		addr = seg[1].strip()
		print '====title:', title, '<br/>'
		print '====addr:', addr, '<br/>'
		rets.append((title, addr))
	return rets

def FetchUrl(url):
	MAX_TRY_NUM = 3
	headers = {
		'User-Agent':
		'Mozilla/4.0 (compatible; MSIE 5.5; Windows NT)'}

	req = urllib2.Request(url=url, headers=headers)
	try_remain = MAX_TRY_NUM
	while try_remain > 0:
		try:
			file_handle = urllib2.urlopen(req)
			if file_handle:
				page = file_handle.read()
				return ParsePage(page)
			else:
				try_remain -= 1
				time.sleep(3)
		except IOError:
			print '%d, try again for url: [%s]' % (try_remain, url)
			try_remain -= 1
			time.sleep(3)
	return None


def Search(keyword, location='MountainViewCAFreecycle'):
	url = ('http://groups.freecycle.org/%s/posts/search?search_words=%s&include_offers=on&include_wanteds=on&'
		   'date_start=&date_end=&resultsperpage=1' % (location, urllib.quote(keyword)))
	print 'Search [%s]' % url
	return FetchUrl(url)


def GetDocMap(k, l, num=10):
	print 'GetDocMap for [%s] [%s]' % (k, l)
	q = greeting_lib.Document.all()
	q.filter('keyword = ', k)
	q.filter('location = ', l)

	results = q.fetch(num)
	ret_map = {}
	for r in results:
		print '%s %s' % (r.title, r.addr)
		ret_map[r.title] = r.addr
	return ret_map


def UpdateDocMap(keyword, location, title, addr):
	doc = greeting_lib.Document()
	doc.keyword = keyword
	doc.location = location
	doc.title = title
	doc.addr = addr
	doc.put()


def DoScan():
	print 'DoScan'
	rets = GetSignups(10)
	if not rets:
		print 'No signups'
		return
	for (k, e, l) in rets:
		res = Search(k)  # need change location
		if not res:
			print 'No result for [%s] [%s]' % (k, l)
			continue
		doc_map = GetDocMap(k, l, 100)
		msg_list = []
		for (title, addr) in res:
			if title in doc_map:
				continue
			msg_list.append('title: %s, addr: %s' % (title, addr))
			doc_map[title] = addr
			UpdateDocMap(k, l, title, addr)
		if not msg_list:
			print 'Nothing updated for [%s] [%s]' % (k, l)
			continue
		unsub_link = 'http://heycycle.appspot.com/unsubscribe?keyword=%s&email=%s&location=%s' % (
			urllib.quote(k), e, urllib.quote(l))
		body = ('<html>keyword: %s, location: %s<br/>%s<br/><br/>'
				'To unsubscribe this search, click <a href=\"%s\">unsubscribe</a></html>') % (k, l, '<br/>'.join(msg_list), unsub_link)
		SendMail(e, body, to_subject='HeyCycle Notification - %s - %s' % (k, l))

# Main
DoScan()
