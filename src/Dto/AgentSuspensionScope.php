<?php declare(strict_types=1);

/***********************************************************************
 * This file is part of AssistantFoundation for BASE3 Framework.
 *
 * AssistantFoundation extends the BASE3 framework with a unified API
 * foundation for assistants, chatbots, and agent-based systems.
 * It provides shared interfaces for modular AI integration.
 *
 * Developed by Daniel Dahme
 * Licensed under GPL-3.0
 * https://www.gnu.org/licenses/gpl-3.0.en.html
 *
 * https://base3.de/v/assistantfoundation
 * https://github.com/ddbase3/AssistantFoundation
 **********************************************************************/

namespace Base3\AssistantFoundation\Dto;

/** Canonical technical scope identifiers for resumable agent suspensions. */
final class AgentSuspensionScope {

	/**
	 * @param string $subjectKey Optional server-verified actor identity for scoped approval isolation.
	 * A missing subject retains the established conversation scope for existing callers.
	 */
	public static function forConversation(string $channelId, string $conversationId, string $subjectKey = ''): string {
		$channelId = trim($channelId);
		$conversationId = trim($conversationId);
		$subjectKey = trim($subjectKey);
		if ($channelId === '' || $conversationId === '') {
			return '';
		}

		$source = $channelId . "\0" . $conversationId;
		if ($subjectKey !== '') {
			$source .= "\0" . $subjectKey;
		}

		return 'conversation:' . hash('sha256', $source);
	}
}
