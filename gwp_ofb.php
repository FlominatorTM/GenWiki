<?php header('Content-Type: text/html; charset=utf-8'); ?>
<?PHP
$actual_link = "http://$_SERVER[HTTP_HOST]$_SERVER[REQUEST_URI]";
echo "aktualisiert via [$actual_link] am {{subst:CURRENTDAY}}. {{subst:CURRENTMONTHNAME}} {{subst:CURRENTYEAR}}<br>";

$page = "http://www.genpluswin.de/nofb/index.php";
$ofbPageContent = file_get_contents ($page);
$linkStart = "<a href=";
$ofbPageParts = explode($linkStart, $ofbPageContent);

$afterLink = " class";

$beforeUpdate = "zuletzt am "; 
$lengthBeforeUpdate = strlen($beforeUpdate);

$beforeFamilies = "umfasst ";
$lengthBeforeFamilies = strlen($beforeFamilies);
// $afterUpdate = "aktualisiert";
// echo "{| class=\"prettytable\" |<br>";

echo "{| class=\"prettytable sortable\" |<br>
! Nr. <br>
! Name/Link <br>
! data-sort-type=\"date\"|aktualisiert <br>
! Familien <br>
! im GenWiki<br>
! Namen<br>
! Orte<br>
|-<br>
";
$i=0;
foreach($ofbPageParts as $oneLinkPart)
{
    $indexOfLinkEnd =  strpos($oneLinkPart, $afterLink);
    if($indexOfLinkEnd > 0)
    {
        $link = substr($oneLinkPart, 0, $indexOfLinkEnd);

        $plainText = strip_tags($linkStart.$oneLinkPart);
        $indexOfBracket = strpos($plainText, "(");
        $name = trim(substr($plainText, 0, $indexOfBracket));

        $theOFBPage = file_get_contents($link);
        $beginningOfUpdate = strpos($theOFBPage, $beforeUpdate) + $lengthBeforeUpdate ;
        // $endOfUpdate = strpos($theOFBPage, $afterUpdate);
        $update = str_replace(' ', '', substr($theOFBPage, $beginningOfUpdate, 10));
        
        $beginningOfFamilies = strpos($theOFBPage, $beforeFamilies) + $lengthBeforeFamilies;
        $endOfFamilies = strpos($theOFBPage, ' ', $beginningOfFamilies);
        $length = $endOfFamilies - $beginningOfFamilies;
        $families = substr($theOFBPage, $beginningOfFamilies, $length);
        if(strlen($name)>0)
        {
            $i++;
            echo "| $i || [$link $name] || $update || $families  || ";
            
            if(stristr($name, "OFB"))
            {
                $folder = str_replace('https://www.genpluswin.de/nofb/ofb/', '', $link);
                $folder = str_replace('/index.php', '', $folder);
                $placesUrl = "http://$_SERVER[HTTP_HOST]"."/gwp_reg.php?ofb=$folder&modus=ort";
                $namesUrl = "http://$_SERVER[HTTP_HOST]"."/gwp_reg.php?ofb=$folder&modus=name";
                
                $gwLink = getOfbArticleName($name);
                echo "[[" . $gwLink . ", OFB]] || ";
                echo "[[" . $gwLink . ", OFB/Namensregister|N]] [$namesUrl] || ";
                echo "[[" . $gwLink . ", OFB/Ortsregister|O]] [$placesUrl]";
            }
            else if(stristr($name, "Familienbuch "))
            {
                $famName = substr($name, strlen("Familienbuch "));
                $famNames = explode("-", $famName);
                foreach($famNames as $oneFamilyName)
                {
                    echo "[[" . str_replace('von ', '', $oneFamilyName) . " (Familienname)]]";
                     echo htmlspecialchars("<br>");
                }
                echo  "|| &nbsp; ||";
            }
            else
            {
                echo "&nbsp || &nbsp; ||";
            }
            echo "<br>|-<br>";
        }
    }
}
echo "|}\n";

function getOfbArticleName($name)
{
    switch($name)
    {
        case 'OFB Ahausen': return 'Ahausen (Kreis Rotenburg)'; break;
        case 'OFB Alsfeld': return 'Alsfeld (Hessen)'; break;
        case 'OFB Breitenbach': return 'Breitenbach (Schauenburg)'; break;
        case 'OFB Brokel': return 'Brockel'; break;
        case 'OFB Burweg - Horst': return 'Burweg'; break;
        case 'OFB Elsdorf 2': return 'Elsdorf (Kreis Rotenburg)'; break;
        case 'OFB Gara': return 'Gara 2017'; break;
        case 'OFB Großenwörden Krs. Stade': return 'Großenwörden'; break;
        case 'OFB Grunbach': return 'Grunbach (Remshalden)'; break;
        case 'OFB Harburg': return 'Harburg (Elbe)'; break;
        case 'OFB Inselneudorf/Szigetújfalu': return 'Inselneudorf'; break;
        case 'OFB Kirchwalsede 2': return 'Kirchwalsede 2015'; break;
        case 'OFB Lang-Göns bei Gießen': return 'Langgöns'; break;
        case 'OFB Neuenkirchen/Heidekreis': return 'Neuenkirchen (Lüneburger Heide)'; break;
        case 'OFB Rhade': return 'Rhade (Kreis Rotenburg)'; break;
        case 'OFB Schneverdingen2': return 'Schneverdingen'; break;
        case 'OFB Stanischitsch': return 'Stanischitsch 2017 (1787-1945)'; break;
        case 'OFB Tschatali': return 'Tschatali 2002 (1737-1946)'; break;
        case 'OFB Verden 3': return 'Verden (Aller)'; break;
        case 'OFB Verden-St.Andreas': return 'Verden (Aller), St Andreas'; break;
        case 'OFB Wilstedt': return 'Wilstedt (Kreis Rotenburg)'; break;
        case 'OFB Wolterdingen': return 'Wolterdingen (Soltau)'; break;
        case 'OFB Worpswede': return 'Worpswede 2015'; break;
        case 'OFB Wulsbüttel': return 'Wulsbüttel 2019'; break;
        case 'OFB Zeven': return 'Zeven 2014'; break;
        default: return substr($name, strlen("OFB ")); break;
    }
}
?>
