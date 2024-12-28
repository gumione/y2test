<?php

namespace common\repositories\interfaces;

use common\models\Document;

interface DocumentRepositoryInterface
{
    public function findById(int $id): ?Document;
    public function findAllByUserId(int $userId): array;
    public function findAllByDocumentTypeId(int $documentTypeId): array;
    public function save(Document $document): bool;
}
