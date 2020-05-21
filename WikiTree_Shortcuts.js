// ==UserScript==
// @name          WikiTree input
// @namespace     https://www.wikitree.com/
// @description   adding some shortcuts and changing some links
// @match https://www.wikitree.com/*
// @include   https://www.wikitree.com/
// ==/UserScript==

//shortcut p for preview button
document.getElementById("previewButton").accessKey="p";

//shortcut e for edit button
for (var i=0; ulNode = document.getElementsByTagName("ul")[i]; i++)
{
  if(ulNode.className == "profile-tabs")
  {

    for (var j=0; aNode = ulNode.children[j]; j++)
    {
      if(aNode.title == "Edit Profile and Family Relationships")
      {
        aNode.accessKey="e";
        break;
      }
    }
    break;
  }
}

//remove "Edit Profile of" from tab title after saving
if((window.location + "").indexOf("?") == -1)
{
	document.title = document.getElementsByTagName("h1")[0].innerText.replace("Edit Profile of", "");
}


