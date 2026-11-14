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

namespace Base3\AssistantFoundation\Dto;

final class AgentStageSlot {

	public const BEFORE_PLANNING = 'before_planning';
	public const PLANNING = 'planning';
	public const BEFORE_EXECUTION = 'before_execution';
	public const EXECUTION = 'execution';
	public const BEFORE_TOOL_CALL = 'before_tool_call';
	public const AFTER_TOOL_CALL = 'after_tool_call';
	public const BEFORE_FINAL_ANSWER = 'before_final_answer';
	public const AFTER_FINAL_ANSWER = 'after_final_answer';

	/** @return array<int,string> */
	public static function all(): array {
		return [
			self::BEFORE_PLANNING,
			self::PLANNING,
			self::BEFORE_EXECUTION,
			self::EXECUTION,
			self::BEFORE_TOOL_CALL,
			self::AFTER_TOOL_CALL,
			self::BEFORE_FINAL_ANSWER,
			self::AFTER_FINAL_ANSWER
		];
	}

	public static function assert(string $slot): string {
		$slot = trim($slot);
		if (!in_array($slot, self::all(), true)) {
			throw new \InvalidArgumentException('Unknown agent stage slot: ' . $slot);
		}
		return $slot;
	}
}
