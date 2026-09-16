# AssistantFoundation FAQ

## What is AssistantFoundation?

AssistantFoundation is the shared contract package for assistant, agent, AI service, retrieval, parser, speech, and assistant-response integrations in BASE3.

It defines stable interfaces, DTOs, events, and exceptions that can be shared across plugins without tying consumers to one concrete agent runtime, AI provider, vector database, parser, or speech service.

## Is AssistantFoundation an AI runtime?

No. AssistantFoundation does not execute an agent by itself and does not select the active runtime. It defines the contracts that runtime and consumer plugins use to communicate.

Shared runtime composition belongs in a runtime-composition component such as AssistantRuntime. Concrete agent orchestration belongs in the corresponding runtime implementation.

## Does AssistantFoundation call external AI providers?

No. The package contains provider-neutral interfaces such as `IAiProvider`, `IAiChatModel`, `IAiEmbeddingModel`, and `IImageGenerationModel`, but it contains no concrete HTTP transport for a specific provider.

External network communication occurs only when another component provides and uses an implementation of those contracts.

## Does AssistantFoundation store API keys or credentials?

No credential store is implemented by AssistantFoundation. Some provider contracts accept runtime options that may include endpoints, API keys, tokens, timeouts, or other provider-specific settings, but persistence and secret management are responsibilities of the implementation and host composition.

## Which agent execution contracts are provided?

The runtime-neutral execution surface includes:

- `IAgentExecutionService`
- `IAgentRuntimeService`
- `IAgentRuntimeRegistry`
- `IAgentRuntimeSelector`
- `IAgentConversationService`
- `IAgentConversationRuntimeService`
- `IAgentTextTaskService`
- `IAgentTextTaskRuntimeService`
- `IAgentConfigFormService`
- `IAgentRuntimeConfigFormService`
- `IAgentEventSink`

These contracts let consumers execute configured agents without importing one specific runtime implementation.

## What is the difference between normal execution, conversations, and text tasks?

Normal execution uses `IAgentExecutionService` and `AgentExecutionRequest` for a configured agent run.

Conversation contracts provide explicit lifecycle operations such as creating, activating, renaming, deleting, and updating conversations.

Text-task contracts represent isolated model-oriented work that does not need to behave like a normal conversation turn.

## Does AssistantFoundation define one conversation storage model?

No. It defines conversation DTOs and service contracts, including conversation metadata, message collections, and conversation state. The concrete runtime decides how and where conversations are stored.

## What are agent context profiles?

Context-profile contracts allow discoverable providers to contribute ordered instruction blocks or other context to an agent execution.

The Foundation separates context profiles from conversation memory, agent memory, tools, and runtime state so those responsibilities remain explicit.

## What are agent tool profiles?

Tool-profile contracts allow providers to expose named tool selections through `IAgentToolProfileProvider`, `IAgentToolProfileService`, and `IAgentToolSet`.

Tools are described through shared capability DTOs and return normalized `AgentToolResult` values.

## How are confirmable or approval-gated tools represented?

`IAgentConfirmableToolSet` extends the normal tool-set boundary for operations that can pause before a mutation is committed.

The shared DTOs include interaction requests, explicit interaction responses, suspensions, action fingerprints, mutation snapshots, and suspension resolutions. Persistence and one-time resume handling are delegated to an `IAgentSuspensionRepository` implementation.

## Does AssistantFoundation itself approve or execute mutations?

No. The package defines the common contracts and DTOs for action review and explicit approval. The concrete runtime and tool implementation remain responsible for validation, authorization, review, commit guards, and execution.

## What AI model contracts are available?

AssistantFoundation defines provider-neutral contracts for:

- chat models,
- embedding models,
- image generation,
- generic AI providers,
- AI model configuration,
- service testing.

Normalized results can include generated content, embeddings, images, tool calls, provider metadata, finish information, and usage data.

## Can model results contain raw provider responses?

Yes. Some result DTOs and service contracts permit raw provider data for callers that explicitly need it. Consumers should avoid persisting or exposing raw results unless there is a documented purpose because provider payloads may contain request-related content or metadata.

## What does `AiProviderRequestCompletedEvent` contain?

The shared completion event contains normalized result metadata, usage, a source name, and a timestamp.

Its contract deliberately excludes provider request payloads, response content, credentials, and raw provider responses.

## What retrieval contracts are provided?

The retrieval boundary includes:

- `IRetrievalIndex`
- `IRetrievalCollectionDefinition`
- `IRetrievalFilterProvider`
- `IRetrievalIndexInspector`
- `IVectorSearch`
- `IConfigurableVectorSearch`
- `IPhoneticEncoder`

Requests can carry collection identifiers, search text, vectors, filters, phrases, required terms, excluded terms, and search limits. Hits can carry identifiers, scores, and provider-defined payloads.

## Does AssistantFoundation enforce access control for retrieval data?

No generic Foundation contract can determine domain-specific access rights. A retrieval implementation or domain-owned filter provider must enforce the access rules required by the data source and application.

## What parser support is defined?

`IFileParserService` is the shared contract for local or remote parser backends. `ParserFileRequest` carries a path, filename, and optional metadata. Parser results can expose normalized text and structured document data.

AssistantFoundation does not parse or upload files by itself.

## What speech support is defined?

Speech contracts cover complete speech-to-text requests, realtime speech-to-text session creation, text-to-speech generation, and text-to-speech streaming.

A speech-to-text request can contain raw audio bytes, MIME type, language, service identifier, and options. A text-to-speech request can contain text, language, service identifier, and options.

## Does AssistantFoundation store audio or generated speech?

No. The package only defines the request and result types and service contracts. Storage behavior depends on the concrete speech implementation and its caller.

## What are service and connection driver definitions?

`IServiceDriverDefinition` and `IConnectionDriverDefinition` describe discoverable configured-service types. They can expose implementation interfaces, implementation names, schemas, defaults, supported connection types, and health-check metadata.

They describe integration slots and do not select or persist the active configured records themselves.

## What are assistant response extensions?

`IAssistantResponseExtension` allows a configured component to contribute runtime instructions and an optional client-plugin description without hard-coding one UI implementation into the assistant runtime.

An extension can also provide examples through `IAssistantResponseExtensionExamples`.

## How are shared values represented across plugin boundaries?

AssistantFoundation uses typed DTOs for execution requests and results, conversations, agent state, capability catalogs, action review, suspensions, tool results, AI results, parser results, retrieval results, speech data, and response extensions.

Consumers should prefer these DTOs over undocumented arrays when the data crosses plugin boundaries.

## Does AssistantFoundation persist data?

The component itself does not implement a database, file store, Settings Store, State Store, conversation store, retrieval backend, or provider transport. `AssistantFoundationPlugin` only registers the plugin object as a replaceable shared service.

Interfaces such as `IAgentSuspensionRepository`, `IAgentToolResultCache`, or retrieval services intentionally leave persistence to other implementations.

## What privacy-relevant data can pass through AssistantFoundation types?

Depending on how the contracts are used, DTOs and method arguments can carry conversation text, prompts, model inputs and outputs, tool arguments and results, action summaries, retrieval text and payloads, filenames and parser metadata, audio, generated speech text, image prompts, runtime context, usage data, identifiers, and provider metadata.

AssistantFoundation does not decide whether those values are personal data. That depends on the content and the consuming application. Technical privacy notes are available in [PRIVACY.md](../PRIVACY.md).

## Which license applies?

AssistantFoundation is licensed under GPL-3.0. See `LICENSE` for the complete license text.
