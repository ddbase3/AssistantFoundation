<?php declare(strict_types=1);

namespace AssistantFoundation\Test\Api;

use AssistantFoundation\Api\IServiceDriverDefinition;
use Base3\Api\IBase;
use PHPUnit\Framework\TestCase;

final class IServiceDriverDefinitionTest extends TestCase {

	public function testDefinitionIsDiscoverableBaseComponent(): void {
		$this->assertTrue(is_subclass_of(IServiceDriverDefinition::class, IBase::class));
	}

	public function testDefinitionContainsImplementationMapping(): void {
		$this->assertTrue(method_exists(IServiceDriverDefinition::class, 'getImplementationInterface'));
		$this->assertTrue(method_exists(IServiceDriverDefinition::class, 'getImplementationName'));
	}
}
