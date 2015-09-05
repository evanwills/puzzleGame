<?php

require_once(dirname(__FILE__).'/puzzleGame.interface.php');

/**
 * @interface puzzleGame abstract factory method
 *
 */
class puzzleGameSquares implements puzzleGame {
	public function __construct( $X , $Y , $mode );

	public function getX();

	public function getY();

	public function getMode();

	public function getPieces();

}

