<?php

namespace common\dto;

use yii\base\Model;
use yii\web\UploadedFile;

class UploadDocumentDto extends Model
{
    /** @var UploadedFile[] */
    public array $files = [];

    public ?int $document_type_id = null;

    public ?int $user_id = null;

    public function __construct(array $files, ?int $documentTypeId, ?int $userId, $config = [])
    {
        $this->files = $files;
        $this->document_type_id = $documentTypeId;
        $this->user_id = $userId;
        parent::__construct($config);
    }

    public function rules()
    {
        return [
            ['files', 'each', 'rule' => ['file', 'extensions' => 'png, jpg, jpeg, pdf', 'maxSize' => 5 * 1024 * 1024]],
            ['document_type_id', 'required'],
            ['document_type_id', 'integer'],
            ['user_id', 'required'],
            ['user_id', 'integer'],
        ];
    }
}
