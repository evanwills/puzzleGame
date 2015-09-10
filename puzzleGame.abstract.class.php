<?php

$here = dirname(__FILE__).'/';
require_once($here.'puzzle.interfaces.php');
require_once($here.'puzzlePiece.class.php');
require_once($here.'puzzlePieceMirror.singleton.class.php');
require_once($here.'blankPuzzlePiece.class.php');
require_once($here.'puzzlePiece.observer.class.php');
require_once($here.'puzzlePiece.factory.class.php');

abstract class abstractPuzzleGame implements puzzleGame {
	protected $pieces = array();
	protected $edgeObservers = array();
	protected $waitingObservers = array();

	/**
	 * @var int $pieceCount number of non blank pieces.
	 */
	protected $pieceCount = 0;
	protected $mode = 'random';
	protected $X = 2;
	protected $Y = 2;
	protected $blankPiece = null;
	protected $nullPiece = null;
	protected $faceCount = 0;
	protected $shape = '';
	protected $bridgePatterns = array();
	protected $bridgePatternsByCode = array();
	protected $pieceAllocationMode = 'addPuzzlePiecesRandomXY';

	public function __construct( $X , $Y , $mode , $pieceAllocation = 'randomXY' , $seed = '' ) {
		if( is_int($X) && $X > 1 )
		{
			$this->X = $X;
		} else {
			if( !is_int($X) ) {
				$suffix = gettype($X);
			} else {
				$suffix = $X;
			}
			throw new exception(get_class($this).'::__construct() expects first parameter $x to be an integer, greater than 1. '.$suffix.' given.');
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
			throw new exception(get_class($this).'::__construct() expects second parameter $Y to be an integer, greater than 1. '.$suffix.' given.');
		}
		if( is_string($mode) ) {
			$tmp = preg_replace('`[^a-z]`i','',trim(ucwords($mode)));
			switch($tmp) {
				case 'random':
				case 'horizontallySymmetrical':
				case 'verticallySymmetrical':
				case 'horizontallyVerticallySymmetrical':
				case 'diagonallySymmetrical':
				case 'radiallySymmetrical':
					$tmp = ucfirst($tmp);
					$this->mode = "apply{$tmp}Mode";
					break;
				default:
					throw new exception(get_class($this).'::__construct() expects third parameter $mode to be a string matching one of the six mirror modes. "'.$mode.'" given.' );
			}
		} else {
			throw new exception(get_class($this).'::__construct() expects third parameter $mode to be a string matching one of the six mirror modes. '.gettype($mode).' given.' );
		}


		if( is_string($pieceAllocation) ) {
			$tmp = preg_replace('`[^a-z]`i','',trim(ucwords($pieceAllocation)));
			switch($tmp) {
				case 'random':
				case 'adjacent':
				case 'linear':
					$tmp = ucfirst($tmp);
					$this->pieceAllocationMode = "addPuzzlePieces{$tmp}";
					break;
				default:
					throw new exception(get_class($this).'::__construct() expects fourth parameter $pieceAllocation to be a string matching one of the three piece alocation modes. "'.$pieceAllocation.'" given.' );
			}
		} else {
			throw new exception(get_class($this).'::__construct() expects fourth parameter $pieceAllocation to be a string matching one of the three piece alocation modes. '.gettype($pieceAllocation).' given.' );
		}


		$this->blankPiece = blankPuzzlePiece::getPiece( $this->shape , $this->faceCount );
		$this->nullPiece = nullPuzzlePiece::getPiece( $this->shape , $this->faceCount );

		$first = true;
		foreach( $this->bridgePatterns as $bridgeCount => $patterns ) {
			foreach( $patterns as $code => $pattern ) {
				$tmp = new puzzlePiecePattern( $code , $pattern['mirror'] , $pattern['bridges'] , $this->mirrorX , $this->mirrorY );
				$this->bridgePatterns[$bridgeCount][$code] = $tmp;
				if( $tmp->getShape() !== $this->shape ) {
					throw new exception(get_class($this).'::bridgePatterns['.$bridgeCount.']['.$code.'] is not a '.$this->shape.' shaped pattern');
				}
				$tmpCode = $tmp->getCode();
				$this->bridgePatternsByCode[$tmpCode] = $tmp;
 			}
		}

		if( $seed === '' ) {
			while( strlen($this->seed) < 64 ) {
				$this->seed .= mt_rand();
			}
		} elseif( is_scalar($seed) && !empty($seed) ) {
			settyp($seed,'string');
			$this->seed = $seed;
		} else {
			$suffix = '';
			if( !is_scalar($seed) ) {
				$suffix = gettype($seed);
			} elseif( empty($seed) ) {
				$suffix = 'empty scalar';
			}
			if( $suffix !== '' ) {
				throw new exception(get_class($this).'::__construct() expects fifth parameter $seed to be a non empty scalar. '.$suffix.' given');
			}
		}

		$this->generatePuzzle();

		$this->addPuzzlePiecesRandomly();
	}

