<?php declare(strict_types=1);

namespace AssistantFoundation\Test\Dto;

use AssistantFoundation\Dto\AgentModuleManifest;
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
