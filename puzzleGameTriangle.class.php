<?php

require_once(dirname(__FILE__).'/puzzleGame.abstract.class.php');

/**
 * @interface puzzleGame abstract factory method
 *
 */
class puzzleGameTriangle implements puzzleGameInterface {

	private $bridgePatterns = array(
		1 => array(
			array( 'bridges' => array( true  , false , false ) , 'mirror' => false )
		),
		2 => array(
			array( 'bridges' => array( true  , true  , false ) , 'mirror' => false )
		),
		3 => array(
			array( 'bridges' => array( true  , true  , true  ) , 'mirror' => false )
		)
	);

	private $faceCount = 3;
	private $shape = 'triangle';

	private function generatePuzzle() {

	}
}
