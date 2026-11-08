<?php declare(strict_types=1);

/***********************************************************************
 * This file is part of AssistantFoundation for BASE3 Framework.
 *
 * AssistantFoundation provides shared contracts for modular agents.
 * Licensed under GPL-3.0
 **********************************************************************/

namespace AssistantFoundation\Api;

use Base3\Api\IBase;

/**
 * Declares a code-owned agent whose existence and identity are independent
 * of the SettingsStore. Any number of plugins can provide definitions.
 *
 * Implementations are discovered through IClassMap. Configuration remains
 * editable and persisted by IAgentConfigurationService, not by this class.
 */
interface IAgentDefinition extends IBase {

	/**
	 * Returns the immutable agent identifier in the shared "agent" group.
	 *
	 * @return string Non-empty lower-case technical identifier containing only
	 *                letters, digits, dots, underscores or hyphens; unique across
	 *                all discovered agent definitions and stored configurations.
	 *                The identifier must remain stable across plugin releases.
	 * @throws \Throwable Implementations must not depend on request state.
	 * @sideEffects None. The method must be deterministic.
	 */
	public function getId(): string;

	/**
	 * Returns the immutable human-readable identity label.
	 *
	 * The label is enforced independently of editable stored settings. Plugins
	 * own localization of user-visible labels when they are translatable.
	 *
	 * @return string Non-empty stable label; not editable in agent administration.
	 * @sideEffects None.
	 */
	public function getLabel(): string;

	/**
	 * Supplies initial, editable settings when no stored record exists.
	 *
	 * Settings use the same flat shape as ordinary agent records, including
	 * agent_runtime, model, tool and memory configuration. The returned values
	 * are not automatically written to storage. Existing stored values always
	 * take precedence, except that the identity label remains code-owned.
	 * In particular, a definition with no configured model should remain
	 * disabled until the user deliberately enables it.
	 *
	 * @return array<string,mixed> Editable defaults. Must not contain secrets
	 *                              or a second persistence/authorization model.
	 * @sideEffects None. Must not read or write the SettingsStore.
	 */
	public function getDefaultSettings(): array;
}
