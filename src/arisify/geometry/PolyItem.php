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

use arisify\geometry\exception\GeometryInvalidPolyItemException;
use pocketmine\math\Vector3;

class PolyItem{
	public const MIN_ITEMS = 3;
	public const MAX_ITEMS = 4;

	/**
	 * @param Vector3[] $items A Vertex, defined by a "position" index, a "normal" index, and a "uv" index
	 */
	public function __construct(
		public array $items,
	){
		$count = count($items);
		if ($count < self::MIN_ITEMS || $count > self::MAX_ITEMS) {
			throw new GeometryInvalidPolyItemException("Items amount must greater than " . self::MIN_ITEMS . " and lower than " . self::MAX_ITEMS . ". $count was given!");
		}
	}
}