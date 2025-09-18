<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Database\Eloquent\SoftDeletes;
use Spatie\Permission\PermissionRegistrar;

class RealEstate extends Model
{
    use HasFactory, SoftDeletes;

    protected $table = 'real_estates';

    protected $fillable = [
        'name',
        'address',
        'connection_id',
        'real_estate_center_id',
    ];

    /**
     * Get RealEstate's content from User Model
     */
    public function users(): BelongsToMany
    {
        return $this->belongsToMany(User::class, 'real_estate_has_user', 'real_estate_id', 'user_id');
    }

    /**
     * Get RealEstate's content from Property Model
     */
    public function properties(): HasMany
    {
        return $this->hasMany(Property::class, 'tenant_id', 'id');
    }

    public function propertyKeys(): HasMany
    {
        return $this->hasMany(Property::class, 'tenant_id', 'id');
    }

    public function propertyPurposes(): HasMany
    {
        return $this->hasMany(PropertyPurpose::class, 'tenant_id', 'id');
    }

    public function occurrences(): HasMany
    {
        return $this->hasMany(Occurrence::class, 'tenant_id', 'id');
    }


    public function contacts(): HasMany
    {
        return $this->hasMany(Contact::class, 'tenant_id', 'id');
    }

    public function blogs(): HasMany
    {
        return $this->hasMany(Blog::class, 'tenant_id', 'id');
    }

    public function blogCategories(): HasMany
    {
        return $this->hasMany(BlogCategory::class, 'tenant_id', 'id');
    }

    public function faqs(): HasMany
    {
        return $this->hasMany(Faq::class, 'tenant_id', 'id');
    }

    public function faqGroups(): HasMany
    {
        return $this->hasMany(FaqGroup::class, 'tenant_id', 'id');
    }

    public function crmLostReasons(): HasMany
    {
        return $this->hasMany(CrmLostReason::class, 'tenant_id', 'id');
    }

    public function crmTags(): HasMany
    {
        return $this->hasMany(CrmTag::class, 'tenant_id', 'id');
    }

    public function site(): HasOne
    {
        return $this->hasOne(Site::class, 'tenant_id', 'id');
    }

    public function siteContact(): HasOne
    {
        return $this->hasOne(SiteContact::class, 'tenant_id', 'id');
    }

    /**
     * A permission can be applied to roles.
     */
    public function roles(): BelongsToMany
    {
        /*ds($this->belongsToMany(
            config('permission.models.role'),
            config('permission.table_names.role_has_permissions'),
            app(PermissionRegistrar::class)->pivotPermission,
            app(PermissionRegistrar::class)->pivotRole
        ));*/

        return $this->belongsToMany(
            \Spatie\Permission\Models\Role::class,
            'role_has_permissions',
            'permission_id',
            'role_id'
        );
    }
}
