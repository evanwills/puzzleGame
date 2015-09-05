<?php


/**
 * @interface puzzleGame abstract factory method
 *
 */
interface puzzleGame
{
	public function __construct( $X , $Y , $mode );

	public function getX();

	public function getY();

	public function getMode();

	public function getPieces();
}



/**
 *
 */

abstract class abstractPuzzlePiece implements puzzlePiece {


	private static $bridgePatterns = array();

	protected $orientation = 0;

	protected $bridges = array();

	protected $neighbours = array();

	protected $faceCount = 0;

	protected $shape = '';

	protected $code = '';

	public function __construct( $orientation , $neighbours , $code ) {
		if( is_int($orientation) && $orientation >= 0 && $orientation <= $this->faceCount ) {
			$this->orientation = $orientation
		} else {
			if( is_int($orientation) ) {
				$suffix = $orientation;
			} else {
				$suffix = gettype($orientation);
			}
			throw new exception(get_class($this).'::__construct() expects first parameter $orientation to be an integer between 0 and '.$this->faceCount.'. '.$suffix.' given.');
		}

		if( is_array($neighbours) ) {
			for( $a = 0 ; $a < $this->faceCount ; $a += 1 ) {
				if( isset($neighbours[$a]) ) {
					if( is_a($neighbours[$a] , 'puzzlePieceVisitor') )
					{
						if( $neighbours[$a]->getShape() === $this->shape ) {
							$this->neighbours[$a] = $neighbours[$a];
						} else {
							throw new exception (get_class($this).'::__construct() expects $neighbours['.$a.'] to be a '.$this->shape.'PuzzlePiece object. '.$neighbours[$a]->getShape().' given');
						}
					} else {
						throw new exception (get_class($this).'::__construct() expects $neighbours['.$a.'] to be a puzzlePieceVisitor object. '.gettype($neighbours[$a]).' given');
					}
				} else {
					throw new exception (get_class($this).'::__construct() expects second parameter $neighbours to be a an array containing '.$this->faceCount.' puzzlePieceVisitor objects. Only '.count($neighbours).' puzzlePieceVisitor objects given');
				}
			}
		} else {
			throw new exception (get_class($this).'::__construct() expects second parameter $neighbours to be an array. '.gettype($neighbours).' given');
		}

		if( is_string($code) ) {
			for( $a = 0 ; $a < count(self::$bridgePatterns) ; $a += 1 ) {
				if( self::$bridgePatterns[$a]['key'] === $code ) {
					$this->bridges = self::$bridgePatterns[$a]['bridges'];
					$this->code =  self::$bridgePatterns[$a]['key'];
				}
			}
			if( !isset($this->code) ) {
				throw new exception (get_class($this).'::__construct() expects third parameter $code to be a string matching one of '.$this->shape.'\'s bridge patterns. "'.$code.'" given');
			}
		} else {
			throw new exception (get_class($this).'::__construct() expects third parameter $code to be a string matching one of '.$this->shape.'\'s bridge patterns. '.gettype($code).' given');
		}
	}


	public function isConnected() {
		$half = ( $this->faceCount / 2 );
		for( $a = 0 ; $a < $this->faceCount ; $a += 1 ) {
			if( $a >= $half) ) {
				$b = ( $a - $half );
			} else {
				$b = ( $a + $half );
			}
			if( $this->bridges[$a] === true ) {
				if( $this->neighbours[$a]->hasBridge($b) === false ) {
					return false;
				}
			}
		}
		return true;
	}


	public function hasBridge( $face ) {
		if( is_int($face) && $face >= 0 && $face <= $this->faceCount ) {
			return $this->bridges[$face];
		} else {
			if( is_int($face) ) {
				$suffix = $face;
			} else {
				$suffix = gettype($face);
			}
			throw new exception(get_class($this).'::hasBridge() expects parameter $face to be an integer between 0 and '.$this->faceCount.'. '.$suffix.' given.');
		}
	}


	public function getOrientation() {
		return $this->orientation;
	}


	public function getShape() {
		return $this->shape;
	}

	public function getCode() {
		return $this->code;
	}

	public function rotate() {
		if( $this->orientation === $this->faceCount - 1 ) {
			$this->orientation = 0;
		} else {
			$this->orientation += 1;
		}
		$old = array_pop($this->bridges);
		array_unshift( $this->bridges , $old );
	}


	public function rotateBack() {
		if( $this->orientation === 0 ) {
			$this->orientation = $this->faceCount - 1;
		} else {
			$this->orientation -= 1;
		}
		$old = array_shift($this->bridges);
		$this->bridges[] = $old;
	}

	static public function getBridgePatterns() {
		return sellf::$bridgePatterns;
	}

	public function copyMe()
	{
		$bridges = 0;
		for( $a = 0 ; $a < $this->faceCount ; $a += 1 ) {
			if( $this->bridges[$a] === true ) {
				$bridges += 1;
			}
		}
		if( $bridges === 0 || $bridges === $this->faceCount ) {
			return $this;
		} else {
			return clone $this;
		}
	}
}



/**
 *
 */
class puzzlePieceVisitor implements puzzlePieceVisitorInterface
{
	protected $piece = null;
	protected $default = true;

	public function __construct( puzzlePiece $puzzle ) {
		$this->piece = $piece;
	}
	public function setPuzzlePiece( puzzlePiece $piece ) {
		if( $defalut === true ) {
			$default = false;
			$this->piece = $piece;
		}
	}


	public function isConnected() { return $this->piece->isConnected(); }

	public function hasBridge( $face ) { return $this->piece->hasBridge($face); }

	public function getOrientation() { return $this->piece->getOrientation(); }

	public function rotate() { return $this->piece->rotate(); }

	public function getShape() { return $this->piece->getShape(); }

	public function getCode() { return $this->piece->getCode(); }

}
