<?php declare(strict_types=1);

/***********************************************************************
 * This file is part of AssistantFoundation for BASE3 Framework.
 **********************************************************************/

namespace AssistantFoundation\Api;

use Base3\Api\IComponent;

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
