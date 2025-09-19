<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Casts\Attribute;

class Contact extends Model
{
    use HasFactory, SoftDeletes;

    protected $table = 'contacts';

    protected $fillable = [
        'name',
        'email',
        'is_company',
        'type_id',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array
     */
    protected $casts = [
        'emails' => 'array',
        'phones' => 'array',
        'identification_documents' => 'array',
        'addresses' => 'array',
        'urls' => 'array',
        'birth_date' => 'date',
        'migration_metadata' => 'array',
    ];

    /**
     * The accessors to append to the model's array form.
     *
     * @var array
     */
    protected $appends = [
        'first_email_account',
        'first_phone_number',
    ];

    /**
     * Get the First Phone Number.
     */
    protected function firstEmailAccount(): Attribute
    {
        return Attribute::make(
            get: fn() => isset($this->emails[0]['value']) ? $this->emails[0]['value'] : null,
        );
    }

    /**
     * Get the First Phone Number.
     */
    protected function firstPhoneNumber(): Attribute
    {
        return Attribute::make(
            get: fn() => isset($this->phones[0]['phone']) ? $this->phones[0]['phone'] : null,
        );
    }

    public function realEstate(): BelongsTo
    {
        // return $this->hasOne(RealEstate::class, 'id', 'tenant_id');
        return $this->belongsTo(RealEstate::class, 'tenant_id', 'id');
    }

    /**
     * Get Contact's content from ContactType Model
     */
    public function utmSource(): BelongsTo
    {
        // return $this->hasOne(ContactUtmSource::class, 'id', 'utm_source_id');
        return $this->belongsTo(ContactUtmSource::class, 'utm_source_id', 'id');
    }

    public function categories(): BelongsToMany
    {
        return $this->belongsToMany(ContactCategory::class, 'contact_has_contact_category', 'contact_id', 'category_id');
    }

}
