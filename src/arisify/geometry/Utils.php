<?php
declare(strict_types=1);

namespace arisify\geometry;

use pocketmine\math\Vector2;
use pocketmine\math\Vector3;

class Utils{

	public const FORMAT_VERSION_LIST = [
		"1.8.0",
		"1.10.0",
		"1.12.0",
		"1.16.0"
	];

	public static function vectorToArray(Vector2 | Vector3 $vector) : array{
		$v = [$vector->x, $vector->y];
		if ($vector instanceof Vector3) {
			$v[] = $vector->z;
		}
		return $v;
	}

	public static function compareVersion(string $versionA, string $versionB) : int{
		if ($versionA === $versionB) {
			return 0;
		}
		$vA = explode('.', $versionA);
		$vB = explode('.', $versionB);
		foreach ($vA as $i => $a) {
			if (!isset($vB[$i]) || ((int) $a  > (int) $vB[$i])) {
				return 1;
			}
		}
		return -1;
	}
}