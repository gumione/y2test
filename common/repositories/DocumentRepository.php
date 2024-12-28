<?php

namespace common\repositories;

use common\models\Document;
use common\repositories\interfaces\DocumentRepositoryInterface;

class DocumentRepository implements DocumentRepositoryInterface
{
    public function findById(int $id): ?Document
    {
        return Document::findOne($id);
    }

    public function findAllByUserId(int $userId): array
    {
        return Document::findAll(['user_id' => $userId]);
    }

    public function findAllByDocumentTypeId(int $documentTypeId): array
    {
        return Document::findAll(['document_type_id' => $documentTypeId]);
    }

    public function save(Document $document): bool
    {
        return $document->save();
    }
}
