<?php




/**
 *
 */
class puzzlePieceObserver implements puzzlePieceObserverInterface
{
	protected $piece = null;
	protected $neighbours = array();
	protected $faceCount = 0;
	protected $boundary = false;

	static protected $traverse = true;

	public function __construct( puzzlePiece $piece , $neighbours ) {
		$this->piece = $piece;
		$this->faceCount = $this->piece->getFaceCount();
		$shape = $this->piece->getShape();
		if( !is_bool($boundary) ) {
			throw new exception('puzzlePieceObserver::__construct() expects thrid parameter $boundary to be boolean. '.gettype($boundary).' given.');
		}
		$this->boundary = $boundary;

		$suffix = '';
		if( !is_array($neighbours) ) {
			$suffix = gettype($neighbours).' given';
		} elseif( count($neighbours) !== $faceCount ) {
			$suffix = 'array had '.count($neighbours).' items.'
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


	public function setPuzzlePiece( puzzlePiece $piece ) { $this->piece = $piece; }

	public function isConnected() { return $this->piece->isConnected(); }

	public function hasBridge( $face ) { return $this->piece->hasBridge($face); }

	public function getOrientation() { return $this->piece->getOrientation(); }

	public function rotate( $steps = 1 ) { return $this->piece->rotate($steps); }

	public function rotateBack( $steps = 1 ) { return $this->piece->rotateBack($steps); }

	public function getShape() { return $this->piece->getShape(); }

	public function getCode() { return $this->piece->getCode(); }

	public function isBoundary() { return $this->boundary; }

	public function getNeighbourObserver( $face ) {
		if( is_int($face) && self::$traverse === true && isset($this->neighbours[$face] && get_class($this->neighbours[$a]) === get_class($this)) ) {
			return $this->neighbours[$a];
		}
		return false;
	}

	static public function blockTraversal() {
		self::$traverse = false;
	}
}
