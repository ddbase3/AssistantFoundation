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

/**
 * Single owner for configured agent records and code-owned agent definitions.
 *
 * The "agent" group combines SettingsStore records with IAgentDefinition
 * implementations discovered through IClassMap. Other settings groups retain
 * their existing SettingsStore semantics for explicitly configured catalogs.
 */
interface IAgentConfigurationService {

	/**
	 * Lists all agents from the requested SettingsStore group.
	 *
	 * @param string $settingsGroup Existing SettingsStore group. Only "agent"
	 *                              includes fixed class-defined agents.
	 * @return array<string,mixed> Records keyed by agent id. Malformed stored
	 *                             records remain visible to existing diagnostics.
	 *                             Fixed agents are included even without storage.
	 * @throws \Throwable On storage or invalid/duplicate fixed definitions.
	 * @sideEffects Reads storage and discovers definitions; does not persist.
	 */
	public function getAgents(string $settingsGroup = 'agent'): array;

	/**
	 * Resolves the effective record for one agent.
	 *
	 * @param string $id Exact technical agent id.
	 * @param string $settingsGroup Existing SettingsStore group. Only "agent"
	 *                              includes fixed definitions.
	 * @return array<string,mixed>|null Stored or effective fixed configuration,
	 *                                  or null if no such agent exists. The fixed
	 *                                  identity label cannot be overridden.
	 * @throws \Throwable On storage or invalid/duplicate fixed definitions.
	 * @sideEffects Reads storage; does not persist.
	 */
	public function getAgent(string $id, string $settingsGroup = 'agent'): ?array;

	/**
	 * Checks whether an agent is stored or declared by a fixed definition.
	 *
	 * @param string $id Exact technical agent id.
	 * @param string $settingsGroup Existing SettingsStore group.
	 * @return bool True for stored records or fixed definitions in "agent".
	 * @throws \Throwable On storage or invalid/duplicate fixed definitions.
	 * @sideEffects None beyond reads.
	 */
	public function hasAgent(string $id, string $settingsGroup = 'agent'): bool;

	/**
	 * Checks whether the id is owned by a discovered IAgentDefinition.
	 *
	 * @param string $id Exact technical agent id in the "agent" group.
	 * @return bool Whether the identity and existence are code-owned.
	 * @throws \Throwable On invalid or conflicting discovered definitions.
	 * @sideEffects No persistence.
	 */
	public function isFixed(string $id): bool;

	/**
	 * Saves the editable configuration of an agent in the "agent" group.
	 *
	 * @param string $id Exact technical agent id.
	 * @param array<string,mixed> $settings Complete editable configuration.
	 * @return void
	 * @throws \InvalidArgumentException When a fixed agent label is changed or
	 *                                   an id is invalid.
	 * @throws \Throwable On persistence or invalid/duplicate definitions.
	 * @sideEffects Replaces the existing SettingsStore record and saves it.
	 *              A fixed definition is never modified or duplicated.
	 */
	public function saveAgent(string $id, array $settings): void;

	/**
	 * Deletes an ordinary configured agent from the "agent" group.
	 *
	 * @param string $id Exact technical agent id.
	 * @return void
	 * @throws \LogicException For a fixed agent, even when no stored record exists.
	 * @throws \Throwable On persistence or invalid/duplicate definitions.
	 * @sideEffects Removes and saves the ordinary stored record only.
	 */
	public function deleteAgent(string $id): void;

	/**
	 * Reloads the underlying SettingsStore.
	 *
	 * @return void
	 * @throws \Throwable When the storage reload fails.
	 * @sideEffects Reloads persisted configuration but does not change any
	 *              discovered code-owned agent definitions.
	 */
	public function reload(): void;
}
