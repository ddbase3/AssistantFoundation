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

namespace Base3\AssistantFoundation\Test\Api;

use Base3\AssistantFoundation\Api\IConfigurableVectorSearch;
use Base3\AssistantFoundation\Api\IVectorSearch;
use PHPUnit\Framework\TestCase;

final class IConfigurableVectorSearchTest extends TestCase {

	public function testConfiguredSearchExtendsVectorSearchContract(): void {
		$this->assertTrue(is_subclass_of(IConfigurableVectorSearch::class, IVectorSearch::class));
	}

	public function testConfiguredSearchExposesRuntimeOptions(): void {
		$this->assertTrue(method_exists(IConfigurableVectorSearch::class, 'setOptions'));
		$this->assertTrue(method_exists(IConfigurableVectorSearch::class, 'getOptions'));
	}
}
