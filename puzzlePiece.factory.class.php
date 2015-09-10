<?php
$here = dirname(__FILE__).'/';
require_once($here.'puzzlePiecePattern.class.php');
require_once($here.'puzzlePiece.observer.class.php');
require_once($here.'PuzzlePiece.class.php');

class puzzlePieceFactory {
	private $shape = '';
	private $faceCount = 0;
	private $bridgePatterns = array();

	public function __construct( $bridgePatterns ) {
		$suffix = '';
		if( !is_string($shape) ) {
			$suffix = gettype($shape);
		}

		$shape = trim(strtolower($shape));
		if( strlen($shape) > 4 && ( $shape === 'triangle' || $shape === 'square' || substr($shape,-4,4)  === 'agon' ) ) {
			$this->shape = $shape;
		} else {
			$suffix = '"'.$shape.'"';
		}
		if( $suffix !== '' ) {
			throw new exception('puzzlePieceFactory::__construct() expects first parameter $shape to be a valid shape name. '.$suffix.' given');
		}


		if( !is_array($bridgePatterns) ) {
			$suffix = gettype($bridgePatterns);
		} elseif( empty($bridgePatterns) ) {
			$suffix = 'empty array';
		}
		if( $suffix !== '' ) {
			throw new exception('puzzlePieceFactory::__construct() expects second parameter $bridgePatterns to be an array containing puzzlePiecePattern objects. '.$suffix.' given');
		}

		foreach( $bridgePatterns as $pattern ) {
			if( !is_a($pattern,'puzzlePiecePattern') ) {
				throw new exception('puzzlePieceFactory::__construct() expects second parameter $bridgePatterns to be a three dimensional array where the key for each top level item must be an index greater than zero. '.$suffix.' given');
			}
			$faceCount = $pattern->getFaceCount();
			if( !isset($this->bridgePatterns[$faceCount]) ) {
				$this->bridgePatterns[$faceCount] = array();
			}
			$code = $pattern->getCode();
			if( strlen($code) === 1 ) {
				$this->bridgePatterns[$faceCount][0] = $pattern;
			} else {
				$code = substr($code,-1,1);
				$this->bridgePatterns[$faceCount][$code] = $pattern;
			}
		}
	}

	public function setNewPuzzlePiece( puzzlePieceObserver $observer , $seed = false ) {
		$requiredBridges = $observer->getRequiredBridges();
		$possiblePatterns = array();
		// TODO loop through patterns with appropriate bridge count
		//		add viable patterns to $possiblePatterns
		//		randomly choose viable pattern from $possiblePatterns
		//		create new puzzlePiece from chosen viable pattern
		//		insert puzzlePiece into $observer
		return $observer;
	}
}

