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

namespace Base3\AssistantFoundation\Api;

use Base3\CoreFoundation\Api\IBase;

/**
 * Declares an immutable, runtime-specific orchestration profile.
 *
 * Implementations are discovered through IClassMap. The owning runtime
 * validates and materializes the settings; this contract does not execute
 * an agent or persist settings.
 */
interface IAgentOrchestratorProfile extends IBase {

	/**
	 * Returns the stable runtime identifier.
	 *
	 * @return string Non-empty identifier matching IAgentRuntimeService::getRuntimeId().
	 * @sideEffects None. Must not depend on request state.
	 */
	public static function getRuntimeId(): string;

	/**
	 * Returns the immutable profile identifier within the owning runtime.
	 *
	 * @return string Non-empty identifier containing only lowercase letters,
	 *                digits, dots, underscores or hyphens. Unique within the
	 *                runtime and stable across releases.
	 * @sideEffects None. Must not depend on request state.
	 */
	public function getId(): string;

	/**
	 * Returns the complete code-owned profile settings for the declared runtime.
	 *
	 * Technical settings must be deterministic; presentation labels and
	 * descriptions may be localized by the owning plugin. The returned settings
	 * must be valid under the runtime's profile configuration contract.
	 *
	 * @return array<string,mixed> Runtime-specific configuration without secrets
	 *                             or per-execution state.
	 * @throws \Throwable If the definition cannot be supplied; the consuming
	 *                    runtime must not silently substitute another profile.
	 * @sideEffects None. Must not read or write persistent agent/profile settings.
	 */
	public function getSettings(): array;
}
