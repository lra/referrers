<?php
chdir(dirname(__FILE__));

/*
 * Fonction pour parser les url des moteurs de recherche
 */
function parse_query($query, $varname)
{
	parse_str($query, $tmp_array);
	if(strlen($tmp_array[$varname]) > 0)
	{
		$arrayOfQueries = $tmp_array[$varname];
	}
	return ($arrayOfQueries);
}

/*
 * Connexion SQL
 */
$db['host'] = 'some_host';
$db['user'] = 'some_user';
$db['database'] = 'some_database';
$db['password'] = 'some_password';

$link = mysql_connect($db['host'], $db['user'], $db['password'])
   or die('Could not connect: ' . mysql_error());
mysql_select_db($db['database']) or die('Could not select database');

/*
 * Generation de la liste des hosts
 */

$query = 'SELECT host,COUNT(host) AS hits FROM referrers WHERE origine=\'fake\' AND host IS NOT NULL GROUP BY host ORDER BY hits DESC';
$result = mysql_query($query);

unset($txt_hosts);
$txt_hosts[] = '# List of hosts generating fake referrers ordered by the number of hits';
$txt_hosts[] = '# Format: <nb of hits>,<hostname>';
while ($row = mysql_fetch_assoc($result))
{
	$txt_hosts[] = $row['hits'].','.$row['host'];
}

// Free resultset
mysql_free_result($result);

/*
 * Generation de la liste des referrers
 */

$query = 'SELECT url,count FROM referrers WHERE origine=\'fake\' ORDER BY count DESC';
$result = mysql_query($query);

unset($txt_refs);
$txt_refs[] = '# List of fake referrers ordered by the number of hits';
$txt_refs[] = '# Format: <nb of hits>,<referrer url>';
while ($row = mysql_fetch_assoc($result))
{
	$txt_refs[] = $row['count'].','.$row['url'];
}

// Free resultset
mysql_free_result($result);

/*
 * Generation de la liste des mots clefs
 */

// Performing SQL query
$query = 'SELECT url FROM referrers WHERE origine=\'search\' ORDER BY count DESC';
$result = mysql_query($query) or die('Query failed: ' . mysql_error());

