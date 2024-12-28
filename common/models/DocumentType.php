<?php

namespace common\models;

use yii\db\ActiveRecord;

/**
 * @OA\Schema(
 *     schema="DocumentType",
 *     title="Document Type Model",
 *     description="Document type for categorizing uploaded files",
 *     @OA\Property(property="id", type="integer", description="Unique document type ID"),
 *     @OA\Property(property="name", type="string", description="Name of the document type"),
 *     @OA\Property(property="description", type="string", description="Description of the document type"),
 *     @OA\Property(property="created_at", type="string", format="date-time", description="Record creation timestamp"),
 *     @OA\Property(property="updated_at", type="string", format="date-time", description="Record last update timestamp")
 * )
 */
class DocumentType extends ActiveRecord
{
    public static function tableName()
    {
        return '{{%document_type}}';
    }

    public function rules()
    {
        return [
            [['name'], 'required'],
            ['name', 'unique'],
            ['name', 'string', 'max' => 50],
            ['description', 'string'],
        ];
    }

    public function getDocuments()
    {
        return $this->hasMany(Document::class, ['document_type_id' => 'id']);
    }
}
