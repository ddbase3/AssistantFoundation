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

use Base3\AssistantFoundation\Dto\AgentExecutionEvent;
use PHPUnit\Framework\TestCase;

final class AgentExecutionEventTest extends TestCase {

	public function testEventNameIsTrimmedAndPayloadPassedThrough(): void {
		$event = new AgentExecutionEvent(' tool.completed ', ['call_id' => '1', 'success' => true]);
		$this->assertSame('tool.completed', $event->getName());
		$this->assertSame(['call_id' => '1', 'success' => true], $event->getPayload());
		$this->assertSame(['name' => 'tool.completed', 'payload' => ['call_id' => '1', 'success' => true]], $event->toArray());
	}

	public function testEmptyEventNameIsRejected(): void {
		$this->expectException(\InvalidArgumentException::class);
		new AgentExecutionEvent(' ');
	}
}
