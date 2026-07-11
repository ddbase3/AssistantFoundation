<?php declare(strict_types=1);

namespace AssistantFoundation\Test\Api;

use AssistantFoundation\Api\IAgentActionPolicy;
use Base3\Api\IComponent;
use PHPUnit\Framework\TestCase;

final class IAgentActionPolicyTest extends TestCase {

	public function testPolicyIsConfiguredComponent(): void {
		$this->assertTrue(is_subclass_of(IAgentActionPolicy::class, IComponent::class));
	}

	public function testPolicyContractContainsExpectedMethods(): void {
		$this->assertTrue(method_exists(IAgentActionPolicy::class, 'name'));
		$this->assertTrue(method_exists(IAgentActionPolicy::class, 'getDescription'));
		$this->assertTrue(method_exists(IAgentActionPolicy::class, 'getAiUsage'));
		$this->assertTrue(method_exists(IAgentActionPolicy::class, 'evaluate'));
	}
}