	public function getX() { return $this->X; }

	public function getY() { return $this->Y; }

	public function getMode() { return $this->mode; }

	public function getPieceCount() { return $this->pieceCount; }

	public function getPieces() {
		$output = array();
		for( $a = 0 ; $a < count($this->pieces) ; $a += 1 ) {
			$output[] = $this->pieces[$a]->getCode();
		}
	}


	abstract protected function generatePuzzle();


	protected function addPuzzlePiecesRandomXY() {
		while( !empty($this->waitingObservers) ) {
			$key = mt_rand(0,count($this->waitingObservers) - 1);
			$observer = $this->waitingObservers[$key];
			$this->setRandomPuzzlePiece( $observer );
			$this->removeWaitingObserver( $observer->getXYstr() );
		}
	}

	protected function addPuzzlePiecesLinear() {
		for( $y = 0 ; $y < $this->Y ; $y += 1 ) {
			for( $x = 0 ; $x < $this->X ; $x += 1 ) {
				$this->setRandomPuzzlePiece( $this->pieces[$x][$y] );
			}
		}
	}

	protected function addPuzzlePiecesAdjacent() {
		$x = mt_rand($this->X - 1);
		$y = mt_rand($this->Y - 1);
		$observer = $this->pieces[$y][$x];
		$this->setRandomPuzzlePiece( $observer );
		$this->addNeighbourObserversToWaiting($observer);
		while( !empty($this->waitingObservers) ) {
			$key = mt_rand(0,count($his->waitingObservers));
			$observer = $this->waitingObserver;
			$this->setRandomPuzzlePiece( $observer );
			$this->addNeighbourObserversToWaiting($observer);
			$this->removeWaitingObserver( $observer->getXYstr() );
		}
	}

	protected function addNeighbourObserversToWaiting( $observer ) {
		for( $a = 0 ; $a < $this->faceCount ; $a += 1 ) {
			$neighbour = $observer->getNeighbourObserver($a);
			if( $neighbour !== false && $neighbour->getPieceType() === 'nullPuzzlePiece' ) {
				$this->waitingObservers[] = $neighbour;
			}
		}
	}

	protected function setRandomPuzzlePiece( puzzlePieceObserver $observer ) {
		if( $observer->getPieceType() === 'nullPuzzlePiece' ) {
			$requiredBridges = $observer->getRequiredBridges();
			$possiblePatterns = array();
			for( $a = $requiredBridges['required'] ; $a <= $requiredBridges['optional'] ; $a += 1 ) {
				if( isset($this->bridgePatterns[$a]) ) {
					if( $count($this->bridgePatterns[$a]) === 1 ) {
						if( $this->bridgePatterns[$a][0]->isUsable($requiredBridges['bridges']) ) {
							$possiblePatterns[] = $this->bridgePatterns[$a][0];
						}
					}
				} else {
					foreach( $this->bridgePatterns[$a] as $pattern ) {

						if( $pattern->isUsable($requiredBridges['bridges']) ) {
							$possiblePatterns[] = $pattern;
						}
					}
				}
			}
			if( count($possiblePatterns) === 0 ) {
				$usePattern = $possiblePatterns[0];
			} else {
				$key = mt_rand(0,count($possiblePatterns) - 1);
				$usePattern = $possiblePatterns[$key];
			}
			if( $usePattern->getBridgeCount() === 0 ) {
				$piece = $this->blankPuzzlePiece;
			} else {
				$piece = new puzzlePiece($usePattern);
			}
			$observer->setPuzzlePiece($piece);
			$this->{$this->mode}($observer);
		}
	}

