(function($) { if (!window.google) { alert('You must include the Google AJAX Feed API script'); return;}
if (!google.feeds) google.load("feeds", "1"); $.fn.gFeed = function(options) { var opts = jQuery.extend({ target: this, max: 5
}, options || {}); var g = new google.feeds.FeedControl(); this.each(function() { var url = this.href || opts.url; var title = opts.title || this.title || $(this).text(); g.addFeed(url, title); g.setNumEntries(opts.max);}); $(opts.target).each(function() { g.draw(this, opts.tabs ? { drawMode: google.feeds.FeedControl.DRAW_MODE_TABBED } : null );}); return this;};})(jQuery); 

