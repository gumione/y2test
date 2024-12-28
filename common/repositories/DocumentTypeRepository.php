<?php

namespace common\repositories;

use common\models\DocumentType;
use common\repositories\interfaces\DocumentTypeRepositoryInterface;

class DocumentTypeRepository implements DocumentTypeRepositoryInterface
{
    public function findById(int $id): ?DocumentType
    {
        return DocumentType::findOne($id);
    }

    public function findByName(string $name): ?DocumentType
    {
        return DocumentType::findOne(['name' => $name]);
    }

    public function getAll(): array
    {
        return DocumentType::find()->all();
    }

    public function save(DocumentType $type): bool
    {
        return $type->save();
    }
}
