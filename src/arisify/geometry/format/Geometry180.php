<?php

namespace arisify\geometry\format;

use arisify\geometry\element\Description;

class Geometry180 extends Geometry{
    private Description $description;
    private array $bones;
    private ?string $cape;

    public function __construct(Description $description, ?array $bones = null, ?string $cape = null) {
        $this->description = $description;
        $bs = [];
        foreach ($bones as $b) {
            $bs[$b->getName()] = $b;
        }
        $this->bones = $bs;
        $this->cape = $cape;
    }

    public function getFormatVersion() : string{
        return "1.8.0";
    }

    public function toJson(){
    }

    /**
     * @return Description
     */
    public function getDescription(): Description {
        return $this->description;
    }

    /**
     * @param Description $description
     */
    public function setDescription(Description $description): void {
        $this->description = $description;
    }
}