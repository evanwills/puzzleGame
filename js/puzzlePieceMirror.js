

function getMirror(inputFaces, inputMirrorX, inputMirrorY) {
	'use strict';
	var suffix = '',
		singletons = [];


	if (inputFaces === parseInt(inputFaces, 10) || inputFaces < 2) {
		if (inputFaces === parseInt(inputFaces, 10)) {
			suffix = typeof (inputFaces);
		} else {
			suffix = inputFaces;
		}
		throw 'PuzzlePieceMirror.getMirror() expects first parameter $faces to be an integer greater than 1 ' + suffix + ' given.';
	}


	function PuzzlePieceMirror(inputMirrorX, inputMirrorY) {
	//	static private $singletons = [];

		var mirrorXfaces = [],
			mirrorYfaces = [],

			a = 0,
			suffix = '';

		function mirrorInner(bridges, swapsies) {
			var tmp0 = null,
				tmp1 = null,
				first = null,
				second = null;
			if (!Array.prototype.isPrototypeOf(bridges)) {
				throw '';
			}
			if (!Array.prototype.isPrototypeOf(swapsies)) {
				throw '';
			}
			for (a = 0; a < swapsies.length; a += 1) {
				if (swapsies[a][0] === undefined || swapsies[a][1] === undefined) {
					throw '';
				}
				tmp0 = swapsies[a][0];
				tmp1 = swapsies[a][1];
				if (bridges[tmp0] === undefined || bridges[tmp1] === undefined) {
					throw '';
				}
				first = bridges[tmp0];
				second = bridges[tmp1];
				bridges[tmp0] = second;
				bridges[tmp1] = first;
			}
			return bridges;
		}

		this.mirrorX = function (bridges) {
			return mirrorInner(bridges, mirrorXfaces);
		};

		this.mirrorY = function (bridges) {
			return mirrorInner(bridges, mirrorXfaces);
		};
	}

	if( singletons[inputFaces] === undefined) {
		var $axis = ['X','Y'];
		var $which = 'second';
		for( var $a = 0 ; $a < 2 ; $a += 1 ) {
			var $var = 'mirror' + $axis[$a];
			var $suffix = '';
			if( $var instanceof Array ) {
				$suffix = typeof $var;
			} else if( $var.length === 0 ) {
				$suffix = $$var;
			}
			if( $suffix !== '' ) {
				throw 'mirrorPuzzlePiece::getMirror() expects ' + $which + ' parameter inputMirror' + $axis[$a] + ' to be an array with at least one child array.';
			}
			for ( var $b in $var ) {
				var $tmp = $$var;
				var $item = $tmp[$b];
				if( $item instanceof Array ) {
					$suffix = gettype($item) + ' given';
				} else if( $item.length !== 2 ) {
					var $x = $item.length;
					$suffix = 'array has ' + $x + ' item';
					if( $x > 1 ) {
						$suffix = $suffix + 's';
					}
				}
				if( $suffix !== '' ) {
					throw 'mirrorPuzzlePiece::getMirror() expects ' + $which + ' parameter inputMirror' + $axis[$a] + '[' + $b + '] to be an array with at exactly 2 children. ' + $suffix;
				}
				for( var $c = 0 ; $c < 2 ; $c += 1 ) {
					if( !is_int($item[$c]) ) {
						$suffx = gettype($itme[$c]);
					} else if( $item[$c] < 0 ) {
						$suffix = $item[$c];
					}
					if( $suffix !== '' ) {
						throw 'mirrorPuzzlePiece::getMirror() expects ' + $which + ' parameter inputMirror' + $axis[$a] + '[' + $b + '][' + $c + '] to be an integer equal to or greater than zero. ' + $suffix + ' given';
					}

				}
			}
			$which = 'third';
		}
		singletons[inputFaces] = new PuzzlePieceMirror( $mirrorX , $mirrorY );
	}
	return singletons[inputFaces];
}


