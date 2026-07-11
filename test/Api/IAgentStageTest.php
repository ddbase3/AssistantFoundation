<?php declare(strict_types=1);

namespace AssistantFoundation\Test\Api;

use AssistantFoundation\Api\IAgentStage;
use Base3\Api\IComponent;
use PHPUnit\Framework\TestCase;
use ReflectionMethod;

final class IAgentStageTest extends TestCase {

	public function testStageIsConfiguredComponent(): void {
		$this->assertTrue(is_subclass_of(IAgentStage::class, IComponent::class));
	}

	public function testStageContractContainsExpectedMethods(): void {
		$this->assertTrue(method_exists(IAgentStage::class, 'name'));
		$this->assertTrue(method_exists(IAgentStage::class, 'getDescription'));
		$this->assertTrue(method_exists(IAgentStage::class, 'getAiUsage'));
		$this->assertTrue(method_exists(IAgentStage::class, 'supports'));
		$this->assertTrue(method_exists(IAgentStage::class, 'process'));

		$this->assertSame('bool', (string)(new ReflectionMethod(IAgentStage::class, 'supports'))->getReturnType());
		$this->assertSame(
			'AssistantFoundation\\Dto\\AgentStageResult',
			(string)(new ReflectionMethod(IAgentStage::class, 'process'))->getReturnType()
		);
	}
}
