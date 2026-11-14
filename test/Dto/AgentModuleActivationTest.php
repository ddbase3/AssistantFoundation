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

use Base3\AssistantFoundation\Api\IAgentStage;
use Base3\AssistantFoundation\Dto\AgentModuleActivation;
use Base3\AssistantFoundation\Dto\AgentStageMount;
use Base3\AssistantFoundation\Dto\AgentStageSlot;
use PHPUnit\Framework\TestCase;

final class AgentModuleActivationTest extends TestCase {

	public function testActivationTrimsInstructionsAndKeepsConfiguredProviders(): void {
		$tool = new \stdClass();
		$stage = new AgentStageMount(AgentStageSlot::PLANNING, $this->createStub(IAgentStage::class), 8);
		$activation = new AgentModuleActivation([' first ', ' ', ' second '], [$tool], [$tool], [$tool], [$stage]);
		$this->assertSame(['first', 'second'], $activation->getInstructions());
		$this->assertSame([$tool], $activation->getTools());
		$this->assertSame([$tool], $activation->getResourceProviders());
		$this->assertSame([$tool], $activation->getPromptProviders());
		$this->assertSame([$stage], $activation->getStages());
	}

	public function testForeignStageObjectsCannotBeInjected(): void {
		$this->expectException(\InvalidArgumentException::class);
		new AgentModuleActivation(stages: ['wrong-stage']);
	}
}
