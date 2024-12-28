<?php

namespace common\services;

use common\repositories\interfaces\DocumentTypeRepositoryInterface;
use common\services\interfaces\DocumentTypeServiceInterface;

class DocumentTypeService implements DocumentTypeServiceInterface
{
    public function __construct(
        private readonly DocumentTypeRepositoryInterface $documentTypeRepository
    ) {}

    public function getAllDocumentTypes(): array
    {
        return $this->documentTypeRepository->getAll();
    }
}