unset($tmp_keywords);
// Getting the results into an array
while ($row = mysql_fetch_row($result)) {
	$url = parse_url($row[0]);
	if(strpos($url['host'], 'www.google.') === 0)
	{
			$tmp_keywords[] = parse_query($url['query'], 'q');
	}
	else
	{
		switch($url['host'])
		{
			case 'a9.com':
				$tmp_keywords[][] = urldecode(substr($url['path'], 1));
				break;
			case 'www.buscapormi.com.ar':
				$tmp_keywords[] = parse_query($url['query'], 'B');
				break;
			case 'www.planet.nl':
				$tmp_keywords[] = parse_query($url['query'], 'googleq');
				break;
			case 'oh1.ru':
			case 'www.oh1.ru':
				$tmp_keywords[] = parse_query($url['query'], 'i');
				break;
			case 'www.neuf.fr':
			case 'misc.skynet.be':
				$tmp_keywords[] = parse_query($url['query'], 'keywords');
				break;
			case 'www.arcor.de':
			case 'www.avantfind.com':
			case 'www.netster.com':
			case 'www.oemji.com':
			case 'www.suche.info':
				$tmp_keywords[] = parse_query($url['query'], 'Keywords');
				break;
			case 'ocnsearch.goo.ne.jp':
			case 'search.goo.ne.jp':
				$tmp_keywords[] = parse_query($url['query'], 'MT');
				break;
			case 'www.dopdolu.net':
				$tmp_keywords[] = parse_query($url['query'], 'ney');
				break;
			case 'ar.search.yahoo.com':
			case 'br.busca.yahoo.com':
			case 'br.search.yahoo.com':
			case 'cade.search.yahoo.com':
			case 'de.search.yahoo.com':
			case 'dk.search.yahoo.com':
			case 'es.search.yahoo.com':
			case 'espanol.search.yahoo.com':
			case 'fr.search.yahoo.com':
			case 'it.search.yahoo.com':
			case 'mx.search.yahoo.com':
			case 'se.search.yahoo.com':
			case 'search.espanol.yahoo.com':
			case 'search.yahoo.co.jp':
			case 'search.yahoo.com':
			case 'tw.search.yahoo.com':
			case 'uk.search.yahoo.com':
			case 'video.search.yahoo.com':
				$tmp_keywords[] = parse_query($url['query'], 'p');
				break;
			case '64.233.161.104':
			case '64.233.183.104':
			case '66.102.9.104':
			case '66.249.93.104':
			case '72.14.207.104':
			case '216.239.37.99':
			case '216.239.51.104':
			case 'ar.search.msn.com':
			case 'arama.e-kolay.net':
			case 'arama.mynet.com':
			case 'at.altavista.com':
			case 'be.altavista.com':
			case 'busca.ubbi.com.br':
			case 'busca.uol.com.br':
			case 'business.galip.com':
			case 'cgi.search.biglobe.ne.jp':
			case 'de.altavista.com':
			case 'farejador-1.ig.com.br':
			case 'froogle.google.com':
			case 'ggoogle.com':
			case 'go.mail.ru':
			case 'google.bg':
			case 'google.startsiden.no':
			case 'google.startpagina.nl':
			case 'google-searcher.com':
			case 'gps.virgin.net':
			case 'home.eircom.net':
			case 'images.google.be':
			case 'images.google.co.in':
			case 'images.google.com':
			case 'images.google.de':
			case 'images.google.fi':
			case 'images.google.it':
			case 'pesquisa.sapo.pt':
			case 'se.altavista.com':
			case 'search.earthlink.net':
			case 'search.gbg.bg':
			case 'search.latam.msn.com':
			case 'search.livedoor.com':
			case 'search.msn.at':
			case 'search.msn.be':
			case 'search.msn.ch':
			case 'search.msn.com.br':
			case 'search.msn.co.in':
			case 'search.msn.co.jp':
			case 'search.msn.co.uk':
			case 'search.msn.com':
			case 'search.msn.de':
			case 'search.msn.dk':
			case 'search.msn.es':
			case 'search.msn.fi':
			case 'search.msn.fr':
			case 'search.msn.it':
			case 'search.msn.no':
			case 'search.msn.se':
			case 'search.ninemsn.com.au':
			case 'search.ntlworld.com':
			case 'search.peoplepc.com':
			case 'search.sympatico.msn.ca':
			case 'search.t1msn.com.mx':
			case 'search.xtramsn.co.nz':
			case 'search1-1.free.fr':
			case 'suche.aol.de':
			case 'suche.aolsvc.de':
			case 'suche.compuserve.de':
			case 'suche.netscape.de':
			case 'sucheaol.aol.de':
			case 'toolbar.search.msn.com':
			case 'verden.abcsok.no':
			case 'ww.google.at':
			case 'ww.google.com.pe':
			case 'ww.google.com.tr':
			case 'ww.google.de':
			case 'ww.google.fi':
			case 'ww.google.it':
			case 'ww.google.lt':
			case 'ww.google.pl':
			case 'www.altavista.com':
			case 'www.arabia.msn.com':
			case 'www.blueyonder.co.uk':
			case 'www.devilfinder.com':
			case 'www.eniro.fi':
			case 'www.eniro.lt':
			case 'www.eniro.se':
			case 'www.excite.fr':
			case 'www.goggle.cz':
			case 'www.googlee.com':
			case 'www.icq.com':
			case 'www.mweb.co.za':
			case 'www.netmadeira.com':
			case 'www.pop.com.br':
			case 'www.porno.com.tr':
			case 'www.search.com':
			case 'www.searchalot.com':
			case 'www.seochat.com':
			case 'www.start.no':
			case 'www.startseite.de':
			case 'www.tesco.net':
			case 'www.ubbi.com.br':
			case 'www.vol.at':
			case 'www.wwwgoogle.de':
				$tmp_keywords[] = parse_query($url['query'], 'q');
				break;
			case 'www.chello.at':
			case 'www.chello.nl':
				$tmp_keywords[] = parse_query($url['query'], 'q1');
				break;
			case 'www.007-suche.de':
			case 'dpxml.infospace.com':
			case 'www.schnellie.com':
				$tmp_keywords[] = parse_query($url['query'], 'qkw');
				break;
			case 'www.google-searcher.com':
				$tmp_keywords[] = parse_query($url['query'], 'qq');
				break;
			case 'aolbusca.aol.com.br':
			case 'aolbusqueda.aol.com.mx':
			case 'aolrecherche.aol.fr':
			case 'aolsearch.aol.co.uk':
			case 'aolsearch.aol.com':
			case 'aolsearcht2.search.aol.com':
			case 'aolsearcht3.search.aol.com':
			case 'aolsearcht4.search.aol.com':
			case 'busca.aol.com.br':
			case 'buscador.aol.com':
			case 'busqueda.americaonline.com.mx':
			case 'keyword.netscape.com':
			case 'poisk.narod.co.il':
			case 'search.aol.co.uk':
			case 'search.aol.com':
			case 'search.aon.at':
			case 'search.hp.netscape.com':
			case 'search.isp.netscape.com':
			case 'search.jubii.dk':
			case 'search.netcenter.netscape.com':
			case 'search.netscape.com':
			case 'searcht.netscape.com':
			case 'suche.fireball.de':
			case 'suche.freenet.de':
			case 'suche.netscape.com':
			case 'vivisimo.com':
			case 'websearch.cs.com':
			case 'websearcht.cs.com':
			case 'www.aolrecherche.aol.fr':
			case 'www.aolrecherches.aol.fr':
			case 'www.bild.t-online.de':
			case 'www.comcast.net':
			case 'www.comundo.de':
			case 'www.dino-online.de':
			case 'www.hotbot.com':
			case 'www.kimbox.com':
			case 'www.zoeken.nl':
			case 'zoek.vinden.nl':
				$tmp_keywords[] = parse_query($url['query'], 'query');
				break;
			case 'prsearch.net':
				$tmp_keywords[] = parse_query($url['query'], 'Query');
				break;
			case 'pesquisa.clix.pt':
				$tmp_keywords[] = parse_query($url['query'], 'question');
				break;
			case 'search.virgilio.it':
				$tmp_keywords[] = parse_query($url['query'], 'qs');
				break;
			case 'rechercher.nomade.aliceadsl.fr':
			case 'rechercher.nomade.tiscali.fr':
			case 'www.zoznam.sk':
				$tmp_keywords[] = parse_query($url['query'], 's');
				break;
			case 'dion.excite.co.jp':
				$tmp_keywords[] = parse_query($url['query'], 'search');
				break;
			case 'www.jevais.com':
				$tmp_keywords[] = parse_query($url['query'], 'search_term');
				break;
			case 'arianna.libero.it':
			case 'kd.mysearch.myway.com':
			case 'kf.mysearch.myway.com':
			case 'ms101.mysearch.com':
			case 'ms104.mysearch.com':
			case 'ms114.mysearch.com':
			case 'ms121.mysearch.com':
			case 'ms127.mysearch.com':
			case 'ms141.mysearch.com':
			case 'ms142.mysearch.com':
			case 'mysearch.myway.com':
			case 'search.mywebsearch.com':
			case 'www.canada.com':
			case 'www.mywebsearch.com':
				$tmp_keywords[] = parse_query($url['query'], 'searchfor');
				break;
			case 'home.bellsouth.net':
				$tmp_keywords[] = parse_query($url['query'], 'string');
				break;
			case 'promosearch.de':
			case 'suchmaschine.promosearch.de':
				$tmp_keywords[] = parse_query($url['query'], 'suchbegriffe');
				break;
			case 'search.aladin.co.yu':
				$tmp_keywords[] = parse_query($url['query'], 'term');
				break;
			case 'www.metaeureka.com':
				$tmp_keywords[] = parse_query($url['query'], 'terms');
				break;
			case '66.94.231.168':
			case '216.109.124.98':
			case 'find.rin.ru':
				$tmp_keywords[] = parse_query($url['query'], 'text');
				break;
			case '216.239.37.104':
			case '216.239.39.104':
			case 'translate.google.com':
				$tmp_keywords[] = parse_query($url['query'], 'u');
				break;
			case 'search1.seznam.cz':
				$tmp_keywords[] = parse_query($url['query'], 'w');
				break;
			case 'so.qq.com':
				$tmp_keywords[] = parse_query($url['query'], 'word');
				break;
			case 'search.rambler.ru':
			case 'www.rambler.ru':
				$tmp_keywords[] = parse_query($url['query'], 'words');
				break;
			default:
				if(isset($debug))
				{
					echo $url['host'].' : '.$url['query'] . "<br />\n";
				}
		}
	}
}

