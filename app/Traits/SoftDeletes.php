<?php

namespace App\Traits;

use Illuminate\Database\Eloquent\SoftDeletes as EloquentSoftDeletes;

/**
* 这是二项的软删除,即被删或没被删.
* DELETED_SIGN 表示删除的符号 默认为1
* NOT_DELETED_SIGN 表示未删除的符号 默认为0
* 覆盖 Laravel的 SoftDeletes 中有关'删除'定义的方法
*/
trait SoftDeletes{
    use EloquentSoftDeletes;

    /**
     * Boot the soft deleting trait for a model.
     *
     * @return void
     */
    public static function bootSoftDeletes()
    {
        static::addGlobalScope(new SoftDeletingScope);
    }

    /**
     * Perform the actual delete query on this model instance.
     *
     * @return void
     */
    protected function runSoftDelete()
    {
        $query = $this->newQueryWithoutScopes()->where($this->getKeyName(), $this->getKey());

        $this->{$this->getDeletedAtColumn()} = $this->getDeletedSign();

        $query->update([$this->getDeletedAtColumn() => $this->getDeletedSign()]);
    }

    /**
     * Restore a soft-deleted model instance.
     *
     * @return bool|null
     */
    public function restore()
    {
        // If the restoring event does not return false, we will proceed with this
        // restore operation. Otherwise, we bail out so the developer will stop
        // the restore totally. We will clear the deleted timestamp and save.
        if ($this->fireModelEvent('restoring') === false) {
            return false;
        }

        $this->{$this->getDeletedAtColumn()} = $this->getNotDeletedSign();

        // Once we have saved the model, we will fire the "restored" event so this
        // developer will do anything they need to after a restore operation is
        // totally finished. Then we will return the result of the save call.
        $this->exists = true;

        $result = $this->save();

        $this->fireModelEvent('restored', false);

        return $result;
    }

    /**
     * Determine if the model instance has been soft-deleted.
     *
     * @return bool
     */
    public function trashed()
    {
        return $this->{$this->getDeletedAtColumn()} == $this->getDeletedSign();
    }

    /**
     * Get a new query builder that includes soft deletes.
     *
     * @return \Illuminate\Database\Eloquent\Builder|static
     */
    public static function withTrashed()
    {
        return (new static)->newQueryWithoutScope(new SoftDeletingScope);
    }

    /**
     * Get a new query builder that only includes soft deletes.
     *
     * @return \Illuminate\Database\Eloquent\Builder|static
     */
    public static function onlyTrashed()
    {
        $instance = new static;

        $column = $instance->getQualifiedDeletedAtColumn();
        $DeletedSign = defined('static::DELETED_SIGN') ? static::DELETED_SIGN : 1; //注意这里 不是 $this->getDeletedSign()

        return $instance->newQueryWithoutScope(new SoftDeletingScope)->where($column, '=', $DeletedSign);
    }

    /**
     * Get the DELETED_SIGN.
     *
     * @return string
     */
    public function getDeletedSign()
    {
        return defined('static::DELETED_SIGN') ? static::DELETED_SIGN : 1;
    }

    /**
     * Get the NOT_DELETED_SIGN.
     *
     * @return string
     */
    public function getNotDeletedSign()
    {
        return defined('static::NOT_DELETED_SIGN') ? static::NOT_DELETED_SIGN : 0;
    }

}
