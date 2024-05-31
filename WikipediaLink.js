javascript: var dummy = 0;
/*
erzeugt aus einer Wikipedia-Artikel den Vorlagenquellentext zur Einbindung von Wikipedia-Links im GenWiki
*/
var articleName = document.getElementById("firstHeading").firstChild.innerText;
var articleEncoded = extractLastUrlPart(window.location.toString());
var template = "{{Wikipedia-Link|" + articleEncoded;
if (articleName != articleEncoded) {
  template += "|" + articleName;
}
template += "}}";

prompt("Copy GenWiki template below", template);
void 0;
function extractLastUrlPart(url) {
  return url.substring(url.lastIndexOf("/") + 1).split("#")[0];
}
