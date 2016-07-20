<?php

namespace App\Traits;

use Illuminate\Database\Eloquent\ScopeInterface;
use Illuminate\Database\Eloquent\SoftDeletingScope as EloquentSoftDeletingScope;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;

class SoftDeletingScope extends EloquentSoftDeletingScope
{
    use GlobalScope;

    /**
     * Apply the scope to a given Eloquent query builder.
     *
     * @param  \Illuminate\Database\Eloquent\Builder  $builder
     * @param  \Illuminate\Database\Eloquent\Model  $model
     * @return void
     */
    public function apply(Builder $builder, Model $model)
    {
        $builder->where($model->getQualifiedDeletedAtColumn(), '=', $model->getNotDeletedSign());

        $this->extend($builder);
    }

    /**
     * Determine if the given where clause is a soft delete constraint.
     * 确定句子是软删除
     * 这个方法只有GlobalScope的remove使用
     *
     * @param  array   $where
     * @param  Model $model
     * @return bool
     */
    protected function isScopeConstraint(array $where, Model $model)
    {
        // return $where['type'] == 'Null' && $where['column'] == $column;
        $column = $model->getQualifiedDeletedAtColumn();
        return $where['type'] == 'Basic' && $where['column'] == $column;
    }

    /**
     * Extend the query builder with the needed functions.
     *
     * @param  \Illuminate\Database\Eloquent\Builder  $builder
     * @return void
     */
    public function extend(Builder $builder)
    {
        foreach ($this->extensions as $extension) {
            $this->{"add{$extension}"}($builder);
        }

        $builder->onDelete(function (Builder $builder) {
            $column = $this->getDeletedAtColumn($builder);

            return $builder->update([
                // $column => $builder->getModel()->freshTimestampString(),
                $column => $builder->getModel()->getDeletedSign(),
                ]);
        });
    }

    /**
     * Add the restore extension to the builder.
     *
     * @param  \Illuminate\Database\Eloquent\Builder  $builder
     * @return void
     */
    protected function addRestore(Builder $builder)
    {
        $builder->macro('restore', function (Builder $builder) {
            $builder->withTrashed();
            // return $builder->update([$builder->getModel()->getDeletedAtColumn() => null]);
            return $builder->update([$builder->getModel()->getDeletedAtColumn() => $builder->getModel()->getNotDeletedSign()]);
        });
    }

    /**
     * Add the only-trashed extension to the builder.
     *
     * @param  \Illuminate\Database\Eloquent\Builder  $builder
     * @return void
     */
    protected function addOnlyTrashed(Builder $builder)
    {
        $builder->macro('onlyTrashed', function (Builder $builder) {
            $model = $builder->getModel();

            $this->remove($builder, $model);
            // $builder->getQuery()->whereNotNull($model->getQualifiedDeletedAtColumn());
            $builder->getQuery()->where($model->getQualifiedDeletedAtColumn(), '=', $model->getDeletedSign());

            return $builder;
        });
    }

    /**
     * Determine if the given where clause is a soft delete constraint.
     * 确定句子是软约束???
     * 这个方法只有自身的remove使用,这里也覆盖下,不覆盖也没有关系
     *
     * @param  array   $where
     * @param  string  $column
     * @return bool
     */
    protected function isSoftDeleteConstraint(array $where, $column)
    {
        // return $where['type'] == 'Null' && $where['column'] == $column;
        return $where['type'] == 'Basic' && $where['column'] == $column;
    }
}
