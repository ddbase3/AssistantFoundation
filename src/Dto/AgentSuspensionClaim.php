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

/** Internal lease for one server-owned agent suspension. */
final class AgentSuspensionClaim {

	public function __construct(
		private readonly string $resumeHandle,
		private readonly string $claimToken,
		private readonly AgentSuspension $suspension
	) {
		if (trim($resumeHandle) === '') {
			throw new \InvalidArgumentException('Agent suspension claim handle must not be empty.');
		}
		if (trim($claimToken) === '') {
			throw new \InvalidArgumentException('Agent suspension claim token must not be empty.');
		}
	}

	public function getResumeHandle(): string {
		return $this->resumeHandle;
	}

	public function getClaimToken(): string {
		return $this->claimToken;
	}

	public function getSuspension(): AgentSuspension {
		return $this->suspension;
	}
}
