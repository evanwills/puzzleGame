<?php

require_once(dirname(__FILE__).'/puzzleGame.abstract.class.php');


class puzzleGameHexagon implements puzzleGameInterface {

	private $bridgePatterns = array(
		1 => array(
			array( 'key' => '1' , 'bridgeCount' => 1 , 'bridges' => array( true  , false , false , false , false , false ) , 'mirror' => false )
		),
		2 => array(
			'a' => array( 'bridges' => array( true  , true  , false , false , false , false ) , 'mirror' => false ),
			'b' => array( 'bridges' => array( true  , false , true  , false , false , false ) , 'mirror' => false ),
			'c' => array( 'bridges' => array( true  , false , false , true  , false , false ) , 'mirror' => false )
		),
		3 => array(
			'a' => array( 'bridges' => array( true  , true  , true  , false , false , false ) , 'mirror' => false ),
			'b' => array( 'bridges' => array( true  , true  , false , true  , false , false ) , 'mirror' => true  ),
			'c' => array( 'bridges' => array( true  , false , true  , false , true  , false ) , 'mirror' => false )
		),
		4 => array(
			'a' => array( 'bridges' => array( true  , true  , true  , true  , false , false ) , 'mirror' => false ),
			'b' => array( 'bridges' => array( true  , true  , true  , false , true  , false ) , 'mirror' => false ),
			'c' => array( 'bridges' => array( true  , true  , false , true  , true  , false ) , 'mirror' => false )
		),
		5 => array(
			array( 'bridges' => array( true  , true  , true  , true  , true  , false ) , 'mirror' => false )
		),
		6 => array(
			array( 'bridges' => array( true  , true  , true  , true  , true  , true  ) , 'mirror' => false )
		)
	);


	private $mirrorH = array(array(1,5),array(2,4));
	private $mirrorV = array(array(0,3),array(1,2),array(4,5));



	private $faceCount = 6;
	private $shape = 'hexagon';

	private function generatePuzzle() {

	}
}

