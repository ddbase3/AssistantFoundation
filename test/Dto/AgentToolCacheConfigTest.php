<?php declare(strict_types=1);

namespace AssistantFoundation\Test\Dto;

use AssistantFoundation\Dto\AgentToolCacheConfig;
use AssistantFoundation\Dto\AgentToolCacheRule;
use PHPUnit\Framework\TestCase;

final class AgentToolCacheConfigTest extends TestCase {

	public function testCachingIsDisabledByDefaultAndWithoutRules(): void {
		$config = AgentToolCacheConfig::disabled();
		$this->assertFalse($config->isEnabled());
		$this->assertSame('configuration', $config->getScope());
		$this->assertSame('default', $config->getKeyNamespace());
		$this->assertSame(262144, $config->getMaxEntryBytes());
		$this->assertSame([], $config->getRules());
		$this->assertNull($config->findRule('tool', '', ''));
		$this->assertFalse(AgentToolCacheConfig::fromArray(['enabled' => 'yes'])->isEnabled());
		$this->assertContains(AgentToolCacheConfig::SCOPE_CUSTOM, AgentToolCacheConfig::getAllowedScopes());
	}

	public function testExplicitRulesAndShorthandToolTtlsAreResolvedInOrder(): void {
		$config = AgentToolCacheConfig::fromArray([
			'enabled' => 'ON', 'scope' => ' CUSTOM ', 'scope_key' => ' company ',
			'namespace' => ' inventory ', 'max_entry_bytes' => 4000,
			'rules' => [['tool' => 'lookup', 'ttl_seconds' => 60, 'resource_id' => 'special']],
			'tools' => ['lookup' => 5, 'status' => ['ttl' => 25, 'implementation' => 'local']]
		]);
		$this->assertTrue($config->isEnabled());
		$this->assertSame('custom', $config->getScope());
		$this->assertSame('company', $config->getScopeKey());
		$this->assertSame('inventory', $config->getKeyNamespace());
		$this->assertSame(4000, $config->getMaxEntryBytes());
		$this->assertCount(3, $config->getRules());
		$this->assertSame(60, $config->findRule('lookup', 'special', 'any')->getTtlSeconds());
		$this->assertSame(5, $config->findRule('lookup', 'elsewhere', 'any')->getTtlSeconds());
		$this->assertSame(25, $config->findRule('status', '', 'local')->getTtlSeconds());
		$this->assertNull($config->findRule('status', '', 'remote'));
	}

	public function testFalsyConfigValuesAndEmptyNamespaceAreNormalized(): void {
		foreach ([false, 0, 'false', 'off', 'no', 'unexpected', []] as $value) {
			$config = AgentToolCacheConfig::fromArray(['enabled' => $value, 'key_namespace' => ' ', 'tools' => ['read' => '12']]);
			$this->assertFalse($config->isEnabled());
			$this->assertSame('default', $config->getKeyNamespace());
		}
		foreach ([true, 1, 'true', 'yes', 'on'] as $value) {
			$this->assertTrue(AgentToolCacheConfig::fromArray(['enabled' => $value, 'tools' => ['read' => 3]])->isEnabled());
		}
	}

	public function testInvalidRuleFormatsScopesAndLimitsAreRejected(): void {
		foreach ([
			['scope' => 'unknown'], ['scope' => 'custom'], ['max_entry_bytes' => 0],
			['rules' => 'not-array'], ['rules' => [false]], ['tools' => 'not-array'],
			['tools' => ['read' => true]], ['tools' => ['read' => 0]]
		] as $override) {
			try {
				AgentToolCacheConfig::fromArray($override);
				$this->fail('Invalid tool-cache options accepted.');
			} catch (\InvalidArgumentException) {
				$this->addToAssertionCount(1);
			}
		}
		try {
			new AgentToolCacheConfig(rules: [new \stdClass()]);
			$this->fail('Foreign cache rule type accepted.');
		} catch (\InvalidArgumentException) {
			$this->addToAssertionCount(1);
		}
	}
}
