
function PuzzlePiecePattern(inputCode, inputMirrorable, inputBridges) {
	"use strict";
	var bridges = [],
		bridgeCount = 0,
		code = '',
		faceCount = 0,
		facesShape = {3: 'triangle', 4: 'square', 5: 'pentagon', 6: 'hexagon', 7: 'septagon', 8: 'octagon', 9: 'nonagon', 10: 'decagon'},
		maxSides = 10,
		mirrorable = false,
		mirrored = false,
		mirrorObj = null,
		shape = '',
		a = 0,
		suffix = '',
		msg = 'puzzlePiecePattern constructor expects ';

	// ======================================

	function mirrorBridges() {
		var output = [];

		if (mirrorable === true) {
			for (a = faceCount - 1; a >= 0; a -= 1) {
				output.push(bridges[a]);
			}
			return output;
		}
		return bridges;
	}

	function getTmpBridges() {
		var output = [];
		for (a = 0; a < faceCount; a += 1) {
			output.push(bridges[a]);
		}
		return output;
	}

	function rotate(tmpBridges) {
		var old = tmpBridges.pop();
		tmpBridges.unshift(old);
		return tmpBridges;
	}

	function isUsableInner(tmpNeighbours, tmpBridges) {

		for (a = 0; a < faceCount; a += 1) {
			if (tmpNeighbours[a] !== tmpBridges[a] && tmpNeighbours[a] !== null) {
				return false;
			}
			// $neighbours[$a] === $bridges[$a] || $neighbours[$a] === null
		}
		return true;
	}

	// ======================================

	if (!Array.prototype.isPrototypeOf(inputBridges)) {
		suffix = typeof (inputBridges);
	} else if (inputBridges.length === 0) {
		suffix = 'empty array';
	} else if (inputBridges.length < 3) {
		suffix = 'array with less than 3 items';
	} else if (inputBridges.length > maxSides) {
		suffix = 'array with more than ' + maxSides + ' items';
	}
	if (suffix !== '') {
		throw msg + 'fourth parameter inputBridges to be an array with between 3 and ' + maxSides + '. ' + suffix + ' given';
	}
	faceCount = inputBridges.length;
	shape = facesShape[faceCount];

	for (a = 0; a < faceCount; a += 1) {
		if (typeof (inputBridges[a]) === 'boolean') {
			bridges.push(inputBridges[a]);
			if (inputBridges[a] === true) {
				bridgeCount += 1;
			}
		} else {
			throw msg + 'fourth parameter $bridges[' + a + '] must be boolean. ' + typeof (bridges[a]) + ' given';
		}
	}

	// ======================================

	if (typeof (inputCode) !== 'string') {
		suffix = typeof (inputCode);
	} else if (!inputCode.match(/[a-z]?/i)) {
		suffix = '"' + inputCode + '"';
	}
	if (suffix !== '') {
		throw msg + 'first parameter $code must be a single alphabetical character string. ' + suffix + ' given';
	}
	code = inputCode;

	// ======================================

	if (typeof (mirrorable) === 'boolean') {
		mirrorable = inputMirrorable;
	} else {
		throw msg + 'third parameter $mirrorable must be boolean. ' + typeof (mirrorable) + ' given';
	}

	// ======================================

	this.isMirrorable = function () { return mirrorable; };
	this.getShape = function () { return shape; };
	this.getCode = function () {
		var output = faceCount + '.' + bridgeCount;
		if (code !== '') {
			output += '.' + code;
		}
		return output;
	};
	this.getFaceCount = function () { return faceCount; };
	this.getBridges = function () { return bridges; };
	this.getBridgeCount = function () { return bridgeCount; };
	this.isMirrored = function () { return mirrored; };

	this.isUsable = function (neighbours) {
		var tmpBridges = getTmpBridges();
		suffix = '';
		if (!Array.prototype.isPrototypeOf(neighbours)) {
			suffix = typeof (neighbours);
		} else if (neighbours.length !== faceCount) {
			suffix = neighbours.length + ' neighbours';
		}
		if (suffix !== '') {
			throw 'puzzlePiecePattern.isUsable() expects parameter \'neighbours\' to be an array with ' + faceCount + ' items. ' + suffix + ' given';
		}
		for (a = 0; a < faceCount; a += 1) {
			if (isUsableInner(neighbours, tmpBridges)) {
				return new PuzzlePiecePattern(code, mirrorable, bridges);
			}
			tmpBridges = rotate(tmpBridges);
		}
		if (mirrorable === true) {
			tmpBridges = mirrorBridges();
			for (a = 0; a < faceCount; a += 1) {
				if (isUsableInner(neighbours, tmpBridges)) {
					return new PuzzlePiecePattern(code, mirrorable, tmpBridges);
				}
				tmpBridges = rotate(tmpBridges);
			}
		}
		return false;
	};

	this.mirrorBridges =  function () {
		var output = [];
		if (mirrorable === true) {
			for (a = faceCount - 1; a >= 0; a -= 1) {
				output.push(bridges[a]);
			}
			return output;
		}
		return bridges;
	};
}
