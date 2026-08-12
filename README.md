# AssistantFoundation Plugin

AssistantFoundation is the shared contract and DTO plugin for AI, chat, embedding, vector-search, and agent integrations in BASE3.

## Boundary

An interface belongs in AssistantFoundation only when another plugin is expected to provide, replace, or consume the contract without depending on MissionBay internals.

Typical reasons are:

- discoverable plugin extension points such as agent stages, action policies, modules, capability providers, context contributors, and conversation-memory backends;
- replaceable runtime services such as capability selection, suspension storage, tool-result caching, task execution, and full agent execution;
- provider-neutral adapter contracts for chat models, embedding models, AI providers, results, service tests, and vector search;
- shared runtime contracts and DTOs exchanged by several plugins.

MissionBay-only factories, profile resolvers, node/resource contracts, orchestration helpers, and internal state extensions belong in `MissionBay/Api`.

## Contents

```text
AssistantFoundation/
  src/Api/        shared plugin-to-plugin interfaces
  src/Dto/        provider-neutral immutable data values
  src/Exception/  shared exceptions for the public contracts
```

AssistantFoundation intentionally contains no displays, routers, registries, storage implementations, event-sink implementations, final project composition, or concrete provider choice. Shared concrete runtime composition belongs in `AssistantRuntime`.

## Current extension surfaces

### Agent runtime

- `IAgentActionPolicy`
- `IAgentCapabilityProvider`
- `IAgentCapabilitySelector`
- `IAgentContext`
- `IAgentContextContributor`
- `IAgentConversationMemory`
- `IAgentConversationService` / `IAgentConversationRuntimeService`
- `IAgentConfigFormService`
- `IAgentRuntimeConfigFormService`
- `IAgentRuntimeRegistry`
- `IAgentRuntimeSelector`
- `IAgentRuntimeService`
- `IAgentEventSink`
- `IAgentExecutionService`
- `IAgentTextTaskService` / `IAgentTextTaskRuntimeService`
- `IAgentMemory`
- `IAgentModule`
- `IAgentStage`
- `IAgentSuspensionRepository`
- `IAgentToolResultCache`
- `IAssistantResponseExtension`
- `IAssistantResponseExtensionExamples`

### AI and search adapters

- `IAiChatModel`
- `IAiEmbeddingModel`
- `IImageGenerationModel`
- `IAiProvider`
- `IServiceDriverDefinition`
- `IConnectionDriverDefinition`
- `IAiResult`
- `IAiServiceTester`
- `IVectorSearch`
- `IConfigurableVectorSearch`
- `IRetrievalIndex`
- `IRetrievalCollectionDefinition`
- `IRetrievalFilterProvider`
- `IRetrievalIndexInspector`
- `IPhoneticEncoder`

Provider and driver extension contracts are documented in:

```text
AssistantFoundation/docs/SERVICE_AND_CONNECTION_DRIVERS.md
```

The wider runtime extension audit remains documented in:

```text
MissionBay/docs/ASSISTANTFOUNDATION_EXTENSION_POINTS.md
```

### Multi-representation retrieval and indexing

The retrieval contracts separate generic search infrastructure from domain-owned collection semantics:

- `IRetrievalIndex` is the storage and retrieval boundary for dense, sparse, phrase and context operations.
- `IRetrievalCollectionDefinition` owns logical-to-physical collection mapping, index schema, payload schema, agent filter allowlists and agent-facing payload projection.
- `IRetrievalFilterProvider` contributes mandatory server-side filters such as ACL constraints.
- `IRetrievalIndexInspector` exposes read-only diagnostic point inspection without leaking backend APIs into admin displays.
- `IPhoneticEncoder` is the discoverable algorithm slot for language/domain-specific phonetic encoders.

Implementations belong in MissionBay or another implementation plugin. Domain-specific collection definitions belong in the consuming domain plugin.

Adding another interface to `AssistantFoundation/src/Api` requires updating the relevant contract documentation in the same change.

## Conversation memory and context

Conversation history, isolated text tasks, and run-local system context are separate contracts:

- `IAgentConversationMemory` loads and writes visible user/assistant messages.
- `IAgentConversationService` routes explicit list/create/activate/rename/delete operations to the configured runtime.
- `IAgentTextTaskService` performs isolated model calls without conversation-memory writes or tool execution.
- `IAgentContextContributor` contributes typed `AgentInstructionBlock` values for a new turn and receives no conversation writes.
- `IAgentMemory` remains the stable compatibility/base contract; new conversation stores should implement `IAgentConversationMemory`.

The Knowledge / Skills component is an explicit tool and is not a conversation-memory or context-contributor contract.

## Typed state and result

AssistantFoundation provides provider-neutral `AgentState` and `AgentResult` DTOs. MissionBay-specific lifecycle access remains under `MissionBay\Api\IAgentStateContext` because it is not a plugin-to-plugin extension slot.

## License

GPL-3.0

## Runtime composition

The runtime contracts live here, but their concrete composition does not. The
separate `AssistantRuntime` plugin provides runtime discovery, routing, shared
configuration forms, event-sink helpers and diagnostics. Runtime plugins such
as MissionBay and NeuronAi implement the contracts defined by this plugin.

## Speech services

AssistantFoundation defines provider-neutral speech slots for plugins that need
transcription or synthesis without importing a concrete provider implementation:

- `ISpeechToTextService` for complete audio transcription requests;
- `IRealtimeSpeechToTextSessionService` for short-lived browser session creation;
- `ITextToSpeechService` for audio synthesis requests.

The realtime session contract deliberately returns transport metadata and an
ephemeral client credential. Long-lived provider credentials remain in the
implementation plugin and are never part of the Chatbot browser configuration.
