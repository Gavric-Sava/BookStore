<?php

interface SessionRepositoryInterface
{
    public static function initializeData(): void;

    public static function fetchAll(): array;

    public static function dataInitialized(): bool;
}