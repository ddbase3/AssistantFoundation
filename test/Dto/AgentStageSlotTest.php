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

use Base3\AssistantFoundation\Dto\AgentStageSlot;
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
