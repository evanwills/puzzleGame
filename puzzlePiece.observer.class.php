<?php

require_once(dirname(__FILE__).'/puzzle.interfaces.php');


/**
 *
 */
class puzzlePieceObserver implements puzzlePieceInterface , puzzlePieceObserverInterface
{
	static protected $traverse = true;
	protected $piece = null;
	protected $neighbours = array();
	protected $faceCount = 0;
	protected $boundary = false;
	protected $x = -1;
	protected $y = -1;

	public function __construct( puzzlePiece $piece , $neighbours ) {
		$this->piece = $piece;
		$this->faceCount = $this->piece->getFaceCount();
		$shape = $this->piece->getShape();
//		if( !is_bool($boundary) ) {

//			throw new exception('puzzlePieceObserver::__construct() expects thrid parameter $boundary to be boolean. '.gettype($boundary).' given.');
//		}
//		$this->boundary = $boundary;

		$suffix = '';
		if( !is_array($neighbours) ) {
			$suffix = gettype($neighbours).' given';
		} elseif( count($neighbours) !== $faceCount ) {
			$suffix = 'array had '.count($neighbours).' items.';
		}
		if( $suffix !== '' ) {
			throw new exception ('puzzlePieceObserver::__construct() expects second parameter $neighbours to be an array containing '.$this->faceCount.' items. '.$suffix);
		}

		for( $a = 0 ; $a < $faceCount ; $a += 1 ) {
			if( isset($neighbours[$a]) ) {
				if( is_object($neighbours[$a]) && in_array('puzzlePiece',class_implements($neighbours[$a])) )
				{
					if( !is_a($neighbours[$a],'puzzlePieceObserver') ) {
						$this->boundary = true;
					}
					if( $neighbours[$a]->getShape() === $this->shape ) {
						$this->neighbours[$a] = $neighbours[$a];
					} else {
						throw new exception ('puzzlePieceObserver::__construct() expects second parameter $neighbours['.$a.'] to be a '.$this->shape.' shaped puzzlePieceObserver object. '.$neighbours[$a]->getShape().' given');
					}
				} else {
					throw new exception ('puzzlePieceObserver::__construct() expects second parameter $neighbours['.$a.'] to be an object that implements puzzlePiece. '.gettype($neighbours[$a]).' given');
				}
			} else {
				throw new exception ('puzzlePieceObserver::__construct() expects second parameter $neighbours to be a an array containing '.$this->faceCount.' puzzlePieceObserver objects. Only '.count($neighbours).' puzzlePieceObserver objects given');
			}
		}
	}


	public function getBridges() { return $this->piece->getBridges(); }

	public function getCode() { return $this->piece->getCode(); }

	public function getNeighbourObserver( $face ) {
		if( is_int($face) && isset($this->neighbours[$face]) ) {
			return $this->neighbours[$a];
		} else {
			if( !is_int($face) ) {
				$face = gettype($face);
			throw new exception('puzzlePieceObserver::getNeighbourObserver() expects parameter $face to be an integer between 0 and '.$this->faceCount.'. '.$face.' given.');
		}
	}

	public function getOppositeFace( $face , $faceCount ) { return $this->piece->getOppositeFace($face,$faceCount); }

	public function getOrientation() { return $this->piece->getOrientation(); }

	public function getPieceClone() { return $this->piece->clone(); }

	public function getPieceType() { return get_class($this->piece); }

	public function getRequiredBridges() {
		$output = array( 'count' => array('required' => 0 , 'optional' => 0 ) , 'bridges' => array() );
		$half = ( $this->faceCount / 2 );
		for( $a = 0 ; $a < $this->faceCount ; $a += 1 ) {
			if( $a >= $half ) {
				$b = ( $a - $half );
			} else {
				$b = ( $a + $half );
			}
			$tmp = $this->neighbours[$a]->hasBridge($b);

			$output['bridges']['required'][] = $tmp;
			if( $tmp === true ) {
				if( is_a($this->neighbours[$a],'genericPuzzlePiece') ) {
					$output['count']['required'] += 1;
				}
				$output['count']['optional'] += 1;
			}
		}
		return $output;
	}

	public function getShape() { return $this->piece->getShape(); }

	public function getX() { return $this->X; }
	public function getY() { return $this->Y; }
	public function getXY() { return array( 'x' => $this->X , 'y' => $this->Y ); }
	public function getXYstr() { return $this->X.','.$this->Y; }


	public function setNeighbourObserver( puzzlePieceObserver $piece , $face ) {
		if( is_int($face) && isset($this->neighbours[$face]) && get_class($this->neighbours[$face]) === 'nullPuzzlePiece' ) {
			$this->neighbours[$face] = $piece;
		}
	}

	public function setPuzzlePiece( puzzlePiece $piece ) { $this->piece = $piece; }

	public function setXY( $x , $y ) {
		if( is_int($x) && $x >= 0 && $this->X === -1 ) {
			$this->X = $x;
		} else {
			throw new exception(get_class($this).'::setXY() expects first parameter $X to be an integer greater than or equal zero.');
		}
		if( is_int($y) && $y >= 0 && $this->Y === -1 ) {
			$this->Y = $y;
		} else {
			throw new exception(get_class($this).'::setXY() expects second parameter $Y to be an integer greater than or equal zero.');
		}
	}


	public function connectToNeighbours() {

		$neighbourBridges = array();
		for( $a = 0 ; $a < $this->faceCount ; $a += 1 ) {
			$neighbourBridges[$a] = $this->neighbours[$a]->hasBridge( $this->piece->getOppositeFace($a) );
		}

		$output = false;
		$limit = $this->faceCount;
		while( $output === false && $limit > 0 ) {
			$unbridged = $this->bridgeCount;

			// TODO this requires more thought
			for( $a = 0 ; $a < $this->faceCount ; $a += 1 ) {
				if( $neighbourBridges[$a] === $this->bridges[$a] || $neighbourBridges[$a] === null ) {
					$unbridged -= 1;
				}
			}
			if( $unbridged < 1 ) {
				return true;
			}
			$this->piece->rotate();
			$limit -= 1;
		}

		throw new exception('puzzlePiece::connectToNeighbours() cannot connect bridges to neighbours.');
	}

	public function isConnected() {

		for( $a = 0 ; $a < $this->faceCount ; $a += 1 ) {
			$neighbourBridge = $this->neighbours[$a]->hasBridge( $this->piece->getOppositeFace($a) );
			if( $neighbourBridge !== $this->bridges[$a] && $neighbourBridge !== null ) {
				return false;
			}
		}
		return true;
	}

	public function isBoundary() { return $this->boundary; }

	public function hasBridge( $face , $faceCount ) { return $this->piece->hasBridge($face,$faceCount); }

	public function rotate( $steps = 1 ) { return $this->piece->rotate($steps); }

	public function rotate180() { return $this->piece->rotate180(); }

	public function rotateBack( $steps = 1 ) { return $this->piece->rotateBack($steps); }

	public function mirrorH() { return $this->piece->mirrorH(); }

	public function mirrorV() { return $this->piece->mirrorV(); }

	static public function StopBlockTraversal() { self::$traverse = false; }

}
