<?php

namespace App\Services;

abstract class AiService
{
    /**
     * Process a text message and generate a response.
     *
     * @param string $message
     * @param array $context Additional context for the AI
     * @return string
     */
    abstract public function processMessage(string $message, array $context = []): string;

    /**
     * Process a voice message and return the transcription.
     *
     * @param string $audioPath Path to the audio file
     * @return string
     */
    abstract public function transcribeVoice(string $audioPath): string;

    /**
     * Generate a text-to-speech response.
     *
     * @param string $text Text to convert to speech
     * @return string Path to the generated audio file
     */
    abstract public function generateSpeech(string $text): string;

    /**
     * Initialize or reset the conversation context.
     *
     * @return void
     */
    abstract public function resetContext(): void;

    /**
     * Get the current conversation context.
     *
     * @return array
     */
    abstract public function getContext(): array;

    /**
     * Set the conversation context.
     *
     * @param array $context
     * @return void
     */
    abstract public function setContext(array $context): void;

    /**
     * Format the final response.
     *
     * @param string $message
     * @param array $additional Additional data to include in response
     * @return array
     */
    protected function formatResponse(string $message, array $additional = []): array
    {
        return array_merge([
            'message' => $message,
            'timestamp' => now()->format('g:i A'),
        ], $additional);
    }
}