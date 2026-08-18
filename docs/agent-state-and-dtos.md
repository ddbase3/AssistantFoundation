# Agent State and DTOs

## Purpose

AssistantFoundation defines typed values for agent execution so runtimes do not need to exchange undocumented nested arrays.

## Execution DTOs

The main request/result values are:

* `AgentExecutionRequest`
* `AgentExecutionResult`
* `AgentExecutionState`
* `AgentExecutionStatus`
* `AgentExecutionEvent`
* `AgentResult`
* `AgentState`

`AgentState` composes stable sections for task, plan, knowledge, memory, context-window, budget, suspension, and result state. Runtime-specific transient values may still live in the runtime context, but cross-plugin consumers should prefer the typed state when it is available.

## Conversation DTOs

Conversation lifecycle is represented by:

* `AgentConversation`
* `AgentConversationScope`
* `AgentConversationRequest`
* `AgentConversationState`

A conversation scope separates a logical channel from a conversation id and gives suspension/memory implementations a stable namespace.

## Capabilities

Capability discovery and per-call selection use:

* `AgentCapability`
* `AgentCapabilityCatalog`
* `AgentCapabilitySelection`
* `AgentCapabilitySelectionConfig`
* `AgentCapabilitySelectionRequest`
* `AgentCapabilitySourceConfig`

The catalog describes the effective run-local functions. Selection records which bounded subset is exposed to one model operation.

## Actions and interaction

Approval and resume use:

* `AgentAction`
* `AgentActionDecision`
* `AgentActionReview`
* `AgentInteractionRequest`
* `AgentInteractionResponse`
* `AgentResume`

Action decisions support explicit allow, deny, approval, dry-run, and clarification outcomes.

## Suspensions

Durable suspension data uses:

* `AgentSuspension`
* `AgentSuspensionClaim`
* `AgentSuspensionScope`
* `AgentSuspensionState`

The repository implementation is outside the Foundation.

## Tool results and contracts

Tool execution uses:

* `AgentToolResult`
* `AgentToolContractValidation`
* `AgentToolCacheConfig`
* `AgentToolCacheRule`
* `AgentToolCacheEntry`
* `AgentToolCacheRecord`

Success/failure state is explicit. Cached output and live output can therefore pass through the same validation boundary.

## Budgets and context windows

Budget and context control uses:

* `AgentBudget`
* `AgentBudgetAssessment`
* `AgentBudgetState`
* `AgentContextAssessment`
* `AgentContextCompaction`
* `AgentContextWindowState`
* `AgentProgressAssessment`
* `AgentContinuationDecision`
* `AgentResultVerification`

These DTOs describe decisions and measurements. They do not implement the policy themselves.

## Serialization rule

Where `toArray()` and `fromArray()` exist, they provide the stable serialization shape for persistence, transport, or diagnostics. Implementations should not add hidden object state that cannot be reconstructed from the documented serialized form when round-trip support is expected.
