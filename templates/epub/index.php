<?php

  //error_reporting(0);
  set_include_path(get_include_path() . PATH_SEPARATOR . dirname(__FILE__) . '/pear_ext');
  $anthEpubDir = WP_PLUGIN_DIR . DIRECTORY_SEPARATOR . 'anthologize' . DIRECTORY_SEPARATOR . 'templates' . DIRECTORY_SEPARATOR . 'epub' . DIRECTORY_SEPARATOR;
  require_once($anthEpubDir  . DIRECTORY_SEPARATOR . 'includes' . DIRECTORY_SEPARATOR . 'class-epub-builder.php');
  include_once(ANTHOLOGIZE_TEIDOM_PATH);


$ops = array('includeStructuredSubjects' => false, //Include structured data about tags and categories
		'includeItemSubjects' => false, // Include basic data about tags and categories
		'includeCreatorData' => false, // Include basic data about creators
		'includeStructuredCreatorData' => false, //include structured data about creators
		'includeOriginalPostData' => true, //include data about the original post (true to use tags and categories)
		'checkImgSrcs' => true, //whether to check availability of image sources
		'linkToEmbeddedObjects' => false, //whether to replace embedded objects with a link to them
		'indexSubjects' => false,
		'indexCategories' => false,
		'indexTags' => false,
		'indexAuthors' => false,
		'indexImages' => false,
		);


$ops['outputParams'] = $_SESSION['outputParams'];



  if (!class_exists('XSLTProcessor', false)) {
    die ('ePub export requires XSL support');
  }

  require_once('Archive.php');


  // Load intermediate TEI file
  // generated by anthologize/includes/class-tei-dom.php


  $tei_data = new TeiDom($_SESSION, $ops);
  $epub = new EpubBuilder($tei_data, $anthEpubDir  . 'tei2html.xsl');
//echo $epub->tei->getTeiString();
//echo $epub->html->saveHTML();
//die();
  $epub->output();

//done!




die();

