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

use Base3\AssistantFoundation\Dto\AgentKnowledgeState;
use PHPUnit\Framework\TestCase;

final class AgentKnowledgeStateTest extends TestCase {

	public function testConstructedValuePreservesItsTransportData(): void {
		$usage = new \Base3\AssistantFoundation\Dto\AiUsage(2);
		$dto = new AgentKnowledgeState([$usage], [['message' => 'confirmed'], $usage]);
		$this->assertSame([$usage], $dto->getKnowledge());
		$this->assertSame([['message' => 'confirmed'], $usage], $dto->getObservations());
		$this->assertSame([$usage->toArray()], $dto->toArray()['knowledge']);
		$this->assertSame([['message' => 'confirmed'], $usage->toArray()], $dto->toArray()['observations']);
	}
}
