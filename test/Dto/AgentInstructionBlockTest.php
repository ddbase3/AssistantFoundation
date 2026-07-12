<?php declare(strict_types=1);

namespace AssistantFoundation\Test\Dto;

use AssistantFoundation\Dto\AgentInstructionBlock;
use PHPUnit\Framework\TestCase;

final class AgentInstructionBlockTest extends TestCase {

	public function testBlockExposesTypedDataAndSystemMessage(): void {
		$block = new AgentInstructionBlock(
			id: 'user-preferences',
			content: 'Prefer compact answers.',
			priority: 20,
			source: 'prefs-primary',
			metadata: ['implementation' => 'userprefsagentresource']
		);

		$this->assertSame('user-preferences', $block->getId());
		$this->assertSame('Prefer compact answers.', $block->getContent());
		$this->assertSame(20, $block->getPriority());
		$this->assertSame('prefs-primary', $block->getSource());
		$this->assertSame(['implementation' => 'userprefsagentresource'], $block->getMetadata());
		$this->assertSame([
			'id' => 'user-preferences',
			'priority' => 20,
			'source' => 'prefs-primary',
			'metadata' => ['implementation' => 'userprefsagentresource'],
			'content_length' => 23
		], $block->toDiagnosticArray());
		$this->assertSame([
			'role' => 'system',
			'content' => 'Prefer compact answers.'
		], $block->toMessage());
	}

	public function testEmptyContentIsRejected(): void {
		$this->expectException(\InvalidArgumentException::class);
		$this->expectExceptionMessage('content must not be empty');

		new AgentInstructionBlock('empty', '   ');
	}
}
