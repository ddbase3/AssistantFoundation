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

namespace Base3\AssistantFoundation\Test\Dto;

use Base3\AssistantFoundation\Dto\AgentModuleManifest;
use PHPUnit\Framework\TestCase;

final class AgentModuleManifestTest extends TestCase {

	public function testManifestTrimsIdentifierAndDeduplicatesTags(): void {
		$manifest = new AgentModuleManifest(' mod ', 'Module', ' Description ', ['  search ', 'search', '', 'admin', ' admin '], ['slot' => 'test']);
		$this->assertSame('mod', $manifest->getName());
		$this->assertSame('Module', $manifest->getTitle());
		$this->assertSame(' Description ', $manifest->getDescription());
		$this->assertSame(['search', 'admin'], $manifest->getTags());
		$this->assertSame(['slot' => 'test'], $manifest->getMetadata());
		$this->assertSame('mod', $manifest->toArray()['name']);
	}

	public function testEmptyManifestNameIsRejected(): void {
		$this->expectException(\InvalidArgumentException::class);
		new AgentModuleManifest('   ');
	}
}
