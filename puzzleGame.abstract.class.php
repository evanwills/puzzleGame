<?php

$here = dirname(__FILE__).'/';
require_once($here.'puzzleGame.interface.php');
require_once($here.'puzzlePiece.class.php');
require_once($here.'blankPuzzlePiece.class.php');
require_once($here.'puzzlePiece.observer.class.php');
require_once($here.'puzzlePiece.factory.class.php');

abstract class abstractPuzzleGame implements puzzleGame {
	protected $pieces = array();
	protected $mode 'random';
	protected $X = 2;
	protected $Y = 2;

	public function __construct( $X , $Y , $mode ) {
		if( is_int($X) && $X > 1 )
		{
			$this->X = $X;
		} else {
			if( !is_int($X) ) {
				$suffix = gettype($X);
			} else {
				$suffix = $X;
			}
			throw new exception('puzzleGameSquares::__construct() expects first parameter $x to be an integer, greater than 1. '.$suffix.' given.');
		}
		if( is_int($Y) && $Y > 1 )
		{
			$this->X = $Y;
		} else {
			if( !is_int($Y) ) {
				$suffix = gettype($Y);
			} else {
				$suffix = $Y;
			}
			throw new exception('puzzleGameSquares::__construct() expects second parameter $Y to be an integer, greater than 1. '.$suffix.' given.');
		}
		if( is_string($mode) ) {
			$tmp = preg_replace('`[^a-z]`i','',trim(ucwords($mode)));
			switch($tmp) {
				case 'random':
				case 'horizontallySymmetrical':
				case 'verticallySymmetrical':
				case 'horizontallyVerticallySymmetrical':
				case 'diagonallySymmetrical':
				case 'squareRadiallySymmetrical':
					$this->mode = $tmp;
					break;
				default:
					throw new exception('puzzleGameSquares::__construct() expects third parameter $mode to be a string matching one of the six mirror modes. "'.$mode.'" given.' );
			}
		} else {
			throw new exception('puzzleGameSquares::__construct() expects third parameter $mode to be a string matching one of the six mirror modes. '.gettype($mode).' given.' );
		}
	}

	public function getX() {
		return $this->X;
	}

	public function getY() {
		return $this->Y;
	}

	public function getMode() {
		return $this->mode;
	}

	public function getPieces() {
		$output = array();
		for( $a = 0 ; $a < count($this->pieces) ; $a += 1 ) {
			$output[] = $this->pieces[$a]->getCode();
		}
	}

}
