<?php declare(strict_types=1);

/***********************************************************************
 * This file is part of AssistantFoundation for BASE3 Framework.
 *
 * AssistantFoundation extends the BASE3 framework with a unified API
 * foundation for assistants, chatbots, and agent-based systems.
 * It provides shared interfaces for modular AI integration.
 *
 * Developed by Daniel Dahme
 * Licensed under GPL-3.0
 * https://www.gnu.org/licenses/gpl-3.0.en.html
 *
 * https://base3.de/v/assistantfoundation
 * https://github.com/ddbase3/AssistantFoundation
 **********************************************************************/

namespace AssistantFoundation\Dto;

/**
 * AgentExecutionStatus
 *
 * Stable provider-neutral status values for agent runs that can complete,
 * fail, be cancelled, or pause for explicit user interaction.
 */
final class AgentExecutionStatus {

	public const RUNNING = 'running';
	public const COMPLETED = 'completed';
	public const FAILED = 'failed';
	public const PARTIAL = 'partial';
	public const CANCELLED = 'cancelled';
	public const AWAITING_APPROVAL = 'awaiting_approval';
	public const AWAITING_INPUT = 'awaiting_input';

	public static function isSuspended(string $status): bool {
		return in_array($status, [
			self::AWAITING_APPROVAL,
			self::AWAITING_INPUT
		], true);
	}

	/**
	 * @return array<int,string>
	 */
	public static function all(): array {
		return [
			self::RUNNING,
			self::COMPLETED,
			self::FAILED,
			self::PARTIAL,
			self::CANCELLED,
			self::AWAITING_APPROVAL,
			self::AWAITING_INPUT
		];
	}
}
