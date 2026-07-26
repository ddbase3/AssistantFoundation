<?php declare(strict_types=1);

/***********************************************************************
 * This file is part of AssistantFoundation for BASE3 Framework.
 *
 * AssistantFoundation provides shared contracts, DTOs, models and
 * exceptions for assistant and agent integrations.
 *
 * Developed by Daniel Dahme
 * Licensed under GPL-3.0
 * https://www.gnu.org/licenses/gpl-3.0.en.html
 *
 * https://base3.de/v/assistantfoundation
 * https://github.com/ddbase3/AssistantFoundation
 **********************************************************************/

namespace AssistantFoundation\Api;

use AssistantFoundation\Dto\RealtimeSpeechToTextSession;
use AssistantFoundation\Dto\RealtimeSpeechToTextSessionRequest;

/**
 * Creates short-lived browser sessions for realtime speech transcription.
 *
 * The implementation keeps long-lived provider credentials server-side and
 * returns only the transport data required by the browser client.
 */
interface IRealtimeSpeechToTextSessionService {

	public function createSession(RealtimeSpeechToTextSessionRequest $request): RealtimeSpeechToTextSession;
}
