// ==UserScript==
// @name          GenWiki login hack
// @namespace     https://wiki.genealogy.net/
// @description   redirecting to the one and only correct URL and trying to fix reload issue
// @match https://*.genealogy.net/*
// @match   https://www.genwiki.de/*

// ==/UserScript==

if(window.name== "hacked window")
{
  window.close();
}


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
    var otherWindow = window.open("https://wiki.genealogy.net/index.php?title=Spezial:Anmelden&returnto=GenWiki%3ASpenden", "hacked window");
    thisWindow.focus();
    thisWindow.location.reload();
  }
}
