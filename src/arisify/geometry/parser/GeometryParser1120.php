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

use arisify\geometry\element\FaceUV;
use arisify\geometry\element\Locator;
use arisify\geometry\element\Polymesh;
use arisify\geometry\element\TextureMesh;
use arisify\geometry\Geometry;
use arisify\geometry\Utils;
use arisify\geometry\element\Bone;
use arisify\geometry\element\Cube;
use arisify\geometry\element\Description;
use arisify\geometry\element\UV;
use arisify\geometry\exception\GeometryMissingFormatVersionException;
use arisify\geometry\exception\GeometryMissingRequiredItemException;

use arisify\jsonhelper\JsonHelper;
use arisify\jsonhelper\JsonObject;
use pocketmine\math\Vector2;

class GeometryParser1120 implements GeometryParser{
	public const FORMAT_VERSION = "1.12.0";

	/**
	 * @param JsonObject $model
	 * @return Geometry[]
	 */
	public static function parseModel(JsonObject $model) : array{
		if ($model->getProperty("format_version") === null) {
			throw new GeometryMissingFormatVersionException("Format version not found!");
		}
		$geometries = JsonHelper::getAsObject($model, "minecraft:geometry");
		if ($geometries === null) {
			throw new GeometryMissingRequiredItemException("minecraft:geometry not found!");
		}

		/** @var Geometry[] $models */
		$models = [];
		foreach ($geometries as $geometry) {
			$models[] = self::parseGeometry(new JsonObject($geometry, ["description"]));
		}
		return $models;
	}

	/**
	 * @param JsonObject $geometry
	 * @return Geometry
	 */
	public static function parseGeometry(JsonObject $geometry) : Geometry{
		$description = JsonHelper::getAsObject($geometry, "description");
		$bones = JsonHelper::getAsArray($geometry, "bones");
		$cape = JsonHelper::getAsString($geometry, "cape");
		if ($description === null) {
			throw new GeometryMissingRequiredItemException("Missing description");
		}
		$description = self::parseDescription(new JsonObject($description, ["identifier"]));
		if ($bones !== null) {
			$bb = [];
			foreach ($bones as $bone) {
				$b = self::parseBone(new JsonObject($bone, ["name"]));
				$bb[$b->getName()] = $b;
			}
			$bones = $bb;
		}

		return new Geometry(self::FORMAT_VERSION, $description, $bones, $cape);
	}

	/**
	 * @param JsonObject $description
	 * @return Description
	 */
	public static function parseDescription(JsonObject $description) : Description{
		$identifier = JsonHelper::getAsString($description, $description);
		if ($identifier === null) {
			throw new GeometryMissingRequiredItemException("Missing identifier");
		}
		return new Description(
			$identifier, //type: string
			JsonHelper::getAsInt($description, "texture_width"), //type: int (> 0), opt
			JsonHelper::getAsInt($description, "texture_height"), //type: int (> 0), opt
			JsonHelper::getAsFloat($description, "visible_bounds_width"), //type: number, opt
			JsonHelper::getAsFloat($description, "visible_bounds_height"), //type: number, opt
			Utils::arraytovector(JsonHelper::getAsArray($description, "visible_bounds_offset")) //type: Vector3, opt
		);
	}

	/**
	 * @param JsonObject $bone
	 * @return Bone
	 */
	public static function parseBone(JsonObject $bone) : Bone{
		$name = JsonHelper::getAsString($bone, "name");
		$cubes = JsonHelper::getAsArray($bone, "cubes");
		if ($name === null) {
			throw new GeometryMissingRequiredItemException("Missing bone name");
		}
		if ($cubes !== null) {
			$cc = [];
			foreach ($cubes as $cube) {
				$cc[] = self::parseCube(new JsonObject($cube));
			}
			$cubes = $cc;
		}
		return new Bone(
			$name, $cubes,
			Utils::arraytovector(JsonHelper::getAsArray($bone, "rotation")),
			Utils::arraytovector(JsonHelper::getAsArray($bone, "pivot")),
			$bone?->locators,
			JsonHelper::getAsString($bone, "parent"),
			JsonHelper::getAsBool($bone, "mirror"),
			JsonHelper::getAsBool($bone, "reset"),
			JsonHelper::getAsBool($bone, "debug"),
			Utils::arraytovector(JsonHelper::getAsArray($bone, "bind_pose_rotation")),
			JsonHelper::getAsFloat($bone, "inflate"),
			JsonHelper::getAsBool($bone, "neverRender"),
			JsonHelper::getAsInt($bone, "render_group_id"),
			$bone?->poly_mesh,
			$bone?->texture_meshes
		);
	}

	/**
	 * @param JsonObject $cube
	 * @return Cube
	 */
	public static function parseCube(JsonObject $cube) : Cube{
		$uv = $cube->getProperty("uv");
		if ($uv instanceof \stdClass) {
			$uv = self::parseUV(new JsonObject($uv));
		} elseif (is_array($uv)) {
			$uv = Utils::arraytovector($uv);
		} else {
			$uv = null;
		}
		/** @var UV|Vector2|null $uv */
		return new Cube(
			Utils::arraytovector(JsonHelper::getAsArray($cube, "origin")),
			Utils::arraytovector(JsonHelper::getAsArray($cube, "size")),
			Utils::arraytovector(JsonHelper::getAsArray($cube, "rotation")),
			Utils::arraytovector(JsonHelper::getAsArray($cube, "pivot")),
			JsonHelper::getAsFloat($cube, "inflate"),
			JsonHelper::getAsBool($cube, "mirror"),
			$uv,
		);
	}

	/**
	 * @param JsonObject $uv
	 * @return UV
	 */
	public static function parseUV(JsonObject $uv) : UV{
		return new UV(
			north: self::parseFaceUV(new JsonObject(JsonHelper::getAsObject($uv, "north"), ["uv"])),
			south: self::parseFaceUV(new JsonObject(JsonHelper::getAsObject($uv, "south"), ["uv"])),
			east: self::parseFaceUV(new JsonObject(JsonHelper::getAsObject($uv, "east"), ["uv"])),
			west: self::parseFaceUV(new JsonObject(JsonHelper::getAsObject($uv, "west"), ["uv"])),
			up: self::parseFaceUV(new JsonObject(JsonHelper::getAsObject($uv, "up"), ["uv"])),
			down: self::parseFaceUV(new JsonObject(JsonHelper::getAsObject($uv, "down"), ["uv"]))
		);
	}

	public static function parseFaceUV(JsonHelper $face_uv) : FaceUV{
		$uv = JsonHelper::getAsArray($face_uv, "uv");
		if ($uv === null) {
			throw new GeometryMissingRequiredItemException("Msisinaiakna");
		}
		return new FaceUV(
			uv: Utils::arraytovector($uv),
			uv_size: Utils::arraytovector(JsonHelper::getAsArray($face_uv, "uv_size")),
			material_instance: JsonHelper::getAsString($face_uv, "material_instance")
		);
	}

	public static function parseLocator(string|\stdClass $locators) : Locator{
	}

	public static function parsePolyMesh(string|\stdClass $poly_mesh) : Polymesh{
	}

	public static function parseTextureMesh(string|\stdClass $texture_meshes) : TextureMesh{
	}
}
