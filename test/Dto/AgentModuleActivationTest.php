<?php declare(strict_types=1);

namespace AssistantFoundation\Test\Dto;

use AssistantFoundation\Api\IAgentStage;
use AssistantFoundation\Dto\AgentModuleActivation;
use AssistantFoundation\Dto\AgentStageMount;
use AssistantFoundation\Dto\AgentStageSlot;
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
