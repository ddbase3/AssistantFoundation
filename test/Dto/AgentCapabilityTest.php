<?php declare(strict_types=1);

namespace AssistantFoundation\Test\Dto;

use AssistantFoundation\Dto\AgentCapability;
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
