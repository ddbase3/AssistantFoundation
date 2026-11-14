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

use Base3\CoreFoundation\Api\IComponent;

/**
 * Groups run-local tools, resource providers, and prompt providers.
 *
 * Implementations may represent local bundles, remote MCP servers, or
 * project-specific capability collections. Returned iterables are validated by
 * the consuming agent runtime against its concrete capability interfaces.
 */
interface IAgentCapabilityProvider extends IComponent {

	public function name(): string;

	public function tools(IAgentContext $context): iterable;

	public function resourceProviders(IAgentContext $context): iterable;

	public function promptProviders(IAgentContext $context): iterable;
}
