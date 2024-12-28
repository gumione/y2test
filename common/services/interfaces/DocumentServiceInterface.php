<?php

namespace common\services\interfaces;

use common\dto\UploadDocumentDto;

interface DocumentServiceInterface
{
    public function uploadDocuments(UploadDocumentDto $dto): bool;
    public function getFilePath(int $documentId, int $userId): string;
}
