<?php
echo '<?xml version="1.0" encoding="ISO-8859-15"?>'."\n";

chdir(dirname(__FILE__));

if (gethostbyaddr($_SERVER['REMOTE_ADDR']) == 'pupo.glop.org')
{
	$modero = true;
}
else
{
	$modero = false;
}

// Check si l'url en argument correspond à un moteur de recherche déjà connu
function isSearchEngine($referrer)
{
	// On choppe l'host du referrer
	$url = parse_url($referrer);
	$host = $url['host'];

	$knownHosts = array (
		'64.233.161.104',
		'64.233.183.104',
		'66.102.9.104',
		'66.249.93.104',
		'66.94.231.168',
		'72.14.207.104',
		'216.239.37.104',
		'216.239.39.104',
		'216.239.51.104',
		'arama.e-kolay.net',
		'arianna.libero.it',
		'aolbusca.aol.com.br',
		'aolrecherche.aol.fr',
		'aolsearch.aol.co.uk',
		'aolsearch.aol.com',
		'aolsearcht2.search.aol.com',
		'aolsearcht3.search.aol.com',
		'aolsearcht4.search.aol.com',
		'ar.search.msn.com',
		'ar.search.yahoo.com',
		'arama.mynet.com',
		'at.altavista.com',
		'be.altavista.com',
		'br.busca.yahoo.com',
		'br.search.yahoo.com',
		'busca.aol.com.br',
		'busca.uol.com.br',
		'buscador.aol.com',
		'busqueda.americaonline.com.mx',
		'cade.search.yahoo.com',
		'de.altavista.com',
		'de.search.yahoo.com',
		'dion.excite.co.jp',
		'dk.search.yahoo.com',
		'dpxml.infospace.com',
		'es.search.yahoo.com',
		'espanol.search.yahoo.com',
		'farejador-1.ig.com.br',
		'find.rin.ru',
		'fr.search.yahoo.com',
		'generic.a9.com',
		'go.mail.ru',
		'google-searcher.com',
		'google.bg',
		'google.startpagina.nl',
		'gps.virgin.net',
		'home.bellsouth.net',
		'images.google.be',
		'images.google.co.in',
		'images.google.com',
		'images.google.de',
		'images.google.fi',
		'it.search.yahoo.com',
		'kd.mysearch.myway.com',
		'keyword.netscape.com',
		'kf.mysearch.myway.com',
		'metaresults.copernic.com',
		'ms101.mysearch.com',
		'ms104.mysearch.com',
		'ms114.mysearch.com',
		'ms121.mysearch.com',
		'ms127.mysearch.com',
		'ms141.mysearch.com',
		'msxml.excite.com',
		'msxml.infospace.com',
		'msxml.webcrawler.com',
		'mysearch.myway.com',
		'mx.search.yahoo.com',
		'oh1.ru',
		'omaha.cox.net',
		'pesquisa.clix.pt',
		'pesquisa.sapo.pt',
		'promosearch.de',
		'rechercher.nomade.aliceadsl.fr',
		'rechercher.nomade.tiscali.fr',
		'se.search.yahoo.com',
		'search.aol.co.uk',
		'search.aol.com',
		'search.aon.at',
		'search.earthlink.net',
		'search.espanol.yahoo.com',
		'search.gbg.bg',
		'search.goo.ne.jp',
		'search.hp.netscape.com',
		'search.isp.netscape.com',
		'search.jubii.dk',
		'search.latam.msn.com',
		'search.msn.at',
		'search.msn.be',
		'search.msn.ch',
		'search.msn.co.uk',
		'search.msn.com',
		'search.msn.com.br',
		'search.msn.de',
		'search.msn.dk',
		'search.msn.fi',
		'search.msn.fr',
		'search.msn.it',
		'search.msn.no',
		'search.msn.se',
		'search.mywebsearch.com',
		'search.netcenter.netscape.com',
		'search.netscape.com',
		'search.ninemsn.com.au',
		'search.peoplepc.com',
		'search.rambler.ru',
		'search.sympatico.msn.ca',
		'search.t1msn.com.mx',
		'search.yahoo.com',
		'search1.seznam.cz',
		'searcht.netscape.com',
		'so.qq.com',
		'suche.aol.de',
		'suche.aolsvc.de',
		'suche.compuserve.de',
		'suche.fireball.de',
		'suche.freenet.de',
		'suche.netscape.de',
		'sucheaol.aol.de',
		'suchmaschine.promosearch.de',
		'toolbar.search.msn.com',
		'translate.google.com',
		'tw.search.yahoo.com',
		'uk.search.yahoo.com',
		'verden.abcsok.no',
		'video.search.yahoo.com',
		'vivisimo.com',
		'websearch.cs.com',
		'ww.google.com.pe',
		'ww.google.com.tr',
		'ww.google.pl',
		'www.altavista.com',
		'www.aolrecherche.aol.fr',
		'www.aolrecherches.aol.fr',
		'www.arabia.msn.com',
		'www.arcor.de',
		'www.avantfind.com',
		'www.bild.t-online.de',
		'www.blueyonder.co.uk',
		'www.canada.com',
		'www.chello.at',
		'www.chello.nl',
		'www.comcast.net',
		'www.dino-online.de',
		'www.dogpile.com',
		'www.dopdolu.net',
		'www.eniro.fi',
		'www.eniro.se',
		'www.excite.fr',
		'www.google.ae',
		'www.google.am',
		'www.google.at',
		'www.google.az',
		'www.google.be',
		'www.google.bg',
		'www.google.ca',
		'www.google.ch',
		'www.google.ci',
		'www.google.cl',
		'www.google.co.cr',
		'www.google.co.hu',
		'www.google.co.id',
		'www.google.co.il',
		'www.google.co.in',
		'www.google.co.jp',
		'www.google.co.nz',
		'www.google.co.th',
		'www.google.co.uk',
		'www.google.co.ve',
		'www.google.co.za',
		'www.google.com',
		'www.google.com.ar',
		'www.google.com.au',
		'www.google.com.bo',
		'www.google.com.br',
		'www.google.com.co',
		'www.google.com.do',
		'www.google.com.ec',
		'www.google.com.gr',
		'www.google.com.gt',
		'www.google.com.hk',
		'www.google.com.ly',
		'www.google.com.mx',
		'www.google.com.my',
		'www.google.com.pe',
		'www.google.com.ph',
		'www.google.com.pk',
		'www.google.com.sa',
		'www.google.com.sg',
		'www.google.com.tr',
		'www.google.com.ua',
		'www.google.com.uy',
		'www.google.com.vn',
		'www.goggle.cz',
		'www.google.de',
		'www.google.dk',
		'www.google.es',
		'www.google.fi',
		'www.google.fr',
		'www.google.gr',
		'www.google.hr',
		'www.google.ie',
		'www.google.interia.pl',
		'www.google.is',
		'www.google.it',
		'www.google.lt',
		'www.google.lu',
		'www.google.lv',
		'www.google.mn',
		'www.google.nl',
		'www.google.no',
		'www.google.pl',
		'www.google.pt',
		'www.google.ro',
		'www.google.ru',
		'www.google.sc',
		'www.google.se',
		'www.google.sk',
		'www.google.to',
		'www.google-searcher.com',
		'www.hotbot.com',
		'www.icq.com',
		'www.kimbox.com',
		'www.metacrawler.com',
		'www.mweb.co.za',
		'www.mywebsearch.com',
		'www.netmadeira.com',
		'www.oh1.ru',
		'www.pop.com.br',
		'www.porno.com.tr',
		'www.rambler.ru',
		'www.search.com',
		'www.searchalot.com',
		'www.start.no',
		'www.startseite.de',
		'www.suche.info',
		'www.tesco.net',
		'www.ubbi.com.br',
		'www.vol.at',
		'www.wwwgoogle.de',
		'www.zoeken.nl',
		'www.zoznam.sk',
		'ww.google.it',
		'zoek.vinden.nl');

	if(in_array($host, $knownHosts))
	{
		$return = true;
	}
	else
	{
		$return = false;
	}
	return $return;
}
?>
<!DOCTYPE
 html PUBLIC "-//W3C//DTD XHTML 1.1//EN"
 "http://www.w3.org/TR/xhtml11/DTD/xhtml11.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">

