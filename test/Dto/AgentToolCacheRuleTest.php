<?php declare(strict_types=1);

namespace AssistantFoundation\Test\Dto;

use AssistantFoundation\Dto\AgentToolCacheRule;
use PHPUnit\Framework\TestCase;

final class AgentToolCacheRuleTest extends TestCase {

	public function testRuleMatchingEnforcesAllDeclaredIdentityConditions(): void {
		$rule = AgentToolCacheRule::fromArray(['tool_name' => ' lookup ', 'ttl' => 30, 'resource_id' => ' record ', 'implementation_name' => ' adapter ', 'variant' => ' revision ', 'metadata' => ['schema' => 2]]);
		$this->assertSame('lookup', $rule->getToolName());
		$this->assertSame(30, $rule->getTtlSeconds());
		$this->assertSame('revision', $rule->getVariant());
		$this->assertTrue($rule->matches('lookup', 'record', 'adapter'));
		$this->assertFalse($rule->matches('search', 'record', 'adapter'));
		$this->assertFalse($rule->matches('lookup', 'other', 'adapter'));
		$this->assertFalse($rule->matches('lookup', 'record', 'other'));
		$this->assertSame(['schema' => 2], $rule->getMetadata());
		$this->assertSame($rule->toArray()['resource_id'], $rule->getResourceId());
		$this->assertSame($rule->toArray()['implementation'], $rule->getImplementationName());
	}

	public function testUnqualifiedRuleMatchesAnyResourceAndImplementation(): void {
		$rule = new AgentToolCacheRule('lookup', 1);
		$this->assertTrue($rule->matches('lookup', '', ''));
		$this->assertTrue($rule->matches('lookup', 'any-resource', 'any-adapter'));
		$this->assertFalse($rule->matches('mutate', '', ''));
		$this->assertSame([], $rule->getMetadata());
		$this->assertSame(1, $rule->toArray()['ttl_seconds']);
	}

	public function testConstructorRejectsEmptyNameAndNonPositiveTtl(): void {
		foreach ([['   ', 10], ['lookup', 0], ['lookup', -1]] as [$name, $ttl]) {
			try {
				new AgentToolCacheRule($name, $ttl);
				$this->fail('Invalid caching rule accepted.');
			} catch (\InvalidArgumentException) {
				$this->addToAssertionCount(1);
			}
		}
	}
}
