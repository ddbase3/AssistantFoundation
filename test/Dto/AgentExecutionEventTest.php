<?php declare(strict_types=1);

namespace AssistantFoundation\Test\Dto;

use AssistantFoundation\Dto\AgentExecutionEvent;
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