<head>
	<title>glop.org - referrers page</title>
	<style type="text/css">
		body {
			color: #000;
			background-color: #fff;
			font-family: verdana, sans-serif;
			font-size: 80%;
		}

		a {
			text-decoration: none;
			font-weight: bold;
			color: #088;
		}

		a:hover {
			color: #0cc;
		}

		p.explanation {
			text-align: justify;
		}

		input {
			font-family: verdana, sans-serif;
		}
		.fake {
			font-weight: bold;
			color: #888;
		}
		div {
			width: 728px;
			margin: auto;
		}

		.center {
			text-align: center;
		}
		li {
			white-space: nowrap;
		}
		select {
			width: 30em;
		}
	</style>
	<script src="http://www.google-analytics.com/urchin.js" type="text/javascript">
	</script>
	<script type="text/javascript">
		_uacct = "UA-107561-2";
		urchinTracker();
	</script>
</head>

<body>
<div>

<h1 class="center">Referrers page</h1>

<p class="explanation">This is a dynamic referrers page. To bring your site on top of the list,
add a link to this page and the most visitors you bring, the better you'll be placed.</p>

<p class="explanation">This is all automated, no need to submit anything here. Just use the following link on your
website : <input type="text" value="http://www.glop.org/referrers/" size="28" /></p>

