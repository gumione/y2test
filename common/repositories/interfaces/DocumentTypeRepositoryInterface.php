<?php

namespace common\repositories\interfaces;

use common\models\DocumentType;

interface DocumentTypeRepositoryInterface
{
    public function findById(int $id): ?DocumentType;
    public function findByName(string $name): ?DocumentType;
    public function getAll(): array;
    public function save(DocumentType $type): bool;
}
