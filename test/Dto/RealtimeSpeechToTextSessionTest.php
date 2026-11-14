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

use Base3\AssistantFoundation\Dto\RealtimeSpeechToTextSession;
use PHPUnit\Framework\TestCase;

final class RealtimeSpeechToTextSessionTest extends TestCase {

	public function testSessionSerializesBrowserTransportData(): void {
		$session = new RealtimeSpeechToTextSession(
			'mistral',
			'websocket',
			'wss://api.mistral.ai/v1/audio/transcriptions/realtime?model=test',
			'rt_test',
			'2026-07-26T12:00:00Z',
			'test',
			'pcm_s16le',
			16000,
			['silenceDurationMs' => 900]
		);

		$this->assertSame('mistral', $session->getProvider());
		$this->assertSame('websocket', $session->getTransport());
		$this->assertSame(16000, $session->getSampleRate());
		$this->assertSame('rt_test', $session->toArray()['clientToken']);
		$this->assertSame(900, $session->toArray()['options']['silenceDurationMs']);
	}
}
