<?php


namespace App\Http\Repositories\Eloquent;


use App\Http\Repositories\BaseRepositoryInterface;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;

abstract class BaseRepository implements BaseRepositoryInterface
{
    protected Model $model;

    protected string $model_class_name;

    public function __construct($model)
    {
        $this->model = $model;
        $this->model_class_name = get_class($this->model);
    }

    public function getAll(): Collection
    {
        return $this->model->all();
    }

    public function getAllOrderedByName(): Collection
    {
        return $this->model->orderBy('name')->get();
    }

    public function getAllOrderedByNamePaginated(int $number_per_page): LengthAwarePaginator
    {
        return $this->model->orderBy('name')->paginate($number_per_page);
    }

    public function getById($id): Model
    {
        return $this->model->find($id);
    }

    public function getByNamePaginated(string $search_string, int $number_per_page): LengthAwarePaginator
    {
        return $this->model->where('name', 'like', '%' . $search_string . '%')->orderBy('name')->paginate($number_per_page);
    }

    /**
     * Create new model instance
     *
     * @return Model
     */
    public function newInstance(): Model
    {
        return $this->model->newInstance();
    }

    /**
     * Create model from data
     *
     * @param array $attributes
     * @return Model
     */
    public function create(array $attributes): Model
    {
        $auth_user_id = Auth::id();
        $log_attributes = json_encode($attributes);

        $model = $this->model->create($attributes);

        Log::info("auth user -> $auth_user_id created a $this->model_class_name -> $model->id, args : $log_attributes");

        return $model;
    }

    /**
     * Update model from data
     *
     * @param Model $model
     * @param array $attributes
     * @return bool
     */
    public function update(Model $model, array $attributes): bool
    {
        $auth_user_id = Auth::id();
        $log_attributes = json_encode($attributes);

        Log::info("auth user -> $auth_user_id updated a $this->model_class_name -> $model->id, args : $log_attributes");

        $model->fill($attributes);
        return $model->save();
    }

    /**
     * Delete models
     *
     * @param $id
     * @return mixed
     */
    public function delete(int $id): int
    {
        $auth_user_id = Auth::id();
        $log_ids = json_encode($id);

        Log::info("auth user -> $auth_user_id deleted $this->model_class_name, args : $log_ids");

        return $this->model->destroy($id);
    }

    public function getCount(): int
    {
        return $this->model->count();
    }

}
