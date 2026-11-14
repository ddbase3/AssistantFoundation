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

use Base3\AssistantFoundation\Dto\AgentTaskState;
use PHPUnit\Framework\TestCase;

final class AgentTaskStateTest extends TestCase {

	public function testConstructedValuePreservesItsTransportData(): void {
		$dto = new AgentTaskState('task-2', 'Review access', ['request' => 1], ['priority' => 'high']);
		$this->assertSame('task-2', $dto->getId());
		$this->assertSame('Review access', $dto->getDescription());
		$this->assertSame(['request' => 1], $dto->getInput());
		$this->assertSame(['priority' => 'high'], $dto->getMetadata());
		$this->assertSame(['request' => 1], $dto->toArray()['input']);
	}
}
