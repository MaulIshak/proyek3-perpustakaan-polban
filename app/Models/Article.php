<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Str;

class Article extends Model
{
    use HasFactory, SoftDeletes;

    /**
     * Nama tabel.
     *
     * @var string
     */
    protected $table = 'articles';

    /**
     * Primary key tabel.
     *
     * @var string
     */
    protected $primaryKey = 'article_id';

    /**
     * Primary key bukan auto-increment.
     *
     * @var bool
     */
    public $incrementing = false;

    /**
     * Primary key bertipe UUID.
     *
     * @var string
     */
    protected $keyType = 'string';

    /**
     * Kolom yang dapat diisi mass-assignment.
     *
     * @var array
     */
    protected $fillable = [
        'url_thumbnail',
        'url_attachment',
        'judul',
        'content',
        'type',
        'status',
    ];

    /**
     * Kolom timestamp kustom.
     *
     * @var string|null
     */
    const CREATED_AT = 'created_date';
    const UPDATED_AT = 'updated_date';
    const DELETED_AT = 'deleted_date';

    /**
     * Generate UUID saat membuat model baru.
     */
    protected static function boot()
    {
        parent::boot();

        static::creating(function ($model) {
            if (empty($model->{$model->getKeyName()})) {
                $model->{$model->getKeyName()} = (string) Str::uuid();
            }
        });
    }

    /**
     * Casting otomatis untuk kolom tertentu.
     *
     * @var array
     */
    protected $casts = [
        'created_date' => 'datetime',
        'updated_date' => 'datetime',
        'deleted_date' => 'datetime',
    ];
}