<script type="text/javascript"><!--
google_ad_client = "pub-9935615233494380";
google_ad_width = 728;
google_ad_height = 90;
google_ad_format = "728x90_as";
google_ad_type = "text_image";
google_ad_channel ="";
google_color_border = "CCCCCC";
google_color_bg = "FFFFFF";
google_color_link = "000000";
google_color_url = "666666";
google_color_text = "333333";
//--></script>
<script type="text/javascript"
  src="http://pagead2.googlesyndication.com/pagead/show_ads.js">
</script>

<? //die('referrers page is down until I optimize it, but stats are still counted'); ?>

<p class="explanation">I. Here are the real referrers:</p>

<?
$db['host'] = 'some_host';
$db['user'] = 'some_user';
$db['database'] = 'some_database';
$db['password'] = 'some_password';
$link = mysql_connect($db['host'], $db['user'], $db['password'])
   or die('Could not connect: ' . mysql_error());
mysql_select_db($db['database']) or die('Could not select database');

if (($modero == true) && (isset($l) || isset($s) || isset($f) || isset($o)))
{
	$query = 'UPDATE referrers SET origine = ';
	if($l)
	{
		$query .= '\'legit\' WHERE url = \''.$l.'\'';
	}
	elseif($s)
	{
		$query .= '\'search\' WHERE url = \''.$s.'\'';
	}
	elseif($f)
	{
		$query .= '\'fake\' WHERE url = \''.$f.'\'';
	}
	elseif($o)
	{
		$query .= '\'obsolete\' WHERE url = \''.$f.'\'';
	}
	mysql_query($query) or die('Query failed: ' . mysql_error());
}

$referrer = parse_url($_SERVER["HTTP_REFERER"]);
if((strlen($referrer['host']) > 0) && ($referrer['host'] != 'www.glop.org'))
{
	$query = 'SELECT count FROM referrers WHERE url = "' . $_SERVER["HTTP_REFERER"] . '"';
	$result = mysql_query($query) or die('Query failed: ' . mysql_error());
	if((mysql_num_rows($result) > 0))
	{
		$nb_referrers = mysql_result($result, 0);
		$query_bis  = 'UPDATE referrers SET';
		$query_bis .= ' count = '.($nb_referrers + 1);
		$query_bis .= ', host = "'.gethostbyaddr($_SERVER['REMOTE_ADDR']).'"';
		if(strlen(trim($_SERVER['HTTP_USER_AGENT'])) > 0)
			$query_bis .= ', user_agent = "'.$_SERVER['HTTP_USER_AGENT'].'"';
		else
			$query_bis .= ', user_agent = NULL';
		$query_bis .= ' WHERE url = "' . $_SERVER["HTTP_REFERER"] . '"';
		mysql_query($query_bis) or die('Query failed: ' . mysql_error());
	}
	else
	{
		$query_bis  = 'INSERT INTO referrers SET';
		$query_bis .= ' count = 1';
		$query_bis .= ', url = "'.$_SERVER['HTTP_REFERER'].'"';
		$query_bis .= ', host = "'.gethostbyaddr($_SERVER['REMOTE_ADDR']).'"';
		// Check si le user agent est NULL
		if(strlen(trim($_SERVER['HTTP_USER_AGENT'])) > 0)
		{
			// Si le user agent est bon, on continue
			$query_bis .= ', user_agent = "'.$_SERVER['HTTP_USER_AGENT'].'"';

			// Check si le referrer est un moteur de recherche déjà connu
			if(isSearchEngine($_SERVER['HTTP_REFERER']))
			{
				$query_bis .= ', origine = \'search\'';
			}
		}
		else
		{
			// Si le user agent est nul, c'est un fake
			$query_bis .= ', user_agent = NULL';
			$query_bis .= ', origine = \'fake\'';
		}
		mysql_query($query_bis) or die('Query failed: ' . mysql_error());
	}
	// Free resultset
}

