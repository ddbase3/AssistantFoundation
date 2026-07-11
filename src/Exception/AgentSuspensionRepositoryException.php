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

namespace AssistantFoundation\Exception;

final class AgentSuspensionRepositoryException extends \RuntimeException {

	public const REASON_INVALID_HANDLE = 'invalid_handle';
	public const REASON_NOT_FOUND = 'not_found';
	public const REASON_ALREADY_CLAIMED = 'already_claimed';
	public const REASON_ALREADY_CONSUMED = 'already_consumed';
	public const REASON_INVALID_STATE = 'invalid_state';
	public const REASON_UNAVAILABLE = 'unavailable';

	public function __construct(
		private readonly string $reason,
		string $message,
		?\Throwable $previous = null
	) {
		parent::__construct($message, 0, $previous);
	}

	public function getReason(): string {
		return $this->reason;
	}
}
