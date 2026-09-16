# Privacy and Data Processing in AssistantFoundation

> This document describes the technical privacy-relevant properties of the AssistantFoundation component. It is not a legal privacy notice for a specific application or installation. Concrete processing purposes, legal bases, recipients, retention periods, and data-subject procedures depend on the components that implement and consume these contracts.

## 1. Scope

AssistantFoundation is a shared contract package. It defines interfaces, DTOs, events, and exceptions for assistant execution, agent runtimes, conversations, tools, AI models and providers, retrieval, parsing, speech, configured service drivers, and assistant response extensions.

The component is intentionally implementation-light. Its role is to define stable data and service boundaries between plugins.

## 2. Processing behavior of the component itself

`AssistantFoundationPlugin` only registers the plugin object as a replaceable shared service.

The component does not itself:

- open network connections to AI or speech providers,
- select a final provider,
- store conversations,
- store prompts or responses,
- store credentials,
- create retrieval indexes,
- parse files,
- persist audio,
- write logs,
- create database tables,
- create files containing user data,
- provide a concrete suspension repository or tool-result cache.

Actual persistence, transfer, logging, and provider communication are responsibilities of implementations supplied by other components.

## 3. Data categories supported by the contracts

Although AssistantFoundation does not persist these values itself, its public contracts are designed to carry structured application data. Depending on the calling application, that data can include personal, confidential, or otherwise sensitive information.

### 3.1 Agent execution data

`AgentExecutionRequest` can carry:

- agent configuration,
- execution inputs,
- runtime context.

These arrays are intentionally generic. A caller may place user text, identifiers, application context, selected profiles, or other runtime values into them.

Agent execution results and state DTOs can likewise carry generated results, state sections, warnings, traces, tool results, and metadata.

### 3.2 Conversation data

Conversation DTOs can contain:

- conversation identifiers,
- titles,
- title source,
- opening messages,
- message arrays,
- creation and update timestamps,
- last-active timestamps,
- node or channel identifiers,
- warnings.

The Foundation does not define where these values are stored. That belongs to the concrete conversation runtime.

### 3.3 Tool and action data

Tool and action DTOs can carry:

- tool names and call identifiers,
- tool arguments,
- tool results,
- action descriptions,
- summaries and risk information,
- action fingerprints,
- mutation snapshots,
- interaction messages,
- explicit approve, deny, or submit decisions,
- optional interaction input, notes, and metadata.

Tool arguments, summaries, and results may contain business or personal data because their structure is owned by the concrete tool implementation.

### 3.4 Suspension data

`AgentSuspension` can serialize:

- suspension identifiers and scope identifiers,
- interaction requests,
- server-owned execution state,
- creation information,
- metadata.

The Foundation only defines the value object and repository contract. A concrete `IAgentSuspensionRepository` implementation determines persistence, TTL handling, replay protection, and deletion behavior.

### 3.5 AI chat and model data

`IAiChatModel` accepts message arrays and optional tool definitions. Model contracts can return generated content, tool calls, usage information, normalized provider metadata, and optionally raw provider results.

Messages and generated content may contain personal or confidential information depending on the application.

### 3.6 Embedding data

`IAiEmbeddingModel` accepts one or more text inputs and returns vectors plus normalized metadata and usage information.

Embedding vectors are derived from source text and may therefore require the same access and lifecycle considerations as the source content in the concrete application.

### 3.7 Image generation data

`IImageGenerationModel` accepts prompts and options and returns generated image information plus provider metadata and usage data.

Prompts can contain personal or confidential information if the caller provides such content.

### 3.8 Retrieval data

Retrieval requests can contain:

- collection keys,
- query text,
- dense vectors,
- filter specifications,
- phrases,
- phonetic phrases,
- required and excluded terms,
- result limits and thresholds.

Retrieval hits can contain identifiers, scores, and arbitrary payload arrays. Those payloads may contain source text, metadata, access-control fields, or personal data depending on the implementation.

### 3.9 Parser data

`ParserFileRequest` contains a local path, a filename, and optional metadata. Parser results can contain normalized text and structured document blocks.

File paths and filenames can themselves reveal user, tenant, project, or document information. Concrete parser implementations must decide whether files remain local or are sent to remote parsing services.

### 3.10 Speech data

`SpeechToTextRequest` can contain raw audio, MIME type, language, service identifier, and options. Speech-to-text results can contain transcribed text, language, metadata, and an optional raw result.

