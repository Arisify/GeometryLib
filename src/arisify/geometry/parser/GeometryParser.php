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
use arisify\jsonhelper\JsonObject;
use pocketmine\math\Vector2;

interface GeometryParser{
	public const FORMAT_VERSION = "0.0.0";

	/**
	 * @param JsonObject $model
	 * @return Geometry[]
	 */
	public static function parseModel(JsonObject $model) : array;

	public static function parseGeometry(JsonObject $geometry) : Geometry;

	public static function parseDescription(JsonObject $description) : ?Description;

	/**
	 * @param JsonObject $bone
	 * @return Bone
	 */
	public static function parseBone(JsonObject $bone) : Bone;

	/**
	 * @param JsonObject $cube
	 * @return Cube
	 */
	public static function parseCube(JsonObject $cube) : Cube;
}