// Performing SQL query
$query = 'SELECT url FROM referrers WHERE origine=\'legit\' ORDER BY count DESC';
$result = mysql_query($query) or die('Query failed: ' . mysql_error());

// Printing results in HTML
echo "<ol>\n";
while ($row = mysql_fetch_row($result)) {
	echo '<li><a href="' . $row[0] . '">' . $row[0] . '</a>';
	echo "</li>\n";
}
// Free resultset
mysql_free_result($result);

echo "</ol>\n";

/*
// Performing SQL query
$query = 'SELECT url FROM referrers WHERE origine IS NULL ORDER BY count DESC';
$result = mysql_query($query) or die('Query failed: ' . mysql_error());
if (mysql_num_rows($result) > 0)
{
	echo "<p class=\"explanation\">I.b. Referrers waiting for approval:</p>\n";
	echo "<ol>\n";
	while ($row = mysql_fetch_row($result)) {
		echo '<li><a href="' . $row[0] . '">' . $row[0] . '</a>';
		if($modero)
		{
			echo ' [<a href="?l=';
			echo urlencode($row[0]);
			echo '">l</a>|<a href="?s=';
			echo urlencode($row[0]);
			echo '">s</a>|<a href="?f=';
			echo urlencode($row[0]);
			echo '">f</a>]<a href="?o=';
			echo urlencode($row[0]);
			echo '">o</a>]';
		}
		echo "</li>\n";
	}
	echo "</ol>\n";
}

// Free resultset
mysql_free_result($result);
*/
?>

<?
$filename = 'faking-keywords.txt';
$handle = fopen ($filename, "r");
$buffer = fgets($handle);
$buffer = fgets($handle);
unset($lines);
$i = 1;
while(($i <= 20) && !feof($handle))
{
	$buffer = fgets($handle);
	if($buffer)
	{
		$lines[$i]['query'] = substr($buffer, strpos($buffer, ',')+1);
		$lines[$i]['occurances'] = substr($buffer, 0, strpos($buffer, ','));
	}
	$i++;
}
fclose ($handle);
// Printing results in HTML

if(count($lines) > 0)
{
	?>

	<p class="explanation">II. Now I'll list the most attracting queries bringing referrers:</p>

	<?
	echo "<ul>\n";
	foreach ($lines as $l)
	{
		echo '<li>'.$l['query'].' ('.$l['occurances']." hits)</li>\n";
	}
	echo '<li><a href="faking-keywords.txt">Get all the queries</a></li>'."\n";
	echo "</ul>\n";

	$query = 'SELECT COUNT(*) FROM referrers WHERE origine=\'fake\'';
	$result = mysql_query($query) or die('Query failed: ' . mysql_error());
	$nbFakes = mysql_result($result, 0);
}
?>

<p class="explanation">III. And finally here are 20 fakers out of the <?=$nbFakes?> total ones, ordered by the number of fake referrals
sent. The 1st being the one who sent the most faked referrals. Nice try ;)</p>

<?
// Performing SQL query
$query = 'SELECT url FROM referrers WHERE origine=\'fake\' ORDER BY count DESC LIMIT 20';
$result = mysql_query($query) or die('Query failed: ' . mysql_error());
// Printing results in HTML
//echo "<textarea readonly=\"readonly\">\n";
echo "<select multiple=\"multiple\" disabled=\"disabled\">\n";
while ($row = mysql_fetch_row($result)) {
//	echo strtr($row[0], " ", "+") . "\n";
	echo '<option>'.$row[0]."</option>\n";
}
echo "</select>\n";
//echo "</textarea>\n";
// Free resultset
mysql_free_result($result);

// Closing connection
mysql_close($link);
?>
</p>

<p>You can also take a look at the generated complete list of <a
 href="http://www.glop.org/referrers/faking-hosts.txt">fakers hostnames</a> and
 <a href="http://www.glop.org/referrers/faking-referrers.txt">fakers URLs</a>.
 Those text files are generated hourly and can be used freely for your antispam
 tools for exemple.</p>

<p class="center">&gt; back to <a href="/">glop.org</a> &lt;</p>

</div>
</body>

</html>
