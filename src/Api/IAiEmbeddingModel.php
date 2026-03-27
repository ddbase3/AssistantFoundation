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

namespace AssistantFoundation\Api;

/**
 * Interface for embedding models (e.g. OpenAI, Ollama, HuggingFace).
 *
 * Accepts text input and returns one or more embeddings (float vectors).
 */
interface IAiEmbeddingModel {

	/**
	 * Encodes one or multiple texts into embedding vectors.
	 *
	 * @param string[] $texts Text inputs (1..n)
	 * @return float[][] List of embedding vectors (one per input text)
	 */
	public function embed(array $texts): array;

	/**
	 * Sets model options like model name, endpoint, etc.
	 *
	 * @param array $options
	 * @return void
	 */
	public function setOptions(array $options): void;

	/**
	 * Optional: get model options (e.g. for debugging or introspection).
	 *
	 * @return array
	 */
	public function getOptions(): array;
}

