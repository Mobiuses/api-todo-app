<?php

declare(strict_types=1);

namespace App\Models;

use App\Modules\Core\ORM\Traits\Searchable;
use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use JetBrains\PhpStorm\ArrayShape;

class Task extends Model
{
    use HasFactory, HasUuids, Searchable;

    const UPDATED_AT = null;
    private const ES_INDEX_NAME = 'tasks';
    public const SORT_AVAILABLE_BY = ['priority', 'created_at', 'completed_at'];


    /**
     * The attributes that are mass assignable.
     *
     * @var array<string>
     */
    protected $fillable = [
        'title',
        'description',
        'priority',
        'parent_id'
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array
     */
    protected $casts = [
        'created_at'   => 'datetime:Y-m-d',
        'completed_at' => 'datetime:Y-m-d',
    ];

    /**
     * @return BelongsTo
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class, 'user_id', 'id');
    }

    /**
     * @return BelongsTo
     */
    public function parent(): BelongsTo
    {
        return $this->belongsTo(self::class);
    }

    /**
     * @return HasMany
     */
    public function subTask(): HasMany
    {
        return $this->hasMany(self::class, 'parent_id');
    }

    /**
     * @return HasMany
     */
    public function subTasks(): HasMany
    {
        return $this->subTask()->with('subTasks');
    }

    /**
     * @return Task
     */
    public function root(): Task
    {
        return $this->parent ? $this->parent->root() : $this;
    }

    /**
     * @return string
     */
    public function getId(): string
    {
        return $this->id;
    }

    /**
     * @return int
     */
    public function getUserId(): int
    {
        return $this->user_id;
    }

    /**
     * @return string
     */
    public function getTitle(): string
    {
        return $this->title;
    }

    /**
     * @return string
     */
    public function getDescription(): string
    {
        return $this->description;
    }

    /**
     * @return int
     */
    public function getPriority(): int
    {
        return (int) $this->priority;
    }

    /**
     * @return string
     */
    public function getStatus(): string
    {
        return $this->status;
    }

    /**
     * @return string
     */
    public function getCreatedAt(): string
    {
        return $this->created_at->toDateTimeString();
    }

    /**
     * @return string|null
     */
    public function getCompletedAt(): ?string
    {
        return $this->completed_at?->toDateTimeString();
    }

    /**
     * @param  string  $parentId
     *
     * @return $this
     */
    public function setParentId(string $parentId): self
    {
        $this->parent_id = $parentId;

        return $this;
    }

    /**
     * @param  string  $title
     *
     * @return $this
     */
    public function setTitle(string $title): self
    {
        $this->title = $title;

        return $this;
    }

    /**
     * @param  string  $description
     *
     * @return $this
     */
    public function setDescription(string $description): self
    {
        $this->description = $description;

        return $this;
    }

    /**
     * @param  int  $priority
     *
     * @return $this
     */
    public function setPriority(int $priority): self
    {
        $this->priority = $priority;

        return $this;
    }

    /**
     * @param  string  $status
     *
     * @return $this
     */
    public function setStatus(string $status): self
    {
        $this->status = $status;

        return $this;
    }

    /**
     * @param  string  $datetime
     *
     * @return $this
     */
    public function setCompletedAt(string $datetime): self
    {
        $this->completed_at = $datetime;

        return $this;
    }

    /**
     * @return array
     */
    #[ArrayShape(['id' => "string", 'title' => "string", 'description' => "string"])]
    public function toSearchIndex(): array
    {
        return [
            'title' => $this->getTitle(),
            'description' => $this->getDescription(),
        ];
    }

    /**
     * @return string
     */
    public static function getSearchIndexStatic(): string
    {
        return self::ES_INDEX_NAME;
    }
}
