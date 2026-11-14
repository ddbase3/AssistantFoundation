<?php declare(strict_types=1);

/***********************************************************************
 * This file is part of AssistantFoundation for BASE3 Framework.
 *
 * AssistantFoundation defines reusable contracts for AI assistants and agents.
 * It provides DTOs, models, and interfaces for retrieval, speech and tools.
 * Implementations reside in independent BASE3 runtime plugins.
 *
 * Developed by Daniel Dahme
 * Licensed under GPL-3.0
 * https://www.gnu.org/licenses/gpl-3.0.en.html
 *
 * https://base3.de/v/assistantfoundation
 * https://github.com/ddbase3/AssistantFoundation
 **********************************************************************/

namespace Base3\AssistantFoundation\Test;

use PHPUnit\Framework\TestCase;
use Base3\AssistantFoundation\AssistantFoundationPlugin;
use Base3\CoreFoundation\Api\IContainer;

class FakeContainer implements IContainer {

	private array $items = [];
	private array $flags = [];

	public function getServiceList(): array {
		return array_keys($this->items);
	}

	public function set(string $name, $classDefinition, $flags = 0): IContainer {
		$this->items[$name] = $classDefinition;
		$this->flags[$name] = (int)$flags;
		return $this;
	}

	public function remove(string $name) {
		unset($this->items[$name], $this->flags[$name]);
	}

	public function has(string $name): bool {
		return array_key_exists($name, $this->items);
	}

	public function get(string $name) {
		return $this->items[$name] ?? null;
	}

	public function getFlags(string $name): ?int {
		return $this->flags[$name] ?? null;
	}

}
