<?php
declare(strict_types=1);

const MCPATH = "C:/Users/TGDD-MSI/Downloads/MC19/";

$known_root_list = static fn(string $version) => match ($version) {
	"1.8.0", "1.10.0" => ["format_version" => "string", "geometry.*" => "object"],
	"1.12.0", "1.16.0" => ["format_version" => "string", "minecraft:geometry" => "array"],
	default => null,
};
$known_format_version = ["1.8.0", "1.10.0", "1.12.0", "1.16.0"];

$known_description = [
	"identifier" => "string",
	"texture_width" => "int",
	"texture_height" => "int",
	"visible_bounds_width" => "double",
	"visible_bounds_height" => "double",
	"visible_bounds_offset" => "array"
];

$known_bones = [
	"name" => "string",
	"cubes" => "array", # Optional
	"inflate" => "double", # Optional, Default: 0.0
	"locators" => "array|object",
	"parent" => "string",
	"pivot" => "array",
	"rotation" => "array",
	"mirror" => "boolean", # Default: false
	"binding" => "string", # 1.16.0+?
	"reset" => "boolean", # 1.12+? Default: false
	"texture_meshes" => "array", # 1.12+? Default: non-exist?
];

$known_cubes = [
	"inflate" => "double",
	"mirror" => "boolean",
	"origin" => "array",
	"pivot" => "array",
	"rotation" => "array",
	"size" => "array",
	"uv" => "array|object",
];
$known_texture_meshes = [
	"position" => "array",
	"texture" => "string"
];
$known_uv = "array|object";

function checkVarType(string $predict, string $real) : bool{
	$validate = static fn(string $s) => match(strtolower($s)) {
		"int", "integer", "float", "double", "long", "long long" => "number",
		"bool" => "boolean",
		"str" => "string",
		"obj" => "object",
		default => $s
	};
	foreach (explode('|', $predict) as $p) {
		if ($validate($p) === $validate($real)) {
			return true;
		}
	}
	return false;
}

function matchGlob(string $s, array $search) : mixed{
	if (isset($search[$s])) {
		return $search[$s];
	}
	foreach (array_keys($search) as $se) {
		if (fnmatch($se, $s)) {
			return $search[$se];
		}
	}
	return null;
}

foreach(glob(MCPATH . "*") as $file) {
	try {
		$data = (array) json_decode(file_get_contents($file),false, 512, JSON_THROW_ON_ERROR);
	} catch (JsonException $e) {
		print ("> Error when trying to read $file");
		continue;
	}
	if ($data["format_version"] === "1.12.0") {
		$data = json_decode(json_encode($data, JSON_THROW_ON_ERROR), false, 512, JSON_THROW_ON_ERROR);
		print_r($data);
		break;
	}
	continue;
	if (!isset($data["format_version"])) {
		print("> Format version not found in $file" . PHP_EOL .  PHP_EOL);
		continue;
	}
	$format_version = $data["format_version"];
	if (!in_array($format_version, $known_format_version, true)) {
		print("> A new format_version was added: " . $format_version);
		print ($file . PHP_EOL .PHP_EOL);
		continue;
	}
	$krl = $known_root_list($format_version);
	foreach ($data as $i => $d) {
		$r = matchGlob($i, $krl);
		$real = gettype($d);
		if ($r !== null) {
			if (!checkVarType($r, $real)) {
				print ("> Tag: $i changed from $r => $real" . PHP_EOL);
				print ($format_version . PHP_EOL);
				print ($file . PHP_EOL .PHP_EOL);
			}
			continue;
		}
		print ("> A new tag has been added to root list: $i => " . gettype($d) . PHP_EOL);
		print ($format_version . PHP_EOL);
		print ($file . PHP_EOL .PHP_EOL);
	}

	switch ($format_version) {
		case "1.8.0":
		case "1.10.0":
			//$geometries = array_shift($data);
			continue 2;
		case "1.12.0":
		case "1.16.0":
			$geometries = (array) $data["minecraft:geometry"];
			// $geometries = $data->{"minecraft:geometry"};
			break;
		default:
			print("> A new format_version was added: " . $format_version . PHP_EOL . $file . PHP_EOL);
			continue 2;
	}

	foreach ($geometries as $geometry) {
		$ged = (array) $geometry;
		$descriptions = $geometry->description;
		$identifier = $descriptions->identifier;
		$bones = $ged["bones"];

		foreach ($descriptions as $k => $description) {
			$real = gettype($description);
			if (isset($known_description[$k])) {
				$predict = $known_description[$k];
				if (!checkVarType($predict, $real)) {
					print("> $identifier 's descriptions: $k changed from $predict to $real" . PHP_EOL . $file . PHP_EOL .  PHP_EOL);
				}
				continue;
			}
			print ("> A new tag has been added to descriptions list: $k => $real" . PHP_EOL);
			print ($format_version . PHP_EOL);
			print ($file . PHP_EOL .PHP_EOL);
		}

		foreach ($bones as $bone) {
			$bd = (array) $bone;
			foreach ($bd as $k => $v) {
				if (isset($known_bones[$k])) {
					$predict = $known_bones[$k];
					if (!checkVarType($predict, gettype($v))) {
						print ($identifier . ":" . ($bd["name"] ?? "unknown")  . " " . ($bd["name"] ?? "unknown") . " -> $k changed from " . $predict . " to " . gettype($v) . PHP_EOL);
						print ($format_version .PHP_EOL);
						print ($file . PHP_EOL .PHP_EOL);
					}
				} else {
					print ($identifier . "'s bonds: " . ($bd["name"] ?? "unknown") . " added a new tag! ($k : " . gettype($v) . ") " . PHP_EOL);
					print ($format_version . PHP_EOL);
					print ($file . PHP_EOL .PHP_EOL);
				}
			}
			if (!isset($bd["cubes"])) {
				continue;
			}
			$cubes = (array) $bd["cubes"];
			foreach ($cubes as $i => $cube) {
				foreach ($cube as $k => $v) {
					if (isset($known_cubes[$k])) {
						$predict = $known_cubes[$k];
						$real = gettype($v);
						if (!checkVarType($predict, $real)) {
							print ($identifier . ":" . ($bd["name"] ?? "unknown") . " > " . $i . " -> $k changed from " . $predict . "to " . $real . PHP_EOL);
							print ($format_version .PHP_EOL);
							print ($file . PHP_EOL .PHP_EOL);
						}
					} else {
						print ($identifier . ":" . ($bd["name"] ?? "unknown") . " added a new tag! ($i -> $k : " . gettype($v) . ") " . PHP_EOL);
						print ($format_version . PHP_EOL);
						print ($file . PHP_EOL .PHP_EOL);
					}
				}
			}
		}
	}
}