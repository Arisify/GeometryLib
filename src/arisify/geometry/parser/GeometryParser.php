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

namespace arisify\geometry\parser;

use arisify\geometry\element\Bone;
use arisify\geometry\element\Cube;
use arisify\geometry\element\Description;
use arisify\geometry\element\UV;
use arisify\geometry\Geometry;
use pocketmine\math\Vector2;

interface GeometryParser{
	public const FORMAT_VERSION = "0.0.0";

	/**
	 * @param \stdClass|string $model
	 * @return Geometry[]
	 */
	public static function parseModel(\stdClass|string $model) : array;

	public static function parseGeometry(\stdClass|string $geometry) : ?Geometry;

	public static function parseDescription(\stdClass|string $description) : ?Description;

	/**
	 * @param \stdClass|string|null $bones
	 * @return Bone[]|null
	 */
	public static function parseBones(\stdClass|string|null $bones) : ?array;

	/**
	 * @param \stdClass|string|null $cubes
	 * @return Cube[]|null
	 */
	public static function parseCubes(\stdClass|string|null $cubes) : ?array;

	/**
	 * @param \stdClass|string|null $uv
	 * @param bool                  $eachFace
	 * @return Vector2|UV|null
	 */
	public static function parseUV(\stdClass|string|null $uv, bool $eachFace = true) : Vector2|UV|null;

	public static function checkFormatVersion(string $version) : bool;
}