<?php header('Content-Type: text/html; charset=utf-8'); ?>
<?PHP
$actual_link = "http://$_SERVER[HTTP_HOST]$_SERVER[REQUEST_URI]";
echo "{{subst:SUBPAGENAME}} zu [[{{subst:BASEPAGENAME}}]], erzeugt via [$actual_link] am {{subst:CURRENTDAY}}. {{subst:CURRENTMONTHNAME}} {{subst:CURRENTYEAR}}<br>{{TOC}}<br>";

$ofb = $_REQUEST['ofb'];
$modus = $_REQUEST['modus'];

$beginningOfContent = "<table width=100% BORDER=0 CELLSPACING=0 CELLPADDING=4 align=center>";
$endOfContent = "</table>";

$page = "http://www.genpluswin-database.de/nofb/ofb/$ofb/index.php?id=$modus";

$end = 65+26;
for($i=65; $i< $end; $i++)
{
    $letter = chr($i);
    $url = $page . "&ia=$letter";
    $oneLetterPage = file_get_contents ($url);
    
    $indexOfBeginning = strpos($oneLetterPage, $beginningOfContent);
    $indexOfEnd = strpos($oneLetterPage, $endOfContent, $indexOfBeginning);
    $length = $indexOfEnd -  $indexOfBeginning;
    
    $content = strip_tags(str_replace("<br>", " — ", substr($oneLetterPage, $indexOfBeginning, $length)));
    $indexLastBreak = strrpos($content, "—");
    
    $content = substr($content, 0, $indexLastBreak);
     // var_dump($content);
    if(strlen($content)>1 && !stristr($content, "Es wurden keine Ergebnisse mit"))
    {
        echo "== $letter ==<br>";
        echo strip_tags($content);
        echo "<br>";
    }
}
?>
