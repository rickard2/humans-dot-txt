=== Humans Dot Txt ===
Contributors: exz
Tags: humans.txt
Requires at least: 2.7.0
Tested up to: 3.6-beta3
Stable tag: 1.1.1
Donate link: https://flattr.com/thing/128629/Humans-dot-txt

This plugin will add a dynamic humans.txt file generated from a template that you'll define yourself. 

== Description ==

This plugin will add a dynamic humans.txt file generated from a template that you'll define yourself. What's humans.txt? It's the latest thing on the web: http://humanstxt.org/

It uses a template format which you can define yourself to add the information you'd like to your humans.txt file. This plugin currently supports the following template tags:

* Active plugins (name, uri, version, description, author, author uri)
* Blog authors (login name, display name, email)
* PHP version
* WP version
* Current theme (name, description, author, author uri, version, parent)
* Number of posts (published, future, drafts, pending, private)
* Number of pages (published, future, drafts, pending, private)

It's pretty easy to extend these template tags with new ones if you're missing someone. Just leave a message and I'll try to fix it for you.

== Installation ==

This is the same procedure as with all ordinary plugins.

1. Download the zip file, unzip it 
2. Upload it to your /wp-content/plugins/ folder 
3. Activate the plugin through the 'Plugins' menu in WordPress
4. Go to the 'Humans dot txt' configuration menu to define your template
5. Head over to http://yourblog.com/humans.txt and behold the awesome result!

== Frequently Asked Questions ==

This is a new plugin, haven't had any questions yet. If you have any, be sure to send them to me. 

== Screenshots ==

There isn't really any point in having screenshots for this plugin, since it only generates a .txt file. If you want to know what that looks like, just press win+r and type in 'notepad' and press enter. If you're not on Windows just google it, it sould be pretty straight forward!

== Changelog ==

= 1.1.1 =

* Fixed PHP 5.5 compatibility

= 1.1 =

* Fixed some issues with newer WordPress versions

= 1.0.3 = 

* Removed one PHP short tag which caused problems for some server configurations

= 1.0.2 = 

* Fixed problem with suggestions box not disappearing correctly
* Fixed problem with some settings that weren't properly registered
* Improved error handling and feedback in the options page

= 1.0.1 = 

Minor bug fix with suggestions URL being wrong

= 1.0 = 

Initial release 

== Upgrade Notice ==

= 1.1.1 =

Fixed PHP 5.5 compatibility

= 1.1 =

Fixed some issues with newer WordPress versions

= 1.0.3 = 

Just a small bug fix with PHP short tags, upgrading should be safe. 

= 1.0.2 = 

Just minor bug fixex, upgrading should be safe. 

= 1.0.1 = 

Minor bug fix with suggestions URL being wrong

= 1.0 =

Initial release

== Feedback ==

I love getting feedback from people using my stuff, if you use it and feel like saying hello, leave a suggestion, complaint or whatever, just drop a message wherever you feel like. 

My contact information is

* rickard (a) 0x539.se
* [twitter.com/rickard2](http://twitter.com/rickard2)

== Plugin integration == 

If you feel like there's more information you'd like to add from your plugin, you can use the filter 'humans_output' to append your own information to the humans.txt file. But if you do, please be a good plugin developer and ask the user if it's ok first! 

A simple example:
`<?php

function myFilter($a) {
  return $a . "My plugin is activated and very cool!";
}

add_filter('humans_output', 'myFilter');`