	protected function applyRandomMode( puzzlePieceObserver $observer ) { /* do nothing */ }

	abstract protected function applyHorizontallySymmetricalMode( puzzlePieceObserver $observer );
	abstract protected function applyVerticallySymmetricalMode( puzzlePieceObserver $observer );
	abstract protected function applyHorizontallyVerticallySymmetricalMode( puzzlePieceObserver $observer );
	abstract protected function applyDiagonallySymmetricalMode( puzzlePieceObserver $observer );
	abstract protected function applyRadiallySymmetricalMode( puzzlePieceObserver $observer );

	protected function createObserver( $edges ) {
		$suffix = '';
		if( !is_array($edges) ) {
			$suffix = gettype($edges);
		} elseif( count($edges) !== $this->faceCount ) {
			$suffix = 'an array with '.count($edges).' items';
		}
		if( $suffix !== '' ) {
			throw new exception(get_class($this).'::createObserver() expects parameter $edges to be an array with '.$this->faceCount.' items. '.$suffix.' given');
		}
		for( $a = 0 ; $a < $this->faceCount ; $a += 1 ) {
			if( !is_bool($edges[$a]) ) {
				throw new exception( get_class($this).'::createObserver() expects parameter $edges['.$a.'] to be boolean . '.gettype($edges[$a]).' given');
			}
			if( $edges[$a] === true ) {
				$edges[$a] = $this->blankPuzzlePiece;
			} else {
				$edges[$a] = $this->nullPuzzlePiece;
			}
		}
		return new puzzlePieceObserver( $this->nullPuzzlePiece,$edges);
	}




	protected function rotate( $input , $steps = 1 ) {
		if( is_int($steps) && $steps > 0 && is_array($input) ) {
			for( $a = 0 ; $a < $steps ; $a += 1 ) {
				$old = array_pop($input);
				array_unshift( $input , $old );
			}
		}
		return $input;
	}

	protected function removeWaitingObserver( $observer ) {
		for( $a = 0 ; $a < count($this->waitingObservers) ; $a += 1 ) {
			if( $xy === $this->waitingObservers[$a]->getXYstr() ) {
				unset($this->waitingObservers[$a]);
				shuffle($this->waitingObservers);
				return true;
			}
		}
		return false;
	}

	protected function rotateBack( $steps = 1 ) {
		if( is_int($steps) && $steps > 0 && is_array($input) ) {
			for( $a = 0 ; $a < $steps ; $a += 1 ) {
				$old = array_shift($input);
				$input[] = $old;
			}
		}
		return $input;
	}

	protected function rotate180() {
		$half = $this->faceCount / 2;
		if( is_int($half) ) {
			for( $a = 0 ; $a < $half ; $a += 1 ) {
				$old = array_pop($input);
				array_unshift( $input , $old );
			}
			return true;
		}
		return false;
	}

	protected function getMirror( $value , $which ) {
		if( is_int($value) && ( $which === 'X' || $which === 'Y' ) && $value < $this->$which ) {
			$tmp = $this->$which - $value;
			if( $tmp !== $value ) {
				return $tmp;
			} else {
				return false;
			}
		} else {
			// throw new exception
		}
	}

	protected function getPredictableNum( $min , $max ) {
		// see:
		//	http://erlycoder.com/49/javascript-hash-functions-to-convert-string-into-integer-hash-
		//	http://pmav.eu/stuff/javascript-hashing-functions/source.html

		// for implementing this in JS
		$source = crc32($this->seed);
		$chars = strlen($max);
		settype($source,'string');
		if( substr($source,0,1) === '-' ) {
			$tmp = '1';
		} else {
			$tmp = '0';
		}
		$source = $tmp.substr($source,1);
		for( $a = count($source) - $chars ; $a >= 0 ; $a -= 1 ) {
			$tmp = substr($source,$a,$chars);
			if( $tmp >= $min && $tmp <= $max ) {
				$this->seed .= $tmp;
				return $tmp;
			}
		}
	}
}
