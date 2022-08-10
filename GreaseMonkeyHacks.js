// ==UserScript==
// @name          GenWiki login hacks for GreaseMonkey
// @namespace     https://wiki.genealogy.net/
// @description   redirecting to the one and only correct URL and trying to fix reload issue
// @match https://*.genealogy.net/*
// @match   https://www.genwiki.de/*

// ==/UserScript==

var strLocation = window.location.toString();

if(strLocation.search("genwiki.de")>-1)
{
    window.location=strLocation.replace("www.genwiki.de", "wiki.genealogy.net");
}

if(strLocation.search("wiki-de.genealogy.net")>-1)
{
    window.location=strLocation.replace("wiki.genealogy.net", "wiki.genealogy.net");
}

else if(strLocation.search("wiki.genealogy.net")>-1)
{
  var loginLink = document.getElementById("pt-login");
  if(loginLink != null)
  {
    var thisWindow = window;
    var otherWindow = window.open(loginLink.firstChild.href);
    thisWindow.location.reload();
  }
}
