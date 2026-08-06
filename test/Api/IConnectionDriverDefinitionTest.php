<?php declare(strict_types=1);

namespace AssistantFoundation\Test\Api;

use AssistantFoundation\Api\IConnectionDriverDefinition;
use Base3\Api\IBase;
use PHPUnit\Framework\TestCase;

final class IConnectionDriverDefinitionTest extends TestCase {

	public function testDefinitionIsDiscoverableBaseComponent(): void {
		$this->assertTrue(is_subclass_of(IConnectionDriverDefinition::class, IBase::class));
	}

	public function testConnectionDefinitionOwnsConnectionSchema(): void {
		$this->assertTrue(method_exists(IConnectionDriverDefinition::class, 'getConfigSchema'));
		$this->assertTrue(method_exists(IConnectionDriverDefinition::class, 'getDefaultConfig'));
		$this->assertTrue(method_exists(IConnectionDriverDefinition::class, 'getHealthCheckSchema'));
	}
}
