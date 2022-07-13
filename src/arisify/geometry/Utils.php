<?php
/**
 * This file is part of the GeometryLib ©2022
 *
 * @author Arisify
 * @link   https://github.com/Arisify
 * @license https://opensource.org/licenses/MIT MIT License
 *
 * •.,¸,.•*`•.,¸¸,.•*¯ ╭━━━━━━━━━━━━╮
 * •.,¸,.•*¯`•.,¸,.•*¯.|:::::::/\___/\
 * •.,¸,.•*¯`•.,¸,.•* <|:::::::(｡ ●ω●｡)
 * •.,¸,.•¯•.,¸,.•╰ *  し------し---Ｊ
 *
 */
declare(strict_types=1);

namespace arisify\geometry;

use pocketmine\math\Vector2;
use pocketmine\math\Vector3;

class Utils{
	public const FORMAT_VERSION_LIST = [
		"1.8.0",
		"1.10.0",
		"1.12.0",
		"1.14.0",
		"1.16.0"
	];

	public static function arraytovector(array|null $array) : Vector2|Vector3|null{
		if ($array === null) {
			return null;
		}
		$array = array_values($array);
		if (count($array) === 2) {
			return new Vector2($array[0], $array[1]);
		}
		if (count($array) === 3) {
			return new Vector3($array[0], $array[1], $array[2]);
		}
		return null;
	}

	public static function vectortoarray(Vector2|Vector3 $vector) : array{
		return $vector instanceof Vector3 ? [$vector->x, $vector->y, $vector->z] : [$vector->x, $vector->y];
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