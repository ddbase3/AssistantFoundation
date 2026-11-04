<?php declare(strict_types=1);

namespace AssistantFoundation\Test\Dto;

use AssistantFoundation\Dto\AgentStageSlot;
use PHPUnit\Framework\TestCase;

final class AgentStageSlotTest extends TestCase {

	public function testAllDeclaredSlotsAreUniqueAndCanBeValidated(): void {
		$slots = AgentStageSlot::all();
		$this->assertCount(8, $slots);
		$this->assertSame($slots, array_values(array_unique($slots)));
		foreach ($slots as $slot) {
			$this->assertSame($slot, AgentStageSlot::assert(' ' . $slot . ' '));
		}
	}

	public function testUnexpectedSlotCannotBeMounted(): void {
		$this->expectException(\InvalidArgumentException::class);
		AgentStageSlot::assert('unregistered_stage');
	}
}
