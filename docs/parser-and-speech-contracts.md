# Parser and Speech Contracts

## Purpose

This document covers configured file parsing and speech services shared across plugins.

## File parsing

`IFileParserService` is a discoverable parser adapter. It exposes:

* runtime options;
* priority;
* `supportsFile()`;
* `parseFile()`.

Input is a `ParserFileRequest`. Output is a `ParserServiceResult` containing a normalized `ParsedDocument` when parsing succeeds.

`ParsedDocument` and `ParsedDocumentBlock` preserve structured document information such as text blocks, headings, page information, and metadata where the concrete parser can provide it.

A domain plugin may add a higher-level parse-flow planner while still delegating file conversion to configured `IFileParserService` implementations.

## Speech to text

`ISpeechToTextService::transcribe()` accepts `SpeechToTextRequest` and returns `SpeechToTextResult`.

`IRealtimeSpeechToTextSessionService` is deliberately separate. It creates short-lived provider session metadata and ephemeral client credentials through `RealtimeSpeechToTextSessionRequest` and `RealtimeSpeechToTextSession`.

Long-lived provider credentials must not be returned to browser clients.

## Text to speech

`ITextToSpeechService` supports two caller-selected modes:

```php
$result = $service->synthesize($request);
```

or streaming:

```php
$result = $service->stream($request, $stream);
```

`ITextToSpeechStream` receives MIME metadata in `start()`, binary chunks in `write()`, and exposes cancellation state.

Streaming is an operation choice, not a separate persistent service type.

## Media boundary

The complete TTS result uses the shared media abstraction rather than introducing a second independent binary-audio model in AssistantFoundation.

## Configuration

Parser and speech interfaces do not prescribe SettingsStore group names. MissionBay currently implements configured service records and driver definitions for these contracts.