`TextToSpeechRequest` can contain arbitrary text, language, service identifier, and options. The corresponding result can contain generated audio information and metadata.

Raw audio and transcribed speech can contain biometric-adjacent voice characteristics, personal statements, names, contact details, or other sensitive content. The actual classification depends on the use case and applicable law.

### 3.11 Provider and service configuration

Provider and model contracts expose generic option arrays. Depending on the implementation, options may include:

- endpoints,
- model names,
- API keys or tokens,
- timeout settings,
- provider-specific parameters.

AssistantFoundation does not store or protect these values itself. Secret storage and redaction must be implemented at the configuration and provider boundary.

## 4. External transfers

AssistantFoundation does not initiate external transfers by itself.

Its contracts are intentionally suitable for implementations that may communicate with remote AI providers, embedding services, image-generation services, retrieval backends, parsers, or speech services. Once a concrete implementation sends contract data to an external system, that implementation and the application composition determine:

- which fields are transferred,
- the destination and operator,
- processing region,
- retention and logging by the remote service,
- training or product-improvement use,
- subprocessors,
- possible international transfers.

Those facts must be documented by the component that performs the transfer or by the concrete installation.

## 5. Raw provider data

Some contracts deliberately allow access to raw provider responses for advanced integrations and diagnostics.

Raw responses can contain more metadata than normalized DTOs and may include content, provider identifiers, request identifiers, tool-call data, timing information, safety metadata, or other provider-specific fields.

Consumers should prefer normalized DTOs and should persist raw results only when there is a documented need, appropriate access control, and a defined retention period.

## 6. Provider completion event minimization

`AiProviderRequestCompletedEvent` is designed as a minimized shared event.

It contains normalized result metadata, usage information, a source name, and the occurrence timestamp. The event contract deliberately excludes:

- provider request payloads,
- generated response content,
- credentials,
- raw provider responses.

A concrete provider implementation can still perform its own logging or diagnostics, which must be reviewed separately.

## 7. Retrieval access control

AssistantFoundation defines generic retrieval and filter contracts, but it does not know the authorization rules of a domain or data source.

The responsible retrieval implementation must enforce access rules before protected payloads are returned or forwarded to another service. A caller should not treat generic retrieval contracts as an authorization mechanism by themselves.

## 8. Data minimization

Implementations and consumers should minimize the data placed into generic arrays and DTOs, especially:

- agent context,
- provider options,
- tool arguments and metadata,
- retrieval payloads,
- parser metadata,
- raw provider results,
- speech options,
- response-extension metadata.

Only values required for the active operation should cross plugin boundaries.

## 9. Logging and diagnostics

AssistantFoundation does not implement logging of prompts, responses, audio, retrieval results, or tool arguments.

Consumers and implementation plugins should avoid logging complete payloads by default. Where diagnostics require content logging, the installation should define:

- the specific fields logged,
- the operational purpose,
- access rights,
- redaction of credentials and identifiers,
- retention and deletion periods.

## 10. Persistence and retention

AssistantFoundation defines persistence-related contracts such as suspension repositories and tool-result caches, but it does not provide their storage backend.

Retention therefore cannot be defined at the Foundation layer. Concrete implementations should document retention for at least:

- conversations,
- agent memory,
- suspensions and replay markers,
- tool-result caches,
- retrieval indexes,
- parser outputs,
- provider request logs,
- speech data,
- generated images or audio.

## 11. Security-sensitive values

The generic option and metadata arrays supported by the contracts can accidentally be used to carry secrets. Implementations should keep API keys, bearer tokens, passwords, session identifiers, and other credentials out of DTOs that are returned to clients or exposed through diagnostics unless the contract explicitly requires them.

Provider request completion events are already designed not to expose credentials or raw provider payloads.

## 12. Production review checklist

For every installation using AssistantFoundation contracts, review the concrete implementing components and document at least:

- active agent runtime implementations,
- active AI, embedding, image, parser, retrieval, and speech providers,
- which contracts carry user or business content,
- conversation and memory storage,
- suspension and cache persistence,
- external endpoints and transferred fields,
- credential storage and redaction,
- retrieval authorization rules,
- logging and diagnostics,
- retention and deletion behavior,
- handling of raw provider results,
- handling of audio, files, generated media, and embeddings.

## 13. Component boundary

This document describes AssistantFoundation only. The component supplies stable contracts and shared data structures. Concrete runtimes, providers, storage backends, UIs, and host applications introduce their own processing behavior and should document it separately.
