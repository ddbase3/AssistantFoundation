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

use Base3\AssistantFoundation\Dto\AiChatResult;
use Base3\AssistantFoundation\Dto\AiResultMetadata;
use Base3\AssistantFoundation\Dto\AiToolCall;
use Base3\AssistantFoundation\Dto\AiUsage;
use PHPUnit\Framework\TestCase;

final class AiChatResultTest extends TestCase {

	public function testPublicArrayShapeIsProviderNeutral(): void {
		$result = new AiChatResult(
			'Checking',
			[
				new AiToolCall('call-1', 'lookup', ['query' => 'BASE3'], ['index' => 0])
			],
			new AiResultMetadata(
				'chat',
				'provider',
				'model',
				'request-1',
				null,
				null,
				'tool_calls',
				new AiUsage(totalTokens: 12)
			),
			['provider' => 'raw']
		);

		$array = $result->toArray();

		$this->assertSame('lookup', $array['tool_calls'][0]['name']);
		$this->assertSame(['query' => 'BASE3'], $array['tool_calls'][0]['arguments']);
		$this->assertArrayNotHasKey('function', $array['tool_calls'][0]);
		$this->assertSame(12, $array['metadata']['usage']['total_tokens']);
		$this->assertArrayNotHasKey('raw', $array);
		$this->assertArrayHasKey('raw', $result->toArray(true));
	}
}
