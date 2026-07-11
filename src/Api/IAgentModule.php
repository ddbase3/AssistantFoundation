<?php declare(strict_types=1);

/***********************************************************************
 * This file is part of AssistantFoundation for BASE3 Framework.
 **********************************************************************/

namespace AssistantFoundation\Api;

use AssistantFoundation\Dto\AgentModuleActivation;
use AssistantFoundation\Dto\AgentModuleManifest;
use Base3\Api\IComponent;

/**
 * Defines an activatable run-local bundle of instructions and capabilities.
 */
interface IAgentModule extends IComponent {

	public function manifest(): AgentModuleManifest;

	public function activate(IAgentContext $context): AgentModuleActivation;
}
