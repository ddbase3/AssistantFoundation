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

use Base3\AssistantFoundation\Dto\AgentMutationCommitSnapshot;
use PHPUnit\Framework\TestCase;

final class AgentMutationCommitSnapshotTest extends TestCase {

	public function testSnapshotRoundTripsAuthorizationAndVersions(): void {
		$snapshot = new AgentMutationCommitSnapshot(
			'action-1',
			'fingerprint-1',
			['subject' => 'user-7'],
			['record:42' => 'version-3'],
			'2026-07-11T12:00:00+00:00',
			['source' => 'test']
		);

		$restored = AgentMutationCommitSnapshot::fromArray($snapshot->toArray());

		$this->assertSame('action-1', $restored->getActionId());
		$this->assertSame('user-7', $restored->getAuthorization()['subject']);
		$this->assertSame('version-3', $restored->getResourceVersions()['record:42']);
		$this->assertSame('2026-07-11T12:00:00+00:00', $restored->getCapturedAt());
		$this->assertSame('test', $restored->getMetadata()['source']);
	}

	public function testEmptyFingerprintIsRejected(): void {
		$this->expectException(\InvalidArgumentException::class);

		new AgentMutationCommitSnapshot('action-1', '');
	}
}
