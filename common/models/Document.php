<?php

namespace common\models;

use yii\db\ActiveRecord;

/**
 * @OA\Schema(
 *     schema="Document",
 *     title="Document Model",
 *     description="User uploaded document",
 *     @OA\Property(property="id", type="integer", description="Unique document ID"),
 *     @OA\Property(property="user_id", type="integer", description="User ID associated with the document"),
 *     @OA\Property(property="document_type_id", type="integer", description="Document type ID"),
 *     @OA\Property(property="file_path", type="string", description="Path to the uploaded file"),
 *     @OA\Property(property="created_at", type="string", format="date-time", description="Record creation timestamp"),
 *     @OA\Property(property="updated_at", type="string", format="date-time", description="Record last update timestamp")
 * )
 */
class Document extends ActiveRecord
{
    public static function tableName()
    {
        return '{{%document}}';
    }

    public function rules()
    {
        return [
            [['user_id', 'document_type_id', 'file_path'], 'required'],
            [['user_id', 'document_type_id'], 'integer'],
            ['file_path', 'string', 'max' => 255],
        ];
    }

    public function getUser()
    {
        return $this->hasOne(User::class, ['id' => 'user_id']);
}

    public function getDocumentType()
    {
        return $this->hasOne(DocumentType::class, ['id' => 'document_type_id']);
    }
}
