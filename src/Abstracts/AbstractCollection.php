<?php
/**
 * Copyright (c) 2018 - present
 * Google Maps PHP - AbstractCollection.php
 * author: Roberto Belotti - roby.belotti@gmail.com
 * web : robertobelotti.com, github.com/biscolab
 * Initial version created on: 5/9/2018
 * MIT license: https://github.com/biscolab/google-maps-php/blob/master/LICENSE
 */

namespace Biscolab\GoogleMaps\Abstracts;

/**
 * Class AbstractCollection
 * @package Biscolab\GoogleMaps\Abstracts
 */
abstract class AbstractCollection {

	/**
	 * @var array
	 */
	protected $items = [];

	/**
	 * @var int
	 */
	protected $index = 0;

	/**
	 * AbstractCollection constructor.
	 *
	 * @param null|array $items
	 */
	public function __construct(?array $items = []) {

		$this->setItems($items);
	}

	/**
	 * @param array $items
	 *
	 * @return AbstractCollection
	 */
	protected function setItems(?array $items = []) {

		if (is_array($items) && count($items)) {
			foreach ($items as $item) {
				$this->addItem($item);
			}
		}

		return $this;
	}

	/**
	 * @param $item
	 *
	 * @return AbstractCollection
	 */
	public function addItem($item) {

		$item = $this->parseItem($item);
		array_push($this->items, $item);

		return $this;
	}

	/**
	 * @param $item
	 *
	 * @return mixed
	 */
	protected function parseItem($item) {

		return $item;
	}

	/**
	 * @return array
	 */
	public function toArray(): array {

		return $this->items;
	}

	/**
	 * @param $index
	 *
	 * @return mixed|null
	 */
	public function get(int $index) {

		return isset($this->items[$index]) ? $this->items[$index] : null;
	}

	/**
	 * @return int
	 */
	public function count(): int {

		return count($this->items);
	}

	/**
	 * @return string
	 */
	public function toJson(): string {

		return json_encode($this->toArray());
	}

	/**
	 * @return string
	 */
	public function __toString(): string {

		return implode(',', $this->toArray());
	}

	/**
	 * @return int
	 */
	public function getLastIndex(): int {

		$last_position = $this->count() - 1;

		return ($last_position) < 0 ? 0 : $last_position;
	}

	/**
	 * Move the index at the specified position
	 *
	 * @param int|null $index
	 *
	 * @return mixed|null
	 */
	public function seek(?int $index = 0) {

		$this->index = ($index < $this->count()) ? $index : $this->getLastIndex();

		return $this->get($this->index);
	}

	/**
	 * Return the current position of the index
	 *
	 * @return int
	 */
	public function position(): int {

		return $this->index;
	}

	/**
	 * Return the current object
	 *
	 * @return mixed|null
	 */
	public function current() {

		return $this->get($this->index);
	}

	/**
	 * Move index to first position and return current element
	 *
	 * @return mixed|null
	 */
	public function first() {

		return $this->seek();
	}

	/**
	 * Move index at the end of collection and return current element
	 *
	 * @return mixed|null
	 */
	public function last() {

		return $this->seek($this->getLastIndex());
	}

}