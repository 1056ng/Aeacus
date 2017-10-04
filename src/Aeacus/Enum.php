<?php

namespace Aeacus;

abstract class Enum {

  private $scalar;

  public function __construct($value) {
    $ref = new ReflectionObject($this);
    $consts = $ref->getConstants();
    if (!in_array($value, $consts, true)) {
      throw new InvalidArgumentException;
    }

    $this->scalar = $value;
  }

  final public static function toArray(): array {
    $class = get_called_class();
    $ref = new ReflectionClass($class);
    return array_keys($ref->getConstants());
  }

  final public static function __callStatic($label, $args) {
    $class = get_called_class();
    $const = constant("$class::$label");
    return new $class($const);
  }

  final public function rawValue() {
    return $this->scalar;
  }

  final public function __toString() {
    return (string)$this->scalar;
  }
}
