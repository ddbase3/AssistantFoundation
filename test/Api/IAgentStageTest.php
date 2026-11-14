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

namespace Base3\AssistantFoundation\Test\Api;

use Base3\AssistantFoundation\Api\IAgentStage;
use Base3\CoreFoundation\Api\IComponent;
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
			'Base3\AssistantFoundation\\Dto\\AgentStageResult',
			(string)(new ReflectionMethod(IAgentStage::class, 'process'))->getReturnType()
		);
	}
}
