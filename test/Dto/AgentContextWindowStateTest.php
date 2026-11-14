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

use Base3\AssistantFoundation\Dto\AgentContextWindowState;
use PHPUnit\Framework\TestCase;

final class AgentContextWindowStateTest extends TestCase {

	public function testConstructedValuePreservesItsTransportData(): void {
		$usage = new \Base3\AssistantFoundation\Dto\AiUsage(3);
		$dto = new AgentContextWindowState([$usage, 'raw'], [$usage]);
		$this->assertSame([$usage, 'raw'], $dto->getAssessments());
		$this->assertSame([$usage], $dto->getCompactions());
		$this->assertSame([$usage->toArray(), 'raw'], $dto->toArray()['assessments']);
		$this->assertSame([$usage->toArray()], $dto->toArray()['compactions']);
	}
}
