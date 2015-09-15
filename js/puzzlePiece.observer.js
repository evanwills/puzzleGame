
function PuzzlePieceObserver(inputPiece, inputNeighbours) { //implements puzzlePieceInterface , puzzlePieceObserverInterface
	'use strict';

	var piece = null,
		neighbours = [],
		faceCount = 0,
		boundary = false,
		shape = '',
		x = -1,
		y = -1,

		a = 0,
		suffix = '';

	if (PuzzlePiece.isPrototypeOf(inputPiece) || blankPuzzlePiece.isPrototypeOf(inputPiece) || nullPuzzlePiece.isPrototypeOf(inputPiece)) {
		piece = inputPiece;
	} else {
		throw 'PuzzlePieceObserver constructor expects first parameter inputPiece to be an PuzzlePiece object';
	}
	faceCount = piece.getFaceCount();
	shape = piece.getShape();

	suffix = '';
	if (!Array.isPrototypeOf(inputNeighbours)) {
		suffix = typeof (inputNeighbours) + ' given';
	} else if (inputNeighbours.length !== faceCount) {
		suffix = 'array had ' + inputNeighbours.length + ' items.';
	}
	if (suffix !== '') {
		throw 'PuzzlePieceObserver constructor expects second parameter inputNeighbours to be an array containing ' + faceCount + ' items. ' + suffix;
	}

	for (a = 0; a < faceCount; a += 1) {
		if( inputNeighbours[a] !== undefined) ) {
			if (PuzzlePiece.isPrototypeOf(inputNeighbours[a]) || blankPuzzlePiece.isPrototypeOf(inputNeighbours[a]) || nullPuzzlePiece.isPrototypeOf(inputNeighbours[a]) || PuzzlePieceObserver.isPrototypeOf(inputNeighbours[a])) {
				if (blankPuzzlePiece.isPrototypeOf(inputNeighbours[a])) {
					boundary = true;
				}
//				if( inputNeighbours[a].getShape() === $this->shape ) {
//					$this->neighbours[$a] = $neighbours[$a];
//				} else {
//					throw new exception ('puzzlePieceObserver::__construct() expects second parameter $neighbours['.$a.'] to be a '.$this->shape.' shaped puzzlePieceObserver object. '.$neighbours[$a]->getShape().' given');
//				}
			} else {
				throw new'PuzzlePieceObserver constructor expects second parameter inputNeighbours[' +a + '] to be an object that implements puzzlePiece. ' + typeof (inputNeighbours[a]) + ' given';
			}
		} else {
			throw 'PuzzlePieceObserver constructor expects second parameter inputNeighbours to be a an array containing '+ faceCount + ' puzzlePieceObserver objects. Only ' + inputNeighbours.length +' puzzlePieceObserver objects given';
		}
	}


	this.getBridges = function () { return piece.getBridges(); };

	this.getCode = function () { return piece.getCode(); };

	this.getNeighbourObserver = function ( inputFace ) {
		if (inputFace === parseInt(inputFace, 10) && neighbours[inputFace] !== undefined) {
			return neighbours[inputFace];
		} else {
			if (inputFace !== parseInt(inputFace,10) ) {
				suffix = typeof (inputFace) + ' given';
			} else {
				suffix = 'neighbours[' + inputFace '] is undefined';
			}
			throw new exception('PuzzlePieceObserver.getNeighbourObserver() expects parameter inputFace to be an integer between 0 and ' + faceCount + '. ' + suffix);
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