// Free resultset
mysql_free_result($result);

unset($tmp_queries);
foreach($tmp_keywords as $t)
{
	$q = trim(stripslashes($t));
	if(strlen($q) > 0)
	{
		$tmp_queries[$q]++;
	}
}
arsort($tmp_queries);
/*
unset($txt_keywords);
$txt_keywords[] = '# List of keywords used to come here';
$txt_keywords[] = '# Format: <nb of hits>,<query used>';
foreach($tmp_queries as $q => $nb)
{
	$txt_keywords[] = $nb.','.$q;
}
*/
$handle = fopen('faking-keywords.txt', 'w');
fwrite($handle, '# List of keywords used to come here'."\n");
fwrite($handle, '# Format: <nb of hits>,<query used>'."\n");
foreach($tmp_queries as $q => $nb)
{
	fwrite($handle, $nb.','.$q."\n");
}
fclose($handle);

//print_r($txt_keywords);

/*
 * On ferme boutique
 */

// Closing connection
mysql_close($link);

// Ecriture des fichiers textes
//file_put_contents ('faking-hosts.txt', $txt_hosts);
	$handle = fopen('faking-hosts.txt', 'w');
	foreach($txt_hosts as $l)
	{
		fwrite($handle, $l."\n");
	}
	fclose($handle);
//file_put_contents ('faking-referrers.txt', $txt_refs);
	$handle = fopen('faking-referrers.txt', 'w');
	foreach($txt_refs as $l)
	{
		fwrite($handle, $l."\n");
	}
	fclose($handle);

//file_put_contents ('faking-keywords.txt', $txt_keywords);
/*
	$handle = fopen('faking-keywords.txt', 'w');
	foreach($txt_keywords as $l)
	{
		fwrite($handle, $l."\n");
	}
	fclose($handle);
*/
