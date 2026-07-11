<?php declare(strict_types=1);

/***********************************************************************
 * This file is part of AssistantFoundation for BASE3 Framework.
 **********************************************************************/

namespace AssistantFoundation\Dto;

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
