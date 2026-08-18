# AI Model and Provider Contracts

## Purpose

This document explains provider-neutral AI service contracts in AssistantFoundation.

## Chat models

`IAiChatModel` supports normalized completion, convenience chat, raw provider access, streaming result production, streaming callbacks, and mutable runtime options.

The normalized operation returns `AiChatResult` containing:

* assistant content;
* typed tool calls;
* `AiResultMetadata`;
* optional raw provider data.

A consumer that only needs normalized behavior should avoid depending on `raw()`.

## Embedding models

`IAiEmbeddingModel` accepts a list of texts and returns `AiEmbeddingResult` or convenience raw embedding arrays.

The interface intentionally does not prescribe one vector dimension. Collection definitions and configured services own compatibility between model dimensions and index schemas.

## Image generation

`IImageGenerationModel` exposes typed `generateResult()` plus a convenience `generate()` array form. Runtime options are configured through the same adapter pattern used by other AI services.

## Provider transport

`IAiProvider` is a lower-level provider-neutral request/stream boundary. It accepts a path, payload, and options. It is useful when multiple higher-level model adapters share one provider transport.

## Result metadata

`AiResultMetadata` carries normalized operation metadata including provider, model, request id, timestamps/duration, finish reason, usage, and extensible extra data.

`AiUsage` represents token/operation usage independently of provider response shape.

## Model configuration

`IAiModelConfigurationProvider` resolves configured model metadata by id into `AiModelConfiguration`. The DTO carries the resolved driver, model, endpoint, API key, and options required by a runtime that needs a normalized configuration view.

The provider does not define where records are stored. MissionBay currently derives them from configured service and connection records.

## Service testing

`IAiServiceTester` is a discoverable test contract identified by service type. Administration can use it to verify a configured service without embedding provider-specific test logic in a generic display.

## Security boundary

Long-lived credentials belong in connection/credential storage and should be resolved at runtime. Typed result DTOs and diagnostic output should not expose secrets.
