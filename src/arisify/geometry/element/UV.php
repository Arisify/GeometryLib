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

namespace arisify\geometry\element;

use arisify\geometry\Utils;

class UV{
	/**
	 * @param FaceUV|null $north Specifies the UV's for the face that stretches along the x and y axes, and faces the minus z-axis.
	 * @param FaceUV|null $south Specifies the UV's for the face that stretches along the x and y axes, and faces the z-axis
	 * @param FaceUV|null $east Specifies the UV's for the face that stretches along the z and y axes, and faces the x-axis
	 * @param FaceUV|null $west Specifies the UV's for the face that stretches along the z and y axes, and faces the minus x-axis
	 * @param FaceUV|null $up Specifies the UV's for the face that stretches along the x and z axes, and faces the y-axis
	 * @param FaceUV|null $down Specifies the UV's for the face that stretches along the x and z axes, and faces the minus y-axis
	 */
	public function __construct(
		public ?FaceUV $north = null,
		public ?FaceUV $south = null,
		public ?FaceUV $east = null,
		public ?FaceUV $west = null,
		public ?FaceUV $up = null,
		public ?FaceUV $down = null
	) {}

	public function toArray(array &$default) : array{
		if ($this->north !== null) {
			$default["north"] = Utils::vectorToArray($this->north);
		}
		if ($this->south !== null) {
			$default["south"] = Utils::vectorToArray($this->south);
		}
		if ($this->east !== null) {
			$default["east"] = Utils::vectorToArray($this->east);
		}
		if ($this->west !== null) {
			$default["west"] = Utils::vectorToArray($this->west);
		}
		if ($this->up !== null) {
			$default["up"] = Utils::vectorToArray($this->up);
		}
		if ($this->down !== null) {
			$default["down"] = Utils::vectorToArray($this->down);
		}
		return $default;
	}
}