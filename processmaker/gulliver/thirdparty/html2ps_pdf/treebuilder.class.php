<?php
// $Header: /cvsroot/html2ps/treebuilder.class.php,v 1.16 2006/11/11 13:43:53 Konstantin Exp $

require_once(HTML2PS_DIR.'dom.activelink.inc.php');
require_once(HTML2PS_DIR.'dom.php5.inc.php');

if (!defined('XML_ELEMENT_NODE')) { define('XML_ELEMENT_NODE',1); };
if (!defined('XML_TEXT_NODE')) { define('XML_TEXT_NODE',2); };
if (!defined('XML_DOCUMENT_NODE')) { define('XML_DOCUMENT_NODE',3); };

class TreeBuilder {
  function build($xmlstring) {
    // Detect if we're using PHP 4 (DOM XML extension)
    // or PHP 5 (DOM extension)
    // First uses a set of domxml_* functions,
    // Second - object-oriented interface
    // Third - pure PHP XML parser
    if (function_exists('domxml_open_mem')) { return domxml_open_mem($xmlstring); };
    if (class_exists('DOMDocument')) { return @DOMTree::from_DOMDocument(DOMDocument::loadXML($xmlstring)); };
    if (file_exists(HTML2PS_DIR.'/classes/include.php')) {
      require_once(HTML2PS_DIR.'classes/include.php');
      import('org.active-link.xml.XML');
      import('org.active-link.xml.XMLDocument');

      // preprocess character references
      // literal references (actually, parser SHOULD do it itself; nevertheless, Activelink just ignores these entities)
      $xmlstring = preg_replace("/&amp;/","&",$xmlstring);
      $xmlstring = preg_replace("/&quot;/","\"",$xmlstring);
      $xmlstring = preg_replace("/&lt;/","<",$xmlstring);
      $xmlstring = preg_replace("/&gt;/",">",$xmlstring);

      // in decimal form
      while (preg_match("@&#(\d+);@",$xmlstring, $matches)) {
        $xmlstring = preg_replace("@&#".$matches[1].";@",code_to_utf8($matches[1]),$xmlstring);
      };
      // in hexadecimal form
      while (preg_match("@&#x(\d+);@i",$xmlstring, $matches)) {
        $xmlstring = preg_replace("@&#x".$matches[1].";@i",code_to_utf8(hexdec($matches[1])),$xmlstring);
      };

      $tree = ActiveLinkDOMTree::from_XML(new XML_($xmlstring));

      return $tree;
    }
    die("None of DOM/XML, DOM or ActiveLink DOM extension found. Check your PHP configuration.");
  }
};
?>