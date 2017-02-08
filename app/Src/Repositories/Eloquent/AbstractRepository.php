<?php 

namespace App\Src\Repositories\Eloquent;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Container\Container as App;


abstract class AbstractRepository {

    /**
     * @var Illuminate\Container\Container
     */
    private $app;

    /**
     * @var
     */
    protected $model;

    /**
     * 
     */
    public function __construct(App $app) {
        $this->app = $app;
        $this->makeModel();
    }

    /**
     * Specify Model class name
     * 
     * @return mixed
     */
    abstract function model();

    /**
     * @return Model
     * @throws RepositoryException
     */
    public function makeModel() {
        $model = $this->app->make($this->model());

        if (!$model instanceof Model)
            throw new RepositoryException("Class {$this->model()} must be an instance of Illuminate\\Database\\Eloquent\\Model");

        return $this->model = $model;
    }

    /**
     * 
     * @return type
     */
    public function paginate($perPage) {
        return $this->model->paginate($perPage);
    }

    /**
     * 
     * @param type $data 
     * @return type
     */
    public function create($data) {
        return $this->model->create($data);
    }

    /**
     * 
     * @param type $id 
     * @param type $data 
     * @return type
     */
    public function update($id, $data) {
        $record =  $this->model->find($id);
        $record->fill($data);
        $record->save();
        return $record;
    }
}