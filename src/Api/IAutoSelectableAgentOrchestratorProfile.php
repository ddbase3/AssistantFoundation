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

namespace Base3\AssistantFoundation\Api;

/** Optional, runtime-specific participation in automatic orchestrator selection. */
interface IAutoSelectableAgentOrchestratorProfile extends IAgentOrchestratorProfile {

	/**
	 * Determines whether the profile can satisfy the effective configuration of a new run.
	 * The check must be deterministic and read-only, must not invoke a model or tool,
	 * and must not change settings, permissions, resources or execution state.
	 * Explicit profile selections do not call this method.
	 *
	 * @param array<string,mixed> $agentSettings Effective configured agent settings.
	 * @param bool $requiresToolLoop Whether configured tools or capability contributions require orchestration.
	 * @return bool True only if the profile is suitable for the supplied requirements.
	 * @throws \RuntimeException If the suitability check cannot be completed; the caller must not silently select another profile on error.
	 */
	public function supportsAutoSelection(array $agentSettings, bool $requiresToolLoop): bool;

	/**
	 * Returns the priority among automatically selectable profiles of the same runtime.
	 * Higher values are checked first; equal priorities are ordered by stable profile ID.
	 * This method is read-only and independent of discovery order.
	 *
	 * @return int Selection priority.
	 */
	public function getAutoSelectionPriority(): int;
}
