<?php

namespace common\services;

use common\models\Document;
use common\repositories\interfaces\DocumentRepositoryInterface;
use common\repositories\interfaces\DocumentTypeRepositoryInterface;
use common\services\interfaces\DocumentServiceInterface;
use common\dto\UploadDocumentDto;
use yii\web\UploadedFile;

class DocumentService implements DocumentServiceInterface
{
    public function __construct(
        private readonly DocumentRepositoryInterface $documentRepository,
        private readonly DocumentTypeRepositoryInterface $typeRepository
    ) {}

    public function uploadDocuments(UploadDocumentDto $dto): bool
    {
        if (!$dto->validate()) {
            throw new \DomainException('Invalid data: ' . json_encode($dto->getErrors()));
        }

        foreach ($dto->files as $file) {
            if (!$file instanceof UploadedFile) {
                throw new \DomainException("Invalid file format.");
            }

            $filename = uniqid() . '.' . $file->extension;
            $savePath = \Yii::getAlias('@files/documents') . '/' . $filename;

            if (!is_dir(\Yii::getAlias('@files/documents'))) {
                mkdir(\Yii::getAlias('@files/documents'), 0777, true);
            }

            if (!$file->saveAs($savePath)) {
                throw new \RuntimeException("Failed to save the file.");
            }

            $doc = new Document();
            $doc->user_id = $dto->user_id;
            $doc->document_type_id = $dto->document_type_id;
            $doc->file_path = 'documents/' . $filename;

            if (!$this->documentRepository->save($doc)) {
                throw new \RuntimeException("Failed to save document record.");
            }
        }

        return true;
    }
    
    public function getFilePath(int $documentId, int $userId): string
    {
        $document = $this->documentRepository->findById($documentId);

        if (!$document) {
            throw new \DomainException('Document not found.');
        }

        if ($document->user_id !== $userId) {
            throw new \DomainException('Access denied.');
        }

        return \Yii::getAlias('@files') . '/' . $document->file_path;
    }
}
