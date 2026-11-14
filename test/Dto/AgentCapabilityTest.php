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

namespace Base3\AssistantFoundation\Test\Dto;

use Base3\AssistantFoundation\Dto\AgentCapability;
use PHPUnit\Framework\TestCase;

final class AgentCapabilityTest extends TestCase {

	public function testDefinitionNameAndMetadataAreExposedWithoutChangingDefinition(): void {
		$definition = ['type' => 'function', 'function' => ['name' => 'lookup', 'parameters' => ['type' => 'object']]];
		$capability = new AgentCapability('lookup', 'Search', 'Find items', 'retrieval', ['read'], 5, $definition, 'source-1', 'CRM', true, ['sensitive' => false]);
		$this->assertSame('lookup', $capability->getName());
		$this->assertSame('Search', $capability->getTitle());
		$this->assertSame('Find items', $capability->getDescription());
		$this->assertSame('retrieval', $capability->getCategory());
		$this->assertSame(['read'], $capability->getTags());
		$this->assertSame(5, $capability->getPriority());
		$this->assertSame('source-1', $capability->getSourceId());
		$this->assertSame('CRM', $capability->getSourceName());
		$this->assertTrue($capability->isAlwaysAvailable());
		$this->assertSame(['sensitive' => false], $capability->getMetadata());
		$this->assertSame($definition, $capability->getDefinition());
		$this->assertSame('lookup', $capability->toArray()['name']);
	}

	public function testMismatchedFunctionNamesAndMalformedTagsAreRejected(): void {
		foreach ([
			['', ['function' => ['name' => ''] ], []],
			['lookup', ['function' => ['name' => 'other']], []],
			['lookup', ['function' => ['name' => 'lookup']], [' ', 'valid']],
			['lookup', ['function' => ['name' => 'lookup']], [false]]
		] as [$name, $definition, $tags]) {
			try {
				new AgentCapability($name, '', '', '', $tags, 0, $definition);
				$this->fail('Invalid capability accepted.');
			} catch (\InvalidArgumentException) {
				$this->addToAssertionCount(1);
			}
		}
	}
}
